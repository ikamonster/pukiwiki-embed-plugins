<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
shadertoy.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Shadertoyウィジェットを埋め込むプラグイン。

【使い方】
#shadertoy(id[,[width][,autoplay]])

id       … 動画ID。Shadertoyサイトの動画ページURL「//gallery.shadertoy.cc/embed?g=XXXXXXXXXXX」の「XXXXXXXXXXX」部分
width    … 動画の幅（px）。省略時の既定値は 560
autoplay … 1：自動再生、0：手動再生。省略時の既定値は 0

【使用例】
#shadertoy(0000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// Shadertoyプラグイン（shadertoy.inc.php）
if (!defined('PLUGIN_SHADERTOY_WIDTH'))  define('PLUGIN_SHADERTOY_WIDTH',  640);          // ウィジェット幅の既定値（px）
if (!defined('PLUGIN_SHADERTOY_ASPECT')) define('PLUGIN_SHADERTOY_ASPECT', (9.0 / 16.0)); // ウィジェットの縦横比


function plugin_shadertoy_convert() {
	list($id, $width, $autoplay) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_SHADERTOY_WIDTH;
		$height = round($width * PLUGIN_SHADERTOY_ASPECT);
		$autoplay = ($autoplay)? 'false' : 'true';

		$widgetTag = '<div class="_p_shadertoy" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe width="' . $width . '" height="' . $height . '" frameborder="0" src="https://www.shadertoy.com/embed/' . $id . '?gui=true&t=10&paused=' . $autoplay . '&muted=false" loading="lazy" allowfullscreen></iframe></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$aspect = sprintf('%.5f', 100 * PLUGIN_SHADERTOY_ASPECT);
			$widgetTag .= <<<EOT
<style>
._p_shadertoy{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_shadertoy:before{display:block;content:'';padding:${aspect}% 0 0 0;margin:0;background:transparent}
._p_shadertoy>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;margin:0;max-width:100%;max-height:auto}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#shadertoy(id[,[width][,autoplay]])';
}
