<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
voicy.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Voicy再生プレイヤーを表示するプラグイン。

【使い方】
#voicy(channelID,showID[,width])

channelID … チャンネルID。Voicyサイト発行の埋め込みコード内「//voicy.jp/embed/channel/XXXX/YYYYY"」の「XXXX」部分
showID    … 番組ID。Voicyサイト発行の埋め込みコード内「//voicy.jp/embed/channel/XXXX/YYYYY"」の「YYYYY」部分
width     … プレイヤーの幅（px）。省略すると領域いっぱいに表示

【使用例】
#voicy(0000,12345)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_voicy_convert() {
	list($channelId, $showId, $width) = func_get_args();

	$channelId = trim($channelId);
	$conentId = trim($conentId);
	if ($channelId) {
		$id = urlencode($channelId) . (($showId)? '/' . urlencode($showId) : '');
		$width = ($width > 0)? (int)$width . 'px' : '100%';

		$widgetTag = '<div class="_p_voicy" style="max-width:' . $width . ';max-height:385px"><iframe src="https://voicy.jp/embed/channel/' . $id . '" width="' . $width . '" height="385" frameborder="0" scrolling="no" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_voicy{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_voicy>iframe{max-width:100%;max-height:100%;padding:0;margin:0}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#voicy(channelID,showID[,width])';
}
