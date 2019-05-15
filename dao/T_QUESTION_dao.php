<?php
require_once('../config.php');
require_once('../dao/dao_common.php');
require_once('../dao/T_QUESTION_DETAILS_dao.php');
require_once('../dao/T_ANSWER_DETAILS_dao.php');

//QUESTIONマスターから一覧を取得
function getTquestionList(){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_QUESTION ORDER BY QUESTION_NO";
  $stmt = $dbh->query($sql);
  $questionList = array();
  while ($row = $stmt->fetch()) {
	  array_push($questionList, $row) ;
  }
  return $questionList;
}

function getTquestionByQno($qno){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_QUESTION WHERE QUESTION_NO = :qno";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_INT);
  $stmt->execute();
  $question = $stmt->fetch();

  return $question;
}

function getTquestionNo(){
  $dbh = getcConectDb();
  $sql = "SELECT * FROM home_T_QUESTION ORDER BY QUESTION_NO DESC";
  $stmt = $dbh->query($sql);
  while ($row = $stmt->fetch()) {
	  return $row["QUESTION_NO"];
  }
  return 0;
}

//QUESTIONマスターから行削除（成功したらtrue）
function deleteTquestion($qno){
  $dbh = getcConectDb();
  $sql = "DELETE FROM home_T_QUESTION WHERE QUESTION_NO = :qno ";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno', $qno, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  if($flag){
	  deleteTquestionByQno($qno);
  }
	  
  $dbh = null;
  return $flag;
}
//QUESTIONマスターに行追加（成功したらtrue）
function insertTquestion($name,$overview,$endmes,$clientinfoflg,$imagepath,$gradingflg,$gradingcate1,$gradingcate2,$gradingcate3,$gradingcate4,$gradingcate5,$questionList){
	
  $dbh = getcConectDb();
  $sql = "INSERT INTO home_T_QUESTION (NAME,OVERVIEW,END_MES,DATE,CLIENTINFO_FLG,IMAGE_PATH,GRADING_FLG,GRADING_CATEGORY1,GRADING_CATEGORY2,GRADING_CATEGORY3,GRADING_CATEGORY4,GRADING_CATEGORY5) VALUES(:name,  :overview,  :endmes,  NOW(),:clientinfoflg,:imagepath,:gradingflg,:gradingcate1,:gradingcate2,:gradingcate3,:gradingcate4,:gradingcate5 )";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);
  $stmt->bindValue(':overview', $overview, PDO::PARAM_STR);
  $stmt->bindValue(':endmes', $endmes, PDO::PARAM_STR);
  $stmt->bindValue(':clientinfoflg', $clientinfoflg, PDO::PARAM_STR);
  $stmt->bindValue(':imagepath', $imagepath, PDO::PARAM_STR);
  $stmt->bindValue(':gradingflg', $gradingflg, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate1', $gradingcate1, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate2', $gradingcate2, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate3', $gradingcate3, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate4', $gradingcate4, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate5', $gradingcate5, PDO::PARAM_STR);
  $flag = $stmt->execute();
  if($flag){
  	  $qno = getTquestionNo();
	  // 詳細レコードも登録する
	  foreach($questionList as $question){
		    
		  $sql2 = "INSERT INTO home_T_QUESTION_DETAILS (QUESTION_NO,TITLE,BODY,REQ_FLG,TYPE,SELECT_ANS,ETC_FLG,IMAGE_PATH,GRADING_POINT,GRADING_SELECTEDCATEGORY) VALUES( :qno,  :title,  :body,  :reqflg,  :type,  :selectans,  :etcflg, :imagepath , :gradingpoint , :gradingselectedcate )";
		  $stmt2 = $dbh->prepare($sql2);
		  $stmt2->bindValue(':qno',$qno, PDO::PARAM_STR);
		  $stmt2->bindValue(':title', $question["TITLE"], PDO::PARAM_STR);
		  $stmt2->bindValue(':body', $question["BODY"], PDO::PARAM_STR);
		  $stmt2->bindValue(':reqflg', $question["REQ_FLG"], PDO::PARAM_STR);
		  $stmt2->bindValue(':type', $question["TYPE"], PDO::PARAM_STR);
		  $stmt2->bindValue(':selectans', $question["SELECT_ANS"], PDO::PARAM_STR);
		  $stmt2->bindValue(':etcflg', $question["ETC_FLG"], PDO::PARAM_STR);
		  $stmt2->bindValue(':imagepath', $question["IMAGE_PATH"], PDO::PARAM_STR);
		  $stmt2->bindValue(':gradingpoint', $question["GRADING_POINT"], PDO::PARAM_STR);
		  $stmt2->bindValue(':gradingselectedcate', $question["GRADING_SELECTEDCATEGORY"], PDO::PARAM_STR);
		  $flag = $stmt2->execute();
	  }
	  return $qno;
  }
  
  return 0;
}

//QUESTIONマスターに行追加（成功したらtrue）
function updateTquestion($qno,$name,$overview,$endmes,$delno,$clientinfoflg,$imagepath,$gradingflg,$gradingcate1,$gradingcate2,$gradingcate3,$gradingcate4,$gradingcate5,$questionList){
	
  $dbh = getcConectDb();
  $sql = "UPDATE home_T_QUESTION SET NAME = :name,OVERVIEW = :overview,END_MES = :endmes,CLIENTINFO_FLG = :clientinfoflg,IMAGE_PATH = :imagepath,GRADING_FLG = :gradingflg,GRADING_CATEGORY1 = :gradingcate1,GRADING_CATEGORY2 = :gradingcate2,GRADING_CATEGORY3 = :gradingcate3,GRADING_CATEGORY4 = :gradingcate4,GRADING_CATEGORY5 = :gradingcate5 WHERE QUESTION_NO = :qno";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':qno',$qno, PDO::PARAM_STR);
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);
  $stmt->bindValue(':overview', $overview, PDO::PARAM_STR);
  $stmt->bindValue(':endmes', $endmes, PDO::PARAM_STR);
  $stmt->bindValue(':clientinfoflg', $clientinfoflg, PDO::PARAM_STR);
  $stmt->bindValue(':imagepath', $imagepath, PDO::PARAM_STR);
  $stmt->bindValue(':gradingflg', $gradingflg, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate1', $gradingcate1, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate2', $gradingcate2, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate3', $gradingcate3, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate4', $gradingcate4, PDO::PARAM_STR);
  $stmt->bindValue(':gradingcate5', $gradingcate5, PDO::PARAM_STR);
  $flag = $stmt->execute();
  
  if($flag){
	  // 詳細レコードを削除する
	  deleteTquestionByQno($qno);
	  
	  // 回答をデリートする
	  $delnos = explode("<>",$delno);
	  
	  foreach($delnos as $qdno){
		  deleteTanswerByQdno($qdno);
	  }
	  
	  // 詳細レコードも登録する
	  foreach($questionList as $question){
		    
		if($question["NO"] !== ""){
		  $sql2 = "INSERT INTO home_T_QUESTION_DETAILS (NO,QUESTION_NO,TITLE,BODY,REQ_FLG,TYPE,SELECT_ANS,ETC_FLG,IMAGE_PATH,GRADING_POINT,GRADING_SELECTEDCATEGORY) VALUES(:no,  :qno,  :title,  :body,  :reqflg,  :type,  :selectans,  :etcflg, :imagepath , :gradingpoint , :gradingselectedcate )";
		  $stmt2 = $dbh->prepare($sql2);
		  $stmt2->bindValue(':no',$question["NO"], PDO::PARAM_STR);
		  $stmt2->bindValue(':qno',$qno, PDO::PARAM_STR);
		  $stmt2->bindValue(':title', $question["TITLE"], PDO::PARAM_STR);
		  $stmt2->bindValue(':body', $question["BODY"], PDO::PARAM_STR);
		  $stmt2->bindValue(':reqflg', $question["REQ_FLG"], PDO::PARAM_INT);
		  $stmt2->bindValue(':type', $question["TYPE"], PDO::PARAM_INT);
		  $stmt2->bindValue(':selectans', $question["SELECT_ANS"], PDO::PARAM_STR);
		  $stmt2->bindValue(':etcflg', $question["ETC_FLG"], PDO::PARAM_INT);
		  $stmt2->bindValue(':imagepath', $question["IMAGE_PATH"], PDO::PARAM_STR);
		  $stmt2->bindValue(':gradingpoint', $question["GRADING_POINT"], PDO::PARAM_STR);
		  $stmt2->bindValue(':gradingselectedcate', $question["GRADING_SELECTEDCATEGORY"], PDO::PARAM_STR);
		  $flag = $stmt2->execute();
		}else{
		  $sql2 = "INSERT INTO home_T_QUESTION_DETAILS (QUESTION_NO,TITLE,BODY,REQ_FLG,TYPE,SELECT_ANS,ETC_FLG,IMAGE_PATH,GRADING_POINT,GRADING_SELECTEDCATEGORY) VALUES( :qno,  :title,  :body,  :reqflg,  :type,  :selectans,  :etcflg, :imagepath , :gradingpoint , :gradingselectedcate )";
		  $stmt2 = $dbh->prepare($sql2);
		  $stmt2->bindValue(':qno',$qno, PDO::PARAM_STR);
		  $stmt2->bindValue(':title', $question["TITLE"], PDO::PARAM_STR);
		  $stmt2->bindValue(':body', $question["BODY"], PDO::PARAM_STR);
		  $stmt2->bindValue(':reqflg', $question["REQ_FLG"], PDO::PARAM_INT);
		  $stmt2->bindValue(':type', $question["TYPE"], PDO::PARAM_INT);
		  $stmt2->bindValue(':selectans', $question["SELECT_ANS"], PDO::PARAM_STR);
		  $stmt2->bindValue(':etcflg', $question["ETC_FLG"], PDO::PARAM_INT);
		  $stmt2->bindValue(':imagepath', $question["IMAGE_PATH"], PDO::PARAM_STR);
		  $stmt2->bindValue(':gradingpoint', $question["GRADING_POINT"], PDO::PARAM_STR);
		  $stmt2->bindValue(':gradingselectedcate', $question["GRADING_SELECTEDCATEGORY"], PDO::PARAM_STR);
		  $flag = $stmt2->execute();
		}
	  }
  }
  
  $dbh = null;
  return $flag;
}

?>