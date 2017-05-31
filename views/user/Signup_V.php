<?php require('../Header_V.php'); ?>
	<!-- 注册信息填写 -->
	<div class="mysign">
		<input type="text" id="username" class="myinput" placeholder="用户名"><br>
		<input type="password" id="pass" class="myinput" placeholder="设置密码"><br>
		<input type="password" id="rpass" class="myinput" placeholder="确认密码"><br>
		性别: <label><input type="radio" name="gender" value="male" id="gender">男</label><label><input type="radio" name="gender" value="female">女</label><br>
		<button id="signup" style="width:250px;height:25px;margin-left:25px;">注册</button>
	</div>
		
	


	<script>
		//监听注册点击按钮
		$sign_up = $('#signup');
		$sign_up.click(function(e){
			check();
		});
		function check(){
			var pass = $('#pass').val().trim();
			var rpass = $('#rpass').val().trim();
			var username = $('#username').val().trim();
			var gender = $('#gender').val().trim();
			if(pass != rpass){
				alert('两次密码不一致');
				$('#rpass').val('');
				return;
			}
			signup(username,pass,gender);
		}

		function signup(username,password,gender){
			//发送ajax请求
			$.ajax({
				url: '../../controllers/user/SignUp_C.php',
				type: 'post',
				data:{
					username:username,
					password:password,
					gender:gender
				},
				success:function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						alert("wrong");
						console.log(data);
						console.log(e);
						return;
					}
					if(data.Flag > 0){
						alert("注册成功");
						login(username,password);
					}else if(data.Flag < 0){
						alert(data.Content);
						return;
					}
				},
				error:function(data){

				}
			})
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
						alert("允许登陆");
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