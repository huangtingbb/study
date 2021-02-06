<?php
/**
 * rabbit消费者
 */


$config = include_once "config.php";

//创建rabbit链接
$conn = new AMQPConnection($config['rabbit']);

//链接
$conn->connect() || die("链接失败");

//在链接内创建一个通道
$channel = new AMQPChannel($conn);

//创建一个交换机
$exchange = new AMQPExchange($channel);
//设置交换机的名称
$exchange->setName($config['test_exchange']);
//设置交换机的类型
$exchange->setType(AMQP_EX_TYPE_DIRECT);
//设置交换机的标志
$exchange->setFlags(AMQP_DURABLE);
//声明交换机
$exchange->declareExchange();

//创建一个队列
$queue = new AMQPQueue($channel);
//设置队列名称
$queue->setName($config['test_queue']);
//设置队列的标志
$queue->setFlags(AMQP_DURABLE);
//声明队列
$queue->declareQueue();
//绑定交换机
$queue->bind($exchange->getName(),$config['test_routing_key']);
//消费消息
$queue->consume(function($envelope,$q){
    echo $envelope->getBody()."\n";
},AMQP_AUTOACK);