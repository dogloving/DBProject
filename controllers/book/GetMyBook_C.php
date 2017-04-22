<?php 
	require('../../models/BookModel_M.php');

	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}

	if(!isset($_COOKIE['user'])){
		echo urldecode(json_encode(getInfo(-8,"你没有登陆")));
	}
	$uid = $_COOKIE['user'];

	$result = getMyBook($uid);
	echo urldecode(json_encode(getInfo(101,$result)));


 ?>