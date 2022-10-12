<?php
include_once __DIR__."/vendor/autoload.php";
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$config = include_once __DIR__."/config.php";
$rabbit_config = $config['rabbit'];
$msg_txt = "hello world";

$conn =new AMQPStreamConnection($rabbit_config['host'],$rabbit_config['port'],$rabbit_config['login'],$rabbit_config['password'],$rabbit_config['vhost']);
$channel = $conn->channel();

$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, 'hello', 'hello');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$conn->close();

