<?php
require_once('../config.php');
require_once('dao_common.php');

//QUESTIONマスターから一覧を取得
function getTanswerList(){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_ANSWER ORDER BY QUESTION_NO";
  $stmt = $dbh->query($sql);
  $answerList = array();
  while ($row = $stmt->fetch()) {
	  array_push($answerList, $row) ;
  }
  return $answerList;
}

function getTanswerListByQno($qno){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_ANSWER WHERE QUESTION_NO = :qno ORDER BY DATE desc";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
    $flag = $stmt->execute();
  
  $answerList = array();
  while ($row = $stmt->fetch()) {
	  array_push($answerList, $row) ;
  }
  return $answerList;
}

//QUESTIONマスターから行削除（成功したらtrue）
function deleteTanswer($qno){
  $dbh = getcConectDb();
  $sql = "DELETE FROM home_T_ANSWER WHERE QUESTION_NO = :qno ";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  if($flag){
	  deleteTanswerByQno($qno);
  }
	  
  $dbh = null;
  return $flag;
}

function getTanswerNo(){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_ANSWER ORDER BY ANSWER_NO DESC";
  $stmt = $dbh->query($sql);
  while ($row = $stmt->fetch()) {
	  return $row["ANSWER_NO"];
  }
  return 0;
}

//QUESTIONマスターに行追加（成功したらtrue）
function insertTanswer($qno,$answerDetailsList){

    $dbh = getcConectDb();
    $sql = "INSERT INTO home_T_ANSWER (QUESTION_NO, DATE) VALUES( :qno, NOW() )";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
    $flag = $stmt->execute();
    if($flag){
        $ano = getTanswerNo();
        // 詳細レコードも登録する
        foreach($answerDetailsList as $answerDetails){

            $sql2 = "INSERT INTO home_T_ANSWER_DETAILS (ANSWER_NO,QUESTION_NO,QUESTION_D_NO,ANSWER,ETC) VALUES( :ano,  :qno,  :adno,  :answer,  :etc )";
            $stmt2 = $dbh->prepare($sql2);
            $stmt2->bindValue(':ano',$ano, PDO::PARAM_STR);
            $stmt2->bindValue(':qno',$answerDetails["QUESTION_NO"], PDO::PARAM_STR);
            $stmt2->bindValue(':adno',$answerDetails["QUESTION_D_NO"], PDO::PARAM_STR);
            $stmt2->bindValue(':answer',$answerDetails["ANSWER"], PDO::PARAM_STR);
            $stmt2->bindValue(':etc', $answerDetails["ETC"], PDO::PARAM_STR);
            $flag = $stmt2->execute();
        }
    }

    return $flag;
}

//QUESTIONマスターに行追加（成功したらtrue）
function updateTanswer($qno,$name,$overview,$endmes,$answerList){
	
  $dbh = getcConectDb();
  $sql = "UPDATE home_T_ANSWER SET NAME = :name,OVERVIEW = :overview,END_MES = :endmes  WHERE QUESTION_NO = :qno";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno',$qno, PDO::PARAM_STR);
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);
  $stmt->bindValue(':overview', $overview, PDO::PARAM_STR);
  $stmt->bindValue(':endmes', $endmes, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  if($flag){
	  // 詳細レコードを削除する
	  deleteTanswerByQno($qno);
	  
	  // 詳細レコードも登録する
	  foreach($answerList as $answer){
		    
		  $sql2 = "INSERT INTO home_T_ANSWER_DETAILS (QUESTION_NO,TITLE,BODY,REQ_FLG,TYPE,SELECT_ANS,ETC_FLG) VALUES( :qno,  :title,  :body,  :reqflg,  :type,  :selectans,  :etcflg )";
		  $stmt2 = $dbh->prepare($sql2);
		  $stmt2->bindValue(':qno',$qno, PDO::PARAM_STR);
		  $stmt2->bindValue(':title', $answer["TITLE"], PDO::PARAM_STR);
		  $stmt2->bindValue(':body', $answer["BODY"], PDO::PARAM_STR);
		  $stmt2->bindValue(':reqflg', $answer["REQ_FLG"], PDO::PARAM_INT);
		  $stmt2->bindValue(':type', $answer["TYPE"], PDO::PARAM_INT);
		  $stmt2->bindValue(':selectans', $answer["SELECT_ANS"], PDO::PARAM_STR);
		  $stmt2->bindValue(':etcflg', $answer["ETC_FLG"], PDO::PARAM_INT);
		  $flag = $stmt2->execute();
	  }
  }
  
  $dbh = null;
  return $flag;
}

?>