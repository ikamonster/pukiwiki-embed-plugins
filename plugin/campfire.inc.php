<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
campfire.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

CAMPFIREウィジェットを埋め込むプラグイン。

【使い方】
#campfire(id)

id … プロジェクトID。CAMPFIREサイトのプロジェクトページURL「//camp-fire.jp/projects/view/XXXXXX」の「XXXXXX」部分（?以降は省く）

【使用例】
#campfire(000000)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_campfire_convert() {
	list($id) = func_get_args();

	if ($id) {
		$id = urlencode(trim($id));
		$widgetTag = '<div class="_p_campfire" style="max-width:245px;max-height:365px"><iframe frameborder="0" height="365" scrolling="no" src="https://camp-fire.jp/projects/' . $id . '/widget" width="245" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_campfire{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_campfire>iframe{min-width:0;min-height:0;max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#campfire(id)';
}
