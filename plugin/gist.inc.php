<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
gist.inc.php, v1.0.1 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

GitHub Gistを埋め込むプラグイン。

【使い方】
#gist(user,id[,height])

user   … ユーザー名。GitHubサイト発行のGist埋め込みコード内「//gist.github.com/XXXX/YYYYYYYY」の「XXXX」部分
id     … GistID。GitHubサイト発行のGist埋め込みコード内「//gist.github.com/XXXX/YYYYYYYY」の「YYYYYYYY」部分
height … ウィジェットの高さ。単位は px, em, % 等（単位なしならpxとみなす）。この引数が指定されると、Gistウィジェットがiframe内に作られる

【使用例】
#gist(hoge,0000000)
#gist(hoge,0000000,15em)

【ご注意】
・埋め込みウィジェットの仕様はサービス提供者に依存します。もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
・タブプラグイン（tab.inc.php）で表示されるページにおいては、heightを指定しないと正しく表示されません。
*/

function plugin_gist_convert() {
	list($user, $id, $height) = func_get_args();

	$user = trim($user);
	$id = trim($id);
	if ($user && $id) {
		$user = urlencode($user);
		$id = urlencode($id);
		$container = '<div class="_p_gist" style="padding:0;border:none;width:100%;height:auto;max-width:100%;max-height:100%">';

		if ($height) {
			if (is_numeric($height)) $height = (int)$height . 'px';
			$widgetTag = $container . '<iframe src="./?plugin=gist&user=' . $user . '&id=' . $id . '" frameborder="0" style="width:100%;height:' . $height . ';margin:0;padding:0;border:none;overflow:auto" loading="lazy"></iframe></div>';
		} else {
			$widgetTag = $container . '<script src="https://gist.github.com/' . $user . '/' . $id . '.js"></script></div>';
		}
	}

	return ($widgetTag)? $widgetTag : '#gist(user,id[,height])';
}

function plugin_gist_action() {
	global	$vars;

	header('Content-Type: text/html; charset=UTF-8');

	if (isset($vars['user']) && isset($vars['id'])) {
		$url = 'https://gist.github.com/' . urlencode($vars['user']) . '/' . urlencode($vars['id']) . '.js';
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
<script src="{$url}"></script>
</body>
</head>
EOT;
	}

	exit;
}
