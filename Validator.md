### Validator ###
Teeple2ではActionメソッドの実行前に自動でValidationを実施します。<br />
Validationでエラーが発生するとRequestオブジェクトにエラーを登録し、ActionクラスのonValidateErrorメソッドを呼び出します。

#### Validationの定義 ####
Validationの定義はActionクラスの定数 VALIDATION\_CONFIG に設定します。<br />
設定する値はYAML形式になります。
```
    const VALIDATION_CONFIG = '
name:                                      <== 検査対象のパラメータ名
    required: {}                           <== 実行するValidator名とその設定
    maxbytelength: { maxbytelength: 256 }  <== 1つのパラメータに複数のValidatorを設定可
login_id:
    required: {}
    maxbytelength: { maxbytelength: 64 }
email:
    required: {}
    maxbytelength: { maxbytelength: 256 }
    email: {}
role:
    required: {}
    maxbytelength: { maxbytelength: 16 }
    ';
```

#### Validation対象となるActionメソッド ####
どのActionメソッドが実行されるときにValidationを行なうかを指定します。<br />
Actionクラスの定数 VALIDATION\_TARGET にカンマ区切りで指定します。
```
    const VALIDATION_TARGET = "doConfirm,doRegist";
```

#### 用意されているValidatorの種類 ####

詳しくはリファレンスを参照してください。

#### Validatorを自作する ####

T.B.D.