<?php

	$rs = fopen("php://stdout",'w');
	if($rs){
		echo $rs.PHP_EOL;
		fwrite($rs,'测试标准输出流'.PHP_EOL);
		fclose($rs);
	}
