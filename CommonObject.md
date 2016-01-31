### リクエストとセッション ###

#### Teeple\_Request ####

Requestオブジェクトはリクエストパラメータやエラーメッセージなどを保持します。<br />
フレームワークが自動で生成しコンテナに登録します。

Actionクラスからは $this->request->addErrorMessage('hoge'); のような形で使用できます。

⇒[PHPDocはこちら](http://my.honestyworks.jp/teeple2/phpdoc/teeple/Teeple_Request.html)

#### Teeple\_Session ####

Sessionオブジェクトは PHPの $_SESSION をラップした形のオブジェクトです。_<br />
フレームワークが自動で生成しコンテナに登録します。

Actionクラスからは $this->session->getParameter('hoge'); のような形で使用できます。

⇒[PHPDocはこちら](http://my.honestyworks.jp/teeple2/phpdoc/teeple/Teeple_Session.html)