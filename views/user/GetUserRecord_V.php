<?php require('../Header_V.php'); ?>
	<div class="mysign" style="margin-top:20px;">
		<input type="text" id="uname" placeholder="用户名" class="myinput">
		<button id="btn" style="width:200px;height:25px;margin-left:40px;">查看</button>	
	</div>
	
	<table id="user" class="mytable"></table>
	<br><br><br><br>
	<table id="record" class="mytable" style="margin-top:20px;"></table>
	<script>
		getUserList();
		var $btn = $('#btn');
		$btn.click(function(e){
			check();
		});
		function check(){
			var uname = $('#uname').val().trim();
			if(uname.length == 0){
				alert("不能为空");
				return;
			}
			getRecord(uname);
		}
		function getRecord(uname){
			//发送ajax请求
			$.ajax({
				url: '../../controllers/user/GetUserRecord_C.php',
				type: 'post',
				data:{
					uname: uname
				},
				success: function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						console.error(e);
						return;
					}
					var record = document.getElementById('record');
					while(record.firstChild){
						record.removeChild(record.firstChild);
					}
					var caption = document.createElement('caption');
					caption.innerText = "用户借书记录";
					caption.setAttribute('class','mycaption');
					record.appendChild(caption);
					var tr = document.createElement('tr');
					var th1 = document.createElement('th');th1.innerText = "姓名";tr.appendChild(th1);
					var th2 = document.createElement('th');th2.innerText = "书名";tr.appendChild(th2);
					var th3 = document.createElement('th');th3.innerText = "借阅时间";tr.appendChild(th3);
					var th4 = document.createElement('th');th4.innerText = "还书时间";tr.appendChild(th4);
					record.appendChild(tr);
					var records = data.Content;
					for(var i = 0;i < records.length;++i){
						var tr = document.createElement('tr');
						var td1 = document.createElement('td');td1.innerText = records[i]['uName'];tr.appendChild(td1);
						var td2 = document.createElement('td');td2.innerText = records[i]['bName'];tr.appendChild(td2);
						var td3 = document.createElement('td');td3.innerText = records[i]['BrwTime'];tr.appendChild(td3);
						var td4 = document.createElement('td');td4.innerText = records[i]['RtTime'];tr.appendChild(td4);
						record.appendChild(tr);	
					}
				}
			})
		};
		function getUserList(){
			$.ajax({
				url: '../../controllers/admin/GetUserList_C.php',
				type: 'post',
				data:{

				},
				success: function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						console.error(e);
					}
					var user = document.getElementById('user');
					while(user.firstChild){
						user.removeChild(user.firstChild);
					}
					var caption = document.createElement('caption');
					caption.setAttribute('class','mycaption');
					caption.innerText = "用户列表";
					user.appendChild(caption);
					var tr = document.createElement('tr');
					var th1 = document.createElement('th');th1.innerText = "姓名";tr.appendChild(th1);
					var th2 = document.createElement('th');th2.innerText = "性别";tr.appendChild(th2);
					user.appendChild(tr);
					var users = data.Content;
					for(var i = 0;i < users.length;++i){
						var tr = document.createElement('tr');
						var td1 = document.createElement('td');td1.innerText = users[i]['Name'];tr.appendChild(td1);
						var td2 = document.createElement('td');td2.innerText = users[i]['Gender'];tr.appendChild(td2);
						user.appendChild(tr);
					}
				}
			})
		}

	</script>


<?php require('../Footer_V.php'); ?>