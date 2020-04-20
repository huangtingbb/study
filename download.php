<?php
/**
 *
 * 下载图片
 * Created by PhpStorm.
 * User: LJ
 * Date: 2019/7/3
 * Time: 16:23
 */

$img_path='jy.jpg';
//header('Location:http://huiya2.com/upload/2019/06/05/a.jpg');
//$size=filesize('./jy.jpg');
$size=filesize('./jy.jpg');
//header 头下载
//header("Content-type:image/*,charset=UTF-8");
//header("Accept-Ranges:bytes");
//header("Content-Length:".$size);
//header("Content-Disposition: attachment; filename=".substr($img_path,strrpos($img_path,'/')));
//$buffer=1024;
//$buffer_count=0;
//$fp=fopen($img_path,"r");
//while(!feof($fp)&&$size-$buffer_count>0){
//    $data=fread($fp,$buffer);
//    $buffer_count+=$buffer;
//    echo $data;
//}
//fflush($fp);
//fclose($fp);exit;

$str=file_get_contents($img_path);
echo base64_encode($str);