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
<?php if($type === 'insert' || $type === 'update'){ ?>
    <form name="myForm" id="myForm" method="post" action="index.php" enctype="multipart/form-data">
    
        <input type="hidden" id="qno" name="qno" value="<?php echo $question["QUESTION_NO"];?>" />
        <input type="hidden" id="qcount" name="qcount" value="" />
    	<input type="hidden" id="type" name="type" value="<?php echo $type;?>" />
    	<input type="hidden" id="delno" name="delno" value="" />
    	<input type="hidden" id="imagepath" name="imagepath" value="<?php echo $question["IMAGE_PATH"]; ?>" />
        
        <div id="buttontable">
        <table><tr>
			<th><?php if($question["QUESTION_NO"] !== "1"){ ?><div class="pagetitle">アンケート作成画面&nbsp;&nbsp;&nbsp;
            <?php if($type === 'update' || $type === 'update_run'){ ?><button type="button" class="green" onclick='analyticsJump("<?php echo $qno;?>");'>アンケート集計</button><?php } ?></div><?php }else{ ?><div class="pagetitle"><?php echo $question["NAME"];?>編集画面</div><?php } ?></th>
			<td>&nbsp;<?php if($question["QUESTION_NO"] !== "1"){ ?><button type="button" class="red" onclick="submitQuestion('delete');">削除</button><?php } ?></td>
        </tr></table>
        </div>


		<input type="text" id="qname" name="qname" value="<?php echo $question["NAME"];?>" style="width:100%;" placeholder="アンケート名を入力して下さい" /><br />
        <?php if($question["QUESTION_NO"] !== "1"){ ?>
            <div class="gurl_box"><?php if($type === 'update' || $type === 'update_run'){ ?><button type="button" class="gray" onclick='return jumpQuestion("<?php echo $qurl;?>");'>アンケート用URLへ移動</button><?php }else{ ?>アンケート用URLは登録後に生成されます。<?php }?></div>
        
		<textarea type="text" id="qoverview" name="qoverview" class="qoverview" rows="5" style="width:100%; margin-bottom:25px;" placeholder="アンケートの概要を入力して下さい" ><?php echo $question["OVERVIEW"];?></textarea><?php } ?><br />
        <?php if($question["QUESTION_NO"] !== "1"){ ?>
        <div class="clientToritsuke">■お客様情報（共通）の取り付け</div>
        <label><input type="radio" id="qclientflg" name="qclientflg" value="0" <?php if($question["CLIENTINFO_FLG"] === "" || $question["CLIENTINFO_FLG"] === "0"){ ?>checked="checked"<?php }?>/>無し</label>
        <label><input type="radio" id="qclientflg" name="qclientflg" value="1" <?php if($question["CLIENTINFO_FLG"] === "1"){ ?>checked="checked"<?php }?>/>前に取り付け</label>
        <label><input type="radio" id="qclientflg" name="qclientflg" value="2" <?php if($question["CLIENTINFO_FLG"] === "2"){ ?>checked="checked"<?php }?>/>後に取り付け</label><br /><br /><?php }else{ ?><input type="hidden" id="qclientflg" name="qclientflg" value="0" /><?php } ?>
        <?php if($question["QUESTION_NO"] !== "1"){ ?>
        <div class="clientToritsuke">■画像のアップロード</div>
        <?php if($question["IMAGE_PATH"] === ""){ ?>
        	<input type="file" name="upfile" id="upfile" /><br /><br />
        <?php }else{ ?>
        	<div class="imageBoxLeft"><dl><dt><img src="../savedir/<?php echo $question["IMAGE_PATH"]; ?>" /></dt><dd><button type="button" class="red" onclick="deleteImage();">画像削除</button></dd></dl></div>
        	<div class="imageBoxRight"><input type="file" name="upfile" id="upfile" /></div>
            <div class="clear"></div><br />
        <?php } ?><?php } ?>
        
        <div class="clientToritsuke">■採点の有無</div>
        <label><input type="radio" id="qgdadingflg" name="qgdadingflg" value="0" <?php if($question["GRADING_FLG"] === "" || $question["GRADING_FLG"] === "0"){ ?>checked="checked"<?php }?>/>無し</label>
        <label><input type="radio" id="qgdadingflg" name="qgdadingflg" value="1" <?php if($question["GRADING_FLG"] === "1"){ ?>checked="checked"<?php }?>/>有り</label><br />
		採点カテゴリー1：<input type="text" id="qgdadingcategory1" name="qgdadingcategory1" value="<?php echo $question["GRADING_CATEGORY1"];?>" style="margin:5px 0;  width:70%;" placeholder="採点用のカテゴリー名を入力して下さい。" /><br />
		採点カテゴリー2：<input type="text" id="qgdadingcategory2" name="qgdadingcategory2" value="<?php echo $question["GRADING_CATEGORY2"];?>" style="margin-bottom:5px;  width:70%;" placeholder="採点用のカテゴリー名を入力して下さい。" /><br />
		採点カテゴリー3：<input type="text" id="qgdadingcategory3" name="qgdadingcategory3" value="<?php echo $question["GRADING_CATEGORY3"];?>" style="margin-bottom:5px;  width:70%;" placeholder="採点用のカテゴリー名を入力して下さい。" /><br />
		採点カテゴリー4：<input type="text" id="qgdadingcategory4" name="qgdadingcategory4" value="<?php echo $question["GRADING_CATEGORY4"];?>" style="margin-bottom:5px;  width:70%;" placeholder="採点用のカテゴリー名を入力して下さい。" /><br />
		採点カテゴリー5：<input type="text" id="qgdadingcategory5" name="qgdadingcategory5" value="<?php echo $question["GRADING_CATEGORY5"];?>" style="margin-bottom:20px;  width:70%;" placeholder="採点用のカテゴリー名を入力して下さい。" /><br />
        
	<div class="question_box">
        ■質問の設定&nbsp;&nbsp;&nbsp;<button type="button" class="gray" onclick="addQuestion()">質問の追加</button>
        
        <!-- qboxの内容はJavaScriptで制御する -->
        <div class="qbox_no_area"></div>
		<div class="clear"></div>
        
        <div class="qbox_body qbox_body_area-1"></div> 
        <div class="qbox_body qbox_body_area-2"></div> 
        <div class="qbox_body qbox_body_area-3"></div> 
        <div class="qbox_body qbox_body_area-4"></div> 
        <div class="qbox_body qbox_body_area-5"></div> 
        <div class="qbox_body qbox_body_area-6"></div> 
        <div class="qbox_body qbox_body_area-7"></div> 
        <div class="qbox_body qbox_body_area-8"></div> 
        <div class="qbox_body qbox_body_area-9"></div> 
        <div class="qbox_body qbox_body_area-10"></div> 
        <div class="qbox_body qbox_body_area-11"></div> 
        <div class="qbox_body qbox_body_area-12"></div> 
        <div class="qbox_body qbox_body_area-13"></div> 
        <div class="qbox_body qbox_body_area-14"></div> 
        <div class="qbox_body qbox_body_area-15"></div> 
        <div class="qbox_body qbox_body_area-16"></div> 
        <div class="qbox_body qbox_body_area-17"></div> 
        <div class="qbox_body qbox_body_area-18"></div> 
        <div class="qbox_body qbox_body_area-19"></div> 
        <div class="qbox_body qbox_body_area-20"></div>      
        <div class="qbox_body qbox_body_area-21"></div>
        <div class="qbox_body qbox_body_area-22"></div>
        <div class="qbox_body qbox_body_area-23"></div>
        <div class="qbox_body qbox_body_area-24"></div>
        <div class="qbox_body qbox_body_area-25"></div>
        <div class="qbox_body qbox_body_area-26"></div>
        <div class="qbox_body qbox_body_area-27"></div>
        <div class="qbox_body qbox_body_area-28"></div>
        <div class="qbox_body qbox_body_area-29"></div>
        <div class="qbox_body qbox_body_area-30"></div>
        <div class="qbox_body qbox_body_area-31"></div>
        <div class="qbox_body qbox_body_area-32"></div>
        <div class="qbox_body qbox_body_area-33"></div>
        <div class="qbox_body qbox_body_area-34"></div>
        <div class="qbox_body qbox_body_area-35"></div>
        <div class="qbox_body qbox_body_area-36"></div>
        <div class="qbox_body qbox_body_area-37"></div>
        <div class="qbox_body qbox_body_area-38"></div>
        <div class="qbox_body qbox_body_area-39"></div>
        <div class="qbox_body qbox_body_area-40"></div>
        <div class="qbox_body qbox_body_area-41"></div>
        <div class="qbox_body qbox_body_area-42"></div>
        <div class="qbox_body qbox_body_area-43"></div>
        <div class="qbox_body qbox_body_area-44"></div>
        <div class="qbox_body qbox_body_area-45"></div>
        <div class="qbox_body qbox_body_area-46"></div>
        <div class="qbox_body qbox_body_area-47"></div>
        <div class="qbox_body qbox_body_area-48"></div>
        <div class="qbox_body qbox_body_area-49"></div>
        <div class="qbox_body qbox_body_area-50"></div>
        <div class="qbox_body qbox_body_area-51"></div>
        <div class="qbox_body qbox_body_area-52"></div>
        <div class="qbox_body qbox_body_area-53"></div>
        <div class="qbox_body qbox_body_area-54"></div>
        <div class="qbox_body qbox_body_area-55"></div>
        <div class="qbox_body qbox_body_area-56"></div>
        <div class="qbox_body qbox_body_area-57"></div>
        <div class="qbox_body qbox_body_area-58"></div>
        <div class="qbox_body qbox_body_area-59"></div>
        <div class="qbox_body qbox_body_area-60"></div>
        <div class="qbox_body qbox_body_area-61"></div>
        <div class="qbox_body qbox_body_area-62"></div>
        <div class="qbox_body qbox_body_area-63"></div>
        <div class="qbox_body qbox_body_area-64"></div>
        <div class="qbox_body qbox_body_area-65"></div>
        <div class="qbox_body qbox_body_area-66"></div>
        <div class="qbox_body qbox_body_area-67"></div>
        <div class="qbox_body qbox_body_area-68"></div>
        <div class="qbox_body qbox_body_area-69"></div>
        <div class="qbox_body qbox_body_area-70"></div>
        <div class="qbox_body qbox_body_area-71"></div>
        <div class="qbox_body qbox_body_area-72"></div>
        <div class="qbox_body qbox_body_area-73"></div>
        <div class="qbox_body qbox_body_area-74"></div>
        <div class="qbox_body qbox_body_area-75"></div>
        <div class="qbox_body qbox_body_area-76"></div>
        <div class="qbox_body qbox_body_area-77"></div>
        <div class="qbox_body qbox_body_area-78"></div>
        <div class="qbox_body qbox_body_area-79"></div>
        <div class="qbox_body qbox_body_area-80"></div>
        <div class="qbox_body qbox_body_area-81"></div>
        <div class="qbox_body qbox_body_area-82"></div>
        <div class="qbox_body qbox_body_area-83"></div>
        <div class="qbox_body qbox_body_area-84"></div>
        <div class="qbox_body qbox_body_area-85"></div>
        <div class="qbox_body qbox_body_area-86"></div>
        <div class="qbox_body qbox_body_area-87"></div>
        <div class="qbox_body qbox_body_area-88"></div>
        <div class="qbox_body qbox_body_area-89"></div>
        <div class="qbox_body qbox_body_area-90"></div>
        <div class="qbox_body qbox_body_area-91"></div>
        <div class="qbox_body qbox_body_area-92"></div>
        <div class="qbox_body qbox_body_area-93"></div>
        <div class="qbox_body qbox_body_area-94"></div>
        <div class="qbox_body qbox_body_area-95"></div>
        <div class="qbox_body qbox_body_area-96"></div>
        <div class="qbox_body qbox_body_area-97"></div>
        <div class="qbox_body qbox_body_area-98"></div>
        <div class="qbox_body qbox_body_area-99"></div>
        <div class="qbox_body qbox_body_area-100"></div>  
    </div>
        <?php if($question["QUESTION_NO"] !== "1"){ ?>
        <div class="endMessage">■アンケート終了時メッセージ</div>
		<textarea type="text" id="qendmes" name="qendmes" rows="5" style="width:100%; margin-bottom:15px;" placeholder="アンケート終了時のメッセージを入力してください。" ><?php echo $question["END_MES"];?></textarea><?php }?><br />
        
        <button type="button" class="green" onclick="submitQuestion('<?php echo $nexttype;?>');"><?php echo $button_name; ?></button>
  </form>
<?php }?>
</div>
<div class="clear"></div>
</div>
<!-- main_contents -->
<?php
//共通フッターを読み込み
require_once('../inc/footer.php');
?>
</body>