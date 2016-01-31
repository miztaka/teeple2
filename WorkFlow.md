![http://teeple2.googlecode.com/svn/wiki/teeple.jpg](http://teeple2.googlecode.com/svn/wiki/teeple.jpg)

#### フレームワークの基本動作 ####
フレームワークは基本的に以下のような流れで動作します。

  1. URLから呼び出すActionクラスを決定する。
  1. リクエストパラメータを保持するRequestオブジェクトを作成する。
  1. filter.iniの設定にしたがって FilterChainを構築する
  1. Filterのprefilter()を実行する(設定ファイルに書いてある順番に実行する)
  1. ActionクラスにRequestパラメータ等を自動セットする
  1. Actionクラスのメソッドを実行する
  1. Viewを実行する(Smartyテンプレートによる描画)
  1. Filterのpostfilter()を実行する(設定ファイルに書いてある順番と逆に実行する)