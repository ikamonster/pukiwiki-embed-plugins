<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
googlemymaps.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Googleマイマップを埋め込むプラグイン。

【使い方】
#googlemymaps(id[,[width][,height]])

id     … 地図ID。Googleマイマップサイト発行の埋め込みコード内「//googlemymaps.com/embed/googlemymaps/XXXXXXXXXXXXX」の「XXXXXXXXXXXXX」部分
width  … 地図の幅（px）。省略時の既定値は 640
height … 地図の高さ（px）。省略時の既定値は 480

【使用例】
#googlemymaps(0000000000000)
#googlemymaps(0000000000000,400,400)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// Googleマイマッププラグイン（googlemymaps.inc.php）
if (!defined('PLUGIN_GOOGLEMYMAPS_WIDTH'))  define('PLUGIN_GOOGLEMYMAPS_WIDTH',  640); // ウィジェット幅の既定値（px）
if (!defined('PLUGIN_GOOGLEMYMAPS_HEIGHT')) define('PLUGIN_GOOGLEMYMAPS_HEIGHT', 480); // ウィジェット高さの既定値（px）


function plugin_googlemymaps_convert() {
	list($id, $width, $height) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_GOOGLEMYMAPS_WIDTH;
		$height = ($height > 0)? (int)$height : PLUGIN_GOOGLEMYMAPS_HEIGHT;

		$widgetTag = '<div class="_p_googlemymaps" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://www.google.com/maps/d/embed?mid=' . $id . '" width="' . $width .'" height="' . $height . '" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_googlemymaps{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_googlemymaps>iframe{max-width:100%;max-height:100%;padding:0;margin:0;border:1px solid rgba(128,128,128,.333);box-sizing:border-box}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#googlemymaps(id[,[width][,height]])';
}
