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
 * コントローラクラス
 * @package     teeple
 */
class Teeple_Controller
{
    /**
     * @var Logger
     */
    private $log;
    
    /**
     * @var Teeple_ActionChain
     */
    private $actionChain;
    public function setComponent_Teeple_ActionChain($c) {
        $this->actionChain = $c;
    }
    
    /**
     * @var Teeple_ConfigUtils 
     */
    private $configUtils;
    public function setComponent_Teeple_ConfigUtils($c) {
        $this->configUtils = $c;
    }
    
    /**
     * @var Teeple_FilterChain
     */
    private $filterChain;
    public function setComponent_Teeple_FilterChain($c) {
        $this->filterChain = $c;
    }
    
    /**
     * @var Teeple_DevHelper
     */
    private $devhelper;
    public function setComponent_Teeple_DevHelper($c) {
        $this->devhelper = $c;
    }
    
    /**
     * @var Teeple_TransactionManager
     */
    private $txManager;
    public function setComponent_Teeple_TransactionManager($c) {
        $this->txManager = $c;
    }
    
    /**
     * @var Teeple_Container
     */
    private $container;
    public function setComponent_container($c) {
        $this->container = $c;
    }
    
    /**
     * コントローラーを実行します。
     *
     */
    public static function start() {
        
        $log = LoggerManager::getLogger($_SERVER['PATH_INFO']);
        $log->info("*** リクエストを開始します。");
        
        try {
            // コンテナの取得
            $container = Teeple_Container::getInstance();
            //$container->setup(WEBAPP_DIR .'/config/dicon.ini');
            
            // セッションを作成 TODO セッションのパラメータ制御
            $session = $container->getComponent("Teeple_Session");
            $session->start();
            
            // リダイレクトスコープのリクエスト復元
            $request = $session->getParameter("__REDIRECT_SCOPE_REQUEST");
            if (is_object($request)) {
                $request->setActionMethod("execute");
                $container->register("Teeple_Request", $request);
                $session->removeParameter("__REDIRECT_SCOPE_REQUEST");
            }
            
            // controllerの実行
            $controller = $container->getComponent('Teeple_Controller');
            $controller->execute();
            
        } catch (Exception $e) {
            $txManager = $container->getComponent('Teeple_TransactionManager');
            $txManager->rollbackAll();
            Teeple_ErrorHandler::handle($e);
        }
        return;
    }
    
    /**
     * コンストラクター
     */
    public function __construct() {

        $this->log = LoggerManager::getLogger(get_class($this));
        $this->log->debug("############ コントローラstart.");
        return;
    }
    
    /**
     * フレームワークを起動させる
     *
     * @access  public
     * @since   3.0.0
     */
    public function execute()
    {
        $this->log->debug("************** controller#execute called.");

        // デフォルトトランザクションをコンテナに登録
        $defaultTx = $this->txManager->getTransaction();
        $this->container->register('DefaultTx', $defaultTx);

        // 実行するActionを決定
        $actionName = $this->makeActionName();
        if ($actionName == NULL) {
            throw new Teeple_Exception("アクションが特定できません。");
        }
        
        // 初期ActionをActionChainにセット
        $this->log->debug("****actionName: $actionName");
        try {
            $this->actionChain->add($actionName);
        } catch (Exception $e) {
            // Action自動生成ヘルパー TODO Controllerに組み込むのは味が悪い
            if (defined('USE_DEVHELPER') && USE_DEVHELPER) {
                $this->devhelper->execute($actionName);
            } else {
                throw $e;
            }
        }
        
        // FilterChainのセットアップと実行
        $this->filterChain->build();
        $this->filterChain->execute();
        //$this->filterChain->clear();
    }
    
    /**
     * URIからAction名を特定します。
     *
     * @return string
     */
    private function makeActionName() {
        $path = $_SERVER['PATH_INFO'];
        if ($path == NULL || strlen($path) == 0 || $path == '/') {
            return 'index';
        }
        $path = preg_replace('/^\/?(.*)$/', '$1', $path);
        $path = preg_replace('/(\..*)?$/', '', $path);
        $path = str_replace('/','_',$path);
        
        return $path;
    }
}
?>