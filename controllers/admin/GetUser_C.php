<?php 
	require('../../models/AdminModel_M.php');
	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}

	$result = getUser_M();
	echo 'test';
	//echo urldecode(json_encode(getInfo(101,$result)));


 ?>