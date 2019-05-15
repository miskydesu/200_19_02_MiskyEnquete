<?php
if(!isset($_SESSION)){ 
	session_start(); 
}
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
require_once('../inc/msg.php');
require_once('../dao/M_USER_dao.php');

$err="";
if(($_POST['id'])){
	$id = ($_POST['id']);
}else{
	$err.= $msg["ERR0102"];
}
if(($_POST['password'])){
	$pswd = ($_POST['password']);
}else{
	$err.= $msg["ERR0103"];
}
if($err){
	$_SESSION["err"] = $err;
    header("Location:../index.php");
}else{
	$user = getTuser($id,$pswd);
	
	//検索結果($user)がないときエラーメッセージをsessionに持ってログイントップに遷移
	if(!$user){
		$_SESSION["err"] = $msg["ERR0101"];
        header("Location:../index.php");
	//検索結果があるとsession_idを作り直してユーザー情報持ってメニューに遷移
	}else{
		session_regenerate_id(true);
		$_SESSION["USER_ID"] = $user["USER_ID"];
		$_SESSION["USER_NAME"] = $user["USER_NAME"];
		header("Location:../mng_question/");
		exit;
	}
}
$dbh = null;
?>