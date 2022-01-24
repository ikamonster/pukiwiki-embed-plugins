<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
globalgiving.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

GlobalGivingウィジェットを埋め込むプラグイン。

【使い方】
#globalgiving(id[,height])

id     … プロジェクトID。GlobalGivingサイトのプロジェクトページURL「//camp-fire.jp/projects/view/XXXXXX」の「XXXXXX」部分（?以降は省く）
height … ウィジェットの高さ。単位は px, em, % 等（単位なしならpxとみなす）。この引数が指定されると、GlobalGivingウィジェットがiframe内に作られる

【使用例】
#globalgiving(000000)
#globalgiving(000000,300)

【ご注意】
・埋め込みウィジェットの仕様はサービス提供者に依存します。もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
・タブプラグイン（tab.inc.php）で表示されるページにおいては、heightを指定しないと正しく表示されません。
*/

function plugin_globalgiving_convert() {
	list($id, $height) = func_get_args();

	if ($id) {
		$id = (int)$id;
		$container = '<div class="_p_globalgiving" style="padding:0;border:none;width:100%;height:auto;max-width:100%;max-height:100%">';

		if ($height) {
			if (is_numeric($height)) $height = (int)$height . 'px';
			$widgetTag = $container . '<iframe src="./?plugin=globalgiving&id=' . $id . '" frameborder="0" style="width:100%;height:' . $height . ';margin:0;padding:0;border:none;overflow:auto" loading="lazy"></iframe></div>';
		} else {
			$widgetTag = $container . '<script type="text/javascript" src="https://www.globalgiving.org/javascript/widget/widget.js" defer>{"projectids":"' . $id . '"}</script></div>';
		}
	}

	return ($widgetTag)? $widgetTag : '#globalgiving(id[,height])';
}

function plugin_globalgiving_action() {
	global	$vars;

	header('Content-Type: text/html; charset=UTF-8');

	if ($vars['id']) {
		$code = '<script type="text/javascript" src="https://www.globalgiving.org/javascript/widget/widget.js" defer>{"projectids":"' . (int)$vars['id'] . '"}</script>';
		echo <<< EOT
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,viewport-fit=cover"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="robots" content="noindex,nofollow,noarchive"/>
<style>
html,body{width:100%;height:100%;margin:0;padding:0;border:none;overflow:auto;-webkit-touch-callout:none;-webkit-text-size-adjust:100%}
</style>
</head>
<body>
${code}
</body>
</head>
EOT;
	}

	exit;
}
