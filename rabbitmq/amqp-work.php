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


echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg){
    echo ' [x] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done\n";
    $msg->nack();
};

$channel->basic_qos(null,1,null);
$channel->basic_consume('task_queue','',false,false,false,false,$callback);

while($channel->is_consuming()){
    $channel->wait();
}

$channel->close();
$conn->close();
