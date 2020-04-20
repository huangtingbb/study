<?php
	$callback=$_GET['callback'];
	$data=12345;
	$script=<<<Script
		$callback($data);
Script;
	echo $script;
