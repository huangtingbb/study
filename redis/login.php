<?php
	
	
	
	$redis=new redis();
	$redis->connect('127.0.0.1',6379);
	$user=$redis->get('user');
	if($user){
		echo '您已经登录，无需重复登录';
		header('location:index.php');
	}


?>

<form action="index.php" method="post">
	用户名：<input type="text" name="username">
	密码：<input type="password" name="pwd">
	<input type="submit" value="提交">
</form>
