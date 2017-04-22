<?php 
	require('../../models/BookModel_M.php');
	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}

	$result = getAllBook();

	echo urldecode(json_encode(getInfo(101,$result)));



 ?>