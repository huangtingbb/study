<?php

$id=$_GET['id'];
$sql="SELECT * FROM user WHERE id=".$id;
$db=new PDO("mysql:dbname=wxxcx;host=127.0.0.1","root","123456");
$user=$db->query($sql)->fetch();
echo json_encode($user);
