<?php
    function strfirsttoU($str){
			        $arr=explode('_',$str);
					        $arr=array_map('ucfirst',$arr);
							        return implode('',$arr);
									    }
										    $str='open_door';
											    echo strfirsttoU($str);
