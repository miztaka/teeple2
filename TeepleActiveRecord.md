## はじめに ##
TeepleActiveRecord は PHP5用(5.1以降)のO/Rマッピング・ライブラリです。
本ライブラリを使用することにより、データベースへのアクセスが容易に行えます。
WebフレームワークTeepleから使用することもできますし、TeepleActiveRecord単体で使用することもできます。

データベースへのアクセスはPDOを使用しています。

本ライブラリの作成にあたっては
  * !CBL\_ActiveRecord (http://31tools.com/cbl_activerecord/)
  * S2JDBC (http://s2container.seasar.org/2.4/ja/s2jdbc.html)
を大変参考にさせていただきました。両プロダクトの開発者の皆様に感謝いたします。

## 必要条件 ##

  * PHP 5.1 以上
  * PDO (PHPに同梱されています。)

## 使用方法 ##
TeepleActiveRecordを使ったDBアクセスコードの開発は主に以下のような流れで行います。

  1. エンティティクラスを作成する。
> 2. エンティティクラスのインスタンスを作成する。
> 3. エンティティクラスのメソッドを呼び出してDBにアクセスする。

## エンティティクラスの作成(自動生成) ##

generateentity.php を使ってエンティティクラスを自動生成することができます。
generateentity.phpは webapp/libs/pear/misc にあります。

```
1. creole をインストールします。(PEAR)
   pear channel-discover pear.phpdb.org
   pear install phpdb/creole
   pear install phpdb/jargon

2. generateentity.php の $dsn, $datasource, $outputdir を書き換えます。
   $dsn - DBに接続する設定です。
   $datasource - エンティティにセットされるデータソース名です。(teepleと連動するときに使います。)
   $outputdir - エンティティクラスを生成するディレクトリです。

3. generateentity.php を実行します。
   Web,CLIどちらからでも実行できるはずです。
```

webapp/components/entity 以下にエンティティクラスが作成されます。

## エンティティクラスの作成(手動で作成) ##

エンティティクラスはDBのテーブルと1対1になるように作成します。

> 作成場所::
> > webapps/components/entity に作成します。


> ファイル名::
> > ''テーブル名(先頭大文字)''.php とします。テーブル名はCamelize(foo\_bar => FooBar)した形になります。


> クラス名::
> > Entity_''テーブル名(先頭大文字)'' とします。ファイル名と一致するようにしてください。_


> 親クラス::
> > Entityクラスは必ず Teeple\_ActiveRecord クラスを extend してください。

(Entityクラス定義の例)
```

// ファイル名 Employee.php
class Entity_Employee extends Teeple_ActiveRecord {

}
```

#### テーブル名の定義(必須) ####
テーブル名を定義します。
```
    public static $_TABLENAME = 'employee';
```

#### プライマリキーの定義(必須) ####
プライマリキーを定義します。
```
    public static $_PK = array('id1', 'id2');
```

#### カラムの定義(必須) ####
DBのカラムを1つのpublicフィールドとして定義します。
```
    public $emp_name;
    public $emp_address;
    public $emp_tel;
```

#### AUTOINCREMENTの定義(必須) ####
AUTOINCREMENTの定義をします。
プライマリキーが1つでかつAUTOINCREMENTの場合にTRUEを設定します。
```
    public static $_AUTO = FALSE;
```

※MySQLのAUTOINCREMENTにて動作確認できています。Sequenceには対応していません。

#### joinするテーブルの定義(任意) ####
joinするテーブルの定義をします。ここで定義した設定を join()メソッドで指定することによって
結合条件を指定したクエリーが実行できます。
```
    /**
     * JOINするテーブルを設定します。
     * 
     * ここに設定してある定義は、$this->join('aliasname') を呼ぶことで初めて結合対象となる。<br/>
     * ※ここに設定しただけではJOINされない。
     * 
     * <pre>
     * 指定方法: 'アクセスするための別名' => 設定値の配列
     * 設定値の配列：
     *   'entity' => エンティティのクラス名
     * 　'columns' => 取得するカラム文字列(SQLにセットするのと同じ形式)
     *   'type' => JOINのタイプ(SQLに書く形式と同じ)(省略した場合はINNER JOIN)
     *   'relation' => JOINするためのリレーション設定
     *      「本クラスのキー名 => 対象クラスのキー名」となります。
     * 
     * 値の例:
     * 
     * public static $_JOINCONFIG = array(
     *     'fuga' => array(
     *         'entity' => 'Entity_Fuga',
     *         'columns' => 'foo, bar, hoge',
     *         'type' => 'LEFT JOIN',
     *         'relation' => array(
     *             'foo_id' => 'bar_id'
     *         )
     *     )
     * );
     *
     * public $fuga;
     *
     * </pre>
     * 
     * @var array
     */
```

※JOINCONFIGで定義した名前で publicプロパティを定義することを忘れずに。
ここに結合されたテーブルのEntityオブジェクトがセットされます。

### エンティティクラスのインスタンスを取得する ###
エンティティのインスタンスは staticメソッド get() で取得することができます。
```

$entity = Entity_Employee::get();

```
このとき、DefaultTransactionに紐づいたインスタンスが取得されます。

また、Teeple\_ActiveRecord単独で使用する場合はコンストラクタにPDOのインスタンスを渡して生成します。
```
    // インスタンス生成
    $pdo = new PDO('mysql:dbname=todo;host=localhost', 'root', '');
    $entity = new Entity_Employee($pdo);

    // 利用例
    $records = $entity->join('dept')->where('base.emp_name = ?', $emp_name)->select();
```

## DataSourceの定義 ##
Teepleから呼び出すためにはDataSourceの定義が必要となります。
DataSourceは webapp/config/user.inc.php に定義します。

```
// user.inc.php

//
// DataSourceの設定
//
define('DEFAULT_DATASOURCE','ad');
DataSource::setDataSource(array(
    'ad' => array(
        'dsn' => 'mysql:host=192.168.0.2;dbname=ad;charset=utf8',
        'user' => 'dbuser',
        'pass' => 'password'
    )
);
```

次に、エンティティクラスに 利用するデータソースを定義します。
```
   /**
     * 使用するデータソース名を指定します。
     * 指定が無い場合は、DEFAULT_DATASOURCE で設定されているDataSource名が使用されます。
     *
     * @var string
     */
    public static $_DATASOURCE = "ad";
```

### select() ###
select()メソッドは複数件の検索を行なうときに使用します。
戻り値はエンティティの配列となります。
```
    $entity = new Entity_Employee($pdo);

    // 複数行検索
    $records = $entity->select(); // 全件取得（エンティティクラスの配列が戻される。）
    foreach($records as $record) {
        echo $record->emp_name;
    }
```

### find() ###
find()メソッドは単一行の検索を行なうときに使用します。
戻り値はエンティティとなります。(存在しない場合はNULL)
複数件ヒットした場合はTeepleActiveRecordExceptionがスローされます。
find()メソッドにはプライマリキーの値を引数として渡すことができます。(複合PKの場合は連想配列で渡します。)

  * find()メソッド： 引数無し
```
    // 単一行検索
    $record = $entity->eq('emp_id', 1)->find();
    echo $record->emp_name;
```

  * find()メソッド: 引数あり
```
    $record = $entity->find(1); // PKが単一の場合

    $record = $entity->find(array('keya'=>1, 'keyb'=>2); // PKが複合の場合
```

### count() ###
COUNT(**) の値を取得します。このメソッドを実行してもwhere句の条件はリセットされないので、
続けて同じ条件でselect()を実行することができます。**

```
    $rownum = $entity->contains('base.emp_name', '佐藤')->count();

    $records = $entity->select(); // count()と同じ条件でSELECT
```

### where() ###
where()メソッドは検索条件を設定するときに使います。第1引数に追加したいWhere句、第2引数以降にプレースフォルダにセットする値を指定します。このメソッドは可変長引数となっています。[[BR](BR.md)]
  * プレースフォルダが複数ある場合は可変長引数として渡してもよいし、第2引数に配列として渡すこともできます。
  * 指定されたWhere句はエンティティにセットされ、結果を返すメソッド(find,select,update等)が実行されるまで保持されます。
  * 指定されたWhere句はANDで連結されます。
  * SELECT文にWHERE句を指定したいとき、カラム名は '''エイリアス名.カラム名''' としてください。本エンティティはエイリアス「base」を使ってください。
  * UPDATE
```
    $records = $entity
        ->where('base.emp_name LIKE ?', '%佐藤%')
        ->where('dept.dept_name LIKE ?', '%人事%')
        ->where('base.status IN (?,?)', 1, 2)
        ->select();
```

### where()を簡易的にする便利メソッド ###
where()メソッドと同じ効果をもたらす便利メソッドを用意しています。


> eq($colname, $value, $notnullonly=true)::
> > colname = ? のWhere句を追加します。[[BR](BR.md)]
> > $notnullonlyがtrueのときは、$valueに値がセットされている場合のみ追加されます。[[BR](BR.md)]
> > $notnullonlyがfalseのときは、$valueに値がセットされていないときは colname IS NULL が追加されます。


> ne($colname, $value, $notnullonly=true)::
> > colname <> ? のWhere句を追加します。[[BR](BR.md)]
> > $notnullonlyがtrueのときは、$valueに値がセットされている場合のみ追加されます。[[BR](BR.md)]
> > $notnullonlyがfalseのときは、$valueに値がセットされていないときは colname IS NOT NULL が追加されます。


> lt($colname, $value)::
> > colname < ? のWhere句を追加します。


> gt($colname, $value)::
> > colname > ? のWhere句を追加します。


> le($colname, $value)::
> > colname <= ? のWhere句を追加します。


> ge($colname, $value)::
> > colname >= ? のWhere句を追加します。


> in($colname, $value)::
> > colname IN (?,?..) のWhere句を追加します。$valueには配列を指定します。


> notin($colname, $value)::
> > colname NOT IN (?,?..) のWhere句を追加します。$valueには配列を指定します。


> like($colname, $value)::
> > colname LIKE ? のWhere句を追加します。


> starts($colname, $value)::
> > colname LIKE ? のWhere句を追加します。$valueの末尾に%をつけた形で実行します。


> ends($colname, $value)::
> > colname LIKE ? のWhere句を追加します。$valueの先頭に%をつけた形で実行します。


> contains($colname, $value)::
> > colname LIKE ? のWhere句を追加します。$valueの先頭と末尾に%をつけた形で実行します。

```
    $records = $entity
        ->contains('base.emp_name', '佐藤')
        ->contains('dept.dept_name', '人事')
        ->in('base.status', array(1, 2))
        ->select();
```

### join() ###
```
    /**
     * JOINするテーブルを設定します。
     * 
     * <pre>
     * $aliasnameで指定された _JOINCONFIGの設定で結合します。
     * JOINする条件を追加する場合は第2引数以降に where()と同じ方法で指定します。
     * 
     * 結合をネストする場合は、
     * $this->join('hoge')->join('hoge$fuga')
     * のように、エイリアス名を $ で繋げて指定します。
     * 'hoge'のEntityに定義されている _JOINCONFIG の 'fuga'が適用されます。
     * </pre>
     *
     * @param mixed $aliasname エイリアス名
     * @param string $condition 追加する条件
     * @param string $params 可変長引数($condition)
     * @return object 本インスタンス
     */
```

テーブルを結合したい場合はjoin()メソッドを使用します。結合条件はあらかじめ $_JOINCONFIGに定義しておく必要があります。_

  * 条件の追加
> > 結合条件を追加する場合は、第2引数以降にwhere()メソッドと同じ形式で記述します。
```
    $record = $entity->join('dept', 'dept.status = ?', 1)->eq('base.emp_id', 1)->find();
```

  * ネストした結合
> > A => B => C という形で結合をネストする場合、B$C というエイリアスを指定することで エンティティBに設定されているCの定義を設定できます。必ず先に A=>Bのjoinを定義してください。
```
    $entity = new Entity_Employee($pdo);
    $record = $entity->join('dept')->join('dept$section')->eq('base.emp_id', 1)->find();
```

### order() ###
ORDER BY句を指定します。
```
    $records = $entity->order('base.modified, base.created')->select();
```

### limit() ###
LIMIT句を指定します。
```
    $records = $entity->limit(20)->select();
```

### offset() ###
OFFSET句を指定します。
```
    $records = $entity->limit(20)->offset(10)->select();
```

### insert() ###
INSERTを実行するにはエンティティに値をセットして insert()メソッドを実行します。
AUTOINCREMENTがTRUEに設定されている場合は、insert後、PKの値がエンティティにセットされます。
```
    $entity = new Entity_Employee($pdo);
    $entity->emp_name = '佐藤';
    $entity->dept_id = 1;
    $entity->emp_tel = '090-0000-0000';
    $entity->insert();
```

### update() ###
update()メソッドはエンティティの値でUPDATEを実行します。
```
   $entity = new Entity_Employee($pdo);
   $record = $entity->find(1);
   $record->emp_name = '加藤';
   $record->update();
```

### updateAll() ###
指定した条件に該当するレコードをすべて更新したい場合にはupdateAll()メソッドを使用します。
```
    $entity = new Entity_Employee($pdo);
    $entity->status = 2;
    $entity->gt('modified', $now)->updateAll();
```

### delete() ###
プライマリキーを指定してレコードを削除する場合、delete()メソッドを指定します。
プライマリキーはエンティティにセットするか、引数で渡すことができます。
```
   // エンティティにセットされたPKで削除  
   $entity = new Entity_Employee($pdo);
   $record = $entity->find(1);
   $record->delete();
```
```
   // 引数を指定して削除
   $entity = new Entity_Employee($pdo);
   $entity->delete(1);
```

### deleteAll() ###
指定した条件に該当するレコードをすべて削除したい場合にはdeleteAll()メソッドを使用します。
```
    $entity = new Entity_Employee($pdo);
    $entity->gt('modified', $now)->deleteAll();
```