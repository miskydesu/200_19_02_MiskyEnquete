<?php
session_start();
require_once('../config.php');
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-86400, '/');
}
session_destroy();
	header("Location:../index.php");
exit;