<?php
    $dsn="mysql:dbname=ljstu;host=127.0.0.1";
	$user="root";
	$pwd="123456";
	try{
		$db=new PDO($dsn,$user,$pwd);
		$sql="select * from test2";
		$result=$db->query($sql);
		echo "<pre>";
		print_r($result);
		echo "<br>";
		//foreach($result as $row){//如果这样遍历了一次，那么使用pdoStatment::fetchAll()会得到空对象
		//	print_r($row);
		//	echo "<br>";
		//}

		print_r($result->fetchAll());//pdo->query 返回的是一个PDOStatement的对象，查询到的值只能遍历一次
		foreach($result as $row2){
			print_r($row2);
			echo "<br>";
		}
	}catch(PDOException $e){
		echo $e->getMessage();
	}

