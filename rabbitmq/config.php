<?php
/**
 * rabbit配置文件
 */

return [
    'rabbit' => [
        'host' => '192.168.29.130',
        'vhost' => '/',
        'port' => '5672',
        'login' => 'admin',
        'password' => '1029lj',
    ],

    'test_channel' => 'test_channel',
    'test_exchange' => 'test_exchange',
    'test_routing_key' => 'test_routing_key',
    'test_queue' => 'test_queue'
];