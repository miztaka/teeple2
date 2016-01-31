### Actionクラス ###

Actionクラスはteeple2の中核をなすクラスです。MVCのCにあたります。

#### 配置場所と命名規則 ####

webapp/htdocs\_app 以下にURLと対応した形で配置します。

例)
|URL|/foo/bar/baz.html|
|:--|:----------------|
|配置場所|/foo/bar/Baz.php |
|クラス名|Foo\_Bar\_Baz    |


#### Actionクラスの作成 ####

手動で作成する場合は MyActionBaseを拡張します。<br />
MyActionBaseは Teeple\_ActionBaseを拡張しています。

```

class Foo_Bar_Baz extends MyActionBase {

}

```

また、開発モードを有効にしていると、ブラウザからアクセスしたURLに対応するActionクラスが存在しない場合、Actionクラスが自動生成されます。


#### Actionメソッド ####

標準では executeメソッドが実行されます。 <br />
submitボタンに
```
<input type="submit" name="action:doHoge" />
```
と書いておくと、このsubmitボタンが押されたときには doHogeメソッドが実行されます。

#### Actionメソッドの戻り値 ####

Actionメソッドの戻り値によってどのViewが実行されるかが決まります。

```
    return NULL;
```
戻り値がNULLの場合はAction名に対応したViewが表示されます。<br />
(上記の例では、foo/bar/baz.html。)

```
    return 'hoge/fuga.html';
```
戻り値にViewのパスを指定するとそのViewが表示されます。

```
    return $this->redirect('hoge_fuga');
```
```
    return $this->redirect(Hoge_Fuga::actionName());
```
```
    return 'redirect:hoge_fuga';
```
上の3つはどれも同じ意味で、hoge/fuga.html にリダイレクトされます。<br />
通常のリダイレクトと違いRequestクラスが引き継がれてリダイレクトされます。
(ステートフルリダイレクト)

```
    return 'location:hoge/fuga.html';
```
こちらも hoge/fuga.html にリダイレクトされますが、Requestクラスは引き継がれません。

#### リクエストパラメータの参照 ####

リクエストパラメータは Actionクラスのプロパティとして自動セットされます。<br />
例えば、
```
<input type="text" name="username" value="" />
```
このTEXTBOXに入力された値は、Actionクラス内で
```
   print $this->username;
```
のように参照できます。


#### 自動セットされているプロパティ ####

Actionクラスには以下のオブジェクトが自動セットされています。

  * Request
```
    $this->request->addErrorMessage('エラーメッセージです。');
```

  * Session
```
    $this->session->setParameter('aaaa', 'セッションに登録');
```

  * Logger
```
    $this->log->debug('デバッグログです');
    $this->log->info('INFOログです');
```

⇒[Teeple\_ActionBaseのPHPDocはこちら](http://my.honestyworks.jp/teeple2/phpdoc/teeple/Teeple_ActionBase.html)