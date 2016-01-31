### エラーメッセージ ###

画面に表示したいエラーメッセージを保持するためのメソッドが Requestオブジェクトに用意されています。<br />

#### エラーメッセージを追加する ####

Requestオブジェクトの addErrorMessageメソッドを使用します。
```
    $this->request->addErrorMessage('エラーが発生しました。');
```

第2引数にパラメータ名を指定することもできます。
```
    $this->request->addErrorMessage('エラーが発生しました。', 'name');
```

#### Validationエラーメッセージ ####
自動的に実行されるValidationのエラーメッセージも同様に追加されます。

#### エラーメッセージを取得する ####

Requestオブジェクトの getAllErrorMessagesメソッドを使用します。<br />
たとえばSmartyテンプレート内で以下のようにしてエラーメッセージを表示します。
```
{{assign var=messages value=$r->getAllErrorMessages()}}
{{if count($messages) > 0}}
<ul>
{{foreach from=$messages item=message}}<li>{{$message|escape}}</li>{{/foreach}}
</ul>
{{/if}}
```

パラメータ別のエラーメッセージを取得するには getErrorMessagesメソッドを使用します。<br />
戻り値は配列です。
```
{{assign var=messages value=$r->getErrorMessages('name')}}
```

#### その他のメソッド ####

isError:

> エラーがあるかどうかを返します。

resetErrorMessage:

> エラーメッセージをすべてクリアします。