<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
googledocs.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Googleドキュメントを埋め込むプラグイン。

【使い方】
#googledocs(docID[,height])

docID   … ドキュメントID。Googleドキュメントサイト発行の埋め込みコード内「//docs.google.com/document/d/e/XXXXX/pub」の「XXXXX」部分
height  … ウィジェットの高さ（px）。省略時の既定値は 400

【使用例】
#googledocs(00000)
#googledocs(00000,11111)
#googledocs(00000,,800)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適宜書き換えてください。
*/

/////////////////////////////////////////////////
// Googleドキュメントプラグイン（googledocs.inc.php）
if (!defined('PLUGIN_GOOGLEDOCS_HEIGHT')) define('PLUGIN_GOOGLEDOCS_HEIGHT', 400); // ウィジェットの標準の高さ（px）


function plugin_googledocs_convert() {
	list($id, $height) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$height = ($height)? $height : PLUGIN_GOOGLEDOCS_HEIGHT;

		$widgetTag = '<div class="_p_googledocs" style="max-width:100%;max-height:' . $height . 'px"><iframe width="100%" height="' . $height . '" src="https://docs.google.com/document/d/e/' . $id . '/pub?embedded=true" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_googledocs{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_googledocs>iframe{max-width:100%;max-height:100%;padding:0;margin:0;box-sizing:border-box}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#googledocs(docID[,height])';
}
