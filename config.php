<?php

//DB接続関連
define('DSN', 'mysql:host=mysql514.heteml.jp;dbname=_questionnair_db;charset=utf8');
define('DB_USER', '_questionnair_db');
define('DB_PASSWORD', 'f2190khg');
define('PAGING_ITEM', 50); //ページングするときのアイテム数


//htmlspecialchars
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

?>