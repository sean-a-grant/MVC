<?php

class Load {
	function view($file, $data = null){
		if(is_array($data)){
			extract($data);
		}

		include 'views/' . $file;
	}
}