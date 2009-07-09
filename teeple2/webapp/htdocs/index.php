<?php
error_reporting(E_ALL);
//error_reporting(0);

/**
 * Teeple設定ファイルの読込み
 */
define('BASE_DIR', dirname(dirname(__FILE__)));
include_once BASE_DIR . "/config/user.inc.php";

/**
 * フレームワーク起動
 */
Teeple_Controller::start();

?>
