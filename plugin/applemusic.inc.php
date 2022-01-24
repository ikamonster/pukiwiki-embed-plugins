<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
applemusic.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Apple Music再生プレイヤーを表示するプラグイン。
アルバム再生・曲再生のみ可能、アーティスト情報やプレイリスト等には非対応。

【使い方】
#applemusic(albumID[,[songID][,country]])

albumID … アルバムID。Apple Musicサイト発行の埋め込みコード内「//embed.music.apple.com/ZZ/album/XXXXXXXXXX?app=music」の「XXXXXXXXXX」部分
songID  … 曲ID。指定すると曲再生ウィジェット、省略するとアルバム再生ウィジェットとなる。Apple Musicサイト発行の埋め込みコード内「//embed.music.apple.com/ZZ/album/XXXXXXXXXX?i=YYYYYYYYYY&app=music」の「YYYYYYYYYY」部分
country … 2文字国名コード。Apple Musicサイト発行の埋め込みコード内「//embed.music.apple.com/ZZ/album/XXXXXXXXXX?i=YYYYYYYYYY&app=music」の「ZZ」部分。省略時の既定値は jp

【使用例】
#applemusic(0000000000)
#applemusic(0000000000,1111111111)
#applemusic(2222222222,,us)
#applemusic(2222222222,3333333333,us)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_applemusic_convert() {
	list($id, $song, $country) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$song = urlencode(trim($song));
		$country = urlencode(strtolower(trim($country)));
		if (!$country) $country = 'jp';

		if (!$song) {
			$widgetTag = '<div class="_p_applemusic" style="max-width:660px;max-height:450px"><iframe allow="autoplay *; encrypted-media *;" frameborder="0" height="450" style="width:100%;max-width:660px;overflow:hidden;background:transparent;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.music.apple.com/' . $country . '/album/' . $id . '" loading="lazy"></iframe></div>';
		} else {
			$widgetTag = '<div class="_p_applemusic" style="max-width:660px;max-height:150px"><iframe allow="autoplay *; encrypted-media *;" frameborder="0" height="150" style="width:100%;max-width:660px;overflow:hidden;background:transparent;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" src="https://embed.music.apple.com/' . $country . '/album/' . $id . '?i=' . $song . '" loading="lazy"></iframe></div>';
		}

		static	$included = false;
		if (!$included) {
			$widgetTag .= <<<EOT
<style>
._p_applemusic{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_applemusic>iframe{padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#applemusic(albumID[,[songID][,country]])';
}
