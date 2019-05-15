<?php
/**************************************
 *     　　ページ別の設定情報
 **************************************/
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
require_once('logic.php');
$html_title= $question["NAME"];

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
	<script src="check.js" charset="utf-8"></script>
	<script type="text/javascript">
		var qnow = 0; //回答の位置
		var qcount = questionDetailsList.length;
    </script>
</head>
<body onLoad="initDisplay()">

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

    <form name="myForm" id="myForm" method="post" action="comp.php">
        <input type="hidden" id="qno" name="qno" value="<?php echo $qno;?>" />
        <input type="hidden" id="qcount" name="qcount" value="<?php echo count($questionDetailsList);?>" />
        
        <div class="ans_box abox-start">
        	<div class="ans_title_start"><?php echo $question["NAME"] ?></div>
        	<div class="ans_desc_start"><?php echo preg_replace("/\r\n|\r|\n/", "<br />", $question["OVERVIEW"]) ?></div>
            <?php if($question["IMAGE_PATH"] !== ""){ ?>
        		<div class="imageBox"><dl><dt><img src="../savedir/<?php echo $question["IMAGE_PATH"]; ?>" /></dt></dl></div>
            	<div class="clear"></div><br />
        	<?php } ?>
        	<div class="ans_footer"><button type="button" class="large green allow1" onClick="start()">アンケートを開始</button></div>
        </div> 
        
		<?php for($i=1;$i<= count($questionDetailsList);$i++){ ?>
        
		<?php $question_d = $questionDetailsList[$i-1]; ?>
        
        <input type="hidden" class="req-<?= $i ?>" name="req-<?= $i ?>" value="<?php echo $question_d["REQ_FLG"] ?>" />
        <input type="hidden" class="type-<?= $i ?>" name="type-<?= $i ?>" value="<?php echo $question_d["TYPE"] ?>" />
            
        <div class="ans_box abox-<?= $i ?>">
            <div class="ans_step"><?= count($questionDetailsList) ?>問中<?= $i ?>問目</div>
        	<div class="ans_title">
            	<div class="no">Q.<?= $i ?></div>
				<div class="text"><?php echo $question_d["TITLE"] ?></div>
				<?php if($question_d["REQ_FLG"]==="1" ){?><!--div class="req">必須</div--><?php } ?>
            	<div class="clear"></div>
            </div>
        	<div class="ans_desc"><?php echo $question_d["BODY"] ?></div>
            
        	<div class="ans_main">
			<?php
				 $selectAnsList = explode("<>",$question_d["SELECT_ANS"]);
			
			     if($question_d["TYPE"] === "0" ){
					 ?>
                     <input type="hidden" name="answer-<?= $i ?>" class="answer-<?= $i ?>" value="" />
                    <select name="answer-p-<?= $i ?>" onChange='answerPulldown("<?= $i ?>")'>
						<option value="">-選択して下さい-</option>
                     <?php
					 $j=0;
					foreach($selectAnsList as $selectAns){ ?>
						<option value="<?= $selectAns ?>"><?= $selectAns ?></option>
					<?php 
					 $j++;}?>
					</select>
					 <?php
					if($question_d["ETC_FLG"] === "1"){
				?>
            		<textarea name="answeretc-<?= $i ?>" rows="5" placeholder="自由記入欄"></textarea>
            <?php
					}
            
            	  }else if($question_d["TYPE"] === "3" ){
					 ?>
                     <input type="hidden" name="answer-<?= $i ?>" class="answer-<?= $i ?>" value="" />
                     <?php
					 $j=0;
					foreach($selectAnsList as $selectAns){ ?>
						<input id="radio-<?= $i ?>-<?= $j ?>" type="radio" name="answer-i-<?= $i ?>" value="<?= $selectAns ?>" onChange='answerRadio("<?= $i ?>")' />
                        <label for="radio-<?= $i ?>-<?= $j ?>" class="radio"><?php if($selectAns !== ""){ echo $selectAns; }else{ echo "&nbsp;";} ?></label><br />
				<?php 
					 $j++;}
					if($question_d["ETC_FLG"] === "1"){
				?>
            		<textarea name="answeretc-<?= $i ?>" rows="5" placeholder="自由記入欄"></textarea>
            <?php
					}
            
            	  }else if($question_d["TYPE"] === "1" ){ ?>
						<input type="hidden" name="answer-<?= $i ?>" class="answer-<?= $i ?>" value="" />
                    <?php
					 $j=0;
					foreach($selectAnsList as $selectAns){ ?>
						<input id="checkbox-<?= $i ?>-<?= $j ?>" type="checkbox" name="answer-i-<?= $i ?>" class="answer-i-<?= $i ?>" value="<?= $selectAns ?>" onChange='answerCheck("<?= $i ?>")' />
						<label for="checkbox-<?= $i ?>-<?= $j ?>" class="checkbox"><?php if($selectAns !== ""){ echo $selectAns; }else{ echo "&nbsp;";} ?></label><br />
				<?php 
					 $j++;}
					if($question_d["ETC_FLG"] === "1"){
				?>
            		<textarea name="answeretc-<?= $i ?>" rows="5" placeholder="自由記入欄"></textarea>
            <?php
					}
				 }else if($question_d["TYPE"] === "2" ){ ?>
            	<textarea name="answer-<?= $i ?>" class="answer-<?= $i ?>" rows="5" placeholder="自由記入欄"></textarea>
            <?php
			     }else if($question_d["TYPE"] === "4" ){ ?>
                     <input type="hidden" name="answer-<?= $i ?>" class="answer-<?= $i ?>" value="" />
                     <select name="select" name="answer-y-<?= $i ?>" class="answer-y-<?= $i ?>" >
                         <option value="0">--</option>
                         <option value="2019">2019</option>
                         <option value="2018">2018</option>
                     </select>
                     年
                     <SELECT name="month" name="answer-m-<?= $i ?>" class="answer-m-<?= $i ?>">
                         <option value="0">--</option>
                         <option value="01">1</option>
                         <option value="02">2</option>
                         <option value="03">3</option>
                         <option value="04">4</option>
                         <option value="05">5</option>
                         <option value="06">6</option>
                         <option value="07">7</option>
                         <option value="08">8</option>
                         <option value="09">9</option>
                         <option value="10">10</option>
                         <option value="11">11</option>
                         <option value="12">12</option>
                     </SELECT>
                     月
             <?php
			     } ?>
            </div>
            <?php if($question_d["IMAGE_PATH"] !== ""){ ?>
        		<div class="imageBox"><dl><dt><img src="../savedir/<?php echo $question_d["IMAGE_PATH"]; ?>" /></dt></dl></div>
            	<div class="clear"></div><br />
        	<?php } ?>
        	<div class="ans_footer">
            <div class="ans_footer_box">
                <div class="prev"><button type="button" class="large gray allow2" onClick="prev()">BACK</button></div>
                <?php if(count($questionDetailsList) > $i){ ?>
                <div class="next"><button type="button" class="large green allow1" onClick="next()">NEXT</button></div>
                <?php }else{ ?>
                <div class="next"><button type="button" class="large red allow1" onClick="ansSubmit()">結果送信</button></div>
                <?php } ?>
                <div class="clear"></div>
            </div>
            </div>
            <div class="paging"><?= $i ?> of <?= count($questionDetailsList) ?></div>
        </div> 
        <?php } ?>
        
        <div class="ans_box abox-end">
        	<div class="ans_title_start"><?php echo $question["NAME"] ?></div>
        	<div class="ans_desc_start"><?php echo $question["END_MES"] ?></div>
        	<div class="ans_main"></div>
            
        	<div class="ans_footer">
            <div class="ans_footer_box">
                <div class="prev"><button type="button" class="large gray allow2" onClick="prev_end()">BACK</button></div>
                <div class="next"><button type="button" class="large red allow1" onClick="ansSubmit()">結果送信</button></div>
                <div class="clear"></div>
            </div>
            </div>
        </div>
     </form>
</div>
<div class="clear"></div>
</div>
<!-- main_contents -->
</body>