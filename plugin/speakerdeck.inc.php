<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
speakerdeck.inc.php, v1.0.1 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Speaker Deckのスライドを埋め込むプラグイン。

【使い方】
#speakerdeck(id[,[width][,[start][,ratio]]])

id    … スライドID。Speaker Deckサイト発行の埋め込みコード内「data-id="XXXXX"」の「XXXXX」部分
width … スライドの幅（px）。省略時の既定値は 640
start … スライドの開始ページ（1～）。省略時の既定値は 1
ratio … スライドの縦横比。SpeakerDeckサイト発行の埋め込みコード内「data-ratio="X.XXX"」の「X.XXX」部分。省略時の既定値は 1.77777777777778

【使用例】
#speakerdeck(00000)
#speakerdeck(00000,320)
#speakerdeck(00000,,10)
#speakerdeck(00000,,,1.333333)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// Speaker Deckプラグイン（speakerdeck.inc.php）
if (!defined('PLUGIN_SPEAKERDECK_WIDTH')) define('PLUGIN_SPEAKERDECK_WIDTH', 640); // スライド幅の既定値（px）
if (!defined('PLUGIN_SPEAKERDECK_RATIO')) define('PLUGIN_SPEAKERDECK_RATIO', (16.0 / 9.0)); // スライド縦横比の既定値


function plugin_speakerdeck_convert() {
	list($id, $width, $start, $ratio) = func_get_args();

	$id = trim($id);
	if ($id) {
		static	$included = 0;
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_SPEAKERDECK_WIDTH;
		$ratio = ($ratio > 0)? (float)$ratio : PLUGIN_SPEAKERDECK_RATIO;
		$height = round($width / $ratio);

		if (!exist_plugin_convert('tab')) {
			$start = ($start > 0)? ' data-slide="' . max($start, 0) . '"' : '';
			$widgetTag = '<div class="_p_speakerdeck _p_speakerdeck-' . $included . '" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><script async class="speakerdeck-embed"' . $start . ' data-id="' . $id . '" data-ratio="' . $ratio . '" src="//speakerdeck.com/assets/embed.js"></script></div>';
		} else {
			// plugin/tab.inc.php 対応
			$start = ($start > 0)? '&start=' . max($start, 0) : '';
			$widgetTag = '<div class="_p_speakerdeck _p_speakerdeck-' . $included . '" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="./?plugin=speakerdeck&id=' . $id . '&width=' . $width . '&ratio=' . $ratio . $start . '" frameborder="0" style="width:100%;height:100%;max-width:' . $width . ';max-height:' . $height . ';margin:0;padding:0;border:none;overflow:auto" loading="lazy"></iframe></div>';
		}

		if (!$included) {
			$widgetTag .= <<<EOT
<style>
._p_speakerdeck{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_speakerdeck:before{display:block;content:'';padding:0;margin:0;background:transparent}
._p_speakerdeck>div,._p_speakerdeck>iframe{position:absolute;top:0;left:0;width:100%;height:100%;min-width:0;min-height:0;padding:0;margin:0;max-width:100%;max-height:100%;overflow:hidden}
</style>
EOT;
		}

		$widgetTag .= '<style>._p_speakerdeck._p_speakerdeck-' . $included . ':before{padding-top:' . sprintf('%.5f', 100 * $height / $width) . '%}</style>';

		$included++;
	}

	return ($widgetTag)? $widgetTag : '#speakerdeck(id[,[width][,[start][,ratio]]])';
}

function plugin_speakerdeck_action() {
	global	$vars;

	header('Content-Type: text/html; charset=UTF-8');
	header('Cache-Control: max-age=86400');

	if (isset($vars['id']) && isset($vars['width']) && isset($vars['ratio'])) {
		$id = urlencode($vars['id']);
		$width = (int)$vars['width'];
		$ratio = (float)$vars['ratio'];
		$height = round($width / $ratio);
		$start = (isset($vars['start']))? ' data-slide="' . max($vars['start'], 0) . '"' : '';

		echo <<< EOT
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,viewport-fit=cover"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="robots" content="noindex,nofollow,noarchive"/>
<style>
html,body{width:100%;height:auto;margin:0;padding:0;border:none;overflow:hidden;box-sizing:border-box;-webkit-touch-callout:none;-webkit-text-size-adjust:100%}
</style>
</head>
<body>
<script async class="speakerdeck-embed" data-id="{$id}"{$start} data-ratio="{$ratio}" src="//speakerdeck.com/assets/embed.js"></script>
</body>
</head>
EOT;
	}

	exit;
}
