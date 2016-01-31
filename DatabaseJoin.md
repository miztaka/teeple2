### テーブルの結合 ###

#### ハイライト ####
Teeple\_ActiveRecordではテーブルを結合した形でのクエリーを実行できます。<br />
たとえば、DeptテーブルとEmployeeテーブルが1:Nの関係だとします。<br />
部門名が"管理部"のEmployeeをselectするには以下のようにします。
```
$entityList = Entity_Employee::get()
    ->join('dept')
    ->eq('dept.dept_name', '管理部')
    ->select();
```

結合したDeptテーブルのエンティティはEmployeeテーブルのプロパティとしてセットされます。
```
foreach ($entityList as $e) {
    print $e->dept->dept_name;
}
```

#### JOINの定義 ####
joinを使用するためにはあらかじめエンティティに定義をしておく必要があります。<br />
エンティティを自動生成した場合はDBにFKがセットされていれば自動的にJOINの定義も作成されます。<br />
もちろん手動で設定することも可能です。<br />
JOINの定義はエンティティクラスに以下のように定義します。
```
public static $_JOINCONFIG = array(
    'dept' => array(
        'entity' => 'Entity_Dept',    // <== エンティティクラス名
        'type' => 'LEFT JOIN',        // <== JOINのタイプ。(ex. INNER JOIN)
        'relation' => array(
            'dept_id' => 'id'         // <== 結合キー。 本テーブルのカラム => JOINするテーブルのカラム
        )
    )
);

/**
 * @var Entity_Dept
 */
public $dept;     // <== JOINしたテーブルのエンティティを格納するプロパティ
```

#### joinを使用したときのWhere句 ####
joinを使用するとき、whereメソッドやwhereの簡易メソッドに指定するカラム名は
> 'エイリアス名.カラム名' とします。<br />
join元のカラムは エイリアス名に'base'を使用します。
```
$entityList = Entity_Employee::get()
    ->join('dept')
    ->eq('dept.dept_name', '管理部')
    ->gt('base.salary', 100000)
    ->select();
```

#### ネストした結合 ####
A => B => C という形で結合をネストする場合、B$C というエイリアスを指定することで エンティティBに設定されているCの定義を設定できます。<br />
必ず先に A=>Bのjoinを定義してください。
```
$entity = Entity_Employee::get()
    ->join('dept')
    ->join('dept$section')
    ->eq('base.emp_id', 1)
    ->find();
```
