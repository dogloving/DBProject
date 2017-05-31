<?php require('../Header_V.php'); ?>
	<div class="mysign">
		<input type="text" name="username" id="username" placeholder="用户名" class="myinput"><br>
		<input type="password" name="password" id="password" placeholder="密码" class="myinput"><br>
		<button id="smt" style="width:250px;height:25px;margin-left:25px;">登陆</button>	
	</div>

<script>
	$('#username').val('');
	$('#password').val('');
</script>
<script>
	$login_btn = $('#smt');
	$login_btn.click(function(e){
		check();
	});
	function check(){
		username = $('#username').val().trim();
		if(username.length == 0){
			alert("名字不能为空");
			return false;
		}
		password = $('#password').val().trim();
		if(password.length == 0){
			alert("密码不能为空");
			return false;
		}
		login(username,password);
			
	}
	function login(username,password){
		//发送ajax请求
		$.ajax({
			url:'../../controllers/user/SignIn_C.php',
			type:'post',
			data:{
				username:username,
				password:password
			},
			success:function(data){
				try{
					data = JSON.parse(data);
				}catch(e){
					console.log(e);
					alert("发生错误");
					return;
				}
				//检查返回Flag
				if(data.Flag < 0){
					alert("账号或密码错误");
					return;
				}else{
					if(data.Content == 1){
						window.location.href = '../User_V.php';	
					}else{
						window.location.href = '../Admin_V.php';
					}
					
					return;
				}
			},
			error:function(data){

			}
		});
	}
</script>
<?php require('../Footer_V.php'); ?>