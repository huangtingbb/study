<?php
include_once __DIR__."/vendor/autoload.php";
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$config = include_once __DIR__."/config.php";
$rabbit_config = $config['rabbit'];
$msg = "hello world";
$conn = new AMQPStreamConnection($rabbit_config['host'],$rabbit_config['port'],$rabbit_config['login'],$rabbit_config['password']);

$channel = $conn->channel();
$channel->queue_declare("task_queue",false,true,false,false);

$data = $argv[1];
$msg = new AMQPMessage($data,['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

$channel->basic_publish($msg,'','task_queue');
echo  ' [x] Sent ', $data, "\n";
$channel->close();
$conn->close();
