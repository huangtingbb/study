<?php
function getMillisecond() {
		list($t1, $t2) = explode(' ', microtime());
		return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}
$dsn="mysql:dbname=ljstu;host=127.0.0.1";
$user="root";
$pwd="123456";

$pdo = new PDO($dsn,$user,$pwd);
$sql = "insert into user values(null,'%s','%s')";
//数据库写log效率
echo "测试1W次写数据库效率".PHP_EOL;
$start_time = getMillisecond();
for($i = 0;$i<=9999;$i++){
	$name = "lj".$i;
	$pwd = 123456;
	$pdo->query(sprintf($sql,$name,$pwd));
}
$end_time = getMillisecond();
echo $end_time - $start_time,PHP_EOL;
