<?php

declare(strict_types=1);

return [
    'configs'    => [
    ],
    // bean扫描目录
    'beanScan'    => [
        'Imi\Swoole\Test\TCPServer\MainServer\Controller',
        'Imi\Swoole\Test\TCPServer\MainServer\Listener',
        'Imi\Swoole\Test\TCPServer\MainServer\Error',
    ],
    'beans'    => [
        'TcpDispatcher'    => [
            'middlewares'    => [
                \Imi\Swoole\Test\TCPServer\Middleware\RequestLogMiddleware::class,
                \Imi\Server\TcpServer\Middleware\RouteMiddleware::class,
                \Imi\Swoole\Test\TCPServer\MainServer\Middleware\Test::class,
            ],
        ],
        'GroupRedis'    => [
            'redisPool'    => 'redis',
            'key'          => 'IMITEST.TCP.GROUP',
            'redisDb'      => 2,
        ],
        'ConnectContextStore'   => [
            'handlerClass'  => \Imi\Swoole\Server\ConnectContext\StoreHandler\MemoryTable::class,
        ],
        'ConnectContextMemoryTable' => [
            'tableName' => 'connectContext',
        ],
        'TcpRouteNotFoundHandler'   => [
            'handler'   => 'RouteNotFound',
        ],
        // 连接绑定器
        'ConnectionBinder'  => [
            'handlerClass' => 'ConnectionBinderLocal',
        ],
        // 连接绑定器本地驱动
        'ConnectionBinderLocal' => [
        ],
    ],
    'controller'    => [
        'singleton' => false,
    ],
];
