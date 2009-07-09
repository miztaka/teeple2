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
 * 出力を補助するクラス
 *
 * @package     teeple
 */
class Teeple_Response
{
    /**
     * @var Content-dispositionを保持する
     *
     * @access  private
     * @since   3.0.0
     */
    var $_contentDisposition;

    /**
     * @var Content-Typeを保持する
     *
     * @access  private
     * @since   3.0.0
     */
    var $_contentType;

    /**
     * @var Resultを保持する
     *
     * @access  private
     * @since   3.0.0
     */
    var $_result;

    /**
     * @var Viewを保持する
     *
     * @access  private
     * @since   3.0.0
     */
    var $_view;

    /**
     * @var redirect先を保持する
     *
     * @access  private
     * @since   3.0.0
     */
    var $_redirect;

    /**
     * コンストラクター
     *
     * @access  public
     * @since   3.0.0
     */
    function __construct()
    {
        $this->_contentDisposition = NULL;
        $this->_contentType        = NULL;
        $this->_result             = NULL;
        $this->_view               = NULL;
        $this->_redirect           = NULL;
    }

    /**
     * contentDispositionの値を返却
     *
     * @return  string  contentDispositionの値
     * @access  public
     * @since   3.0.0
     */
    function getContentDisposition()
    {
        return $this->_contentDisposition;
    }

    /**
     * contentDispositionの値をセット
     *
     * @param   string  $contentDisposition contentDispositionの値
     * @access  public
     * @since   3.0.0
     */
    function setContentDisposition($contentDisposition)
    {
        $this->_contentDisposition = $contentDisposition;
    }

    /**
     * contentTypeの値を返却
     *
     * @return  string  contentTypeの値
     * @access  public
     * @since   3.0.0
     */
    function getContentType()
    {
        return $this->_contentType;
    }

    /**
     * contentTypeの値をセット
     *
     * @param   string  $contentType    contentTypeの値
     * @access  public
     * @since   3.0.0
     */
    function setContentType($contentType)
    {
        $this->_contentType = $contentType;
    }

    /**
     * resultの値を返却
     *
     * @return  string  resultの値
     * @access  public
     * @since   3.0.0
     */
    function getResult()
    {
        return $this->_result;
    }

    /**
     * resultの値をセット
     *
     * @param   string  $result resultの値
     * @access  public
     * @since   3.0.0
     */
    function setResult($result)
    {
        $this->_result = $result;
    }

    /**
     * viewの値を返却
     *
     * @return  string  viewの値
     * @access  public
     * @since   3.0.0
     */
    function getView()
    {
        return $this->_view;
    }

    /**
     * viewの値をセット
     *
     * @param   string  $view   viewの値
     * @access  public
     * @since   3.0.0
     */
    function setView($view)
    {
        $this->_view = $view;
    }

    /**
     * Redirectの値を返却
     *
     * @return  string  redirectの値
     * @access  public
     * @since   3.0.0
     */
    function getRedirect()
    {
        return $this->_redirect;
    }

    /**
     * Redirectの値をセット
     *
     * @param   string  $redirect   redirectの値
     * @access  public
     * @since   3.0.0
     */
    function setRedirect($redirect)
    {
        $this->_redirect = $redirect;
    }

}
?>
