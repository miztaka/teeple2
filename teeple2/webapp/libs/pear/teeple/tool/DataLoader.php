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
 * @package     teeple.tool
 * @author      Mitsutaka Sato <miztaka@gmail.com>
 * @license     http://www.php.net/license/3_0.txt  PHP License 3.0
 */

require_once 'PHPExcel/IOFactory.php';

/**
 * Excelからデータベースにデータを読み込みます。
 *
 * @package teeple.tool
 */
class Teeple_Tool_DataLoader {
    
    /**
     * 
     * @var Teeple_Container
     */
    protected $c;
    public function setComponent_container($c) {
        $this->c = $c;
    }
    
    /**
     * @var Logger
     */
    protected $log;
    
    /**
     * コンストラクタです。
     */
    public function __construct() {
        $this->log = LoggerManager::getLogger(get_class($this));
    }

    /**
     * Excelからデータを読み込みます。
     */
    public function execute() {
        
        $filename = $this->_argv[0];
        if (! $filename || ! file_exists($filename)) {
            print "file not found. $filename";
            return;
        }
        
        $excel = PHPExcel_IOFactory::load($filename);
        $sheets = $excel->getAllSheets();
        if (isset($this->_argv[1]) && $this->_argv[1] == 'replace') {
            $this->clearTables($sheets);
        }
        foreach($sheets as $sheet) {
            $this->loadSheet($sheet);
        }
        return;
    }
    
    /**
     * 
     * @param PHPExcel_Worksheet $sheet
     */
    private function loadSheet($sheet) {
        
        $name = $sheet->getTitle();
        $entity_name = "Entity_$name";
        if (! class_exists($entity_name, true)) {
            print "entity class not found. skip. $entity_name";
            return;
        }
        
        // ヘッダ
        $rowIterator = $sheet->getRowIterator();
        if (! $rowIterator->valid()) {
            print "no data. skip. $entity_name";
            return;
        }
        $col = array();
        $row = $rowIterator->current();
        $cellIterator = $row->getCellIterator();
        while ($cellIterator->valid()) {
            $cell = $cellIterator->current();
            $col[] = trim($cell->getValue());
            $cellIterator->next();
        }
        $rowIterator->next();
        
        print "load $entity_name .... ";
        
        // データを登録
        while ($rowIterator->valid()) {
            $row = $rowIterator->current();
            $entity = $this->c->getEntity($entity_name);
            $cellIterator = $row->getCellIterator();
            $i=0;
            while ($cellIterator->valid()) {
                $cell = $cellIterator->current();
                $prop = $col[$i];
                $entity->$prop = trim($cell->getValue());
                $cellIterator->next();
                $i++;
            }
            $entity->insert();
            $rowIterator->next();
        }
        print $sheet->getHighestRow() -1 ." rows loaded.\n";
        return;
    }
    
    /**
     * データを削除します。シートの逆順に実行します。
     * @param array $sheets
     */
    private function clearTables($sheets) {
        
        $names = array();
        foreach ($sheets as $sheet) {
            $names[] = $sheet->getTitle();
        }
        foreach (array_reverse($names) as $name) {
            $entity_name = "Entity_$name";
            if (! class_exists($entity_name, true)) {
                print "entity class not found. skip. $entity_name";
                continue;
            }
            $entity = $this->c->getEntity($entity_name);
            $entity->deleteAll();
        }
        return;
    }
    
}

?>