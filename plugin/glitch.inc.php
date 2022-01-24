<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
glitch.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Glitchウィジェットを埋め込むプラグイン。

【使い方】
#glitch(id[,[code][,height]])

id     … プロジェクトID。GlitchサイトのプロジェクトページURL「https://glitch.com/~XXXXX」の「XXXXX」部分
code   … 1：ソースコード表示。省略するとプレビュー表示
height … ウィジェットの高さ（px）。省略時の既定値は 500

【使用例】
#glitch(XXXXX,1,400)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// Glitchプラグイン（glitch.inc.php）
if (!defined('PLUGIN_GLITCH_HEIGHT')) define('PLUGIN_GLITCH_HEIGHT', 500); // ウィジェットの標準の高さ（px）

function plugin_glitch_convert() {
	list($id, $code, $height) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = htmlsc($id);
		$code = (!$code)? '?previewSize=100&previewFirst=true&sidebarCollapsed=true' : '';
		$height = ($height)? (int)$height : PLUGIN_GLITCH_HEIGHT;

		$widgetTag = '<div class="_p_glitch glitch-embed-wrap" style="height:20px;min-height:' . $height . 'px;width:100%"><iframe src="https://glitch.com/embed/#!/embed/' . $id . $code . '" title="Glitch" allow="geolocation;microphone;camera;midi;vr;encrypted-media" style="height:100%;width:100%;border:0" loading="lazy"></iframe></div>';
	}

	return ($widgetTag)? $widgetTag : '#glitch(id[,[code][,height]])';
}
