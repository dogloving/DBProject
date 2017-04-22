<?php 
	require('../../models/AdminModel_M.php');

	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}

	$uname = $_POST['uname'];

	$result = delUser_M($uname);
	if($result){
		echo urldecode(json_encode(getInfo(101,"删除成功")));
	}else{
		echo urldecode(json_encode(getInfo(-4,"删除失败")));
	}


 ?>