<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
omnyfm.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

omny.fm再生プレイヤーを表示するプラグイン。

【使い方】
#omnyfm(id[,type])

id   … 音声ID。omny.fmサイトの音声ページURL「//omny.fm/shows/XXXX/YYYY」の「XXXX/YYYY」部分
type … 表示種別。wide, simple, square のいずれか。省略時の既定値は wide

【使用例】
#omnyfm(0000000000)
#omnyfm(0000000000,artwork)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_omnyfm_convert() {
	list($id, $type) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = htmlsc($id);
		$type = strtolower(trim($type));

		switch ($type) {
		case 'simple':
			$width = '100%';
			$widgetTag = '<iframe src="https://omny.fm/shows/' . $id . '/embed?style=artwork" frameborder="0" width="100%" height="180" loading="lazy"></iframe>';
			break;

		case 'square';
			$width = '400px';
			$widgetTag = '<iframe src="https://omny.fm/shows/' . $id . '/embed?style=cover&size=square" frameborder="0" width="400" height="400" loading="lazy"></iframe>';
			break;

		case 'wide';
		case '';
		default:
			$width = '100%';
			$widgetTag = '<iframe src="https://omny.fm/shows/' . $id . '/embed?style=cover" frameborder="0" width="100%" height="180" loading="lazy"></iframe>';
			break;
		}

		$widgetTag = '<div class="_p_omnyfm" style="max-width:' . $width . '">' . $widgetTag . '</iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_omnyfm{position:relative;width:auto;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_omnyfm>iframe{width:100%;min-width:0;min-height:0;max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#omnyfm(id[,type])';
}
