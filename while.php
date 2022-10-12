<?php
	$end=time()+20;
	$i=1;
	echo date('Y-m-d H:i:s',time());
	while(time()<$end){
		 $i++;
	}
	echo $i;
	echo "<br>";
	echo date('Y-m-d H:i:s',time());
