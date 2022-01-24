<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
codepen.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

CodePenウィジェットを埋め込むプラグイン。

【使い方】
#codepen(id[,[user][,[title][,[width][,theme]]]])

id    … コードID。CodePenサイト発行の埋め込みコード内「data-slug-hash="XXXXXXX"」の「XXXXXXX」部分
user  … ユーザー名。CodePenサイト発行の埋め込みコード内「data-user="XXXXXXX"」の「XXXXXXX」部分
title … 題名。CodePenサイト発行の埋め込みコード内「data-pen-title="XXXXXXX"」の「XXXXXXX」部分
width … ウィジェットの幅（px）。省略時の既定値は 806
theme  … default：通常の色調で表示、light：明るい色調で表示、dark：暗い色調で表示。省略時の既定値は default

【使用例】
#codepen(xxxxxxx)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_codepen_convert() {
	list($id, $user, $title, $width, $theme) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = htmlsc($id);
		$user = htmlsc(trim($id));
		$title = htmlsc(trim($title));
		$width = ($width > 0)? (int)$width . 'px' : '100%';
		$theme = ($theme)? htmlsc(strtolower(trim($theme))) : 'default';

		$widgetTag = '<div class="_p_codepen" style="max-width:' . $width . '"><p class="codepen" data-height="265" data-theme-id="' . $theme . '" data-default-tab="js,result" data-user="' . $user . '" data-slug-hash="' . $id . '" style="height: 265px; box-sizing: border-box; display: flex; align-items: center; justify-content: center; border: 2px solid; margin: 1em 0; padding: 1em;" data-pen-title="' . $title . '"></p></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_codepen{position:relative;width:100%;height:auto;min-width:0;min-height:0;max-height:100%;padding:0;border:none;overflow:hidden}
._p_codepen>iframe{max-width:100%;max-height:100%;padding:0;margin:0}
</style>
<script async src="https://static.codepen.io/assets/embed/ei.js"></script>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#codepen(id[,[user][,[title][,[width][,theme]]]])';
}
