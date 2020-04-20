<?php

	$a=['a'=>123,'b'=>['ab'=>1,'bb'=>2]];

	print_r(http_build_query($a));
