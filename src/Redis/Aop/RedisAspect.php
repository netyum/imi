<?php
namespace Imi\Redis\Aop;

use Imi\Aop\AroundJoinPoint;
use Imi\Aop\Annotation\Around;
use Imi\Aop\Annotation\Aspect;
use Imi\Aop\Annotation\PointCut;

/**
 * @Aspect
 */
class RedisAspect
{
	/**
	 * Redis 延迟收包
	 * @PointCut(
	 * 		allow={
	 * 			"Swoole\Coroutine\Redis::set",
	 * 			"Swoole\Coroutine\Redis::setBit",
	 * 			"Swoole\Coroutine\Redis::setEx",
	 * 			"Swoole\Coroutine\Redis::psetEx",
	 * 			"Swoole\Coroutine\Redis::lSet",
	 * 			"Swoole\Coroutine\Redis::get",
	 * 			"Swoole\Coroutine\Redis::mGet",
	 * 			"Swoole\Coroutine\Redis::del",
	 * 			"Swoole\Coroutine\Redis::hDel",
	 * 			"Swoole\Coroutine\Redis::hSet",
	 * 			"Swoole\Coroutine\Redis::hMSet",
	 * 			"Swoole\Coroutine\Redis::hSetNx",
	 * 			"Swoole\Coroutine\Redis::delete",
	 * 			"Swoole\Coroutine\Redis::mSet",
	 * 			"Swoole\Coroutine\Redis::mSetNx",
	 * 			"Swoole\Coroutine\Redis::getKeys",
	 * 			"Swoole\Coroutine\Redis::keys",
	 * 			"Swoole\Coroutine\Redis::exists",
	 * 			"Swoole\Coroutine\Redis::type",
	 * 			"Swoole\Coroutine\Redis::strLen",
	 * 			"Swoole\Coroutine\Redis::lPop",
	 * 			"Swoole\Coroutine\Redis::blPop",
	 * 			"Swoole\Coroutine\Redis::rPop",
	 * 			"Swoole\Coroutine\Redis::brPop",
	 * 			"Swoole\Coroutine\Redis::bRPopLPush",
	 * 			"Swoole\Coroutine\Redis::lSize",
	 * 			"Swoole\Coroutine\Redis::lLen",
	 * 			"Swoole\Coroutine\Redis::sSize",
	 * 			"Swoole\Coroutine\Redis::scard",
	 * 			"Swoole\Coroutine\Redis::sPop",
	 * 			"Swoole\Coroutine\Redis::sMembers",
	 * 			"Swoole\Coroutine\Redis::sGetMembers",
	 * 			"Swoole\Coroutine\Redis::sRandMember",
	 * 			"Swoole\Coroutine\Redis::persist",
	 * 			"Swoole\Coroutine\Redis::ttl",
	 * 			"Swoole\Coroutine\Redis::pttl",
	 * 			"Swoole\Coroutine\Redis::zCard",
	 * 			"Swoole\Coroutine\Redis::zSize",
	 * 			"Swoole\Coroutine\Redis::hLen",
	 * 			"Swoole\Coroutine\Redis::hKeys",
	 * 			"Swoole\Coroutine\Redis::hVals",
	 * 			"Swoole\Coroutine\Redis::hGetAll",
	 * 			"Swoole\Coroutine\Redis::debug",
	 * 			"Swoole\Coroutine\Redis::restore",
	 * 			"Swoole\Coroutine\Redis::dump",
	 * 			"Swoole\Coroutine\Redis::renameKey",
	 * 			"Swoole\Coroutine\Redis::rename",
	 * 			"Swoole\Coroutine\Redis::renameNx",
	 * 			"Swoole\Coroutine\Redis::rpoplpush",
	 * 			"Swoole\Coroutine\Redis::randomKey",
	 * 			"Swoole\Coroutine\Redis::ping",
	 * 			"Swoole\Coroutine\Redis::auth",
	 * 			"Swoole\Coroutine\Redis::unwatch",
	 * 			"Swoole\Coroutine\Redis::watch",
	 * 			"Swoole\Coroutine\Redis::save",
	 * 			"Swoole\Coroutine\Redis::bgSave",
	 * 			"Swoole\Coroutine\Redis::lastSave",
	 * 			"Swoole\Coroutine\Redis::flushDB",
	 * 			"Swoole\Coroutine\Redis::flushAll",
	 * 			"Swoole\Coroutine\Redis::dbSize",
	 * 			"Swoole\Coroutine\Redis::bgrewriteaof",
	 * 			"Swoole\Coroutine\Redis::time",
	 * 			"Swoole\Coroutine\Redis::role",
	 * 			"Swoole\Coroutine\Redis::setRange",
	 * 			"Swoole\Coroutine\Redis::setNx",
	 * 			"Swoole\Coroutine\Redis::getSet",
	 * 			"Swoole\Coroutine\Redis::append",
	 * 			"Swoole\Coroutine\Redis::lPushx",
	 * 			"Swoole\Coroutine\Redis::lPush",
	 * 			"Swoole\Coroutine\Redis::rPush",
	 * 			"Swoole\Coroutine\Redis::rPushx",
	 * 			"Swoole\Coroutine\Redis::sContains",
	 * 			"Swoole\Coroutine\Redis::sismember",
	 * 			"Swoole\Coroutine\Redis::zScore",
	 * 			"Swoole\Coroutine\Redis::zRank",
	 * 			"Swoole\Coroutine\Redis::zRevRank",
	 * 			"Swoole\Coroutine\Redis::hGet",
	 * 			"Swoole\Coroutine\Redis::hMGet",
	 * 			"Swoole\Coroutine\Redis::hExists",
	 * 			"Swoole\Coroutine\Redis::publish",
	 * 			"Swoole\Coroutine\Redis::zIncrBy",
	 * 			"Swoole\Coroutine\Redis::zAdd",
	 * 			"Swoole\Coroutine\Redis::zDeleteRangeByScore",
	 * 			"Swoole\Coroutine\Redis::zRemRangeByScore",
	 * 			"Swoole\Coroutine\Redis::zCount",
	 * 			"Swoole\Coroutine\Redis::zRange",
	 * 			"Swoole\Coroutine\Redis::zRevRange",
	 * 			"Swoole\Coroutine\Redis::zRangeByScore",
	 * 			"Swoole\Coroutine\Redis::zRevRangeByScore",
	 * 			"Swoole\Coroutine\Redis::zRangeByLex",
	 * 			"Swoole\Coroutine\Redis::zRevRangeByLex",
	 * 			"Swoole\Coroutine\Redis::zInter",
	 * 			"Swoole\Coroutine\Redis::zinterstore",
	 * 			"Swoole\Coroutine\Redis::zUnion",
	 * 			"Swoole\Coroutine\Redis::zunionstore",
	 * 			"Swoole\Coroutine\Redis::incrBy",
	 * 			"Swoole\Coroutine\Redis::hIncrBy",
	 * 			"Swoole\Coroutine\Redis::incr",
	 * 			"Swoole\Coroutine\Redis::decrBy",
	 * 			"Swoole\Coroutine\Redis::decr",
	 * 			"Swoole\Coroutine\Redis::getBit",
	 * 			"Swoole\Coroutine\Redis::lInsert",
	 * 			"Swoole\Coroutine\Redis::lGet",
	 * 			"Swoole\Coroutine\Redis::lIndex",
	 * 			"Swoole\Coroutine\Redis::setTimeout",
	 * 			"Swoole\Coroutine\Redis::expire",
	 * 			"Swoole\Coroutine\Redis::pexpire",
	 * 			"Swoole\Coroutine\Redis::expireAt",
	 * 			"Swoole\Coroutine\Redis::pexpireAt",
	 * 			"Swoole\Coroutine\Redis::move",
	 * 			"Swoole\Coroutine\Redis::select",
	 * 			"Swoole\Coroutine\Redis::getRange",
	 * 			"Swoole\Coroutine\Redis::listTrim",
	 * 			"Swoole\Coroutine\Redis::ltrim",
	 * 			"Swoole\Coroutine\Redis::lGetRange",
	 * 			"Swoole\Coroutine\Redis::lRange",
	 * 			"Swoole\Coroutine\Redis::lRem",
	 * 			"Swoole\Coroutine\Redis::lRemove",
	 * 			"Swoole\Coroutine\Redis::zDeleteRangeByRank",
	 * 			"Swoole\Coroutine\Redis::zRemRangeByRank",
	 * 			"Swoole\Coroutine\Redis::incrByFloat",
	 * 			"Swoole\Coroutine\Redis::hIncrByFloat",
	 * 			"Swoole\Coroutine\Redis::bitCount",
	 * 			"Swoole\Coroutine\Redis::bitOp",
	 * 			"Swoole\Coroutine\Redis::sAdd",
	 * 			"Swoole\Coroutine\Redis::sMove",
	 * 			"Swoole\Coroutine\Redis::sDiff",
	 * 			"Swoole\Coroutine\Redis::sDiffStore",
	 * 			"Swoole\Coroutine\Redis::sUnion",
	 * 			"Swoole\Coroutine\Redis::sUnionStore",
	 * 			"Swoole\Coroutine\Redis::sInter",
	 * 			"Swoole\Coroutine\Redis::sInterStore",
	 * 			"Swoole\Coroutine\Redis::sRemove",
	 * 			"Swoole\Coroutine\Redis::srem",
	 * 			"Swoole\Coroutine\Redis::zDelete",
	 * 			"Swoole\Coroutine\Redis::zRemove",
	 * 			"Swoole\Coroutine\Redis::zRem",
	 * 			"Swoole\Coroutine\Redis::pSubscribe",
	 * 			"Swoole\Coroutine\Redis::subscribe",
	 * 			"Swoole\Coroutine\Redis::multi",
	 * 			"Swoole\Coroutine\Redis::exec",
	 * 			"Swoole\Coroutine\Redis::eval",
	 * 			"Swoole\Coroutine\Redis::evalSha",
	 * 			"Swoole\Coroutine\Redis::script"
	 * 		}
	 * )
	 * @Around
	 * @return mixed
	 */
	public function defer(AroundJoinPoint $joinPoint)
	{
		// 获取调用前的defer状态
		$isDefer = $joinPoint->getTarget()->getDefer();
		if(!$isDefer)
		{
			// 强制设为延迟收包
			$joinPoint->getTarget()->setDefer(true);
		}
		// 调用原方法
		$joinPoint->proceed();
		// 接收结果
		$result = $joinPoint->getTarget()->recv();
		if(!$isDefer)
		{
			// 设为调用前状态
			$joinPoint->getTarget()->setDefer(false);
		}
		return $result;
	}
}