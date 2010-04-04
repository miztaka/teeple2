<?php

/**
 * Sample_Converter
 */
class Sample_Converter extends Teeple_ActionBase
{

    // 特定のメソッド時にValidationを実行したいときに定義。
    //const VALIDATION_TARGET = "";
    
    // Validationを実行したいときに定義。(ex. sample/Validator.php)
    //const VALIDATION_CONFIG = '';
    
    const CONVERTER_CONFIG = '
__all:
  trim: {}
datearrayText:
  datearray: { target: "datearrayStr" }
datetimehashText:
  datetimehash: { target: "datetimehashStr", format: "%Y/%m/%d %H:%M:%S" } 
timehashText:
  timehash: { target: "timehashStr" }
telText:
  tel: { target: "telStr" }
zipText:
  zip: { target: "zipStr" }
hiraganaText:
  hiragana: {}
katakanaText:
  katakana: {}
hankatakanaText:
  hankatakana: {}
  
  
    ';
    
    /**
     * 標準で実行されるメソッドです。
     */
    public function execute() {
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