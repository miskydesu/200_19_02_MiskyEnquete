<?php
/**************************************
 *     　　ページ別の設定情報
 **************************************/
$html_title="アンケート管理機能";
$body_class="mng_question";
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
require_once('logic.php');

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
	<script type="text/javascript">
		var qnow = 0; //質問の位置
		var qcount = 0; //質問のカズ初期値
		//var qbox_html = []; //各質問のHTML内容
		var qselect = []; //各質問の数
		
		var question = <?php echo  json_encode($question, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
		var questionDetailsList = <?php echo  json_encode($questionDetailsList, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

		function initDisplay(){
			<?php if($type === 'insert'){ ?>
			
			insertInitDisplay();
			
			<?php } ?>
			
			<?php if($type === 'update'){ ?>
			
			updateInitDisplay();
			
			<?php } ?>
			
		}
    </script>
</head>
<body onLoad="initDisplay()">
<?
//グローバルメニュー
require_once('../inc/global_menu.php');
 ?>

<div class="title_box">
	<div class="title_contents">
    	<?= $html_title ?>
    </div>
</div>
<?php if($display_mes){ ?>
<div class="display_box">
	<div class="display_msg">
		<?= $display_mes; ?>
	</div>
</div>
<?php }?>
<div class="main_contents">

<div class="menu_box">
	<div class="inner_box">
	<div class="list_title"><a href='./index.php'>アンケート管理</a></div>
    <button type="button" class="list_add gray" onclick="insertJump();">+アンケート追加</button>
	<?php foreach($questionList as $row){ ?>
    	<?php if($row["QUESTION_NO"] === "1"){ ?>
        	<hr /><?php } ?>
		<div class="list_midashi"><a href='./index.php?type=update&qno=<?php echo $row["QUESTION_NO"]?>'><?php echo $row["NAME"] ?></a></div>
        <?php if($row["QUESTION_NO"] === "1"){ ?>
        	<hr /><?php } ?>
	<?php } ?>
    <hr />
	<div><a href='./user.php'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;👤&nbsp;ユーザー管理</a></div>
    </div>
</div>

<div class="contents_box">
	<iframe src="../mst_user/index.php" width="780" height="1200" ></iframe>
</div>
<div class="clear"></div>
</div>
<!-- main_contents -->
<?php
//共通フッターを読み込み
require_once('../inc/footer.php');
?>
</body>