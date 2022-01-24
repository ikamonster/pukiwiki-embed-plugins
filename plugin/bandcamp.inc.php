<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
bandcamp.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Bandcamp再生プレイヤーを表示するプラグイン。

【使い方】
#bandcamp(albumID[,[type][,theme]])

albumID … アルバムID。Bandcampサイト発行の埋め込みコード内「/album=XXXXXXXXXX/」の「XXXXXXXXXX」部分
type    … 表示種別。standard, slim, artwork のいずれか。省略時の既定値は standard
theme   … dark：暗い色調で表示。省略すると明るい色調で表示

【使用例】
#bandcamp(0000000000)
#bandcamp(0000000000,artwork)
#bandcamp(0000000000,,dark)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_bandcamp_convert() {
	list($id, $type, $theme) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$type = strtolower(trim($type));
		$theme = (strtolower(trim($theme) == 'dark'))? '333333' : 'ffffff';

		switch ($type) {
		case 'slim':
			$widgetTag = '<iframe style="border:0;width:100%;height:42px;" src="https://bandcamp.com/EmbeddedPlayer/album=' . $id . '/size=small/bgcol=' . $theme . '/linkcol=0687f5/transparent=true/" loading="lazy" seamless>';
			break;

		case 'artwork';
			$widgetTag = '<iframe style="border:0;width:350px;height:350px;" src="https://bandcamp.com/EmbeddedPlayer/album=' . $id . '/size=large/bgcol=' . $theme . '/linkcol=0f91ff/minimal=true/transparent=true/" loading="lazy" seamless></iframe>';
			break;

		case 'standard';
		case '';
		default:
			$widgetTag = '<iframe style="border:0;width:400px;height:120px;" src="https://bandcamp.com/EmbeddedPlayer/album=' . $id . '/size=large/bgcol=' . $theme . '/linkcol=0687f5/tracklist=false/artwork=small/transparent=true/" loading="lazy" seamless></iframe>';
			break;
		}

		$widgetTag = '<div class="_p_bandcamp">' . $widgetTag . '</iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_bandcamp{position:relative;width:auto;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_bandcamp>iframe{width:auto;height:auto;min-width:0;min-height:0;max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#bandcamp(albumID[,[type][,theme]])';
}
