<?php
/**************************************
 *     　　ページ別の設定情報
 **************************************/
$html_title="アンケート結果管理機能 > 閲覧";
$body_class="mst_questionnaire";
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
require_once('edit_logic.php');

/**************************************
 *     　　　　表示用
 **************************************/
//共通ヘッダーを読み込み
require_once('../inc/header.php');
//グローバルメニュー
require_once('../inc/global_menu.php');
 ?>
<script type="text/javascript" src="../mst_questionnaire - Copy/edit.js"></script>

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
	<form name="myForm" action="../mst_questionnaire - Copy/edit.php" method="post">
        
        <div id="inputtable">
        <table>        
    	<tr>
			<td class="tdmidashi" width="150">登録日時</td>
            <td><?= $questionnaire["Q_DATE"] ?></td>
        </tr>      
    	<tr>
			<td class="tdmidashi">質問１</td>
            <td><?= $questionnaire["Q1"] ?></td>
        </tr>      
    	<tr>
			<td class="tdmidashi">質問２</td>
            <td><?= $questionnaire["Q2"] ?></td>
        </tr>      
    	<tr>
			<td class="tdmidashi">質問３</td>
            <td><?= $questionnaire["Q3"] ?></td>
        </tr>      
    	<tr>
			<td class="tdmidashi">質問４</td>
            <td><?= $questionnaire["Q4"] ?></td>
        </tr>        
    	<tr>
			<td class="tdmidashi">質問４ その他</td>
            <td><?= $questionnaire["Q4_ETC"] ?></td>
        </tr>    
    	<tr>
			<td class="tdmidashi">質問５</td>
            <td><?= $questionnaire["Q5"] ?></td>
        </tr>       
    	<tr>
			<td class="tdmidashi">質問５ その他</td>
            <td><?= $questionnaire["Q5_ETC"] ?></td>
        </tr>    
    	<tr>
			<td class="tdmidashi">質問６</td>
            <td><?= $questionnaire["Q6"] ?></td>
        </tr>
        </table>
        </div>
        <div id="buttontable">
        <table><tr>
			<th></th>
			<td><button type="button" class="green" onclick="return jump();">一覧に戻る</button></td>
        </tr></table>
        </div>
	</form>

</div><!-- main_contents -->
<?php
//共通フッターを読み込み
require_once('../inc/footer.php');
?>
</body>