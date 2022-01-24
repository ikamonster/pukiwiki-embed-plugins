<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
note.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

noteウィジェットを埋め込むプラグイン。

【使い方】
#note(id)

id … 記事ID。noteサイト発行の埋め込みコード内「//note.com/embed/notes/XXXXXXXXXXXXX」の「XXXXXXXXXXXXX」部分

【使用例】
#note(0000000000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_note_convert() {
	list($id, $height) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$widgetTag = '<div class="_p_note"><iframe class="note-embed" src="https://note.com/embed/notes/' . $id . '" style="border:0;display:block;max-width:99%;width:494px;padding:0;margin:0;position:static;visibility:visible;" height="400" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_note{position:relative;width:100%;min-width:0;max-width:494px;height:auto;padding:0;border:none;overflow:hidden}
._p_note>iframe{max-width:100%;max-height:100%;padding:0;margin:0}
</style>
<script defer src="https://note.com/scripts/embed.js" charset="utf-8"></script>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#note(id)';
}
