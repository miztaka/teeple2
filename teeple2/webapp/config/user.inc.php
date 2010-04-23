<?php
/**
 * Teeple2 - PHP5 Web Application Framework inspired by Seasar2
 *
 * PHP versions 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @package     teeple
 * @author      Mitsutaka Sato <miztaka@gmail.com>
 * @license     http://www.php.net/license/3_0.txt  PHP License 3.0
 */

include_once dirname(__FILE__) .'/teeple.inc.php';

//
// Action自動生成機能のON/OFF
//
define('USE_DEVHELPER', true);

//
//Smartyテンプレートの設定
//
Teeple_Smarty4Maple::setOptions(array(
    "caching"           => false,
    //"cache_lifetime"    => 3600,
    "cache_lifetime"    => 5,
    "compile_check"     => false,
    "force_compile"     => true
    //"default_modifiers" => array("escape:html")
));

//
// DataSourceの設定
//
define('DEFAULT_DATASOURCE','default');
Teeple_DataSource::setDataSource(array(
    'default' => array(
        'dsn' => 'mysql:host=localhost;dbname=default;charset=utf8',
        'user' => 'default',
        'pass' => 'default'
    )
));

?>
