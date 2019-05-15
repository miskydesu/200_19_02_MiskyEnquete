<?php
if(!isset($_SESSION)){
	session_start(); 
} 
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

//ログインしていないユーザーはlogout画面へ飛ばす(logout側の処理でセッション破棄させた上でloginへ遷移する)
if(!$_SESSION["USER_NAME"]){
	header("Location: ../logout/");
}else{
  $USER_ID = $_SESSION["USER_ID"];
  $USER_NAME = $_SESSION["USER_NAME"];
}

?>