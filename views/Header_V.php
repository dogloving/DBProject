<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>数据库管理系统</title>
	<script src="/DBProject/assets/js/jquery.js"></script>
	<script src="/DBProject/assets/js/help.js"></script>
	<link rel="stylesheet" href="/DBProject/assets/css/base.css">
	<link rel="stylesheet" href="/DBProject/assets/css/help.css">
	<style>
		body{margin:0px;background-image:url('/DBProject/assets/img/background.webp');padding-bottom:100px;}
		a{text-decoration: none;}
		table{border-collapse:collapse;}
		table th{border:solid 1px;}
		table td{border:solid 1px;}
	</style>
</head>
<body>
	<div class="header">
		<a href="/DBProject/index.php"><img src="/DBProject/assets/img/home.jpg" alt="home.jpg" style="height:50px;width:150px;"></a>
		<a href="" id="aa"><span id="uuname" style="float:fixed;display:inline;float:right;line-height:90px;margin-right:160px;"></span></a>
		<h4 style="display:inline;float:right;line-height:50px;">用户：</h4>
	</div>
		<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=3>
	<?php 

	if(isset($_COOKIE['user'])){
		$html = sprintf("<script>document.getElementById('uuname').innerText='%s';</script>",$_COOKIE['user']);
		echo $html;
		if($_COOKIE['user'] == 'root'){
			echo "<script>document.getElementById('aa').setAttribute('href','/DBProject/views/Admin_V.php');</script>";
		}else{
			echo "<script>document.getElementById('aa').setAttribute('href','/DBProject/views/User_V.php');</script>";
		}
	}

 	?>

	

		
