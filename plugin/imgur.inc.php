<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
imgur.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

imgur画像／動画を埋め込むプラグイン。

【使い方】
#imgur(id)

id … 画像／動画ID。imgurサイト発行の埋め込みコード内「data-id="a/XXXXXX"」の「XXXXXX」部分

【使用例】
#imgur(000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_imgur_convert() {
	list($id) = func_get_args();

	$id = trim($id);
	if ($id) {
		$widgetTag = '<div class="_p_imgur" style="min-width:0;min-height:0;height:auto;border:none;padding:0;overflow:hidden;"><blockquote class="imgur-embed-pub" lang="en" data-id="a/' . urlencode($id) . '" data-context="false"></blockquote><script async src="//s.imgur.com/min/embed.js" charset="utf-8"></script></div>';
	}

	return ($widgetTag)? $widgetTag : '#imgur(id)';
}
