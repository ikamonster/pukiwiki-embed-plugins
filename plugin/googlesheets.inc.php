<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
googlesheets.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Googleスプレッドシートを埋め込むプラグイン。

【使い方】
#googlesheets(docID[,[sheetID][,height]])

docID   … ドキュメントID。Googleスプレッドシートサイト発行の埋め込みコード内「//docs.google.com/spreadsheets/d/e/XXXXX/pubhtml」の「XXXXX」部分
sheetID … シートID。ドキュメント全体ではなく、特定シートのみ埋め込む場合に指定。Googleスプレッドシートサイト発行の埋め込みコード内「//docs.google.com/spreadsheets/d/e/XXXXX/pubhtml?gid=YYYYY&...」の「YYYYY」部分
height  … ウィジェットの高さ（px）。省略時の既定値は 400

【使用例】
#googlesheets(00000)
#googlesheets(00000,11111)
#googlesheets(00000,,800)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適宜書き換えてください。
*/

/////////////////////////////////////////////////
// Googleスプレッドシートプラグイン（googlesheets.inc.php）
if (!defined('PLUGIN_GOOGLESHEETS_HEIGHT')) define('PLUGIN_GOOGLESHEETS_HEIGHT', 400); // ウィジェットの標準の高さ（px）


function plugin_googlesheets_convert() {
	list($id, $gid, $height) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$gid = urlencode(trim($gid));
		$height = ($height)? $height : PLUGIN_GOOGLESHEETS_HEIGHT;
		$gid = ($gid)? '&amp;single=true&amp;gid=' . $gid : '';

		$widgetTag = '<div class="_p_googlesheets" style="max-width:100%;max-height:' . $height . 'px"><iframe width="100%" height="' . $height . '" src="https://docs.google.com/spreadsheets/d/e/' . $id . '/pubhtml?widget=true&amp;headers=false' . $gid . '" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_googlesheets{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_googlesheets>iframe{max-width:100%;max-height:100%;padding:0;margin:0;box-sizing:border-box}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#googlesheets(docID[,[sheetID][,height]])';
}
