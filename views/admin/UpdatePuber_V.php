<?php require('../Header_V.php'); ?>
	<div class="mysign" style="margin-top:20px;">
		<input type="text" id="oldname" placeholder="原来的名字" class="myinput"><br>
		<input type="text" id="newname" placeholder="新名字" class="myinput"><br>
		<button id="btn" style="width:200px;margin-left:50px;">修改</button>
	</div>
	<table id="puber" class="mytable" style="margin-top:-30px;"></table>

	<script>
		getPuber();
		var $btn = $('#btn');
		$btn.click(function(e){
			check();
		});
		function check(){
			var oldname = $('#oldname').val().trim();
			var newname = $('#newname').val().trim();
			if(oldname.length == 0 || newname.length == 0){
				alert("不能为空");
				return;
			}
			var names = localStorage['pubernames'];
			//if(names.indexOf(oldname) == -1 || names.indexOf(newname) != -1){
			//	alert('无效更改');
			//	return;
			//}
			modify(oldname,newname);
		}
		function modify(oldname,newname){
			$.ajax({
				url: '/DBProject/controllers/admin/ModifyPuber_C.php',
				type: 'post',
				data:{
					oldname: oldname,
					newname: newname
				},
				success: function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						alert(e);
						return;
					}
					if(data.Flag > 0){
						alert(data.Content);
						getPuber();
					}else{
						alert(data.Content);
						alert('修改失败');
					}
					
				}
			})
		}
		function getPuber(){
			$.ajax({
				url: '/DBProject/controllers/admin/GetPuber_C.php',
				type: 'post',
				data:{

				},
				success:function(data){
					try{
						data =  JSON.parse(data);
					}catch(e){
						console.error(e);
						return;
					}
					var puber = document.getElementById('puber');
					while(puber.firstChild){
						puber.removeChild(puber.firstChild);
					}
					var tr = document.createElement('tr');
					var th = document.createElement('th');th.innerText = "出版商名字";tr.appendChild(th);
					puber.appendChild(tr);
					var names = new Array();
					var pubers = data.Content;
					for(var i = 0;i < pubers.length;++i){
						var tr = document.createElement('tr');
						tr.setAttribute('style','text-align:center;');
						var td = document.createElement('td');td.innerText = pubers[i]['Name'];
						tr.appendChild(td);
						puber.appendChild(tr);
						names.push(pubers[i]['Name']);
					}
					localStorage.setItem('pubernames',JSON.stringify(names));
				}
			})
		}
	</script>

<?php require('../Footer_V.php'); ?>