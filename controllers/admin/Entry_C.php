<?php 
	require('../../models/AdminModel_M.php');

	/**
	*	@param $Flag:101->success positive:fail
	*/
	function getInfo($Flag,$Content){
		$info = array("Flag"=>$Flag,"Content"=>$Content);
		return $info;
	}

	$name = $_POST['name'];
	$price = $_POST['price'];
	$cate = $_POST['cate'];
	$puber = $_POST['puber'];

	// echo urldecode(json_encode(getInfo(101,$puber)));
	// return;

	//  $result = entry_M($name,$price,$cate,$puber);
	//  echo urldecode(json_encode(getInfo(101,$result)));
	// return;
	$result = entry_M($name,$price,$cate,$puber);
	if(is_bool($result) && $result){
		echo urldecode(json_encode(getInfo(101,"录入成功")));
	}else{
		echo urldecode(json_encode(getInfo(-3,$result)));
	}

 ?>