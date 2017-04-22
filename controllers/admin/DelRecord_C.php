<?php 
	require('../../models/AdminModel_M.php');
	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}

	$User = $_POST['User'];
	$Book = $_POST['Book'];
	$BrwTime = $_POST['BrwTime'];
	$result = delRecord_M($User,$Book,$BrwTime);
	if($result){
		echo urldecode(json_encode(getInfo(101,"删除成功")));
	}else{
		echo urldecode(json_encode(getInfo(-5,"删除失败")));
	}
	

 ?>