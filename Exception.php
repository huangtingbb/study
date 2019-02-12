<?php
	
	set_error_handler('dealerror');


	function dealerror($type,$message,$file,$line){
		var_dump('<b>set_error_handler: ' . $type . ':' . $message . ' in ' . $file . ' on ' . $line . ' line .</b><br />');
		throw new \Exception($message);
	}
	try{
	$a=0;
	10/$a;
	}catch(Execption $e){
		echo 123;
	}
	echo 10;
