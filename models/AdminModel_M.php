<?php 
	function getHandler(){
		$host = 'localhost';
		$database = 'dbproject';
		$username = 'root';
		$password = 'mysql930';
		$pdo = new PDO("mysql:host=$host;dbname=$database",$username,$password);
		$pdo->exec('set names "utf8"');
		return $pdo;
	}

	/**
	*	录入书籍信息
	*	@return 1->录入成功;2->已经存在此书；
	*/
	function entry_M($name,$price,$cate,$puber){
		$pdo = getHandler();
		//先检查数据库中是否已经有该书
		$sql = sprintf("select * from book where Name = '%s' and Puber = '%s'",$name,$puber);

		$result = $pdo->query($sql);
		
		if($result->rowCount()){
			return 2;
		}
		$bid = uniqid();
		//检查数据库中是否存在该出版商，若不存在则插入
		$sql = sprintf("select * from publisher where Name = '%s'",$puber);
		$result = $pdo->query($sql);
		if($result->rowCount()){
			//数据库中已经有该出版商就获取该出版商的PID
			foreach($result as $row){
				$pid = $row['PID'];
			}
		}else{
			//数据库中不存在就将该出版商信息存入数据库中
			$pid = uniqid();
			$sql = sprintf("insert into publisher values('%s','%s')",$pid,$puber);
			$pdo->query($sql);
		}
		//将书和出版商关系的信息保存到数据库中
		$sql = sprintf("insert into bookpuber values('%s','%s')",$bid,$pid);
		$pdo->query($sql);

		//检查数据库中是否存在该目录，若不存在则插入
		$sql = sprintf("select * from category where Name = '%s'",$cate);
		$result = $pdo->query($sql);
		if($result->rowCount()){
			//数据库中已经有该类别就获取该类别的CID
			foreach($result as $row){
				$cid = $row['CID'];
			}
		}else{
			$cid = uniqid();
			$sql = sprintf("insert into category values('%s','%s')",$cid,$cate);
			$pdo->query($sql);
		}
		//将书和类别关系的信息存入数据库中
		$sql = sprintf("insert into bookcate values('%s','%s')",$bid,$cid);
		$pdo->query($sql);
		//将书籍信息存入数据库
		$sql = sprintf("insert into book values('%s','%s','%f','%d','%d','%s','%s')",$bid,$name,$price,1,0,$puber,$cate);
		$pdo->query($sql);
		return 1;
	}

	/**
	*	删除用户信息
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
	  		$pdo->commit();
	  		if($result->rowCount())
	  			return true;
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			//如果事务执行失败就先抛出异常，然后事务回滚，数据库返回之前的状态
  			$pdo->rollback();
  			return false;
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
	*	@return true->修改成功 false->修改失败
	*/
	function modifyPuber($oldname,$newname){
		$pdo = getHandler();
		$sql = sprintf("call upd_pro('%s','%s')",$oldname,$newname);
		$result = $pdo->query($sql);
		return $result;
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