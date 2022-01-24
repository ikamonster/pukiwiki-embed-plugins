<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
snapchat.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

SnapChatストーリーを埋め込むプラグイン。

【使い方】
#snapchat(id)

id … ユーザー名またはスナップID。SnapChatサイト発行の埋め込みコード内「//play.snapchat.com/UserName」の「UserName」部分、または「//play.snapchat.com/s:XXXXXXXXXXXXXXXXXXXXXX」の「s:XXXXXXXXXXXXXXXXXXXXXX」部分。「?」以降は含まないので注意

【使用例】
#snapchat(hoge)
#snapchat(s:0000000000000000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_snapchat_convert() {
	list($id) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);

		$widgetTag = '<div class="_p_snapchat" style="max-width:270px;max-height:480px"><iframe width="270" height="480" style="max-width:270px;max-height:480px;" frameborder="0" src="https://play.snapchat.com/' . $id . '?loop=true" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_snapchat{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_snapchat>iframe{padding:0;margin:0}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#snapchat(id)';
}
