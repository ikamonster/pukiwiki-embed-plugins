<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
styly.inc.php, v1.0.1 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

STYLYウィジェットを埋め込むプラグイン。

【使い方】
#styly(id[,width])

id       … コンテンツID。STYLYサイトのコンテンツページURL「//gallery.styly.cc/embed?g=XXXXXXXXXXX」の「XXXXXXXXXXX」部分
width    … ウィジェットの幅（px）。省略時の既定値は 640

【使用例】
#styly(0000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// STYLYプラグイン（styly.inc.php）
if (!defined('PLUGIN_STYLY_WIDTH'))  define('PLUGIN_STYLY_WIDTH',  640); // ウィジェット幅の既定値（px）
if (!defined('PLUGIN_STYLY_ASPECT')) define('PLUGIN_STYLY_ASPECT', (9.0 / 16.0)); // ウィジェットの縦横比


function plugin_styly_convert() {
	list($id, $width) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_STYLY_WIDTH;
		$height = round($width * PLUGIN_STYLY_ASPECT);

		$widgetTag = '<div class="_p_styly" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe height="' . $height . '" width="' . $width . '" frameborder="0" src="https://gallery.styly.cc/embed?g=' . $id . '" allowfullscreen="allowfullscreen" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$aspect = sprintf('%.5f', 100 * PLUGIN_STYLY_ASPECT);
			$widgetTag .= <<<EOT
<style>
._p_styly{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_styly:before{display:block;content:'';padding:{$aspect}% 0 0 0;margin:0;background:transparent}
._p_styly>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;margin:0;max-width:100%;max-height:auto}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#styly(id[,width])';
}
