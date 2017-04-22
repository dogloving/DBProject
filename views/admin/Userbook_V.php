<?php require('../Header_V.php'); ?>

	<div class="mysign" style="margin-top:20px;">
		<input type="text" id="rid" placeholder="记录编号" style="width:150px;height:25px;">
		<button id="del" style="line-height:25px;">删除记录</button>	
		<input type="text" id="uname" placeholder="用户名" style="width:150px;display:inline;">
		<button id="btn" style="width:50px;height:25px;line-height:25px;">查看</button>	
	</div>
	<table id="user" class="mytable" style="float:right;"></table>
	<table id="record" class="mytable" style="margin-top:-20px;"></table>
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
		getRecord();
		var $del = $('#del');
		$del.click(function(e){
			check();
		});
		function check(){
			var rid = $('#rid').val().trim();
			if(rid.length == 0){
				alert('不能为空');
				return;
			}else{
				var len = strToNum(localStorage['tSize']);
				rid = strToNum(rid);
				if(rid >= len || rid < 0){
					alert('编号无效');
					return;
				}
			} 
			delRecord(rid);
		}
		function delRecord(rid){
			var objs = JSON.parse(localStorage['rec']);
			//发送ajax请求
			$.ajax({
				url: '../../controllers/admin/DelRecord_C.php',
				type: 'post',
				data:{
					User: objs[rid].User,
					Book: objs[rid].Book,
					BrwTime: objs[rid].BrwTime
				},
				success: function(data){
					try{
						alert(data);
						data = JSON.parse(data);
					}catch(e){
						alert(e);
						return;
					}
					if(data.Flag){
						alert("删除成功");
						getRecord();
					}else{
						alert("删除失败");
					}
				}
			})
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
						alert(e);
						return;
					}
					if(data.Flag){
						var record = document.getElementById('record');
						while(record.firstChild){
							record.removeChild(record.firstChild);
						}
						var caption = document.createElement('caption');
						caption.innerText = "借书记录";
						caption.setAttribute('class','mycaption');
						record.appendChild(caption);
						var tr = document.createElement('tr');
						var th0 = document.createElement('th');th0.innerText = "编号";tr.appendChild(th0);
						var th1 = document.createElement('th');th1.innerText = "用户名";tr.appendChild(th1);
						var th2 = document.createElement('th');th2.innerText = "书名";tr.appendChild(th2);
						var th3 = document.createElement('th');th3.innerText = "借阅日期";tr.appendChild(th3);
						var th4 = document.createElement('th');th4.innerText = "还书日期";tr.appendChild(th4);
						record.appendChild(tr);
						var records = data.Content;
						//存储所有记录，方便删除
						var allRecord = new Array();
						for(var i = 0;i < records.length;++i){
							var tr = document.createElement('tr');
							var td0 = document.createElement('td');td0.innerText = i;tr.appendChild(td0);
							var td1 = document.createElement('td');td1.innerText = records[i]['uName'];tr.appendChild(td1);
							var td2 = document.createElement('td');td2.innerText = records[i]['bName'];tr.appendChild(td2);
							var td3 = document.createElement('td');td3.innerText = records[i]['BrwTime'];tr.appendChild(td3);
							var td4 = document.createElement('td');td4.innerText = records[i]['RtTime'];tr.appendChild(td4);
							record.appendChild(tr);
							var obj = new Object();
							obj.User = records[i]['ubUser'];obj.Book = records[i]['ubBook'];obj.BrwTime = records[i]['BrwTime'];
							allRecord.push(obj);
						}
						localStorage.setItem('rec',JSON.stringify(allRecord));
						localStorage.setItem('tSize',allRecord.length);
					}
				}
			})
		}
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