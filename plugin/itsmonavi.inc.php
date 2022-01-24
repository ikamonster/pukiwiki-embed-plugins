<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
itsmonavi.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

いつもNAVI地図を埋め込むプラグイン。

【使い方】
#itsmonavi(lat,lon[,[level][,[width][,height]]])

lat    … 緯度。いつもNAVIサイト発行の埋め込みコード内「&lat=XXXXXXXXX&lon=YYYYYYYYY&lvl=ZZ」の「XXXXXXXXXXXXX」部分
lon    … 経度。いつもNAVIサイト発行の埋め込みコード内「&lat=XXXXXXXXX&lon=YYYYYYYYY&lvl=ZZ」の「YYYYYYYYY」部分
level  … 表示倍率（1～18）。いつもNAVIサイト発行の埋め込みコード内「&lat=XXXXXXXXX&lon=YYYYYYYYY&lvl=ZZ」の「ZZ」部分。省略時の既定値は 10
width  … 地図の幅（px）。省略時の既定値は 640
height … 地図の高さ（px）。省略時の既定値は 480

【使用例】
#itsmonavi(0000000000000)
#itsmonavi(0000000000000,400,400)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// いつもNAVIプラグイン（itsmonavi.inc.php）
if (!defined('PLUGIN_ITSMONAVI_WIDTH'))  define('PLUGIN_ITSMONAVI_WIDTH',  640); // 地図幅の既定値（px）
if (!defined('PLUGIN_ITSMONAVI_HEIGHT')) define('PLUGIN_ITSMONAVI_HEIGHT', 480); // 地図高さの既定値（px）
if (!defined('PLUGIN_ITSMONAVI_LEVEL'))  define('PLUGIN_ITSMONAVI_LEVEL',  10);  // 表示倍率の既定値

function plugin_itsmonavi_convert() {
	list($lat, $lon, $level, $width, $height) = func_get_args();

	$lat = trim($lat);
	$lon = trim($lon);
	if ($lat && $lon) {
		$lat = (int)$lat;
		$lon = (int)$lon;
		$level = ($level > 0)? min(max($level, 0), 18) : PLUGIN_ITSMONAVI_LEVEL;
		$width = ($width > 0)? (int)$width : PLUGIN_ITSMONAVI_WIDTH;
		$height = ($height > 0)? (int)$height : PLUGIN_ITSMONAVI_HEIGHT;

		$widgetTag = '<div class="_p_itsmonavi" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.its-mo.com/map/link.php?type=1&lat=' . $lat . '&lon=' . $lon . '&lvl=' . $level . '&w=' . $width . '&h=' . $height . '" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_itsmonavi{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_itsmonavi>iframe{max-width:100%;max-height:100%;padding:0;margin:0;border:1px solid rgba(128,128,128,.333);box-sizing:border-box}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#itsmonavi(lat,lon[,[level][,[width][,height]]])';
}
