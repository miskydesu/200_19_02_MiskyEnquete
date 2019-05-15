<?php
require_once('../inc/msg.php');
require_once('../dao/T_QUESTIONNAIRE_dao.php');

//処理タイプの判定
if($_POST['type']){
	$type = $_POST['type'];
}else{
	$err.= $msg["ERR0001"];
}

if($err){
	$_SESSION["err"] = $err;
	header("Location:./index.php");
}else{
	
	$no = $_POST['no'];
	$questionnaire = getTquestionnaireByNo($no);

}

?>