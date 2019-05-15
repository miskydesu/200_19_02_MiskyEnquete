<?php
require_once('../config.php');
require_once('dao_common.php');

//idとパスワードに一致するユーザを取得
function getTuser($id,$pswd){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_M_USER WHERE USER_ID = :id AND PASSWORD = :pswd";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':id', $id, PDO::PARAM_STR);
  $stmt->bindValue(':pswd', $pswd, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetch();

  $dbh = null;
  return $user;
}

//USERマスターから一覧を取得
function getTuserList(){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_M_USER ORDER BY NO";
  $stmt = $dbh->query($sql);
  $userList = array();
  while ($row = $stmt->fetch()) {
	  array_push($userList, $row) ;
  }
    
  $dbh = null;
  return $userList;
}

//idに一致する情報を取得
function getTuserByNo($no){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_M_USER WHERE NO = :no";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':no', $no, PDO::PARAM_INT);
  $stmt->execute();
  $user = $stmt->fetch();

  $dbh = null;
  return $user;
}

//userid_iに一致する情報を取得
function getTuserByUserId($userid){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_M_USER WHERE USER_ID = :userid";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
  $stmt->execute();
  $user = $stmt->fetch();

  $dbh = null;
  return $user;
}

//USERマスターから行削除（成功したらtrue）
function deleteTuser($no){
  $dbh = getcConectDb();
  $sql = "DELETE FROM home_M_USER WHERE NO = :no ";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':no', $id, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  $dbh = null;
  return $flag;
}
//USERマスターに行追加（成功したらtrue）
function insertTuser($username,$userid,$password){
  $dbh = getcConectDb();
  $sql = "INSERT INTO home_M_USER (USER_NAME,USER_ID,PASSWORD) VALUES( :name, :userid, :password)";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':name', $username, PDO::PARAM_STR);
  $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  $dbh = null;
  return $flag;
}
//USERマスターに行変更（成功したらtrue）
function updateTuser($no,$username,$userid,$password){
  $dbh = getcConectDb();
  $sql = "UPDATE home_M_USER SET USER_NAME = :name,USER_ID = :userid,PASSWORD = :password  WHERE NO = :no";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':no', $no, PDO::PARAM_STR);
  $stmt->bindValue(':name', $username, PDO::PARAM_STR);
  $stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  $dbh = null;
  return $flag;
}

?>