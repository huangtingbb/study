<?php

include_once __DIR__."/vendor/autoload.php";
use PhpAmqpLib\Connection\AMQPStreamConnection;

$config = include_once __DIR__."/config.php";
$rabbit_config = $config['rabbit'];

$conn =new AMQPStreamConnection($rabbit_config['host'],$rabbit_config['port'],$rabbit_config['login'],$rabbit_config['password'],$rabbit_config['vhost']);
$channel = $conn->channel();

$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
};

$channel->exchange_declare("hello",AMQP_EX_TYPE_DIRECT);

$channel->basic_consume('hello', 'hello', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
