### データベース処理 ###

Teeple2には Teeple\_ActiveRecord というPHP5用(5.1以降)のO/Rマッピング・ライブラリが用意されています。<br />
本ライブラリを使用することにより、データベースへのアクセスが容易に行えます。

Teeple\_ActiveRecordはPDOを使用しています。

#### ハイライト:メソッドチェーン ####
Teeple\_ActiveRecordではjqueryのようなメソッドチェーンを実装しています。<br />
例えば、
```
SELECT * 
  FROM employee
 WHERE name like '%佐藤%'
   AND state = '1'
 ORDER BY 'id'
 LIMIT 20
OFFSET 40
```
このようなSQLを実現したい場合、
```
$entityList = Entity_Employee::get()
    ->contains('name', '佐藤')
    ->eq('state', '1')
    ->limit(20)
    ->offset(40)
    ->order('id')
    ->select();
```
このように簡単に直感的に書くことができます。<br />
※EclipseIDEを使用するとコードアシストが効いてより便利です。

#### 必要条件 ####
  * PHP 5.1 以上
  * PDO (PHPに同梱されています。)

#### 使用方法 ####
Teeple\_ActiveRecordを使ったDBアクセスコードの開発は主に以下のような流れで行います。

  1. エンティティクラスを作成する。
  1. エンティティクラスのインスタンスを取得する。
  1. エンティティクラスのメソッドを呼び出して select,insert,update,delete操作を実行する。

#### DataSourceの定義 ####
データベースの接続情報(DataSource)を定義します。<br />
DataSourceは webapp/config/user.inc.php に定義します。
```
//
// DataSourceの設定
//
define('DEFAULT_DATASOURCE','db01');
DataSource::setDataSource(array(
    'db01' => array(
        'dsn' => 'mysql:host=192.168.0.2;dbname=db01;charset=utf8',
        'user' => 'dbuser',
        'pass' => 'password'
    )
);
```

  * エンティティに定義するDataSource名を上記設定にあわせます。(ex. db01)
    * ⇒手動生成の場合
  * DataSourceは複数定義することができます。

#### エンティティクラスの自動生成 ####

Teeple2ではエンティティクラスを自動生成するためのコンポーネントが用意されています。<br />
以下のように使用します。

  1. creole をインストールします。(PEAR)
```
   pear channel-discover pear.phpdb.org
   pear install phpdb/creole
   pear install phpdb/jargon
```
  1. DataSourceの設定が完了していることを確認します。(webapp/config/user.inc.php)
  1. binディレクトリにあるcli.phpを使ってEntityGeneratorをコマンドラインから実行します。
```
$ cd bin
$ php cli.php Teeple_EntityGenerator
```
  1. webapp/components/entity 以下にエンティティクラスが作成されます。

#### インスタンスの取得 ####
エンティティのインスタンスは staticメソッド get() で取得することができます。
```
$entity = Entity_Employee::get();
```

#### 複数件検索 ####
複数件検索にはselectメソッドを使用します。<br />
戻り値はエンティティの配列となります。
```
$entityList = Entity_Employee::get()
    ->contains('name', '佐藤')
    ->eq('state', '1')
    ->limit(20)
    ->offset(40)
    ->order('id')
    ->select();
```

#### 単一行検索 ####
単一行検索にはfindメソッドを使用します。<br />
戻り値はエンティティとなります。(存在しない場合はNULL)<br />
複数件ヒットした場合はTeepleActiveRecordExceptionがスローされます。<br />
find()メソッドにはプライマリキーの値を引数として渡すことができます。(複合PKの場合は連想配列で渡します。)

  * find()メソッド： 引数無し
```
// 単一行検索
$record = Entity_Employee::get()
    ->eq('emp_id', 1)
    ->find();
```

  * find()メソッド: 引数あり(単一PK)
```
$record = Entity_Employee::get()->find(1);
```

  * find()メソッド: 引数あり(複合PK)
```
$record = Entity_Employee::get()->find(array('key_a' => 1, 'key_b' => 1));
```

#### 件数取得 ####
検収取得にはcountメソッドを使用します。<br />
このメソッドを実行してもwhere句の条件はリセットされないので、続けて同じ条件でselect()を実行することができます。
```
$entity = $Entity_Employee::get();
$rownum = $entity->contains('emp_name', '佐藤')->count();
$entityList = $entity->select(); // count()と同じ条件でSELECT
```

#### WHERE条件 ####
WHERE条件を指定するにはwhereメソッドやそれをより簡易的に使えるようにした eq, gt, lt, in 等のメソッドを使用します。<br />
whereメソッドは第1引数に追加したいWhere句、第2引数以降にプレースフォルダにセットする値を指定します。このメソッドは可変長引数となっています。<br />
  * プレースフォルダが複数ある場合は可変長引数として渡してもよいし、第2引数に配列として渡すこともできます。
  * 指定されたWhere句はエンティティにセットされ、結果を返すメソッド(find,select,update等)が実行されるまで保持されます。
  * 指定されたWhere句はANDで連結されます。
```
$entityList = Entity_Employee::get()
    ->where('emp_name LIKE ?', '%佐藤%')
    ->where('dept_name LIKE ?', '%人事%')
    ->where('status IN (?,?)', 1, 2)
    ->select();
```
上記の例は以下のように簡単に書くこともできます。
```
$entityList = Entity_Employee::get()
    ->contains('emp_name', '佐藤')
    ->contains('dept_name', '人事')
    ->in('status', array(1,2))
    ->select();
```

※詳しくはリファレンスを参照してください。

#### レコードの作成 ####
新規レコードをINSERTするにはinsertメソッドを使用します。<br />
AUTOINCREMENTがTRUEに設定されている場合は、insert後、PKの値がエンティティにセットされます。
```
$entity = Entity_Employee::get();
$entity->emp_name = '佐藤';
$entity->dept_id = 1;
$entity->emp_tel = '090-0000-0000';
$entity->insert();
```

#### 単一レコードの更新 ####
取得したレコードをUPDATEするにはupdateメソッドを使用します。<br />
```
$entity = Entity_Employee::get()->find(1);
$entity->emp_name = '加藤';
$entity->update();
```

#### 複数レコードの更新 ####
指定した条件に該当するレコードをすべて更新したい場合にはupdateAllメソッドを使用します。
```
// 条件にマッチするレコードのstatusを2にする
$entity = Entity_Employee::get();
$entity->status = 2;
$entity->gt('modified', $now)->upateAll();
```

#### 単一レコードの削除 ####
単一レコードを削除するにはdeleteメソッドを使用します。
```
$entity = Entity_Employee::get->find(1);
$entity->delete();
```

また、PKを引数を指定して削除することもできます。
```
Entity_Employee::get()->delete(1);
```

#### 複数レコードの削除 ####
指定した条件に該当するレコードをすべて削除したい場合にはdeleteAllメソッドを使用します。
```
$entity = Entity_Employee::get();
$entity->gt('modified', $now)->deleteAll();
```

#### order ####
ORDER BY句を指定します。
```
$records = $entity->order('base.modified, base.created')->select();
```

#### limit ####
LIMIT句を指定します。
```
$records = $entity->limit(20)->select();
```

#### offset ####
OFFSET句を指定します。
```
$records = $entity->limit(20)->offset(10)->select();
```