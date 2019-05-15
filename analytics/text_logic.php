<?php

require_once('../dao/T_ANSWER_DETAILS_dao.php');

$qdno = '';
if($_GET['qdno']){
	$qdno = $_GET['qdno'];
}

$type = '';
if($_GET['type']){
	$type = $_GET['type'];
}

$answerDetailsList = getTanswerDetailsListByQdno($qdno);

?>