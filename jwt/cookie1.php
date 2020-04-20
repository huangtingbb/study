<?php
	if(isset($_GET['name'])){
		$name = $_GET['name'];
		setcookie('name',$name);
		echo "登录成功!";
		return ;
	}
	
	if(isset($_COOKIE['name'])){
		echo "欢迎您,",$_COOKIE['name'],"!";	
		return;
	}

	echo "请先登录";
