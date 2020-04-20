<?php

	session_start();
	if(isset($_GET['name'])){
		$_SESSION['name'] = $_GET['name'];
		echo "登录成功!";
		return;
	}

	if(isset($_SESSION['name'])){
		echo "欢迎您",$_SESSION['name'],"<br>";
		echo "session保存位置：",session_save_path(),"<br>";
		echo "\t session_id: ",session_id();
		return;	
	}

	echo "请先登录";

