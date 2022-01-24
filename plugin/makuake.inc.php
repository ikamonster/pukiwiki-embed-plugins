<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
makuake.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Makuakeウィジェットを埋め込むプラグイン。

【使い方】
#makuake(project[,type])

project … プロジェクト名。MakuakeサイトのプロジェクトページURL「//www.makuake.com/project/XXXXX/」の「XXXXX」部分
type    … 表示種別。default, length, wide, square, hero のいずれか。省略時の既定値は default

【使用例】
#makuake(hoge)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_makuake_convert() {
	list($project, $type) = func_get_args();

	$project = trim($project);
	if ($project) {
		$project = urlencode($project);
		$type = strtolower(trim($type));

		switch ($type) {
		case 'length':
			$width = 160;
			$height = 420;
			break;

		case 'wide';
			$width = 460;
			$height = 200;
			break;

		case 'square';
			$width = 160;
			$height = 160;
			break;

		case 'hero';
			$width = 1000;
			$height = 287;
			break;

		case '':
		case 'default':
		default:
			$width = 310;
			$height = 390;
			$type = '';
			break;
		}

		if ($type) $type .= '/';
		$widgetTag = '<div class="_p_makuake" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:' . $width . 'px; height:' . $height . 'px;" allowtransparency="true" src="https://www.makuake.com/widget/project/' . $project . '/' . $type . '" loading="lazy"></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$widgetTag .= <<<EOT
<style>
._p_makuake{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_makuake>iframe{width:100%;min-width:0;min-height:0;max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#makuake(project[,type])';
}
