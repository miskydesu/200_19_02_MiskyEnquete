<?php
/**************************************
 *     　　ページ別の設定情報
 **************************************/
$html_title="ログイン";
$body_class="login";
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
 
/**************************************
 *     　　　　表示用
 **************************************/
//共通ヘッダーの呼び出し
require_once('./inc/header_login.php');
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
<div class="main_contents" style="padding:15px;">
	<form action="./login/check.php" class="sds_form" method="post">
        <div id="inputtable">
    	<table>
        	<tr><td class="tdmidashi">
				<label><span>ユーザID: </span></td><td><input type="text" name="id" class="validate[required]"></label>
            </td></tr>
        	<tr><td class="tdmidashi">
				<label><span>パスワード: </span></td><td><input type="password" name="password" class="validate[required]"></label>
            </td></tr>
		</table>
        </div>
        <div id="buttontable">
        <table><tr>
			<th><button type="submit" class="large" value="ログイン">ログイン</button></th>
			<td><button type="button" class="green" onclick="">終了</button></td>
        </tr></table>
        </div>
		
	</form>

</div><!-- main_contents -->
</body>