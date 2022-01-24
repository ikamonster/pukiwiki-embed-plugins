<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
googleslides.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Googleスライドを埋め込むプラグイン。

【使い方】
#googleslides(id[,[width][,[delay][,[autoStart][,loop]]]])

id        … スライドID。Googleスライドサイト発行のウェブ公開用埋め込みコード内「//docs.google.com/presentation/d/e/XXXXXXXXXX/embed」の「XXXXXXXXXX」部分
width     … スライドの幅（px）。省略時の既定値は 480
delay     … スライドショーのページ送り間隔（ミリ秒）。省略時の既定値は 3000
autoStart … 1：プレイヤーの読み込み後すぐにスライドショーを開始する。省略時の既定値は 0（オフ）
loop      … 1：最後のスライドまで到達したらスライドショーを再度開始する省略時の既定値は 0（オフ）

【使用例】
#googleslides(0000000000)
#googleslides(0000000000,800)
#googleslides(0000000000,,1,1)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// Googleスライドプラグイン（googleslides.inc.php）
if (!defined('PLUGIN_GOOGLESLIDES_WIDTH')) define('PLUGIN_GOOGLESLIDES_WIDTH', 480); // ウィジェット幅の既定値（px）
if (!defined('PLUGIN_GOOGLESLID_ASPECT'))  define('PLUGIN_GOOGLESLID_ASPECT', (9.0 / 16.0)); // ウィジェットの縦横比
if (!defined('PLUGIN_GOOGLESLIDES_DELAY')) define('PLUGIN_GOOGLESLIDES_DELAY', 3000); // ページ送り間隔既定値（ミリ秒）


function plugin_googleslides_convert() {
	list($id, $width, $delay, $autoStart, $loop) = func_get_args();

	$id = trim($id);
	if ($id) {
		static	$included = 0;
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_GOOGLESLIDES_WIDTH;
		$delay = ($delay > 0)? (int)$delay : PLUGIN_GOOGLESLIDES_DELAY;
		$autoStart = ($autoStart != 0)? 'true' : 'false';
		$loop = ($loop != 0)? 'true' : 'false';
		$uiHeight = 29;	// 操作バー高さ
		$height = (int)($width * PLUGIN_GOOGLESLID_ASPECT) + $uiHeight;
		$aspect = sprintf('%.5f', $height / $width * 100);

		$widgetTag = '<div class="_p_googleslides _p_googleslides-' . $included . '" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://docs.google.com/presentation/d/e/' . $id . '/embed?start=' . $autoStart . '&loop=' . $loop . '&delayms=' . $delay . '" frameborder="0" width="' . $width . '" height="' . $height . '" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" loading="lazy"></iframe></div>';

		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_googleslides{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_googleslides:before{display:block;content:'';padding:0;margin:0;background:transparent}
._p_googleslides>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;margin:0;max-width:100%;max-height:auto}
</style>
EOT;
		}

		$widgetTag .= '<style>._p_googleslides-' . $included . ':before{padding-top:' . $aspect . '%}</style>';

		$included++;
	}

	return ($widgetTag)? $widgetTag : '#googleslides(id[,[width][,[delay][,[autoStart][,loop]]]])';
}
