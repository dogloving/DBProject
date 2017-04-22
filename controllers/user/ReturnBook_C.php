<?php 
	require('../../models/BookModel_M.php');

	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}

	$bid = $_POST['bid'];
	if(!isset($_COOKIE['user'])){
		echo urldecode(json_encode(getInfo(-7,"还书失败")));
	}
	$uid = $_COOKIE['user'];

	$result = returnBook($uid,$bid);
	if($result){
		echo urldecode(json_encode(getInfo(101,"还书成功")));
	}else{
		echo urldecode(json_encode(getInfo(-7,"还书失败")));
	}
	
	
 ?>