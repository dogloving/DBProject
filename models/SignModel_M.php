<?php 
	function getHandler(){
		$host = 'localhost';
		$database = 'dbproject';
		$username = 'root';
		$password = 'mysql930';
		$pdo = new PDO("mysql:host=$host;dbname=$database",$username,$password);  
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->exec('set names "utf8"');
		return $pdo;
	}

	/**
	*	登陆函数：检查数据库中是否有这一tuple
	*	@return 0->不允许登陆 1->普通用户 2->管理员
	*/
	function signIn_M($username,$password){
		$pdo = getHandler();
		$sql = sprintf("select * from user where name = '%s' and password='%s'",$username,$password);
		$result = $pdo->query($sql);
		if($result->rowCount()){
			//获取用户类型：1为普通用户，2为管理员
			//设置Cookie
			$cookie = null;
			foreach ($result as $row) {
				//echo $row['Name'];
				$cookie = $row['Name'];
				$type = $row['Type'];
			}
			setcookie("user",$cookie,time()+9999,'/');
			//echo $cookie;
			return $type;
		}else{
			return 0;
		}
		
		
	}

	/**
	*	注册函数:先检查数据库中是否有重复的Name，若没有将信息插入数据库
	*	@return 1->插入成功	2->有重复Name 3->其他错误
	*/
	function signUp_M($username,$password,$gender){
		//先检查数据库中是否已经有相同的Name
		$pdo = getHandler();
		$sql = sprintf("select * from user where name = '%s'",$username);
		$result = $pdo->query($sql);
		if($result->rowCount()){
			return 2;
		}
		$uid = uniqid();
		$brwid = uniqid();
		$sql = sprintf("insert into user values('%s','%s','%s','%s','%s','%d')",$uid,$brwid,$username,$gender,$password,1);
		$result = $pdo->query($sql);
		if($result->rowCount()){
			return 1;
		}
		return 3;
	}



 ?>