<?php

	require_once "./Util.php";
	header("Content-Type:text/json");
	$code=$_GET['code'];
	
	$data=[
		'code'=>$code,
		'appid'=>Util::APPID,
		'secret'=>Util::APP_SECRET,
		'grant_type'=>'authorization_code'
	];	
	
	$url="https://api.weixin.qq.com/sns/jscode2session?appid=".Util::APPID."&secret=".Util::APP_SECRET."&js_code=".$code."&grant_type=authorization_code";
	$result=Util::request($url);
	$result=json_decode($result,true);
	$db=new PDO('mysql:dbname=wxxcx;host=127.0.0.1','root','123456');
	$sql='select * from user where openid="'.$result['openid'].'"';
	$user=$db->query($sql);
	if($user){
		//echo "该用户是老用户";
	}else{
		$insert_sql="INSERT INTO user (`openid`) VALUES (?)";
		$pre_sql=$db->prepare($insert_sql);
		$pre_sql->execute(array($result['openid']));
	}
	//判断result里面的数据库有没有该openid，没有就添加进数据库
	echo $result['session_key'];

