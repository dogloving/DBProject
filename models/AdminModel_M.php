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
	*	录入书籍信息
	*	@return true->录入成功
	*/
	function entry_M($name,$price,$cate,$puber){
		$pdo = getHandler();
		try{
			$bid = uniqid();
			$sql = sprintf("insert into Book values('%s','%s','%f','%d','%d','%s','%s')",$bid,$name,$price,1,0,$puber,$cate);
			$pdo->query($sql);
			//如果上述操作没有违背触发器条件就在书本出版商关系表、书本类别关系表中插入数据
			//BookPuber表中插入数据
			$sql = sprintf("select PID from Publisher where Name = '%s'",$puber);
			$result = $pdo->query($sql);
			if($result->rowCount()){
				foreach ($result as $row) {
					$pid = $row['PID'];
				}
			}
			$sql = sprintf("insert into BookPuber values('%s','%s')",$pid,$puber);
			$pdo->query($sql);
			//BookCate表中插入数据
			$sql = sprintf("select CID from Category where Name = '%s'",$cate);
			$result = $pdo->query($sql);
			if($result->rowCount()){
				foreach ($result as $row) {
					$pid = $row['CID'];
				}
			}
			$sql = sprintf("insert into BookCate values('%s','%s')",$pid,$cate);
			$pdo->query($sql);
			return true;
		}catch(PDOException $e){
			//return 2;
			return $e->getMessage();
		}
		
	}

	/**
	*	删除用户借书信息
	*	@return true:删除成功 false:删除失败
	*/
	function delUser_M($uname){
		$pdo = getHandler();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//开始事务
  		try{
  			$pdo->beginTransaction();
  			//先删除UserBook中的数据然后删除User
	  		$sql = sprintf("select user,Book from user,userbook where Name = '%s' and User = user.UID",$uname);
	  		$pairs = $pdo->query($sql);//获取所有需要删除的UserBook中的pair
	  		foreach($pairs as $row){
	  			$sql = sprintf("delete from userbook where user = '%s' and book = '%s'",$row['User'],$row['Book']);
	  			$result = $pdo->query($sql);
	  			if(!$result->rowCount()){
	  				return false;
	  			}
	  		}
	  		//删除User
	  		$sql = sprintf("delete from user where Name = '%s'",$uname);
	  		$result = $pdo->query($sql);

	  		//test of rollback
	  		$sql = 'call test()';
	  		//$pdo->query($sql);

	  		$pdo->commit();
	  		if($result->rowCount())
	  			return true;
  		}catch(PDOException $e){
  			//如果事务执行失败就先抛出异常，然后事务回滚，数据库返回之前的状态
  			$pdo->rollback();
  			return $e->getMessage();
  		}

	}

	/**
	*	获取所有用户信息
	*	@return 包含所有用户信息的数组
	*/
	function getUser_M(){
		$pdo = getHandler();
		$sql = "select * from user";
		$result = $pdo->query($sql);
		return $result->fetchAll();
	}

	/**
	*	根据给出的用户ID、书籍ID和借阅日期删除该条记录
	*	@return true->删除成功 false->删除失败
	*/
	function delRecord_M($User,$Book,$BrwTime){
		$pdo = getHandler();
		$sql = sprintf("delete from userbook where User = '%s' and Book = '%s' and BrwTime = '%s'",$User,$Book,$BrwTime);
		$result = $pdo->query($sql);
		if($result->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	/**
	*	获取所有用户借阅记录
	*	@return 包含所有用户借阅信息的记录
	*/
	function getRecord(){
		$pdo = getHandler();
		$sql = "select user.Name uName,book.Name bName,BrwTime,RtTime,userbook.User ubUser,userbook.Book ubBook from userbook,user,book where userbook.User = user.Name and userbook.Book = book.BID";
		$result = $pdo->query($sql);
		return $result->fetchAll();
	}
	/**
	*	获取所有用户列表
	*	@return 包含所有用户信息的数组
	*/
	function getUserList(){
		$pdo = getHandler();
		$sql = "select Name,Gender from user";
		$result = $pdo->query($sql);
		return $result->fetchAll();
	}
	/**
	*	根据用户姓名获取他所有的借书记录
	*	@param uname 用户姓名
	*	@return 包含该用户所有借书记录的数组
	*/
	function getUserRecord($uname){
		$pdo = getHandler();
		$sql = sprintf("select * from recordview where uName = '%s' ",$uname);
		$result = $pdo->query($sql);
		return $result->fetchAll();
	}
	/**
	*	修改出版商名字
	*/
	function modifyPuber($oldname,$newname){
		$pdo = getHandler();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try{
			$sql = sprintf("call upd_pro('%s','%s')",$oldname,$newname);
			$result = $pdo->query($sql);
			return $result;
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}
	/**
	*	返回所有出版商的信息
	*	@return 包含所有出版商信息的数组
	*/
	function getPuber(){
		$pdo = getHandler();
		$sql = "select Name from publisher";
		$result = $pdo->query($sql);
		return $result->fetchAll();
	}


 ?>