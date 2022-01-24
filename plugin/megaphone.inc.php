<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
megaphone.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Megaphone再生プレイヤーを表示するプラグイン。

【使い方】
#megaphone(id[,theme])

id       … 動画ID。Megaphoneサイトの動画ページURL「cms.megaphone.fm/channel/vergecast?selected=XXXXXXXXXXXXX」の「XXXXXXXXXXXXX」部分
theme    … dark:ダークモード。省略時の既定値はライトモード

【使用例】
#megaphone(0000000000000)
#megaphone(0000000000000,dark)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_megaphone_convert() {
	list($id, $theme) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$theme = ($theme != 'dark')? '&light=true' : '';

		$widgetTag = '<div class="_p_megaphone" style="max-width:100%;max-height:200px"><iframe frameBorder="0" height="200" scrolling="no" src="https://playlist.megaphone.fm/?e=' . $id . $theme . '" width="100%" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_megaphone{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_megaphone>iframe{padding:0;margin:0;max-width:100%;max-height:auto:border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#megaphone(id[,theme])';
}
