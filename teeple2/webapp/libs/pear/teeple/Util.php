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

/**
 * Utilクラスです。
 *
 * @package teeple
 */
class Teeple_Util {
    
    /**
     * iniファイルを読込みます。
     *
     * @param string $configfile iniファイルのパス
     * @return array
     */
    public static function readIniFile($configfile) {
        
        if(! file_exists($configfile)) {
            $this->log->info("Filterの設定ファイルが存在しません。($configfile)");
            return NULL;
        }
        
        $config = parse_ini_file($configfile, true);
        if (! is_array($config)) {
            $this->log->error("Filterの設定ファイルに誤りがあります。($configfile)");
            return NULL;
        }
        if (CONFIG_CODE != INTERNAL_CODE) {
            mb_convert_variables(INTERNAL_CODE, CONFIG_CODE, $config);
        }
        
        return $config;
    }
    
    /**
     * ハイフン区切りでCapitalizeされたクラス名を取得します。
     *
     * @param string $name クラス名
     * @return string
     */
    public static function capitalizedClassName($name) {
        
        $pathList = explode("_", $name);
        $ucPathList = array_map('ucfirst', $pathList);
        return join("_", $ucPathList);
    }

    /**
     * 値が空白かどうかをチェックします。
     *
     * @param mixed $value
     * @param boolean $trim
     * @return boolean
     */
    public static function isBlank($value, $trim = TRUE) {
        
        if ($trim) {
            $value = trim($value);
        }
        return ($value === NULL || $value === "");
    }
    
    /**
     * エラーメッセージにパラメータを埋め込んで返します。
     *
     * @param string $msg
     * @param array $param
     * @return string
     */
    public static function formatErrorMessage($msg, &$param) {
        
        foreach($param as $i => $arg) {
            $msg = str_replace("{".$i."}", $arg, $msg);
        }
        return $msg;
    }
    
    /**
     * クラスファイルをincludeします。
     *
     * @param string $name
     * @return boolean
     */
    public static function includeClassFile($name) {
        
        $pathList = explode('_', $name);
        $path = "";
        for($i=0; $i<count($pathList); $i++) {
            if ($i != count($pathList) - 1) {
                $path .= strtolower($pathList[$i]);
                $path .= '/';
            } else {
                $path .= $pathList[$i];
            }
        }
        $path .= ".php";
        $result = @include_once $path;
        if ($result !== FALSE) {
            return TRUE;
        }
        
        $path = implode('/', $pathList) .".php";
        $result = @include_once $path;
        
        return $result === FALSE ? FALSE : TRUE;
    }
    
    /**
     * オブジェクトまたは配列から指定された名前のプロパティを取り出します。
     *
     * @param mixed $obj
     * @param string $fieldName
     * @return mixed
     */
    public static function getProperty($obj, $fieldName) {
        
        if (is_object($obj)) {
            return $obj->$fieldName;
        }
        if (is_array($obj)) {
            return isset($obj[$fieldName]) ? $obj[$fieldName] : NULL;
        }
        return $obj;
    }
    
    /**
     * オブジェクトまたは配列に指定された名前のプロパティをセットします。
     *
     * @param mixed $obj
     * @param string $fieldName
     * @param mixed $value
     */
    public static function setProperty(&$obj, $fieldName, $value) {
        
        if (is_object($obj)) {
            $obj->$fieldName = $value;
        }
        if (is_array($obj)) {
            $obj[$fieldName] = $value;
        }
        return;
    }
    
    /**
     * オブジェクトまたは配列にセットされているプロパティの名前をすべて取得します。
     *
     * @param mixed $obj
     * @return array
     */
    public static function getPropertyNames($obj) {
        
        if (is_object($obj)) {
            return array_keys(get_object_vars($obj));
        }
        if (is_array($obj)) {
            return array_keys($obj);
        }
        return array();
    }

}
?>
