<?php

/**
 * Sample_Hello
 */
class Sample_Hello extends MyActionBase
{

    // 特定のメソッド時にValidationを実行したいときに定義。
    //const VALIDATION_TARGET = "";
    
    // Validationを実行したいときに定義。(ex. sample/Validator.php)
    //const VALIDATION_CONFIG = '';
    
    // Converterを実行したいときに定義。(ex. sample/Converter.php)
    //const CONVERTER_CONFIG = '';
    
    // output
    public $helloMessage;
    public $example4;
    
    /**
     * 標準で実行されるメソッドです。
     */
    public function execute() {
        
        $this->helloMessage = 'ようこそ、teepleへ!';
        
        if (isset($this->aaa) && isset($this->bbb)) {
            $this->result = $this->aaa + $this->bbb;
        }
        
        return NULL;
    }

    /**
     * action:doExample4を実行します。
     */
    function doExample4() {
        
        $this->example4 = 'doExample4を実行しました。';
        return NULL;
    }
    
    /**
     * Validationエラー時の処理。
     */
    public function onValidateError() {
        return NULL;
    }

}

?>