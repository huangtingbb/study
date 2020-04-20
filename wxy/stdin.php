<?php
	while($line = fopen('php://stdin','r')){
		echo $line.PHP_EOL;
		ECHO fgets($line);
	}
