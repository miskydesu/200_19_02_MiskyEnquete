<?php
/**************************************
 *     　　ページ別の設定情報
 **************************************/
$html_title="アンケート集計機能";
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
<?php if($display_mes){ ?>
<div class="display_box">
	<div class="display_msg">
		<?= $display_mes; ?>
	</div>
</div>
<?php }?>
<div class="main_contents">
    
    <form name="myForm" id="myForm" method="post" action="text.php">
        <input type="hidden" id="text" name="text" value="" />
        
    <div class="menu_box">
        <div class="inner_box">
        <div class="list_title"><a href='./index.php'>アンケート管理</a></div>
        <button type="button" class="list_add gray" onclick="insertJump();">+アンケート追加</button>
        <?php foreach($questionList as $row){ ?>
            <?php if($row["QUESTION_NO"] === "1"){ ?>
                <hr /><?php } ?>
            <div class="list_midashi"><a href='../mng_question/index.php?type=update&qno=<?php echo $row["QUESTION_NO"]?>'><?php echo $row["NAME"] ?></a></div>
            <?php if($row["QUESTION_NO"] === "1"){ ?>
                <hr /><?php } ?>
        <?php } ?>
        </div>
    </div>
    
    <div class="contents_box">
        
        <div id="buttontable">
        <table><tr>
			<th><div class="pagetitle">アンケート集計画面&nbsp;&nbsp;&nbsp;
            <button type="button" onclick='questionJump("<?php echo $qno;?>");'>アンケート編集</button>&nbsp;&nbsp;&nbsp;
            <button type="button" class="green" onclick='downloadJump("<?php echo $qno;?>");'>アンケートCSV</button></div></th>
			<td></td>
        </tr></table>
        </div>
        <div class="analytics_name"><?php echo $question["NAME"] ?></div>
        <div class="analytics_count">回答人数：<?php echo count($answerList) ?>名</div>
        
        <?php $i=1;foreach($questionDetailsList as  $questionDetails){ ?>
        
        	<div class="analytics_title">質問<?php echo $i; ?>&nbsp;&nbsp;<?php echo $questionDetails["TITLE"]; ?>
			<?php if($questionDetails["TYPE"] == "0" || $questionDetails["TYPE"] == "3"){ ?>（単一選択）
			<? }else if($questionDetails["TYPE"] == "1"){ ?>（複数選択）
			<? }else if($questionDetails["TYPE"] == "2"){ ?>（自由記入）<? } ?></div>
        	<div class="analytics_body"><?php echo $questionDetails["BODY"] ?></div>
        
        	<?php
            	if($questionDetails["TYPE"] == "0" || $questionDetails["TYPE"] == "1" || $questionDetails["TYPE"] == "3"){
					$questionList = explode("<>",$questionDetails["SELECT_ANS"]);
					
					foreach($questionList as $quesText){
			?>
                        <div class="analytics_selectans_box">
                        <table class="analytics">
                        <tr>
                        <th><?= $quesText ?></th>
                
            <?php
                        if($questionDetails["TYPE"] == "0" || $questionDetails["TYPE"] == "3"){ ?>
                              <td><?php if(count($answerList) >0){ echo (sprintf('%0.1f', ($questionDetails[$quesText] / count($answerList)) * 100));}else{echo "0";}?>%（<?php if(count($answerList) >0){echo $questionDetails[$quesText];}else{ echo "0";} ?>件）</td>
            <?php
                        }else if($questionDetails["TYPE"] == "1"){ ?>
                              <td><?php if($questionDetails["COUNT"] >0){echo (sprintf('%0.1f', ($questionDetails[$quesText] / $questionDetails["COUNT"]) * 100));}else{echo "0";}?>%（<?php if($questionDetails["COUNT"] >0){echo $questionDetails[$quesText];}else{ echo "0";} ?>件）</td>
            <?php	    } ?>
                        </tr>
                        </table>
                        </div>
            <?php
					}
					if($questionDetails["TYPE"] == "0" || $questionDetails["TYPE"] == "3"){
			?>
                        <div class="analytics_selectans_box">
                        <table class="analytics">
                        <tr>
                        <th>※未回答</th>
                        <td><?= $questionDetails["NOANS_PERCENT"] ?>%（<?= $questionDetails["NOANS_COUNT"] ?>件）</td>
                        </tr>
                        </table>
                        </div>
            <?php
					}
					if($questionDetails["ETC_FLG"] === "1"){
			?>
                        <table class="analytics">
                        <tr>
                        <th></th>
                        <td><button type="button" onClick='window.open("./text.php?qdno=<?= $questionDetails["NO"] ?>&type=<?= $questionDetails["TYPE"] ?>")' class="gray" style="margin:5px 0 0 50px;">入力内容の表示</button></td>
                        </tr>
                        </table>
            <?php
					}
					
			    }else{
					
			?>
            <button type="button" onClick='window.open("./text.php?qdno=<?= $questionDetails["NO"] ?>&type=<?= $questionDetails["TYPE"] ?>")' class="gray" style="margin-left:50px;">入力内容の表示</button>
            <?php
				}
			?>
        <?php $i++;} ?>
	</form>
</div>
<div class="clear"></div>
</div>
<!-- main_contents -->
<?php
//共通フッターを読み込み
require_once('../inc/footer.php');
?>
</body>