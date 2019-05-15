<?php
require_once('../dao/T_QUESTION_dao.php');
require_once('../dao/T_QUESTION_DETAILS_dao.php');


$qno = 0;

//処理タイプの判定
if($_GET['qno']){
	$qno = $_GET['qno'];
}else{
	$err.= $msg["ERR0001"];
}
	
//編集時の初期値	
$type = "update";
		
$question = getTquestionByQno($qno);

$questionDetailsList = getTquestionDetailsListByQnoCiflg($qno,$question["CLIENTINFO_FLG"]);		

?>
<script>
	var question = <?php echo  json_encode($question, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
	var questionDetailsList = <?php echo  json_encode($questionDetailsList, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
</script>

