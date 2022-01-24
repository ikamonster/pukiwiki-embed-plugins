<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
scratch.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Scratchを埋め込むプラグイン。

【使い方】
#scratch(id[,[width][,height]])

id     … プロジェクトID。SCRATCHサイト発行の埋め込みコード内「//scratch.mit.edu/projects/XXXXXXXXX/」の「XXXXXXXXX」部分
width  … ウィジェットの幅（px）。省略すると標準の幅
height … ウィジェットの高さ（px）。省略すると標準の高さ

【使用例】
#scratch(000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_scratch_convert() {
	list($id, $width, $height) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : 485;
		$height = ($height > 0)? (int)$height : 402;

		$widgetTag = '<div class="_p_scratch" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://scratch.mit.edu/projects/' . $id . '/embed" allowtransparency="true" width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" loading="lazy" allowfullscreen></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_scratch{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_scratch>iframe{max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#scratch(id[,[width][,height]])';
}
