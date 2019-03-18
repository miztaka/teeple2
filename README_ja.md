# teeple2
Automatically exported from code.google.com/p/teeple2

# Teeple概要 #

## チュートリアル ##
  * [チュートリアル](TeepleTutrial.md)
  * [TeepleActiveRecordの説明](TeepleActiveRecord.md)

## フレームワークの基本動作 ##
フレームワークは基本的に以下のような流れで動作します。

  1. URLから呼び出すActionクラスを決定する。
  1. filter.iniの設定にしたがって FilterChain (ValidatorやConverterなど)を構築する
  1. !Filterのprefilter()を実行する(設定ファイルに書いてある順番に実行する)
  1. ActionクラスにRequestパラメータ等を自動セットする。
  1. Actionクラスのメソッドを実行する。
  1. Viewを実行する。
  1. Filterのpostfilter()を実行する(設定ファイルに書いてある順番に実行する)

### Actionメソッドを実行する ###
http://～～～//app/foo/bar/baz.html にアクセスした場合、以下のアクションクラスが実行されます。
  * ファイル名: htdocs\_app/foo/bar/Baz.php
  * クラス名: Foo\_Bar\_Baz

実行されるメソッドは以下のように決定されます。
  * デフォルトでは execute()メソッドが実行される。
  * submitボタンのname属性を name="action:hogehoge" としておくと、hogehoge() が実行される。

### RequestパラメータをActionクラスに自動セットする ###
RequestパラメータはActionクラスのプロパティとして自動セットされます。
例えば、
```
<input type="text" name="username" value="" />
```
このTEXTBOXに入力された値は、Actionクラス内で
```
   print $this->username;
```
のように参照できます。

### Viewを実行する ###
Actionメソッドの戻り値により次の動作が決まります。

  * HTMLテンプレートを表示する場合
    * return NULL; とすると、Actionクラスに対応するHTML (htdocs/app/foo/bar/baz.html)をレンダリングします。
    * return "foo/bar/baz2.html"; とすると、htdocs\_app/foo/bar/baz2.html をレンダリングします。
  * 別のActionクラスを実行する場合
    * return "redirect:fuga\_hoge"; とすると、/app/fuga/hoge.html にリダイレクトされます。このとき、リダイレクト前のRequestパラメータ(Requestオブジェクト)が復元されます。
  * 他のURLにリダイレクトする場合
    * return "location:～～～～" とすると、指定されたlocationにリダイレクトされます。パラメータは引き継がれません。(通常のHTMLのリダイレクト)

### Viewに自動セットされる値 ###
smartyテンプレートからは、Actionオブジェクト、Requestオブジェクト、Sessionオブジェクトを参照できます。
  * Actionオブジェクト: $a
  * Requestオブジェクト: $r
  * Sessionオブジェクト: $s

  * [インストールと設定](TeepleSetup.md)
  * [チュートリアル](TeepleTutrial.md)
  * 概要
    * [動作の流れ](WorkFlow.md)
    * [リクエストとセッション](CommonObject.md)
    * [Actionクラス](TeepleAction.md)
    * [画面表示](TeepleView.md)
    * [エラーメッセージ](ErrorMessage.md)
    * [データベース処理](DatabaseIntro.md)
    * [テーブルのJOIN](DatabaseJoin.md)
    * Pagination
    * [Validator](Validator.md)
    * [Converter](Converter.md)
    * [Filter](Filter.md)
    * [マイグレーション](Migration.md)
  * カスタマイズ
    * Filterを作る
    * Validatorを作る
    * Converterを作る
  * リファレンス
    * [Teeple\_ActiveRecord](ActiveRecordReference.md)
      * [find](ActiveRecordReference#find.md)
      * [select](ActiveRecordReference#select.md)
      * [count](ActiveRecordReference#count.md)
      * [insert](ActiveRecordReference#insert.md)
      * [update](ActiveRecordReference#update.md)
      * [updateAll](ActiveRecordReference#updateAll.md)
      * [delete](ActiveRecordReference#delete.md)
      * [deleteAll](ActiveRecordReference#deleteAll.md)
      * [join](ActiveRecordReference#join.md)
      * [where](ActiveRecordReference#where.md)
      * [eq](ActiveRecordReference#eq.md)
      * [ne](ActiveRecordReference#ne.md)
      * [gt](ActiveRecordReference#gt.md)
      * [lt](ActiveRecordReference#lt.md)
      * [ge](ActiveRecordReference#ge.md)
      * [le](ActiveRecordReference#le.md)
      * [in](ActiveRecordReference#in.md)
      * [notin](ActiveRecordReference#notin.md)
      * [starts](ActiveRecordReference#starts.md)
      * [ends](ActiveRecordReference#ends.md)
      * [contains](ActiveRecordReference#contains.md)
      * [limit](ActiveRecordReference#limit.md)
      * [offset](ActiveRecordReference#offset.md)
      * [convert2Page](ActiveRecordReference#convert2Page.md)
      * [convert2Entity](ActiveRecordReference#convert2Entity.md)
    * [Validator](ValidatorReference.md)
      * [required](ValidatorReference#required.md)
      * [mask](ValidatorReference#mask.md)
      * [length](ValidatorReference#length.md)
      * [minlength](ValidatorReference#minlength.md)
      * [minbytelength](ValidatorReference#minbytelength.md)
      * [maxlength](ValidatorReference#maxlength.md)
      * [maxbytelength](ValidatorReference#maxbytelength.md)
      * [integer](ValidatorReference#integer.md)
      * [numeric](ValidatorReference#numeric.md)
      * [range](ValidatorReference#range.md)
      * [email](ValidatorReference#email.md)
      * [datearray](ValidatorReference#datearray.md)
      * [datehash](ValidatorReference#datehash.md)
      * [datetimehash](ValidatorReference#datetimehash.md)
      * [timehash](ValidatorReference#timehash.md)
      * [equal](ValidatorReference#equal.md)
    * Converter
      * trim
      * datearray
      * datetimehash
      * timehash
      * tel
      * zip
      * hiragana
      * katakana
      * hankatakana
  * [PHPDoc](http://my.honestyworks.jp/teeple2/phpdoc/)
