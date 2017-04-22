<?php 
	require('../../models/AdminModel_M.php');
	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}
	//根据用户姓名返回他所有的借书记录
	$uname = $_POST['uname'];
	$result = getUserRecord($uname);
	echo urldecode(json_encode(getInfo(101,$result)));
	
 ?>