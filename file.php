<?php
	chmod('./a.txt','0744');
	$file=fopen('./a.txt','w+');
	fwrite($file,'hello a.txthhhhhh');
	fclose($file);


	function readDirs($path){
		$dir=opendir($path);
		while(false!==$file=readDir($dir)){
			if($file=='.'||$file=='..'){
				continue;
			}
			echo $file."<br>";
			if(is_dir($path.'/'.$file)){
				readDirs($path.'/'.$file);
			}
		}
	}

	readDirs('/usr/local/lnmp/nginx/html');
