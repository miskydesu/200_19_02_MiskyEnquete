<?php
/**************************************
 *     　　ページ別の設定情報
 **************************************/
$html_title="メニュー";
$body_class="menu";
$display_mes = "";
if(!isset($_SESSION)){ 
	session_start(); 
	if(!empty($_SESSION["err"])){
		$display_mes = $_SESSION["err"];
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
//共通ヘッダーを読み込み
require_once('../inc/header.php');
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

    <li><a href="#">来場者データ登録</a>
        <div>
            <div>
                <ul>
                        <li>&nbsp;<a href="../csv_import/index.php">・CSVインポート画面</a></li>
                        <li>&nbsp;<a href="../data_input/index.php">・データ入力(管理)画面</a></li>
                </ul>
            </div>
        </div>
    </li><br /><br />
    <li><a href="#">管理メニュー</a>
        <div>
            <div>
                <ul>
                        <li>&nbsp;<a href="../reference/index.php">・報告書ダウンロード</a></li>
                        <li>&nbsp;<a href="../mst_questionnaire/index.php">・アンケート結果閲覧機能</a></li>
                        <li>&nbsp;<a href="../mst_user/index.php">・利用者マスタ管理機能</a></li>
                </ul>
            </div>
        </div>
    </li>

</div><!-- main_contents -->
<?php
//共通フッターを読み込み
require_once('../inc/footer.php');
?>
</body>