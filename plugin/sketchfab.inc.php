<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
sketchfab.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Sketchfabウィジェットを埋め込むプラグイン。

【使い方】
#sketchfab(id[,[width][,[height][,[autostart][,[aniEntrance][,[turn][,preload]]]]]])

id … モデルID。Sketchfabサイト発行の埋め込みコード内「//sketchfab.com/models/XXXXXXXXXX/embed」の「XXXXXXXXXX」部分
width … ウィジェットの幅（px）。省略時の既定値は 640
height … ウィジェットの高さ（px）。省略時の既定値は 480
autostart … 1：自動再生、0：手動再生。省略時の既定値は 0
aniEntrance … 1：カメラ移動しながら開始、0：静止したまま開始。省略時の既定値は 0
turn … 1：カメラ自動旋回、0：カメラ静止。省略時の既定値は 0
preload … 1：データの事前ロードあり、0：事前ロードなし。省略時の既定値は 0

【使用例】
#sketchfab(XXXXXXXXXX)

【ご注意】
・埋め込みウィジェットの仕様はサービス提供者に依存します。もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
・モデルによってはブラウザーやハードウェアが対応できず、正常に表示されない場合やクラッシュする場合があります。
*/

/////////////////////////////////////////////////
// Sketchfabプラグイン（sketchfab.inc.php）
if (!defined('PLUGIN_SKETCHFAB_WIDTH'))  define('PLUGIN_SKETCHFAB_WIDTH',  640); // ウィジェット幅の既定値（px）
if (!defined('PLUGIN_SKETCHFAB_HEIGHT')) define('PLUGIN_SKETCHFAB_HEIGHT', 480); // ウィジェット高さの既定値（px）


function plugin_sketchfab_convert() {
	list($id, $width, $height, $autostart, $aniEntrance, $turn, $preload) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_SKETCHFAB_WIDTH;
		$height = ($height > 0)? (int)$height : PLUGIN_SKETCHFAB_HEIGHT;

		if (!is_numeric($autostart)) $autostart = 0;
		if (!is_numeric($aniEntrance)) $aniEntrance = 1;
		if (!is_numeric($turn)) $turn = 0;
		if (!is_numeric($preload)) $preload = 1;

		$turn = ($turn)? 'autospin=0.2&amp;' : '';
		$autostart = ($autostart)? 'autostart=1&amp;' : '';
		$aniEntrance = ($aniEntrance)? '' : 'camera=0&amp;';
		$preload = ($preload)? 'preload=1&amp;' : '';

		$widgetTag = '<div class="_p_sketchfab" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><div class="sketchfab-embed-wrapper"><iframe title="A 3D model" width="' . $width . '" height="' . $height . '" src="https://sketchfab.com/models/' . $id . '/embed?' . $turn . $autostart . $aniEntrance . $preload . 'ui_controls=1&amp;ui_infos=1&amp;ui_inspector=1&amp;ui_stop=1&amp;ui_watermark=1&amp;ui_watermark_link=1" frameborder="0" allow="autoplay; fullscreen; vr" mozallowfullscreen="true" webkitallowfullscreen="true" loading="lazy"></iframe></div></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_sketchfab{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_sketchfab>div{max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#sketchfab(id[,[width][,[height][,[autostart][,[aniEntrance][,[turn][,preload]]]]]])';
}
