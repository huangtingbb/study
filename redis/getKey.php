<?php

require_once "./common.php";

$keys = $redis->keys("test_many_key:*");

echo "string keys count :".count($keys),PHP_EOL;

$value = $redis->hgetall("test_big_key");

echo "hash map has ",count($value)," element",PHP_EOL;
