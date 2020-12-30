<?php

declare(strict_types=1);

namespace Imi\Model\Listener;

use Imi\App;
use Imi\Bean\Annotation\Listener;
use Imi\Config;
use Imi\Event\EventParam;
use Imi\Event\IEventListener;
use Imi\Util\Imi;
use Imi\Util\MemoryTableManager;

/**
 * @Listener(eventName="IMI.SWOOLE.SERVER.BEFORE_START")
 */
class Init implements IEventListener
{
    /**
     * 事件处理方法.
     *
     * @param EventParam $e
     *
     * @return void
     */
    public function handle(EventParam $e)
    {
        $runtimeInfo = App::getRuntimeInfo();

        // 初始化内存表模型
        foreach ($runtimeInfo->memoryTable as $item)
        {
            $memoryTableAnnotation = $item->getAnnotation();
            MemoryTableManager::addName($memoryTableAnnotation->name, [
                'size'                  => $memoryTableAnnotation->size,
                'conflictProportion'    => $memoryTableAnnotation->conflictProportion,
                'columns'               => $item->columns,
            ]);
        }
        // 初始化配置中的内存表
        foreach (Config::get('@app.memoryTable', []) as $name => $item)
        {
            MemoryTableManager::addName($name, $item);
        }

        MemoryTableManager::init();
    }
}
