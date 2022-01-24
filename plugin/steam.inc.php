<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
steam.inc.php, v1.02 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Steamウィジェットを埋め込むプラグイン。

【使い方】
#steam(id[,introduction])

id           … Steam内対象ソフトのストアページURL「//store.steampowered.com/app/XXXXXX/Hoge/」における「XXXXXX」部分
introduction … 任意の文字列。省略すると各ソフト既定の紹介文が表示される

【使用例】
#steam(000000,最高のFPS！)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_steam_convert() {
	list($code, $intro) = func_get_args();

	$code = trim($code);
	if ($code) {
		$intro = ($intro)? '?t=' . urlencode(mb_strimwidth($intro, 0, 375)) : '';
		$widgetTag = '<div class="_p_steam" style="min-width:0;max-width:100%;height:auto;max-height:100%;padding:0;border:none;overflow:hidden"><iframe src="https:'.'//store.steampowered.com/widget/' . htmlsc($code) . '/' . $intro . '" frameborder="0" width="646" height="190" style="max-width:100%;max-height:auto" loading="lazy"></iframe></div>';
	}

	return ($widgetTag)? $widgetTag : '#steam(id[,introduction])';
}
