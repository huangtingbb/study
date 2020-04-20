<?php


$url = "https://openapi.alipay.com/gateway.do";

$api = ";

$param = [
	'app_id' => '2019092567776861',
	'method' => 'alipay.trade.app.pay',
	'format' => 'json',
	'charset' => 'UTF-8',
	'sign_type' => 'RSA2',
	'timestamp' => time(),
	'notify_url' => 'www.ljstu.top/getCallback',
	'version' => 1.0,
];

$order_num = time().rand(100,999);

$biz_content = <<<BIZ
{
	"timeout_express":"30m",
	"total_amount":"0.01",
	"subject":"77电竞战点充值",
	"out_trade_no":"{$order_num}",
	}
BIZ;
echo $biz_content;
$param['biz_content'] = $biz_content;

echo "<pre>";print_r($param);
