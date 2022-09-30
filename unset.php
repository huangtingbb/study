<?php

$m1 = memory_get_usage();
echo $m1,"\n";
//$a = "1234";
unset($a);
$m2 = memory_get_usage();
echo $m2,"\n";
//var_dump($m2);
echo $m2-$m1;