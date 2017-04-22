<?php require('../Header_V.php'); ?>
	<div class="mysign" style="margin-top:20px;">
		<input type="text" id="name" placeholder="书名" class="myinput"><br>
		<input type="number" id="price" placeholder="价格" class="myinput"><br>
		<input type="text" id="cate" placeholder="类别" class="myinput"><br>
		<input type="text" id="puber" placeholder="出版商" class="myinput"><br>
		<button id="smt" style="width:200px;height:25px;margin-left:40px;">提交</button>
	</div>

<script>
	$smt = $('#smt');
	$smt.click(function(e){
		check();
	});
	function check(){
		var name = $('#name').val().trim();if(name.length == 0){alert('书籍名称不能为空');return;}
		var price = $('#price').val().trim();if(price.length == 0){alert('书籍价格不能为空');return;}
		if(price < 0){alert("价格不能为负");return;}
		var cate = $('#cate').val().trim();if(cate.length == 0){alert('书籍类别不能为空');return;}
		var puber = $('#puber').val().trim();if(puber.length == 0){alert('书籍出版商不能为空');return;}
		submit(name,price,cate,puber);
	}

	function submit(name,price,cate,puber){
	
		//ajax请求
		$.ajax({
			url: '/DBProject/controllers/admin/Entry_C.php',
			type: 'post',
			data:{
				name:name,
				price:price,
				cate:cate,
				puber:puber
			},
			success:function(data){
				try{
					alert(data);
					data = JSON.parse(data);
				}catch(e){
					alert("wrong");
					console.log(data);
					console.log(e);
					return;
				}
				if(data.Flag < 0){
					alert(data.Content);
				}else if(data.Flag > 0){
					alert(data.Content);
				}
			},
			error:function(data){
				try{
					alert(data);
					data = JSON.parse(data);
				}catch(e){
					console.log(e);
					return;
				}
				alert(data);

			}
		})
	}
</script>

<?php require('../Footer_V.php'); ?>