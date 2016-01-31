### モックアップを作成する ###
teepleではまず、HTMLでモックアップを作成することをお勧めします。<br />
モックアップ作成で画面の要素、画面遷移、画面のURLをできるだけFIXさせておくと後が楽になります。<br />
モックアップのHTMLは webapp/htdocs 以下に配置します。サブディレクトリをいくら作成しても構いません。
(階層を深くしすぎるとそれだけActionクラス名が長くなります。。)

画像やCSS,Javascriptの配置場所もデフォルトで webapp/htdocs以下に作成してありますが、これに従わなければいけないということではありません。

<br />
### モックアップ -> テンプレートとして使用 ###
モックアップで画面設計が終わったら、webapp/htdocs以下のHTML(静的ページは除く)を webapp/htdocs\_app 以下にコピーします。(ディレクトリ構成は保ったままにします。)<br />
これらをそのままSmartyテンプレートとして使用します。

<br />
### Actionクラスを作成する ###
モックアップが完成したら、それに対応するActionクラスを作成します。<br />
自動生成機能を使うと非常に楽に開発が進められます。

<br />
### 自動生成機能 ###
まず、作りたいActionクラスのURL(モックアップのHTML) へブラウザからアクセスしてみてください。<br />
Actionクラスが存在しない場合、通常の動作ではエラーとなりますが、自動生成機能がONになっている場合は自動生成を行なうかどうかの確認画面が表示されます。<br />
ここで、「雛形を自動生成する」を押すとActionクラスとiniファイルが自動生成されます。(HTMLテンプレートも存在しない場合はそれも作成されます。)

<br />
### 画面に出力するには ###
sample/hello.html を見てください。

> テンプレート側(webapp/htdocs\_app/sample/hello.html)では、
```
{{$a->helloMessage|escape}}
```
となっています。

> Actionクラス(webapp/htdocs\_app/sample/Hello.php)では、
```
$this->helloMessage = 'ようこそ、teepleへ!';
```
としています。

このように、Actionクラスのプロパティやメソッドはテンプレート側で $a-> でアクセスできます。

<br />
### Requestパラメータを取得するには ###
同じく sample/hello.html の 「例：Requestパラメータの取得」を見てください。
aaaとbbbの値を足して、resultで出力しています。
```
       if (isset($this->aaa) && isset($this->bbb)) {
            $this->result = $this->aaa + $this->bbb;
       }
```

このようにRequestパラメータはActionクラスのプロパティとしてセットされています。<br />
(フレームワークがRequestパラメータをセットした上でActionメソッドを実行します。)

<br />
### Sessionへパラメータを登録したり、取得したりするには ###
Teeple\_SessionオブジェクトはActionクラスのプロパティ'session'としてセットされていますので、次のように使用することができます。
```
    // sessionに値を格納する。
    $this->session->setParameter('HOGE_FUGA', $fuga);

    // sessionに格納した値を取得する。
    $value = $this->session->getParameter('HOGE_FUGA');
```

<br />
### Actionメソッドを指定するには ###
sample/hello.html の 「例：Actionメソッドの指定」を見てください。
submitボタンのname属性が以下のようになっています。
```
    <input type="submit" value="doExample4メソッドを実行" name="action:doExample4" />
```
このようにsubmitボタンでname属性を「action:メソッド名」とすると、
指定されたメソッドが呼び出されます。<br />
(なにも指定されていない場合は execute()メソッドが実行されます。)

<br />
### Validationとエラーメッセージ ###
sample/validator.html を開いてみてください。<br />
何も入力せずにsubmitボタンを押すとエラーメッセージが表示されます。<br />
この処理の流れは以下のようになっています。
  * validator.htmlが呼ばれる (Actionクラス: Sample\_Validator)
  * Validationが実行される。
  * Validationエラーが発生したので Actionクラスの onValidateError()メソッドが呼ばれる
  * return NULL; なのでデフォルトのテンプレート(validator.html)が表示される。

Actionクラスの定数 VALIDATION\_CONFIGにYAML形式でValidationの定義を書いておくとフレームワークが自動的にValidationを実行します。<br />
Validation実行対象のメソッドを指定したいときは、Actionクラスの定数 VALIDATION\_TARGETにメソッド名をカンマ区切りで指定します。<br />

フレームワークはValidationでエラーが発生した場合、Teeple\_Requestオブジェクトにメッセージを追加します。(Teeple\_Request#addErrorMessage)<br />

エラーメッセージはSmartyテンプレートで以下のように取得できます。
```
{{assign var=messages value=$r->getAllErrorMessages()}}
{{if count($messages) > 0}}
<ul>
{{foreach from=$messages item=message}}
<li><font color="#ff0000">{{$message|escape}}</font></li>
{{/foreach}}
</ul>
{{/if}}
```

また、項目別にエラーを出力したい場合は以下のように取得します。
```
{{foreach from=$r->getErrorMessages('username') item=m}}
<span style="color: #ff0000; font-size: 0.8em">{{$m|escape}}</span><br/>
{{/foreach}}
```

Validationのエラーメッセージは webapp/config/resources.ini に定義されています。<br />
また、メッセージ中に埋め込まれるフォームのラベルは、resources.iniに 「form.パラメータ名」という形で定義します。

<br />
### Converterによるフォームパラメータの自動変換 ###

sample/converter.html を開いてみてください。<br />
Actionクラスの定数CONVERTER\_CONFIGにYAML形式でConverterの定義を書いておくとフレームワークが自動的にフォームパラメータの変換を行ないます。<br />
ConverterはValidationより前に実行されます。

TODO: 詳しい説明ページへ

<br />
### ステートフルなリダイレクト ###

フォームパラメータを引き継いだまま別のActionにリダイレクトしたい場合は
Actionクラスの戻り値で
```
    return $this->redirect(Sample_Hello::actionName());
```
のようにします。これは、
```
    return "redirect:sample_hello";
```
と同じことです。

このときフレームワークは Teeple\_Requestオブジェクトをいったんセッションに保存し、
リダイレクト先のActionのURLへリダイレクトします。<br />
リダイレクト先のActionクラスが実行される前にセッションに登録されたTeeple\_Requestオブジェクトを復元します。

値を引き渡したい場合などはrequest#setParameter()を使用すればよいでしょう。
```
    // リダイレクト先に値を引き継ぐ
    $this->request->setParameter('saved_data', $savedata);
    return "redirect:foo_bar";
```

<br />
### TeepleActiveRecordの使用 ###

TeepleActiveRecord も参考にしてください。

<br />
#### 使用方法 ####
Entityクラスのスタティックメソッドget() を呼び出すことでEntityのインスタンスが取得できます。
```
   $record = Entity_Employee::get()->find($id);
```

<br />
#### セットアップ ####
Teepleから呼び出すためにはDataSourceの定義が必要となります。
DataSourceはwebapp/config/user.inc.php に定義します。
```
// user.inc.php

//
// DataSourceの設定
//
define('DEFAULT_DATASOURCE', 'ad');
DataSource::setDataSource(array(
    'ad' => array(
        'dsn' => 'mysql:host=192.168.0.2;dbname=ad;charset=utf8',
        'user' => 'dbuser',
        'pass' => 'password'
    )
);
```

<br />
#### トランザクションについて ####

##### DefaultTx #####
Teepleではリクエスト開始時に1つトランザクションが生成されます。これを「デフォルトトランザクション」と呼びます。

「デフォルトトランザクション」は、DIContainerに "DefaultTx" という名前で登録されます。

Actionクラスでは $this->defaultTx としてアクセスできます。

##### TransactionManager #####
デフォルトトランザクション以外のトランザクションを取得したい場合には、TransactionManagerのgetTransaction()を呼び出します。

TransactionManagerは DIContainerに "TransactionManager"という名前で登録されています。

Actionクラスでは $this->txManager としてアクセスできます。

##### トランザクションの開始と終了 #####

  * トランザクションを開始するには、TeepleTransaction#start()を呼び出します。
  * トランザクションをコミットするには、TeepleTransaction#commit()を呼び出します。
  * トランザクションをロールバックするには、TeepleTransaction#rollback()を呼び出します。
```
    $tx = $this->defaultTx->getTransaction();
    $tx->start();
    $record = $tx->Entity_Employee->find(1);
    ...
    $record->update();
    $tx->commit();
```

##### 自動トランザクション #####
Filter\_AutoTx を使用すると、Actionメソッドの実行直前にデフォルトトランザクションを開始し、Actionメソッド終了後にコミットされます。

filter.iniに以下のように設定します。

```

[AutoTx]

```

```
    // 自動トランザクションでの更新処理例
    $record = Entity_Employee::get()->find($id);
    $record->emp_name = '新しい名前';
    $record->update();

    // トランザクションの開始と終了を書く必要なし
```

<br />
#### コンポーネントの作成 ####

共通ロジッククラスなどコンポーネントとして使いたいクラスは以下のように作成します。

> 配置場所::
> > webapp/components 以下に配置します。


> ファイル名とクラス名::
> > foo/bar/Hoge.php というファイル名の場合、クラス名は Foo\_Bar\_Hoge とします。

<br />
##### コンポーネントの使用 #####

  * コンポーネントを使用したいクラスに setComponent_''コンポーネント名''() メソッドを用意しておくとコンテナが自動で呼び出します。
  * また、setPrototype_''コンポーネント名''() メソッドを用意しておくと、コンポーネントが毎回インスタンス化されてセットされます。
  * また、setSessionComponent_''コンポーネント名''()メソッドを用意しておくと、Sessionに保持されているインスタンスがセットされます。(なければインスタンス化されてSessionに登録されます。)_

※ setComponent の場合は、同一リクエスト内で同一インスタンスが使用されます。

```
    private $hogeLogic;
    public function setComponent_Foo_Bar_Hoge($c) {
        $hogeLogic = $c;
    }

    public function execute() {
        $this->hogeLogic->foo();
    }
```