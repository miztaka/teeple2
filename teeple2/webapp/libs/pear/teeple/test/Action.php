<?php
class Teeple_Test_Action extends Teeple_ActionBase
{

    const VALIDATION_TARGET = "doLogin";
    const VALIDATION_CONFIG = '
str1:
  length:
    args: [maxlength, minlength]
    minlength: 5
    maxlength: 10
"str2.文字列２":
  required: {}
  length:
    minlength: 3
    maxlength: 9
    msg: "{0}の長さが間違ってるで。"
    ';

    public function execute() {
        return 'result/execute';
    }
    
    public function doLogin() {
        return 'result/doLogin';
    }
    
    public function onValidateError() {
        return 'result/validateError';
    }
    
   
}
?>