<?php require('../Header_V.php'); ?>
	
	<div class="mysign" style="margin-top:20px;">
		<input type="text" id="name" placeholder="学生姓名">
		<button id="btn">删除</button>	
	</div>
	<div><table id="userlist" style="margin-top:-90px;margin-left:auto;margin-right:auto;"></table></div>
	<div><table id="allrecord" style="margin-top:5px;margin-left:auto;margin-right:auto;"></table></div>
	
	
	

	
	<script>
		getUser();
		getRecord();
		$btn = $('#btn');
		$btn.click(function(e){
			check();
		})
		function check(){
			var uname = $('#name').val().trim();
			if(uname.length == 0){
				alert("不能为空");
				return;
			}
			delUser(uname);
		}
		function delUser(uname){
			//发送ajax请求
			$.ajax({
				url: '../../controllers/admin/DelUser_C.php',
				type: 'post',
				data:{
					uname: uname
				},
				success: function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						alert('delUser error');
						alert(e);
						return;
					}
					if(data.Flag){
						alert(data.Content);
						getUser();
						getRecord();
					}else{
						alert(data.Content);
					}
				},
				error:function(data){
				
				}
			})

		}
		function getUser(){
			//从服务器获取所有用户信息并且显示在列表中
			$.ajax({
				url: '../../controllers/admin/GetUser_C.php',
				type: 'post',
				data:{

				},
				success: function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						alert('getUser error');
						alert(e);
						return;
					}
					var userlist = document.getElementById('userlist');
					while(userlist.firstChild){
						userlist.removeChild(userlist.firstChild);
					}
					var caption = document.createElement('caption');
					caption.innerText = "用户列表";
					caption.setAttribute('class','mycaption');
					userlist.appendChild(caption);
					var tr = document.createElement('tr');
					var th3 = document.createElement('th');th3.innerText="Name";tr.appendChild(th3);
					var th4 = document.createElement('th');th4.innerText="Gender";tr.appendChild(th4);
					var th5 = document.createElement('th');th5.innerText="Password";tr.appendChild(th5);
					userlist.appendChild(tr);
					var list = data.Content;
					for(var i = 0;i < list.length;i++){
						var tr = document.createElement('tr');
						var td3 = document.createElement('td');td3.innerText = list[i]['Name'];tr.appendChild(td3);
						var td4 = document.createElement('td');td4.innerText = list[i]['Gender'];tr.appendChild(td4);
						var td5 = document.createElement('td');td5.innerText = list[i]['Password'];tr.appendChild(td5);
						userlist.appendChild(tr);
					}
				}
			});
		}
		function getRecord(){
			$.ajax({
				url: '../../controllers/admin/GetRecord_C.php',
				type: 'post',
				data:{

				},
				success: function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						alert('getRecord error');
						console.error(e);
						return;
					}
					var allrecord = document.getElementById('allrecord');
					while(allrecord.firstChild){
						allrecord.removeChild(allrecord.firstChild);
					}
					var caption = document.createElement('caption');
					caption.innerText = "借书列表";
					caption.setAttribute('class','mycaption');
					allrecord.appendChild(caption);
					var tr = document.createElement('tr');
					var th1 = document.createElement('th');th1.innerText = "用户姓名";tr.appendChild(th1);
					var th2 = document.createElement('th');th2.innerText = "书籍名称";tr.appendChild(th2);
					var th3 = document.createElement('th');th3.innerText = "借书时间";tr.appendChild(th3);
					var th4 = document.createElement('th');th4.innerText = "还书时间";tr.appendChild(th4);
					allrecord.appendChild(tr);
					var records = data.Content;
					for(var i = 0;i < records.length;++i){
						var tr = document.createElement('tr');
						var td1 = document.createElement('td');td1.innerText = records[i]['uName'];tr.appendChild(td1);
						var td2 = document.createElement('td');td2.innerText = records[i]['bName'];tr.appendChild(td2);
						var td3 = document.createElement('td');td3.innerText = records[i]['BrwTime'];tr.appendChild(td3);
						var td4 = document.createElement('td');td4.innerText = records[i]['RtTime'];tr.appendChild(td4);
						allrecord.appendChild(tr);
					}

				}
			})
		}
	</script>
	
<?php require('../Footer_V.php'); ?>