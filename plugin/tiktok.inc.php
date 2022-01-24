<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
tiktok.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

TikTok動画を埋め込むプラグイン。

【使い方】
#tiktok(userName,videoID)

userName … 「@」から始まるユーザー名
videoID … 動画ID。TikTokサイト発行の埋め込みコード内「data-video-id="XXXXXXXXXXXXXXXXXXX"」の「XXXXXXXXXXXXXXXXXXX」部分

【使用例】
#tiktok(@hoge,0000000000000000000)

【ご注意】
・埋め込みウィジェットの仕様はサービス提供者に依存します。もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
・2020年4月現在、埋め込みウィジェットは Internet Explorer および Edge 旧版（Edge HTML版）では正常に表示されません。
*/

function plugin_tiktok_convert() {
	list($user, $id) = func_get_args();

	$user = trim($user);
	$id = trim($id);
	if ($user && $id) {
		$user = urlencode($user);
		$id = urlencode($id);

		$widgetTag = '<div class="_p_tiktok" style="max-width:325px"><blockquote class="tiktok-embed" cite="https://www.tiktok.com/' . $user . '/video/' . $id . '" data-video-id="' . $id . '"><section></section></blockquote></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_tiktok{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden;max-height:960px}
._p_tiktok>blockquote{max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
<script defer src="https://www.tiktok.com/embed.js"></script>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#tiktok(username,videoID)';
}
