<?php

$a = '当前时间:'.date('Y-m-d H:i:s')."\r\n";
$log=fopen('task.log','a+');
fwrite($log,$a);
fclose($log);
