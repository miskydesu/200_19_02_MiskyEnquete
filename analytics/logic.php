<?php
require_once('../dao/T_QUESTION_dao.php');
require_once('../dao/T_QUESTION_DETAILS_dao.php');
require_once('../dao/T_ANSWER_dao.php');
require_once('../dao/T_ANSWER_DETAILS_dao.php');


$type = 'init';

//処理タイプの判定
if($_GET['type']){
	$type = $_GET['type'];
}else{
	$err.= $msg["ERR0001"];
}

$qno = 0;

//処理タイプの判定
if($_GET['qno']){
	$qno = $_GET['qno'];
}else{
	$err.= $msg["ERR0001"];
}

//処理タイプの判定

if($type === "init" || $type === "download"){	
		
		$question = getTquestionByQno($qno);
	
		$questionDetailsList = getTquestionDetailsListByQnoCiflg($qno,$question["CLIENTINFO_FLG"]);
		
		$answerList = getTanswerListByQno($qno);
		
		for($i= 0;$i < count($questionDetailsList); $i++){
			
			//全体の回答リスト
			$answerList = getTanswerListByQno($qno);
			//実際に答えたリスト（質問を追加されたりした時は↑と数が合わない）
			$answerDetailsList = getTanswerDetailsListByQdnoAndQno($questionDetailsList[$i]["NO"],$qno);
						
			if($questionDetailsList[$i]["TYPE"] === "0" || $questionDetailsList[$i]["TYPE"] === "3"){
				$etc = "";
				$quesList = explode("<>",$questionDetailsList[$i]["SELECT_ANS"]);
				$ansSelectCount = 0;
				foreach($quesList as $quesText){
					$questionDetailsList[$i] = array_merge($questionDetailsList[$i],array($quesText=>0));
				}			
				
				foreach($answerDetailsList as $answerDetails){
					if($etc !== "" && $answerDetails["ETC"] !== ""){
						$etc .= "<>";
					}
					$etc .= $answerDetails["ETC"];
					$questionDetailsList[$i][$answerDetails["ANSWER"]] = $questionDetailsList[$i][$answerDetails["ANSWER"]] + 1;
						
					if($answerDetails["ANSWER"] !== ""){
						$ansSelectCount++;
					}
				}
				
				$questionDetailsList[$i]["ANSWER"] = "";
				$questionDetailsList[$i]["ETC"] = $etc;
				
				$questionDetailsList[$i]["NOANS_COUNT"] = count($answerList) - $ansSelectCount;//未回答の数
				if($questionDetailsList[$i]["NOANS_COUNT"] > 0){
					$questionDetailsList[$i]["NOANS_PERCENT"] = sprintf('%0.1f', ($questionDetailsList[$i]["NOANS_COUNT"] / count($answerList)) * 100);//未回答のパーセンテージ
				
				}else{
					$questionDetailsList[$i]["NOANS_PERCENT"] = 0;
				}
			}else if($questionDetailsList[$i]["TYPE"] === "1"){
				$etc = "";
				$ansSelectCount = 0;
				$quesList = explode("<>",$questionDetailsList[$i]["SELECT_ANS"]);
				foreach($quesList as $quesText){
					$questionDetailsList[$i] = array_merge($questionDetailsList[$i],array($quesText=>0));
				}			
					
				foreach($answerDetailsList as $answerDetails){
					
					$answerSelectList = explode("<>",$answerDetails["ANSWER"]);
					
					foreach($answerSelectList as $answerSelect){
						if($etc !== "" && $answerDetails["ETC"] !== "")$etc .= "<>";
						$etc .= $answerDetails["ETC"];
						$questionDetailsList[$i][$answerSelect] = $questionDetailsList[$i][$answerSelect] + 1;
						$ansSelectCount++;
					}
				}
				$questionDetailsList[$i]["ANSWER"] = "";
				$questionDetailsList[$i]["ETC"] = $etc;
				$questionDetailsList[$i]["COUNT"] = $ansSelectCount;
				
			}else{
				$answer = "";
				foreach($answerDetailsList as $answerDetails){
					if($answer !== "" && $answerDetails["ANSWER"] !== "")$answer .= "<>";
					$answer .= $answerDetails["ANSWER"];
				}
				$questionDetailsList[$i]["ANSWER"] = $answer;
				$questionDetailsList[$i]["ETC"] = "";
			}
			
			
			
		}
		
		if($type === "download"){
		  
		  
			for($i=0; $i < 1;$i++ ){	
			  $csv .=  '"DATETIME",';
			  
			  $answerDetailsList = getTanswerDetailsListByAno( $answerList[$i]["ANSWER_NO"]);
			  
			  $j =1;
			  foreach($questionDetailsList as $questionDetail){
			  	  $csv .=  '"回答'.$j.'",';
			  	  $csv .=  '"回答'.$j.'_etc",';
			  	  $j++;
			  }
			  
			  $csv .=  "\n"; 
			}
			
			for($i=0; $i < count($answerList);$i++ ){	
			  $csv .=  '"'. $answerList[$i]["DATE"] .'",';
			  
			  $answerDetailsList = getTanswerDetailsListByAno( $answerList[$i]["ANSWER_NO"]);
			  
			  foreach($questionDetailsList as $questionDetails){
				  //ANSWERの番号と質問の番号が合っていたら書き出す。
				  
				  $flg = false;
				  for($k= 0;$k < count($answerDetailsList); $k++){
					  if($questionDetails["NO"] == $answerDetailsList[$k]["QUESTION_D_NO"]){
						  $flg = true;
			  	  		  $csv .=  '"'. $answerDetailsList[$k]["ANSWER"] .'",';
			  	  		  $csv .=  '"'. $answerDetailsList[$k]["ETC"] .'",';
					  }
				  }
				  
				  if($flg){
				  }else{
			  	  	$csv .=  '"",';
			  	  	$csv .=  '"",';
				  }
			  }
			  
			  $csv .=  "\n"; 
			}
			
			
			$filename = 'answer.csv';
			header("Content-Type: application/octet-stream");
			//$filenameにファイル名を指定
			header("Content-Disposition: attachment; filename=$filename");
			//Excelで開くようにSJISにする
			echo mb_convert_encoding($csv,"SJIS", "UTF-8");
			exit;
		}
	
}

$questionList = getTquestionList();

?>