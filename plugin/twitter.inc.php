<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
twitter.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Twitterウィジェットを埋め込むプラグイン。

【使い方】
#twitter(type,user[,[id][,[width][,[height][,theme]]]])

type   … 表示種別。tweet（単一のツイート）, profile（userのツイート）, likes（userがいいねしたツイート）, list（userの作成リスト）, collection（userのまとめたツイート） のいずれか
user   … 「@」から始まるユーザー名
id     … ツイート／リスト／コレクションID。ツイッターURL「//twitter.com/yyyy/status/XXXXXXX」または「//twitter.com/yyyy/timeline/XXXXXXX」の「XXXXXXX」部分。不要な type では省略
width  … ウィジェットの幅（px）。省略時の既定値は 500
height … ウィジェットの高さ（px）。省略時の既定値は 500。0 で高さ無制限
theme  … dark：暗い色調で表示。省略すると明るい色調で表示

【使用例】
#twitter(tweet,Hoge,000000000000000000)
#twitter(profile,Hoge)
#twitter(likes,Hoge)
#twitter(list,Hoge,fuga)
#twitter(collection,Hoge,111111111111111111)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_twitter_convert() {
	list($type, $user, $id, $width, $height, $theme) = func_get_args();

	$type = trim($type);
	$user = trim($user);
	if ($type && $user) {
		$type = strtolower($type);
		$user = urlencode($user);
		$id = urlencode(trim($id));
		$width = ' data-width="' . (($width > 0)? round($width) : 500) . '"';
		$height = (is_numeric($height) && $height == 0)? '' : (' data-height="' . (($height > 0)? round($height) : 500) . '"');
		$theme = (strtolower($theme) == 'dark')? ' data-theme="dark"' : '';
		$container = '<div class="_p_twitter" style="height:auto;padding:0;border:none;overflow:hidden">';

		switch ($type) {
		case 'tweet':
			$widgetTag = $container . '<blockquote class="twitter-tweet"' . $width . $theme . '><a href="https://twitter.com/' . $user . '/status/' . $id . '"></a></blockquote></div>';
			break;
		case 'profile':
			$widgetTag = $container . '<a class="twitter-timeline"' . $width . $height . $theme . ' href="https://twitter.com/' . $user . '"></a></div>';
			break;
		case 'likes':
			$widgetTag = $container . '<a class="twitter-timeline"' . $width . $height . $theme . ' href="https://twitter.com/' . $user . '/likes"></a></div>';
			break;
		case 'list':
			$widgetTag = $container . '<a class="twitter-timeline"' . $width . $height . $theme . ' href="https://twitter.com/' . $user . '/lists/' . $id . '"></a></div>';
			break;
		case 'collection':
			$widgetTag = $container . '<a class="twitter-timeline"' . $width . $height . $theme . ' href="https://twitter.com/' . $user . '/timelines/' . $id . '"></a></div>';
			break;
		}

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#twitter(type,user[,[id][,[width][,[height][,theme]]]])';
}
