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
 * メールアドレスの形式かどうかをチェックします。
 *
 * @package teeple.validator
 */
class Teeple_Validator_Email extends Teeple_Validator
{

    protected function execute($obj, $fieldName) {
        
        $value = $this->getTargetValue($obj, $fieldName);
        if (Teeple_Util::isBlank($value)) {
            return TRUE;
        }
        
        $atom       = "(?:[a-zA-Z0-9_!#\\\$\\%&'*+/=?\\^`{}~|\\-]+)";
        $dot_atom   = "(?:{$atom}(?:\\.{$atom})*)";
        $quoted     = '(?:"(?:\\\\[^\r\n]|[^\\\\"])*")';
        $local      = "(?:{$dot_atom}|{$quoted})";
        $domain_lit = '(?:\[(?:\\\\\\S|[\x21-\x5a\x5e-\x7e])*\])';
        $domain     = "(?:{$dot_atom}|{$domain_lit})";
        $addr_spec  = "{$local}\\@{$domain}";
        
        return preg_match("/^{$addr_spec}$/", $value);
    }
    
}
?>