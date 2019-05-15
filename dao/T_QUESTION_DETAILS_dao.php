<?php
require_once('../config.php');
require_once('dao_common.php');

//QUESTIONマスターから一覧を取得
function getTquestionDetailsList(){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_QUESTION_DETAILS ORDER BY NO";
  $stmt = $dbh->query($sql);
  $questionList = array();
  while ($row = $stmt->fetch()) {
	  array_push($questionList, $row) ;
  }
  return $questionList;
}


function getTquestionDetailsListByQno($qno){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_QUESTION_DETAILS WHERE QUESTION_NO = :qno ORDER BY NO";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
  $stmt->execute();
  
  $questiondetailsList = array();
  while ($row = $stmt->fetch()) {
	  array_push($questiondetailsList, $row) ;
  }
  return $questiondetailsList;
}

function getTquestionDetailsListByQnoCiflg($qno,$ciflg){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_QUESTION_DETAILS WHERE QUESTION_NO = :qno ORDER BY NO";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
  $stmt->execute();
  
  if($ciflg == 1 || $ciflg == 2){
	  $sql2 = "SELECT * FROM home_T_QUESTION_DETAILS WHERE QUESTION_NO = :qno ORDER BY NO";
	  $stmt2 = $dbh->prepare($sql2);
	  $stmt2->bindValue(':qno', 1, PDO::PARAM_STR);
	  $stmt2->execute();
  }
  
  $questiondetailsList = array();
  
  if($ciflg == 1){
	  while ($row = $stmt2->fetch()) {
		  array_push($questiondetailsList, $row) ;
	  }
  }
  
  while ($row = $stmt->fetch()) {
	  array_push($questiondetailsList, $row) ;
  }
  
  if($ciflg == 2){
	  while ($row = $stmt2->fetch()) {
		  array_push($questiondetailsList, $row) ;
	  }
  }
  
  return $questiondetailsList;
}

//QUESTIONマスターから行削除（成功したらtrue）
function deleteTquestionByQno($qno){
  $dbh = getcConectDb();
  $sql = "DELETE FROM home_T_QUESTION_DETAILS WHERE QUESTION_NO = :qno ";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  $dbh = null;
  return $flag;
}


?>