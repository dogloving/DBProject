<?php require('Header_V.php'); ?>
	<h1 style="text-align:center;">用户界面</h1>
	<div class="outer" style="padding-left:550px;">
		<a href="/DBProject/views/user/Borrowbook_V.php"><div class="inner">借书</div></a>
		<a href="/DBProject/views/user/Returnbook_V.php"><div class="inner">还书</div></a>
	</div>
<?php 
	if(!isset($_COOKIE['user'])){
		header('Location:/DBProject/views/user/Sign_V.php');
	}
 ?>	
<?php require('Footer_V.php'); ?>