<?php
/**************************************
 *     　　ページ別の設定情報
 **************************************/
$html_title="アンケート集計機能(入力内容表示)";
$body_class="analytics";
$display_mes = "";
if(!isset($_SESSION)){ 
	session_start(); 
	if(!empty($_SESSION["err"])){
		$display_mes = $_SESSION["err"];
		$_SESSION["err"] = "";
	}
}
/**************************************
 *     共通変数・クラスの読み込み
 **************************************/
require_once('../config.php');
require_once('../inc/msg.php');

//ログインチェック、セッション読み込み
require_once('../inc/session.php');

//業務ロジックを読み込み
require_once('text_logic.php');

/**************************************
 *     　　　　表示用
 **************************************/
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?= $html_title; ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="../css/style.css">
	<link rel="stylesheet" type="text/css" media="all" href="../css/pagination.css">
	<script src="../js/jquery-1.11.3.min.js" charset="utf-8"></script>
	<script src="../js/jquery.pagination.js" charset="utf-8"></script>
	<script src="../js/jquery.hoverIntent.js" charset="utf-8"></script>
	<script src="../js/common.js" charset="utf-8"></script>
	<script src="check.js" charset="utf-8"></script>
</head>
<body>
<?
//グローバルメニュー
require_once('../inc/global_menu.php');
 ?>

<div class="title_box">
	<div class="title_contents">
    	<?= $html_title ?>
    </div>
</div>
<div class="main_contents">


<div class="contents_box">
        
        <div id="buttontable">
        <table><tr>
			<th><div class="pagetitle">入力内容表示</div></th>
			<td></td>
        </tr></table>
        </div>
        
        	<div class="analytics_title">入力内容表示</div>
        
        	<?php
            	
				if(count($answerDetailsList) > 0){
					foreach($answerDetailsList as $answerDetails){
						if($type === "2"){
			 ?>
            
            	<div class="analytics_selectans_box"><?= $answerDetails["ANSWER"] ?>
            	</div>
            
            <?php
						}else{
			 ?>
            
            	<div class="analytics_selectans_box"><?= $answerDetails["ETC"] ?>
            	</div>
            
            <?php
						}
					}
				}else{
			?>
            
            	<div class="analytics_selectans_box">入力無し
            	</div>
            <?php
				}
			?>

</div>
<div class="clear"></div>
</div>
<!-- main_contents -->
<?php
//共通フッターを読み込み
require_once('../inc/footer.php');
?>
</body>