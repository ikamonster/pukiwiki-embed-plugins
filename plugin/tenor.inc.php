<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
tenor.inc.php, v1.0.1 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

tenor画像を埋め込むプラグイン。

【使い方】
#tenor(id[,[aspect][,width]])

id     … 画像ID。tenorサイト発行の埋め込みコード内「data-postid="XXXXXXXX"」の「XXXXXXXX」部分
aspect … 画像の縦横比。tenorサイト発行の埋め込みコード内「data-aspect-ratio="XXX"」の「XXX」部分。省略時の既定値は1.0
width  … 画像の幅（px）。省略時の既定値は640

【使用例】
#tenor(00000000,1.778)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// tenorプラグイン（tenor.inc.php）
if (!defined('PLUGIN_TENOR_ASPECT')) define('PLUGIN_TENOR_ASPECT', 1.0); // ウィジェット幅の既定縦横比
if (!defined('PLUGIN_TENOR_WIDTH'))  define('PLUGIN_TENOR_WIDTH',  640); // ウィジェット幅の既定値（px）


function plugin_tenor_convert() {
	list($id, $aspect, $width) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = htmlsc($id);
		$aspect = ($aspect)? (float)$aspect : PLUGIN_TENOR_ASPECT;
		$width = ($width)? (int)$width : PLUGIN_TENOR_WIDTH;

		$widgetTag = '<div class="_p_tenor tenor-gif-embed" data-postid="' . $id . '" data-share-method="host" data-width="100%" data-aspect-ratio="' . $aspect . '"></div>';

		static	$included = false;
		if (!$included) {
			$widgetTag .= <<<EOT
<style>._p_tenor{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden;max-width:{$width}px}</style>
<script type="text/javascript" async src="https://tenor.com/embed.js"></script>
EOT;
		}

		$included = true;
	}

	return ($widgetTag)? $widgetTag : '#tenor(id[,[aspect][,width]])';
}
