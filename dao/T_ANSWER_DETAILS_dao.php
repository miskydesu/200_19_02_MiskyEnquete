<?php
require_once('../config.php');
require_once('dao_common.php');

//ANSWERマスターから一覧を取得
function getTanswerDetailsList(){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_ANSWER_DETAILS ORDER BY NO";
  $stmt = $dbh->query($sql);
  $answerList = array();
  while ($row = $stmt->fetch()) {
	  array_push($answerList, $row) ;
  }
  return $answerList;
}


function getTanswerDetailsListByAno($ano){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_ANSWER_DETAILS WHERE ANSWER_NO = :ano ORDER BY NO ASC";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':ano', $ano, PDO::PARAM_STR);
  $stmt->execute();
  
  $answerdetailsList = array();
  while ($row = $stmt->fetch()) {
	  array_push($answerdetailsList, $row) ;
  }
  return $answerdetailsList;
}

function getTanswerDetailsListByQno($qno){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_ANSWER_DETAILS WHERE QUESTION_NO = :qno ORDER BY NO";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
  $stmt->execute();
  
  $answerdetailsList = array();
  while ($row = $stmt->fetch()) {
	  array_push($answerdetailsList, $row) ;
  }
  return $answerdetailsList;
}

function getTanswerDetailsListByQdno($qdno){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_ANSWER_DETAILS WHERE QUESTION_D_NO = :qdno ORDER BY NO";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qdno', $qdno, PDO::PARAM_STR);
  $stmt->execute();
  
  
  $answerdetailsList = array();
  while ($row = $stmt->fetch()) {
	  array_push($answerdetailsList, $row) ;
  }
  return $answerdetailsList;
}

function getTanswerDetailsListByQdnoAndQno($qdno,$qno){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_ANSWER_DETAILS WHERE QUESTION_D_NO = :qdno AND QUESTION_NO = :qno ORDER BY NO";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qdno', $qdno, PDO::PARAM_STR);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
  $stmt->execute();
  
  $answerdetailsList = array();
  while ($row = $stmt->fetch()) {
	  array_push($answerdetailsList, $row) ;
  }
  return $answerdetailsList;
}

//ANSWERマスターから行削除（成功したらtrue）
function deleteTanswerByQno($qno){
  $dbh = getcConectDb();
  $sql = "DELETE FROM home_T_ANSWER_DETAILS WHERE ANSWER_NO = :qno ";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  $dbh = null;
  return $flag;
}
//ANSWERマスターから行削除（成功したらtrue）
function deleteTanswerByQdno($qdno){
  $dbh = getcConectDb();
  $sql = "DELETE FROM home_T_ANSWER_DETAILS WHERE QUESTION_D_NO = :qdno ";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qdno', $qdno, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  $dbh = null;
  return $flag;
}


?>