### Filter概要 ###

Teeple2は JavaサーブレットのようなFilter機構を用意しています。<br />
Filterは定義された順番にprefilterメソッドが実行され、Actionが実行された後、今度は逆順にpostfilterメソッドが実行されます。

#### Filterの定義 ####

Filterの定義は webapp/config/filter.iniに定義します。<br />
PHPのiniファイル形式で各セクションにFilter名を指定します。
```
;;
;; Teeple Filter settings
;;
[DataSource]

[AdminAuth]
includes[] = "admin_.*"
_DEFAULT_ = _REJECT_
admin_login = _NOAUTH_
admin_ = _NOROLE_

[UserAuth]
includes[] = "user_.*"
_DEFAULT_ = _REJECT_
user_login = _NOAUTH_
user_ = _NOROLE_

[AutoTx]

```

Filterには自由にパラメータを渡すことができます。<br />
共通のパラメータとして includes[.md](.md) と excludes[.md](.md) があります。

includes[.md](.md) を指定すると、設定された正規表現にマッチするActionクラスにのみFilterが実行されます。(Actionクラス名を小文字にして比較)

includes[.md](.md) は複数行指定できます。

excludes[.md](.md) はその逆で、マッチしたActionクラスにはこのFilterは実行されません。


#### 配置場所 ####
Teeple2標準で用意されているFilterは webapp/libs/pear/teeple/filter に配置されてます。<br />

自作するFilterは webapp/components/teeple/filter に配置してください。


#### Filterを作成する ####

Filterを作成するには Teeple\_Filter をextendして prefilter,postfilterを実装します。



