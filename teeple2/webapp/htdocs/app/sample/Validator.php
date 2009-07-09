<?php

/**
 * Sample_Validator
 */
class Sample_Validator extends Teeple_ActionBase
{

    // 特定のメソッド時にValidationを実行したいときに定義。
    const VALIDATION_TARGET = "doHoge";
    
    // Validationを実行したいときに定義。(ex. sample/Validator.php)
    const VALIDATION_CONFIG = '
integerText:
  required: {}
  integer: {}
maskText:
  mask: { mask: "/^\d{3}-\d{4}$/" }
lengthText:
  length: { minlength: 3, maxlength: 10 }
minlengthText:
  minlength: { minlength: 3 }
minbytelengthText:
  minbytelength: { minbytelength: 3 }
maxlengthText:
  maxlength: { maxlength: 10 }
maxbytelengthText:
  maxbytelength: { maxbytelength: 10 }
numericText:
  numeric: {}
rangeText:
  range: { min: 8.9, max: 14.5 }
emailText:
  email: {}
#strptimeText:
#  strptime: { format: "%Y/%m/%d" }
datearrayText:
  datearray: {}
datehashText:
  datehash: {}
datetimehashText:
  datetimehash: {}
timehashText:
  timehash: {}
equalText:
  equal: { compareTo: "emailText" }
    ';
    
    /**
     * 標準で実行されるメソッドです。
     */
    public function execute() {
        return NULL;
    }
    
    /**
     * サブミットボタンが押されたとき。
     *
     * @return unknown
     */
    public function doHoge() {
        return NULL;
    }
    
    /**
     * Validationエラー時の処理。
     *
     */
    public function onValidateError() {
        return NULL;
    }

}

?>
