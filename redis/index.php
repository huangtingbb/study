<?php
	
	$redis=new redis();
	$redis->connect('127.0.0.1',6379);	
	$mysql=new mysqli('127.0.0.1','root','123456','ljstu');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		$id=$redis->get('user');	
		if($id){
			$query='select username from user where id='.$id;
			$result=$mysql->query($query);
			if($result){
				while($row=$result->fetch_array()){
					$username=$row['username'];
				}
			}
		}else{
			echo '登录状态超时，请<a href="login.php">重新登录</a>';
						
			header('refresh:3;url=http://47.107.44.128/redis/login.php');
		}
	}else{
	
		$data=$_POST;
		$username=strip_tags(trim($data['username']));
		$pwd=strip_tags(trim($data['pwd']));

		try{
			$query='select id from user where username="'.$username.'" and pwd="'.$pwd.'"';
			$result=$mysql->query($query);
			if($result){
				while($row=$result->fetch_array()){
					$id=$row['id'];	
					$redis->setex('user',600,$id);
				}
			}else{
				echo "用户名或密码错误";
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
	
?>

<h2>欢迎登录,<?php echo $username ?>|<small><a href="logout.php?<?php echo $id?>">退出登录</a></small></h2>



