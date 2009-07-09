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
 * Token管理を行う
 *
 * @package     teeple
 */
class Teeple_Token
{
    /**
     * @var Tokenの名前を保持する
     *
     * @access  private
     * @since   3.0.0
     */
    var $_name;

    /**
     * @var Teeple_Session
     */
    var $_session;
    public function setComponent_Teeple_Session($c) {
        $this->_session = $c;
    }

    /**
     * コンストラクター
     *
     * @access  public
     * @since   3.0.0
     */
    function __construct()
    {
        $this->_name = "";
        $this->_session = NULL;
    }

    /**
     * Sessionのインスタンスをセット
     *
     * @param   Object  $session    Sessionのインスタンス
     * @access  public
     * @since   3.0.0
     */
    function setSession($session)
    {
        $this->_session = $session;
    }

    /**
     * Tokenの名前を返却
     *
     * @return  string  Tokenの名前
     * @access  public
     * @since   3.0.0
     */
    function getName()
    {
        if ($this->_name == "") {
            $this->_name = "mapleToken";
        }

        return $this->_name;
    }

    /**
     * Tokenの名前を設定
     *
     * @param   string  $name   Tokenの名前
     * @access  public
     * @since   3.0.0
     */
    function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Tokenの値を返却
     *
     * @return  string  Tokenの値を返却
     * @access  public
     * @since   3.0.0
     */
    function getValue()
    {
        return $this->_session->getParameter($this->getName());
    }

    /**
     * Tokenの値を生成
     *
     * @access  public
     * @since   3.0.0
     */
    function build()
    {
        $this->_session->setParameter($this->getName(), md5(uniqid(rand(),1)));
    }

    /**
     * Tokenの値を比較
     *
     * @param   Object  $value  Requestクラスのインスタンス
     * @return  boolean Tokenの値が一致するか？
     * @access  public
     * @since   3.0.0
     */
    function check(&$request)
    {
        return (($this->getValue() != '') &&
                $this->getValue() == $request->getParameter($this->getName()));
    }

    /**
     * Tokenの値を削除
     *
     * @access  public
     * @since   3.0.0
     */
    function remove()
    {
        $this->_session->removeParameter($this->getName());
    }
}
?>
