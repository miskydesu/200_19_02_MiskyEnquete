<?php
require_once('../dao/T_QUESTION_dao.php');
require_once('../dao/T_QUESTION_DETAILS_dao.php');
require_once('../dao/T_ANSWER_dao.php');


$qno = 0;

//処理タイプの判定
if($_POST['qno']){
	$qno = $_POST['qno'];
}else{
	$err.= $msg["ERR0001"];
}
		
$question = getTquestionByQno($qno);
$questionDetailsList = getTquestionDetailsListByQnoCiflg($qno,$question["CLIENTINFO_FLG"]);

$qcount = 0;

//処理タイプの判定
if($_POST['qcount']){
	$qcount = $_POST['qcount'];
}else{
	$err.= $msg["ERR0001"];
}

$answerDetailsList = array();


$gradingTotal = array(0,0,0,0,0);


for($i = 1; $i <= $qcount ;$i++){
		
		
	$answer_detail = array(
		"NO" => "",
		"QUESTION_NO" => $qno,
		"QUESTION_D_NO" => $questionDetailsList[$i-1]["NO"],
		"ANSWER" => "",
		"ETC" => "",
	);

    if(isset($_POST['answer-' . $i])){
		$answer_detail["ANSWER"] = $_POST['answer-' . $i];


    }
	if(isset($_POST['answeretc-' . $i])){
		$answer_detail["ETC"] = $_POST['answeretc-' . $i];
	}

	//採点が必要なら採点する （採点フラグかつ単一選択の時だけ）
	if($question["GRADING_FLG"] === "1" && ($questionDetailsList[$i-1]["TYPE"] === "0" || $questionDetailsList[$i-1]["TYPE"] === "3")){
		
		
		$selectansArray = explode("<>", $questionDetailsList[$i-1]["SELECT_ANS"]);
		$gradingpointArray = explode("<>", $questionDetailsList[$i-1]["GRADING_POINT"]);
		
		
		for($j = 0; $j <= count($selectansArray) ;$j++){
			if($selectansArray[$j] === $answer_detail["ANSWER"]){
				if(count($gradingpointArray) > $j){
					$gradingTotal[intval($questionDetailsList[$i-1]["GRADING_SELECTEDCATEGORY"])] += intval($gradingpointArray[$j]);
				}
			}
		}
	}
	
	array_push($answerDetailsList, $answer_detail) ;
}
//echo '<br><br><br>感情数値：'.$sentiment_score;


insertTanswer($qno,$answerDetailsList);

//$err= "<span class='mes_msg'>アンケート送付完了。</div>";
//$display_mes = $err;
		

?>
<script>
	var question = <?php echo  json_encode($question, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
	var questionDetailsList = <?php echo  json_encode($questionDetailsList, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
</script>

