<?php require('../Header_V.php'); ?>
	<div class="mysign" style="margin-top:20px;">
		<input type="text" id="bid" placeholder="书的ID" class="myinput" style="width:200px;">
		<button id="btn" style="height:28px;">还书</button>
	</div>
	
	<table id="mybook" class="mytable"></table>
	<script>
		getMyBook();
		var $btn = $('#btn');
		$btn.click(function(e){
			check();
		});
		function check(){
			var bid = $('#bid').val().trim();
			if(bid.length == 0){
				alert("不能为空");
				return;
			}
			returnBook(bid);
		}
		function returnBook(bid){
			//发送ajax请求
			$.ajax({
				url: '../../controllers/user/ReturnBook_C.php',
				type: 'post',
				data:{
					bid: bid
				},
				success: function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						alert('error');
						console.error(e);
						return;
					}
					if(data.Flag){
						getMyBook();
					}else{
						alert(data.Content);
					}
				}
			})
		}
		function getMyBook(){
			//发送ajax请求
			$.ajax({
				url: '../../controllers/book/GetMyBook_C.php',
				type: 'post',
				data:{

				},
				success: function(data){
					try{
						data = JSON.parse(data);
					}catch(e){
						console.error(e);
						return;
					}
					var mybook = document.getElementById('mybook');
					while(mybook.firstChild){
						mybook.removeChild(mybook.firstChild);
					}
					var caption = document.createElement('caption');
					caption.setAttribute('class','mycaption');
					caption.innerText = "书籍列表";
					mybook.appendChild(caption);
					var tr = document.createElement('tr');
					var th0 = document.createElement('th');th0.innerText = "书籍ID";tr.appendChild(th0);
					var th1 = document.createElement('th');th1.innerText = "书籍名字";tr.appendChild(th1);
					var th2 = document.createElement('th');th2.innerText = "借书日期";tr.appendChild(th2);
					mybook.appendChild(tr);
					var books = data.Content;
					for(var i = 0;i < books.length;++i){
						var tr = document.createElement('tr');
						var td0 = document.createElement('td');td0.innerText = books[i]['BID'];tr.appendChild(td0);
						var td1 = document.createElement('td');td1.innerText = books[i]['Name'];tr.appendChild(td1);
						var td2 = document.createElement('td');td2.innerText = books[i]['BrwTime'];tr.appendChild(td2);
						mybook.appendChild(tr);
					}
				}
			})
		}
	</script>


<?php require('../Footer_V.php'); ?>