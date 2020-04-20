<?php
function getMillisecond() {
		list($t1, $t2) = explode(' ', microtime());
		return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}
echo getMillisecond();

$fp = fopen('./29.log','w+');
echo "1W次写文件操作耗时".PHP_EOL;
$start_time = getMillisecond();
for($i = 0;$i<=9999;$i++){
	fputs($fp,"id:{$i},name:刘锦{$i},pwd:123456".PHP_EOL);
}
$end_time = getMillisecond();
echo $end_time - $start_time,PHP_EOL;
