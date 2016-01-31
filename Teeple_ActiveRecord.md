#Teeple\_ActiveRecord リファレンス

## 概要 ##

⇒[こちらを見てください](DatabaseIntro.md)

## メソッドリファレンス ##

### find ###
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

### select ###
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

### count ###
件数取得にはcountメソッドを使用します。<br />
このメソッドを実行してもwhere句の条件はリセットされないので、続けて同じ条件でselect()を実行することができます。
```
$entity = $Entity_Employee::get();
$rownum = $entity->contains('emp_name', '佐藤')->count();
$entityList = $entity->select(); // count()と同じ条件でSELECT
```

### insert ###
新規レコードをINSERTするにはinsertメソッドを使用します。<br />
AUTOINCREMENTがTRUEに設定されている場合は、insert後、PKの値がエンティティにセットされます。
```
$entity = Entity_Employee::get();
$entity->emp_name = '佐藤';
$entity->dept_id = 1;
$entity->emp_tel = '090-0000-0000';
$entity->insert();
```

### update ###
取得したレコードをUPDATEするにはupdateメソッドを使用します。<br />
```
$entity = Entity_Employee::get()->find(1);
$entity->emp_name = '加藤';
$entity->update();
```

### updateAll ###
指定した条件に該当するレコードをすべて更新したい場合にはupdateAllメソッドを使用します。
```
// 条件にマッチするレコードのstatusを2にする
$entity = Entity_Employee::get();
$entity->status = 2;
$entity->gt('modified', $now)->upateAll();
```

### delete ###
単一レコードを削除するにはdeleteメソッドを使用します。
```
$entity = Entity_Employee::get->find(1);
$entity->delete();
```

また、PKを引数を指定して削除することもできます。
```
Entity_Employee::get()->delete(1);
```

### deleteAll ###
指定した条件に該当するレコードをすべて削除したい場合にはdeleteAllメソッドを使用します。
```
$entity = Entity_Employee::get();
$entity->gt('modified', $now)->deleteAll();
```

### join ###
※ [テーブルを結合したクエリー](DatabaseJoin.md) も参照してください。

joinメソッドは _JOINCONFIGで設定したalias名を指定して結合句を作ります。_<br />
_JOINCONFIG の定義に加えてJOINする条件を追加する場合は第2引数以降に where()と同じ方法で指定します。
```
$entity->join('foo', 'state IN (?,?)', 1, 2)->select();

// 「state IN (1,2)」 という条件が ON句に追加されます。
```_

### where ###
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

### eq ###
```
 eq($colname, $value, $notnullonly=true)
```
colname = ? のWhere句を追加します。<br />
$notnullonlyがtrueのときは、$valueに値がセットされている場合のみ追加されます。<br />
$notnullonlyがfalseのときは、$valueに値がセットされていないときは colname IS NULL が追加されます。

### ne ###
```
 ne($colname, $value, $notnullonly=true)
```
colname <> ? のWhere句を追加します。<br />
$notnullonlyがtrueのときは、$valueに値がセットされている場合のみ追加されます。<br />
$notnullonlyがfalseのときは、$valueに値がセットされていないときは colname IS NOT NULL が追加されます。

### lt ###
```
 lt($colname, $value)
```
colname < ? のWhere句を追加します。

### gt ###
```
 gt($colname, $value)
```
colname > ? のWhere句を追加します。

### le ###
```
 le($colname, $value)
```
colname <= ? のWhere句を追加します。

### ge ###
```
 ge($colname, $value)
```
colname >= ? のWhere句を追加します。

### in ###
```
 in($colname, $value)
```
colname IN (?,?..) のWhere句を追加します。$valueには配列を指定します。

### notin ###
```
 notin($colname, $value)
```
colname NOT IN (?,?..) のWhere句を追加します。$valueには配列を指定します。

### starts ###
```
 starts($colname, $value)
```
colname LIKE ? のWhere句を追加します。$valueの末尾に%をつけた形で実行します。

### ends ###
```
 ends($colname, $value)
```
colname LIKE ? のWhere句を追加します。$valueの先頭に%をつけた形で実行します。

### contains ###
```
 contains($colname, $value)
```
colname LIKE ? のWhere句を追加します。$valueの先頭と末尾に%をつけた形で実行します。

### order ###
ORDER BY句を指定します。
```
$records = $entity->order('base.modified, base.created')->select();
```

### limit ###
LIMIT句を指定します。
```
$records = $entity->limit(20)->select();
```

### offset ###
OFFSET句を指定します。
```
$records = $entity->limit(20)->offset(10)->select();
```