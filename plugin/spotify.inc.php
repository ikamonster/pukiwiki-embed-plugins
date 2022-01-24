<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
spotify.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Spotify再生プレイヤーを表示するプラグイン。

【使い方】
#spotify(type,id)

type … 再生種別。artist, album, track, playlist, podcast, episode のいずれか。Spotifyサイト発行の埋め込みコード内「//open.spotify.com/embed/?????/XXXXXXXXXXXXXXXXXXXXXX」の「?????」部分
id   … コンテンツID。Spotifyサイト発行の埋め込みコード内「////open.spotify.com/embed/?????/XXXXXXXXXXXXXXXXXXXXXX」の「XXXXXXXXXXXXXXXXXXXXXX」部分

【使用例】
#spotify(playlist,0000000000000000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_spotify_convert() {
	list($type, $id) = func_get_args();

	$type = trim($type);
	$id = trim($id);
	if ($type && $id) {
		$id = urlencode($id);
		$type = strtolower($type);

		switch ($type) {
		case 'artist';
			$width = 300;
			$height = 380;
			$widgetTag = '<div class="_p_spotify" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://open.spotify.com/embed/artist/' . $id . '" width="' . $width . '" height="' . $height . '" frameborder="0" allowtransparency="true" allow="encrypted-media" loading="lazy"></iframe></div>';
			break;

		case 'album';
			$width = 300;
			$height = 380;
			$widgetTag = '<div class="_p_spotify" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://open.spotify.com/embed/album/' . $id . '" width="' . $width . '" height="' . $height . '" frameborder="0" allowtransparency="true" allow="encrypted-media" loading="lazy"></iframe></div>';
			break;

		case 'track';
			$width = 300;
			$height = 380;
			$widgetTag = '<div class="_p_spotify" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://open.spotify.com/embed/track/' . $id . '" width="' . $width . '" height="' . $height . '" frameborder="0" allowtransparency="true" allow="encrypted-media" loading="lazy"></iframe></div>';
			break;

		case 'playlist';
			$width = 300;
			$height = 380;
			$widgetTag = '<div class="_p_spotify" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://open.spotify.com/embed/playlist/' . $id . '" width="' . $width . '" height="' . $height . '" frameborder="0" allowtransparency="true" allow="encrypted-media" loading="lazy"></iframe></div>';
			break;

		case 'podcast':
			$width = 0;
			$height = 232;
			$widgetTag = '<div class="_p_spotify" style="max-width:100%;max-height:' . $height . 'px"><iframe src="https://open.spotify.com/embed-podcast/show/' . $id . '" width="100%" height="' . $height . '" frameborder="0" allowtransparency="true" allow="encrypted-media" loading="lazy"></iframe></div>';
			break;

		case 'episode':
			$width = 0;
			$height = 232;
			$widgetTag = '<div class="_p_spotify" style="max-width:100%;max-height:' . $height . 'px"><iframe src="https://open.spotify.com/embed-podcast/episode/' . $id . '" width="100%" height="' . $height . '" frameborder="0" allowtransparency="true" allow="encrypted-media" loading="lazy"></iframe></div>';
			break;
		}

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_spotify{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_spotify>iframe{padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#spotify(type,id)';
}
