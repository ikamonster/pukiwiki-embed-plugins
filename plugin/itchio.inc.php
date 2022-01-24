<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
itchio.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

itch.ioウィジェットを埋め込むプラグイン。

【使い方】
#itchio(id)

id … ページID。itch.ioサイト発行の埋め込みコード内「//itch.io/embed/XXXXXX」の「XXXXXX」部分

【使用例】
#itchio(000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_itchio_convert() {
	list($id) = func_get_args();

	$id = trim($id);
	if ($id) {
		$widgetTag = '<div class="_p_itchio" style="width:100%;max-width:552px;height:auto;padding:0;border:none;overflow:hidden"><iframe src="https://itch.io/embed/' . $id . '" height="167" width="552" frameborder="0" style="margin:0;padding:0;border:none" loading="lazy"></iframe></div>';
	}

	return ($widgetTag)? $widgetTag : '#itchio(id)';
}
