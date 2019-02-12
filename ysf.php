<?php
	error_reporting(0);
    $a=5;
    $b=3;

    $c=$a|$b;
    echo $c."<br>";

    $d='img';
    $e='txt';

    $f=$d??$e;
    echo $f;

	function getMax($a,$b,$c){
		return $a>$b ? ($a>$c?$a:$c) : ($b>$c?$b:$c);
	}

	echo getMax(3,4,5);

	$g = in_array('01',array('1')) == var_dump('01' == 1);
	echo $g;
	echo "<br>";
	var_dump('01'==1);
	var_dump(in_array('01',array('1'),true));

	echo count('abc');


	echo "<br>";
	var_dump('02'==2);
