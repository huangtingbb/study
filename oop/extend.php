<?php

	Class a{
		protected $c;

		public function a(){
			$this->c=10;
		}
		
	}

	class b extends a{
		
		public function getData(){
			echo $this->c;
		}
	}


	$b=new b();
	$b->getData();
