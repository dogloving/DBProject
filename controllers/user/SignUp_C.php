<?php 
	require('../../models/SignModel_M.php');

	/**
	*	@param $Flag:101->success negative:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}


	//注册
	$username = $_POST['username'];
	$password = $_POST['password'];
	$gender = $_POST['gender'];

	$result = signUp_M($username,$password,$gender);

	if($result == 1){
		echo urldecode(json_encode(getInfo(101,"注册成功")));
	}else if($result == 2){
		echo urldecode(json_encode(getInfo(-2,"该用户名已经存在，请输入其他用户名")));
	}else if($result == 3){
		echo urldecode(json_encode(getInfo(-2,"注册失败,请重试")));
	}



 ?>