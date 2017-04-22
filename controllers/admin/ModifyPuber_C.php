<?php 
	require('../../models/AdminModel_M.php');
	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}

	$oldname = $_POST['oldname'];
	$newname = $_POST['newname'];
	
	$result = modifyPuber($oldname,$newname);
	if($result){
		echo urldecode(json_encode(getInfo(101,"修改成功")));
	}else{
		echo urldecode(json_encode((getInfo(-9,"修改失败"))));
	}


	
 ?>