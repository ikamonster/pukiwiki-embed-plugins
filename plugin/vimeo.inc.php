<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
vimeo.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Vimeo動画再生プレイヤーを表示するプラグイン。

【使い方】
#vimeo(id[,[width][,[loop][,autoplay]]])

id       … 動画ID。Vimeoサイトの動画ページURL「//www.vimeo.com/watch?v=XXXXXXXXXXX」の「XXXXXXXXXXX」部分
width    … 動画の幅（px）。省略時の既定値は 640
loop     … 1：ループ再生、0：通常再生。省略時の既定値は 0
autoplay … 1：自動再生、0：手動再生。省略時の既定値は 0。モバイル環境では効かないことがある

【使用例】
#vimeo(00000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// Vimeoプラグイン（vimeo.inc.php）
if (!defined('PLUGIN_VIMEO_WIDTH'))  define('PLUGIN_VIMEO_WIDTH',  640); // 動画幅の既定値（px）
if (!defined('PLUGIN_VIMEO_ASPECT')) define('PLUGIN_VIMEO_ASPECT', (9.0 / 16.0)); // 動画の縦横比


function plugin_vimeo_convert() {
	list($id, $width, $loop, $autoplay) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_VIMEO_WIDTH;
		$height = round($width * PLUGIN_VIMEO_ASPECT);
		$loop = ($loop)? '&loop=1' : '';
		$autoplay = ($autoplay)? '&autoplay=1' : '';

		$widgetTag = '<div class="_p_vimeo" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://player.vimeo.com/video/' . $id . '?byline=0' . $autoplay . $loop . '" width="' . $width . '" height="' . $height . '" frameborder="0" allow="autoplay; fullscreen" loading="lazy" allowfullscreen></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$aspect = sprintf('%.5f', 100 * PLUGIN_VIMEO_ASPECT);
			$widgetTag .= <<<EOT
<style>
._p_vimeo{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_vimeo:before{display:block;content:'';padding:${aspect}% 0 0 0;margin:0;background:transparent}
._p_vimeo>iframe{position:absolute;top:0;left:0;width:100%;height:100%;max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#vimeo(id[,[width][,[loop][,autoplay]]])';
}
