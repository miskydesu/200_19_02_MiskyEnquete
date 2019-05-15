<?php
/**************************************
 *     　　ページ別の設定情報
 **************************************/
$html_title="送信完了画面";
$body_class="question_comp";
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


//業務ロジックを読み込み
require_once('comp_logic.php');

/**************************************
 *     　　　　表示用
 **************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=460px,user-scalable=no">
	<title><?= $html_title; ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="../css/style_display.css">
	<link rel="stylesheet" type="text/css" media="all" href="../css/pagination.css">
	<script src="../js/jquery-1.11.3.min.js" charset="utf-8"></script>
	<script src="../js/jquery.pagination.js" charset="utf-8"></script>
	<script src="../js/jquery.hoverIntent.js" charset="utf-8"></script>
	<script src="../js/common.js" charset="utf-8"></script>
	<script src="comp.js" charset="utf-8"></script>
</head>
<body>

<div class="title_box">
	<div class="title_contents">
    	<div class="text">
    	<?php echo $question["NAME"] ?>
        </div>
    	<div class="logo">
    		<img src="../images/logo@2x.png" width="180" height="56" />
        </div>
    </div>
</div>
<?php if($display_mes){ ?>
<div class="display_box">
	<div class="display_msg">
		<?= $display_mes; ?>
	</div>
</div>
<?php }?>
<div class="main_contents2">

	<?php if($question["GRADING_FLG"] === "1"){ //採点有り時 ?>
        <div class="ans_box abox-start">
        	<div class="ans_title_start">簡易採点結果</div>
        	<div class="ans_desc_start"><?php echo $question["NAME"] ?><br /><br />
        	
			<?php if($question["GRADING_CATEGORY1"] !== ""){?>
				<span class="grading"><span class="grading_text1"><?= $question["GRADING_CATEGORY1"] ?></span>：　<?= $gradingTotal[0] ?>点</span><br>
			<?php } ?>
			<?php if($question["GRADING_CATEGORY2"] !== ""){?>
				<span class="grading"><span class="grading_text2"><?= $question["GRADING_CATEGORY2"] ?></span>：　<?= $gradingTotal[1] ?>点</span><br>
			<?php } ?>
			<?php if($question["GRADING_CATEGORY3"] !== ""){?>
				<span class="grading"><span class="grading_text3"><?= $question["GRADING_CATEGORY3"] ?></span>：　<?= $gradingTotal[2] ?>点</span><br>
			<?php } ?>
			<?php if($question["GRADING_CATEGORY4"] !== ""){?>
				<span class="grading"><span class="grading_text4"><?= $question["GRADING_CATEGORY4"] ?></span>：　<?= $gradingTotal[3] ?>点</span><br>
			<?php } ?>
			<?php if($question["GRADING_CATEGORY5"] !== ""){?>
				<span class="grading"><span class="grading_text5"><?= $question["GRADING_CATEGORY5"] ?></span>：　<?= $gradingTotal[4] ?>点</span><br>
			<?php } ?>
       	
        	</div>
        	<div class="ans_footer">
            <div class="ans_footer_box">
                <button type="button" class="large green" onClick='start("<?= $qno; ?>")'>再度アンケートを開始</button>
                <button type="button" class="large red" onClick='end("<?= $qno; ?>")'>アンケートを終了する</button>
            </div>
            </div>
        </div> 
        
	<?php }else{ //採点無し ?>
        <div class="ans_box abox-start">
        	<div class="ans_title_start"><?php echo $question["NAME"] ?></div>
        	<div class="ans_desc_start">アンケート結果を送信致しました。<br>
もう一度アンケートにご回答いただく場合は、<br>
「再度アンケートを開始」ボタンを押してください。</div>
        	<div class="ans_footer">
            <div class="ans_footer_box">
                <button type="button" class="large green allow1" onClick='start("<?= $qno; ?>")'>再度アンケートを開始</button>
            </div>
            </div>
        </div> 
	<?php } ?>
</div>
<div class="clear"></div>
</div>
<!-- main_contents -->
</body>