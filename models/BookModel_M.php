<?php 
	function getHandler(){
		$host = 'localhost';
		$database = 'dbproject';
		$username = 'root';
		$password = 'root';
		$pdo = new PDO("mysql:host=$host;dbname=$database",$username,$password);
		$pdo->exec('set names "utf8"');
		return $pdo;
	}

	/**
	*	获取所有书籍信息
	*	@return 所有书籍信息的数组
	*/
	function getAllBook(){
		$pdo = getHandler();
		$sql = "select * from book";
		$result = $pdo->query($sql);
		return $result->fetchAll();
	}

	/**
	*	借书
	*	@return true->借书成功 false->借书失败
	*/
	function borrow($bid,$uid){
		$pdo = getHandler();
		$sql = sprintf("update book set State = 2 where BID = '%s' and State = 1",$bid);
		$result = $pdo->query($sql);
		if(! $result->rowCount()){
			return false;
		}
		//将书的借阅次数加1
		$sql = sprintf("update book set BrwCount = BrwCount+1 where BID = '%s'",$bid);
		$result = $pdo->query($sql);
		if(!$result->rowCount()){
			return false;
		}
		//在UserBook中插入一条记录
		$brwtime = date("Y-m-d");
		$sql = sprintf("insert into userbook values('%s','%s','%s','%s')",$uid,$bid,$brwtime,"3999-12-30");
		$result = $pdo->query($sql);
		if($result->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	/**
	*	还书
	*	@param uid->用户id  bid->书id
	*	@return true->还书成功 false->还书失败
	*/
	function returnBook($uid,$bid){
		$pdo = getHandler();
		$rttime = date('Y-m-d');
		$sql = sprintf("update userbook set RtTime = '%s' where User = '%s' and Book = '%s'",$rttime,$uid,$bid);
		$result = $pdo->query($sql);
		if(!$result->rowCount()){
			return false;
		}
		//将书的状态设置为可借
		$sql = sprintf("update book set State = 1 where BID = '%s'",$bid);
		$result = $pdo->query($sql);
		if($result->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	/**
	*	根据用户ID返回他借的的所有书
	*	@return 返回该用户借的所有书的数组
	*/
	function getMyBook($uid){
		$pdo = getHandler();
		$sql = sprintf("select Name,BrwTime,BID from book,userbook where User = '%s' and Book = BID and State = 2 and RtTime = '3999-12-30'",$uid);
		$result = $pdo->query($sql);
		return $result->fetchAll();
	}


 ?>