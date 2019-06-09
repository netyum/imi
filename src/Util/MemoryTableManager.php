<?php
namespace Imi\Util;

/**
 * 跨进程共享内存表
 */
abstract class MemoryTableManager
{
    /**
     * 是否已初始化过
     * @var boolean
     */
    private static $isInited = false;

    /**
     * \Swoole\Table 数组
     * @var \Swoole\Table[]
     */
    private static $tables = [];

    /**
     * 初始化
     * @return void
     */
    public static function init()
    {
        if(static::$isInited)
        {
            throw new \RuntimeException('MemoryTableManager can not repeated init');
        }
        foreach(static::$tables as $name => $option)
        {
            $table = new \Swoole\Table($option['size'] ?? 1024, $option['conflictProportion'] ?? 0.2);
            foreach($option['columns'] as $column)
            {
                $table->column($column['name'], $column['type'] ?? \Swoole\Table::TYPE_STRING, $column['size'] ?? 0);
            }
            if(!$table->create())
            {
                throw new \RuntimeException('MemoryTableManager create table failed');
            }
            static::$tables[$name] = $table;
        }
        static::$isInited = true;
    }

    /**
     * 增加内存表对象名称
     * @param string $name
     * @param array $option
     * @return void
     */
    public static function addName(string $name, $option)
    {
        if(static::$isInited)
        {
            throw new \RuntimeException('addName failed, MemoryTableManager was inited');
        }
        static::$tables[$name] = $option;
    }

    /**
     * 设置内存表对象名称
     * @param string[] $names
     * @return void
     */
    public static function setNames(array $names)
    {
        if(static::$isInited)
        {
            throw new \RuntimeException('addName failed, MemoryTableManager was inited');
        }
        foreach($names as $key => $value)
        {
            if(is_numeric($key))
            {
                static::$tables[$value] = 0;
            }
            else
            {
                static::$tables[$key] = $value;
            }
        }
    }

    /**
     * 获取所有内存表对象名称
     * @return void
     */
    public static function getNames()
    {
        return array_keys(static::$tables);
    }

    /**
     * 获取内存表类实例
     * @param string $name 表名
     * @return \Swoole\Table
     */
    public static function getInstance(string $name): \Swoole\Table
    {
        if(!static::$isInited)
        {
            throw new \RuntimeException('getInstance failed, MemoryTableManager is not initialized');
        }
        if(!isset(static::$tables[$name]))
        {
            throw new \RuntimeException(sprintf('GetInstance failed, %s is not found', $name));
        }
        return static::$tables[$name];
    }

    /**
     * 设置行的数据
     * @param string $name 表名
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $name, string $key, $value)
    {
        return static::getInstance($name)->set($key, $value);
    }

    /**
     * 获取一行数据
     * @param string $name 表名
     * @param string $key
     * @param mixed $field
     * @return array
     */
    public static function get(string $name, string $key, string $field = null)
    {
        return static::getInstance($name)->get($key, $field);
    }

    /**
     * 删除行的数据
     * @param string $name 表名
     * @param string $key $key对应的数据不存在，将返回false
     * @return boolean
     */
    public static function del(string $name, string $key)
    {
        return static::getInstance($name)->del($key);
    }

    /**
     * 行数据是否存在
     * @param string $name 表名
     * @param string $key $key对应的数据不存在，将返回false
     * @return boolean
     */
    public static function exist(string $name, string $key)
    {
        return static::getInstance($name)->exist($key);
    }

    /**
     * 原子自增
     * @param string $name 表名
     * @param string $key
     * @param int|float $incrby 增量，默认为1。如果列为整形，$incrby必须为int型，如果列为浮点型，$incrby必须为float类型
     * @return boolean
     */
    public static function incr(string $name, string $key, $incrby = 1)
    {
        return static::getInstance($name)->incr($key, $incrby);
    }

    /**
     * 原子自减
     * @param string $name 表名
     * @param string $key
     * @param int|float $incrby 减量，默认为1。如果列为整形，$incrby必须为int型，如果列为浮点型，$incrby必须为float类型
     * @return boolean
     */
    public static function decr(string $name, string $key, $incrby = 1)
    {
        return static::getInstance($name)->decr($key, $incrby);
    }
    
    /**
     * 获取表行数
     * 失败返回false
     * @param string $name 表名
     * @return int
     */
    public static function count(string $name)
    {
        return static::getInstance($name)->count();
    }
}