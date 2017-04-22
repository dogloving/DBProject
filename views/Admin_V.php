<?php require('header_V.php'); ?>

	<h1 style="text-align:center;">管理员界面</h1>
	<div class="outer" style="padding-left:300px;">
		<a href="/DBProject/views/admin/Entry_V.php"><div class="inner">录入书籍</div></a>
		<a href="/DBProject/views/admin/DelUser_V.php"><div class="inner">删除用户</div></a>
		<a href="/DBProject/views/admin/Userbook_V.php"><div class="inner">所有借书记录</div></a>
		<a href="/DBProject/views/admin/UpdatePuber_V.php"><div class="inner">修改出版商信息</div></a>
	</div>
<?php 
	if(!isset($_COOKIE['user'])){
		header('Location:/DBProject/views/user/Sign_V.php');
	}
 ?>		
<?php require('footer_V.php'); ?>