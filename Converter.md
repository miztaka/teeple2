### Converter ###
Teeple2ではActionメソッドの実行前に自動でConverterを実行させることができます。

#### Converterの定義 ####
Converterの定義はActionクラスの定数 CONVERTER\_CONFIGに設定します。<br />
設定する値はYAML形式になります。
```
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
```

#### 用意されているConverterの種類 ####

詳しくはリファレンスを参照してください。

#### Converterを自作する ####

T.B.D.