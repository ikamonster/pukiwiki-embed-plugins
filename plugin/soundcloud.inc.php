<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
soundcloud.inc.php, v1.10 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

SoundCloud再生プレイヤーを表示するプラグイン。

【使い方】
#soundcloud(track|playlist,trackID[,[comment][,[color][,[width][,visual]]]])

第1引数 … track：曲再生、playlist：プレイリスト／アルバム再生
id      … 曲／プレイリスト／アルバムID。SoundCloudサイト発行の埋め込みコード内URL「//api.soundcloud.com/tracks/XXXXXXXXX&color=...」または「//api.soundcloud.com/playlists/XXXXXXXXX&color=...」における「XXXXXXXXX」部分
comment … 1：コメント表示、0：コメント非表示。省略時の既定値は 0。再生モードによっては無視される
color   … 再生ボタンの色を表す #RRGGBB 形式のカラーコード文字列。省略時の既定値はブランドカラー
width   … プレイヤーの幅（px）。省略すると領域いっぱいに表示
visual  … 1：視覚強調表示、0：通常表示。省略時の既定値は 0

【使用例】
#soundcloud(track,123456789,1)
#soundcloud(playlist,123456789)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_soundcloud_convert() {
	list($type, $code, $comments, $color, $width, $visual) = func_get_args();

	$type = strtolower(trim($type));
	$code = trim($code);
	if ($type && $code) {
		if ($type == 'track') $type = 'tracks';
		else if ($type == 'playlist') $type = 'playlists';

		if ($type == 'tracks' || $type == 'playlists') {
			$comments = ($comments)? 'true' : 'false';
			$color = ($color && preg_match('([\da-fA-F]{6}|[\da-fA-F]{3})', trim($color), $matches) > 0)? $matches[0] : "ff5500";
			$width = ($width > 0)? (int)$width . 'px' : '100%';
			$visual = ($visual)? '&visual=true' : '';

			if (!$visual) {
				$visual = '';
				$height = ($type == 'tracks')? 166 : 450;
			} else {
				$visual = '&visual=true';
				$height = 450;
			}

			$widgetTag = '<div class="_p_soundcloud" style="max-width:' . $width . ';max-height:' . $height . '"><iframe width="100%" height="' . $height . '" scrolling="no" frameborder="no" allow="autoplay" src="https:'.'//w.soundcloud.com/player/?url=https%3A'.'//api.soundcloud.com/' . $type . '/' . $code . '&color=%23' . $color . '&auto_play=false&hide_related=true&show_comments=' . $comments . '&show_user=true&show_reposts=false&show_teaser=false' . $visual . '" loading="lazy"></iframe></div>';

			static	$included = false;
			if (!$included) {
				$widgetTag .= <<<EOT
<style>
._p_soundcloud{position:relative;width:100%;height:auto;min-width:0;min-height:0;max-height:100%;padding:0;border:none;overflow:hidden}
._p_soundcloud>iframe{padding:0;margin:0;border:none}
</style>
EOT;
				$included = true;
			}
		}
	}

	return ($widgetTag)? $widgetTag : '#soundcloud(track|playlist,trackID[,[comment][,[color][,[width][,visual]]]])';
}
