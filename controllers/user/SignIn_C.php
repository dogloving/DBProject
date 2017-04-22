<?php 
	require('../../models/SignModel_M.php'); 

	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}




	//登陆
	$username = $_POST['username'];
	$password = $_POST['password'];

	$result = signIn_M($username,$password);

	if($result != 0){
		echo urldecode(json_encode(getInfo(101,$result)));
	}else {
		echo urldecode(json_encode(getInfo(-1,$result)));
	}
	



?>

