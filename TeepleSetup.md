### インストール ###
ダウンロードしたパッケージを解凍してください。
解凍すると以下のようなディレクトリ構成になります。
```
teeple
  |-- bin
  |-- testcase
  |-- webapp
      |-- cache
      |-- components       <== Action以外のクラスを配置。
      |-- config           <== 設定ファイル群を配置。
      |-- htdocs           <== 静的ファイルを配置。WebサーバのDocumentRootもしくはAliasを指定。
      |-- htdocs_app       <== ActionクラスとSmartyテンプレートを配置します。
      |-- libs
          |-- log4php      <== log4phpのライブラリ
          |-- pear         <== PEARパッケージ置き場
              |-- teeple   <== teepleのコアライブラリ
          |-- smarty-2.6.26 <== smartyのライブラリ
      |-- (*)logs          <== アプリケーションログの出力場所。(デフォルト)
      |-- smarty_plugins   <== Smartyプラグインを配置。
      |-- (*)templates_c   <== Smartyのコンパイル用ディレクトリ。

※ (*)のついたディレクトリは、Webサーバーからの書き込みを許可してください。
```

  * webapp/logs, webapp/templates\_c はWebサーバ実行アカウントからの書き込みを許可してください。
  * 開発中は、webapp/htdocs\_app 以下についても書き込みを許可してください。(雛形自動生成機能を使う場合)

<br />
### Apacheの設定 ###
  * webapp/htdocs ディレクトリをDocumentRootまたはAliasに指定します。
  * webapp/htdocs/.htaccessの RewriteBase を上記設定にあわせて修正します。
    * DocumentRootに指定した場合 -> `RewriteBase /`
    * Aliasに指定した場合 (ex. /teeple2) -> `RewriteBase /teeple2`

<br />
### DBとの接続設定 ###
データベースを使用するためには以下の2箇所の設定を行ないます。
  * webapp/config/filter.ini の DataSourceフィルターを有効にする
```
;;
;; Teeple Filter settings
;;

;;[DataSource]  <- uncommentする

[AutoTx]

;; End of File
```

  * webapp/config/user.inc.php の「DataSourceの設定」を行なう
```
//
// DataSourceの設定
//
define('DEFAULT_DATASOURCE','default');
Teeple_DataSource::setDataSource(array(
    'default' => array(
        'dsn' => 'mysql:host=localhost;dbname=default;charset=utf8',
        'user' => 'default',
        'pass' => 'default'
    )
));
```

<br />
### 開発モード ###
Actionクラス自動生成機能はデフォルトでOFFになっています。ONにするには webapp/config/user.inc.phpの
```
define('USE_DEVHELPER', false);
```
の部分を true に変更してください。

  * **※本番リリースの際は必ず falseにしてください。**

<br />
### 開発環境 ###
  * 特に指定はありませんが、eclipse + PDT での開発に最適化されています。
  * ソースコードはUTF-8で書かれていますので、できるだけUTF-8で開発をしたほうがよいでしょう。

<br />
### 動作確認 ###
sampleを実行してみましょう。

> http://~~~~~/path_to_htdocs/sample/validator.html

をブラウザから開いてみてください。ページが見えればセットアップは成功です。<br />
(path\_to\_htdocs は ApacheのAliasに指定した場所。)