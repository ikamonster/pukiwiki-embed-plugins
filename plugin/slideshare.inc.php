<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
slideshare.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

SlideShareウィジェットを埋め込むプラグイン。

【使い方】
#slideshare(id[,[startSlide][,width]])

id         … スライドID。SlideShareサイト発行の埋め込みコード内「//www.slideshare.net/slideshow/embed_code/key/XXXXXXXXXXXXXX」の「XXXXXXXXXXXXXX」部分
startSlide … スライドの表示開始ページ。1～ページ数まで。省略時の既定値は 1
width      … ウィジェットの幅（px）。省略時の既定値は 595

【使用例】
#slideshare(00000000000000)
#slideshare(00000000000000,5)
#slideshare(00000000000000,,800)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// SlideShareプラグイン（slideshare.inc.php）
if (!defined('PLUGIN_SLIDESHARE_WIDTH'))  define('PLUGIN_SLIDESHARE_WIDTH', 595); // ウィジェット幅の既定値（px）
if (!defined('PLUGIN_SLIDESHARE_ASPECT')) define('PLUGIN_SLIDESHARE_ASPECT', (9.0 / 16.0)); // ウィジェットの縦横比


function plugin_slideshare_convert() {
	list($id, $start, $width) = func_get_args();

	$id = trim($id);
	if ($id) {
		static	$included = 0;

		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_SLIDESHARE_WIDTH;
		$uiHeight = 39;	// 操作バー高さ
		$height = (int)($width * PLUGIN_SLIDESHARE_ASPECT) + $uiHeight;
		$start = ($start > 0)? '?startSlide=' . (int)$start : '';
		$aspect = sprintf('%.5f', $height / $width * 100);

		$widgetTag = '<div class="_p_slideshare _p_slideshare-' . $included . '" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="//www.slideshare.net/slideshow/embed_code/key/' . $id . $start . '" width="' . $width . '" height="' . $height . '" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid transparent; border-width:1px; margin-bottom:5px; max-width: 100%;" loading="lazy" allowfullscreen></iframe></div>';

		if ($included == 0) {
			$widgetTag .= <<<EOT
<style>
._p_slideshare{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_slideshare:before{display:block;content:'';padding:0;margin:0;background:transparent}
._p_slideshare>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;margin:0;max-width:100%;max-height:auto;box-sizing:border-box}
</style>
EOT;
		}

		$widgetTag .= '<style>._p_slideshare-' . $included . ':before{padding-top:' . $aspect . '%}</style>';

		$included++;
	}

	return ($widgetTag)? $widgetTag : '#slideshare(id[,[startSlide][,width]])';
}
