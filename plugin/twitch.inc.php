<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
twitch.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Twitchチャンネル・動画・チャットを埋め込むプラグイン。

【使い方】
#twitch(channel|chat|video,id[,width])

第1引数 … 埋め込みウィジェットの種類。chennnel：チャンネル, chat：チャット, video：ビデオ
id      … チャンネルやビデオのID。Twitch内対象コンテンツURL「//player.twitch.tv/?channel=XXXXXXXXX」「//player.twitch.tv/?autoplay=false&video=XXXXXXXXX」における「XXXXXXXXX」部分
width   … ウィジェットの幅（px）。省略すると標準の幅となる

【使用例】
#twitch(channel,hoge)
#twitch(chat,hoge)
#twitch(video,000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_twitch_convert() {
	list($type, $id, $width) = func_get_args();

	$type = trim($type);
	$id = trim($id);
	if ($type && $id) {
		$id = urlencode($id);
		$type = strtolower($type);

		switch ($type) {
		case 'channel':
			$width = ($width > 0)? (int)$width : 620;
			$height = round($width * 378 / 620);
			$widgetTag = '<div class="_p_twitch _p_twitch-channel" style="max-width:' . $width . 'px"><iframe src="https:'.'//player.twitch.tv/?channel=' . $id . '" frameborder="0" allowfullscreen="true" scrolling="no" width="620" height="378" loading="lazy"></iframe></div>';
			break;

		case 'chat':
			$width = ($width > 0)? (int)$width : 350;
			$height = round($width * 500 / 350);
			$widgetTag = '<div class="_p_twitch _p_twitch-chat" style="max-width:' . $width . 'px"><iframe src="https:'.'//www.twitch.tv/embed/' . $id . '/chat" frameborder="0" allowfullscreen="true" scrolling="no" width="350" height="500" loading="lazy"></iframe></div>';
			break;

		case 'video':
			$width = ($width > 0)? (int)$width : 620;
			$height = round($width * 378 / 620);
			$widgetTag = '<div class="_p_twitch _p_twitch-video" style="max-width:' . $width . 'px"><iframe src="https:'.'//player.twitch.tv/?autoplay=false&video=' . $id . '" frameborder="0" allowfullscreen="true" scrolling="no" width="620" height="378" loading="lazy"></iframe></div>';
			break;
		}

		static	$included = false;
		if ($widgetTag && !$included) {
			// レスポンシブ対応：縦横比を維持するようスタイルを設定
			$aspectVideo = sprintf('%.5f', 378 / 620 * 100);
			$aspectChat = sprintf('%.5f', 500 / 350 * 100);
			$widgetTag .= <<<EOT
<style>
._p_twitch{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_twitch:before{display:block;content:'';padding:${aspectVideo}% 0 0 0;margin:0;background:transparent}
._p_twitch._p_twitch-chat:before{padding-top:${aspectChat}%}
._p_twitch>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;max-width:100%;max-height:auto}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#twitch(channel|chat|video,id[,width])';
}
