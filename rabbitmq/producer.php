<?php
/**
 * rabbit生产者
 */

$config = include_once "config.php";
$connection = new AMQPConnection($config['rabbit']);
$connection->connect() or die("Cannot connect to the broker!\n");

try {
    $message = "hello world";
    $channel = new AMQPChannel($connection);
    $channel->confirmSelect();
    $channel->setConfirmCallback(function ($data) {
        var_dump($data);
        echo "消息处理成功";
        exit();
    },function ($data){
        var_dump($data);
        echo "消息处理失败";
        exit;
    });

    $exchange = new AMQPExchange($channel);
    $exchange->setName($config['test_exchange']);
    $queue = new AMQPQueue($channel);
    $queue->setName($config['test_queue']);
    $exchange->publish($message, $config['test_routing_key']);
    var_dump("[x] Sent 'Hello World!'");
    $channel->waitForConfirm();
} catch (AMQPConnectionException $e) {
    var_dump($e);
    exit();
}
$connection->disconnect();
exit;

//创建一个AMQP链接
$conn = new AMQPConnection($config['rabbit']);
//尝试链接
$conn->connect() || die("链接失败");

//再在Connect里面创建Channel通道
$channel = new AMQPChannel($conn);

//创建交换机
$exchange = new AMQPExchange($channel);
//设置exchange的名称
$exchange->setName($config['test_exchange']);
//设置交换机机的类型
$exchange->setType(AMQP_EX_TYPE_DIRECT);
//设置交换机的标志
$exchange->setFlags(AMQP_DURABLE);
//声明交换机
$exchange->declareExchange();

//发送消息到队列
for ($i = 0; $i<3;$i++){
    $exchange->publish("消息:_".$i.",产生时间:".date("Y-m-d H:i:s"),$config['test_routing_key']);
}

$conn->disconnect();


