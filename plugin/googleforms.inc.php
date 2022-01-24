<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
googleforms.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Googleフォームを埋め込むプラグイン。

【使い方】
#googleforms(id[,[width][,height]])

id     … 記事ID。Googleフォームサイト発行の埋め込みコード内「//docs.google.com/forms/d/e/XXXXXXXXXXXXX/viewform」の「XXXXXXXXXXXXX」部分
width  … ウィジェットの幅（px）。省略時の既定値は 640
height … ウィジェットの高さ（px）。省略時の既定値は 382

【使用例】
#googleforms(0000000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// Googleフォームプラグイン（googleforms.inc.php）
if (!defined('PLUGIN_GOOGLEFORMS_WIDTH'))  define('PLUGIN_GOOGLEFORMS_WIDTH',  640); // ウィジェットの標準の幅（px）
if (!defined('PLUGIN_GOOGLEFORMS_HEIGHT')) define('PLUGIN_GOOGLEFORMS_HEIGHT', 382); // ウィジェットの標準の高さ（px）


function plugin_googleforms_convert() {
	list($id, $width, $height) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width)? (int)$width : PLUGIN_GOOGLEFORMS_WIDTH;
		$height = ($height)? (int)$height : PLUGIN_GOOGLEFORMS_HEIGHT;

		$widgetTag = '<div class="_p_googleforms" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://docs.google.com/forms/d/e/' . $id . '/viewform?embedded=true" width="' . $width . '" height="' . $height . '" frameborder="0" marginheight="0" marginwidth="0" loading="lazy">Now loading...</iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_googleforms{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_googleforms>iframe{max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#googleforms(id[,[width][,height]])';
}
