## はじめに ##
teeple2は「**Java屋のためのPHP5フレームワーク**」をコンセプトににseasar2ファミリーのteedaやSAStrutsのエッセンスを取り込んだ、PHP5のWebアプリケーションフレームワークです。
以下のような特徴を持っています。

  * 学習コストを極限まで低くしました。(規約をできるだけ少なく、シンプルに)
  * ブラウザからURLにアクセスするだけでActionクラスの雛形を自動生成できます。
  * URLとActionとのマッピング定義が不要です。
  * 設定ファイルを書くだけの入力値検証(Validator)
  * 設定ファイルを書くだけの入力値変換(Converter)
  * メソッドチェーン型の易しいDBアクセスライブラリ(O/Rマッパー)を提供しています。
  * ServletFilterのようなFilter構造を採用しています。
  * HTMLテンプレートにはsmartyを使用します。
  * HTMLモックアップからそのまま開発に進めるように心がけています。(URLを変えない)
  * DIパターンによるシンプルな構成
  * Eclipseでの開発に最適化、コードアシストを最大限に活用できる構成にしています。

## ハイライト ##

  * 一覧 & 検索
```
class Example_Search extends Teeple_ActionBase {

    // フォームに入力された検索条件で、employeeの一覧を表示する。
    public function doSearch() {

        $this->searchResults = Entity_Employee::get()
            ->contains('name', $this->name)
            ->contains('name_kana', $this->name_kana)
            ->limit($this->limit)
            ->offset($this->offset)
            ->order('employee_no ASC')
            ->select();

        return '/example/search.html';
    }
}
```

  * 新規作成
```
class Example_Create extends Teeple_ActionBase {

    // フォームに入力された内容で employee を登録する。
    public function doCreate() {

        $entity = Entity_Employee::get();
        $entity->convert2Entity($this); // formの値をentityにコピー
        $entity->insert();

        return '/example/create.html';
    }
}
```

  * 更新
```
class Example_Update extends Teeple_ActionBase {

    // フォームに入力された内容で employee を更新する。
    public function doUpdate() {

        $entity = Entity_Employee::get()->find($this->id);
        $entity->convert2Entity($this); // formの値をentityにコピー
        $entity->update();

        return '/example/update.html';
    }
}
```

  * 照会
```
class Example_Read extends Teeple_ActionBase {

    // 指定されたIDの employee を表示する。
    public function execute() {

        $entity = Entity_Employee::get()->find($this->id);
        $entity->convert2Page($this); // entityの値をページにコピー

        return '/example/read.html';
    }
}
```

## ドキュメント ##
  * [目次](TableOfContents.md)
  * [API Specification](http://my.honestyworks.jp/teeple2/phpdoc/)

## 最新情報 ##
  * 2010.11.01 Teeple2 ver2.0.1 をリリースしました。
  * 2010.05.16 Teeple2 ver2.0.0 をリリースしました。
  * 2010.04.05 現在リリース準備中です。

## ダウンロード ##

⇒ [こちらから](http://code.google.com/p/teeple2/downloads/list)


## お問い合わせ ##
teeple2に関するお問い合わせは
「ｉｎｆｏ　＠　ｈｏｎｅｓｔｙｗｏｒｋｓ．ｊｐ」までお願いします。<br />
もしくは、 ハッシュタグ #teeple をつけてtweetしてください。



