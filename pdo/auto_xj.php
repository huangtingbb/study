<?php
/**
 * 自动下架
 * User: LJ
 * Date: 2019/4/4
 * Time: 15:48
 */

$dsn='mysql:dbname=shipin;host=120.24.6.201:8205';
$user='shipin';
$pwd='ksdh23984JG*&^(*)';
$conn=new \PDO($dsn,$user,$pwd);

$sql="select id,sell_sdate,sell_edate from goods where status=1";

$goodsList=$conn->query($sql);
//需要下架的id
$ids=[];
foreach ($goodsList->fetchAll() as $goods){
    //判断时间
    if($goods['sell_edate']<date('Y-m-d H:i:s')){
        array_push($ids,$goods['id']);
    }
}

$log=fopen('/vdb2/www/shipin/auto.log','a+');
try {
    if (empty($ids)) {
        fwrite($log, date('Y-m-d H:i:s') . '  : 没有商品需要下架'.PHP_EOL);
        fclose($log);
        exit();
    }


    $update_sql = "UPDATE goods set status=-1 where id in(" . implode(',', $ids) . ")";
    $count = $conn->exec($update_sql);
    fwrite($log, date('Y-m-d H:i:s') . '  : 下架成功' . $count . '件商品,商品id为:'.implode(',',$ids).PHP_EOL);
}catch (PDOException $e){
    fwrite($log,date('Y-m-d H:i:s').':'.$e->getMessage().PHP_EOL);
    fclose($log);
}


