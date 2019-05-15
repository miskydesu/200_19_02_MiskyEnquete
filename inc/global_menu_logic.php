<?php
//ログインしていないユーザーはlogout画面へ飛ばす(logout側の処理でセッション破棄させた上でloginへ遷移する)
if(!$_SESSION["USER_NAME"]){
	header("Location: ../logout/");
}else{
  $USER_ID = $_SESSION["USER_ID"];
  $USER_NAME = $_SESSION["USER_NAME"];
}

//メッセージがあったときはここで受け取る
$display_mes = "";
if($result_mes){
	$display_mes = $result_mes;
}
?>