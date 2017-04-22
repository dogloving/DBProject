<?php require('../Header_V.php'); ?>

	<div class="mysign" style="margin-top:20px;">
		<input type="text" id="bid" placeholder="书籍编号">
		<button id="btn">借书</button>
	</div>
	<table id="book" style="margin-top:-90px;margin-left:auto;margin-right:auto;"></table>
	<script>
		getBook();
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
			borrow(bid);
		}
		function borrow(bid,uid){
			//发送ajax请求
			$.ajax({
				url: '../../controllers/user/Borrow_C.php',
				type: 'post',
				data:{
					bid: bid
				},
				success: function(data){
					try{
						alert(data);
						data = JSON.parse(data);
					}catch(e){
						alert("fuck");
						console.log(e);
						return;
					}
					if(data.Flag > 0){
						alert(data.Content);
						getBook();
					}else{
						alert(data.Content);
					}

				}
			})
		}
		function getBook(){
			$.ajax({
				url: '../../controllers/book/GetBook_C.php',
				type: 'post',
				data:{

				},
				success: function(data){
					try{
						alert(data);
						data = JSON.parse(data);
					}catch(e){
						console.log(e);
						return;
					}
					var books = data.Content;
					var book = document.getElementById('book');
					while(book.firstChild){
						book.removeChild(book.firstChild);
					}
					var caption = document.createElement('caption');
					caption.innerText = "书籍列表";
					caption.setAttribute('class','mycaption');
					book.appendChild(caption);
					var tr = document.createElement('tr');
					var th1 = document.createElement('th');th1.innerText = "书籍编号";tr.appendChild(th1);
					var th2 = document.createElement('th');th2.innerText = "书籍名称";tr.appendChild(th2);
					var th3 = document.createElement('th');th3.innerText = "价格";tr.appendChild(th3);
					var th4 = document.createElement('th');th4.innerText = "状态";tr.appendChild(th4);
					var th5 = document.createElement('th');th5.innerText = "总被借次数";tr.appendChild(th5);
					var th6 = document.createElement('th');th6.innerText = "出版商";tr.appendChild(th6);
					var th7 = document.createElement('th');th7.innerText = "类别";tr.appendChild(th7);
					book.appendChild(tr);
					for(var i = 0;i < books.length;++i){
						var tr = document.createElement('tr');
						var td1 = document.createElement('td');td1.innerText = books[i]["BID"];tr.appendChild(td1);
						var td2 = document.createElement('td');td2.innerText = books[i]["Name"];tr.appendChild(td2);
						var td3 = document.createElement('td');td3.innerText = books[i]["Price"];tr.appendChild(td3);
						var td4 = document.createElement('td');if(books[i]['State'] == 1){td4.innerText="可借";}else{td4.innerText="不可借";}tr.appendChild(td4);
						var td5 = document.createElement('td');td5.innerText = books[i]["BrwCount"];tr.appendChild(td5);
						var td6 = document.createElement('td');td6.innerText = books[i]["Puber"];tr.appendChild(td6);
						var td7 = document.createElement('td');td7.innerText = books[i]["cate"];tr.appendChild(td7);
						book.appendChild(tr);
					}
				}
			})
		}
	</script>


<?php require('../Footer_V.php'); ?>