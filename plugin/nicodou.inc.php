<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
nicodou.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

ニコニコ動画再生プレイヤーを表示するプラグイン。

【使い方】
#nicodou(id[,[width][,start]])

id       … 動画ID。ニコニコ動画サイトの動画ページURL「//www.nicovideo.jp/watch/smXXXXX」の「smXXXXX」部分
width    … 動画の幅（px）。省略時の既定値は 640
start    … 再生開始位置（秒）。省略時の既定値は 0

【使用例】
#nicodou(sm00000)
#nicodou(sm00000,320)
#nicodou(sm00000,,30)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// ニコニコ動画プラグイン（nicodou.inc.php）
if (!defined('PLUGIN_NICODOU_WIDTH'))  define('PLUGIN_NICODOU_WIDTH',  640); // 動画幅の既定値（px）
if (!defined('PLUGIN_NICODOU_ASPECT')) define('PLUGIN_NICODOU_ASPECT', (9.0 / 16.0)); // 動画の縦横比


function plugin_nicodou_convert() {
	list($id, $width, $start) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_NICODOU_WIDTH;
		$height = round($width * PLUGIN_NICODOU_ASPECT);
		$start = ($start > 0)? '&from=' . round($start) : '';

		if (!exist_plugin_convert('tab')) {
			$widgetTag = '<div class="_p_nicodou" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><script type="application/javascript" src="https://embed.nicovideo.jp/watch/' . $id . '/script?w=' . $width . '&h=' . $height . $start . '"></script><noscript><a href="https://www.nicovideo.jp/watch/' . $id . '">https://www.nicovideo.jp/watch/' . $id . '</a></noscript></div>';
		} else {
			// plugin/tab.inc.php 対応
			$widgetTag = '<div class="_p_nicodou" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="./?plugin=nicodou&id=' . $id . '&width=' . $width . '&height=' . $height . $start . '" frameborder="0" style="width:100%;height:100%;max-width:' . $width . ';max-height:' . $height . ';margin:0;padding:0;border:none;overflow:auto" loading="lazy"></iframe></div>';
		}

		static	$included = false;
		if ($widgetTag && !$included) {
			$aspect = sprintf('%.5f', 100 * PLUGIN_NICODOU_ASPECT);
			$widgetTag .= <<<EOT
<style>
._p_nicodou{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_nicodou:before{display:block;content:'';padding:${aspect}% 0 0 0;margin:0;background:transparent}
._p_nicodou>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;margin:0;max-width:100%;max-height:100%;overflow:hidden}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#nicodou(id[,[width][,start]])';
}

function plugin_nicodou_action() {
	global	$vars;

	header('Content-Type: text/html; charset=UTF-8');
	header('Cache-Control: max-age=86400');

	if (isset($vars['id']) && isset($vars['width']) && isset($vars['height'])) {
		$id = urlencode($vars['id']);
		$width = urlencode($vars['width']);
		$height = urlencode($vars['height']);
		$from = (isset($vars['from']))? '&from=' . round($vars['from']) : '';
		$aspect = sprintf('%.5f', $height / $width * 100);

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
._p_nicodou{position:relative;width:100%;max-width:${width}px;height:100%;max-height:${height}px;overflow:hidden}
._p_nicodou:before{display:block;content:'';padding:${aspect}% 0 0 0;margin:0;background:transparent}
._p_nicodou>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;margin:0;max-width:100%;max-height:100%;overflow:hidden}
</style>
</head>
<body>
<div class="_p_nicodou">
	<script type="application/javascript" src="https://embed.nicovideo.jp/watch/${id}/script?w=${width}&h=${height}${from}"></script>
	<noscript><a href="https://www.nicovideo.jp/watch/${id}">https://www.nicovideo.jp/watch/${id}</a></noscript>
</div>
</body>
</head>
EOT;
	}

	exit;
}
