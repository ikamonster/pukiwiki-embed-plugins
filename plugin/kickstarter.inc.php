<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
kickstarter.inc.php, v1.0.1 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

KickStarterウィジェットを埋め込むプラグイン。

【使い方】
#kickstarter(creator,project[,[type][,width]])

creator … クリエイター名。KickStarterサイトのプロジェクトページURL「//www.kickstarter.com/projects/????/XXXX」の「????」部分
project … プロジェクト名。KickStarterサイトのプロジェクトページURL「//www.kickstarter.com/projects/????/XXXX」の「XXXX」部分
type    … ウィジェット種別。card：カード表示, video：ビデオ表示。省略時の既定値は card
width   … ビデオの幅（px）。省略時の既定値は 640

【使用例】
#kickstarter(hoge,fuga)
#kickstarter(hoge,fuga,video)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// KickStarterプラグイン（kickstarter.inc.php）
if (!defined('PLUGIN_KICKSTARTER_VIDEO_WIDTH'))  define('PLUGIN_KICKSTARTER_VIDEO_WIDTH',  640);	// ビデオウィジェットの標準の幅（px）
if (!defined('PLUGIN_KICKSTARTER_VIDEO_HEIGHT')) define('PLUGIN_KICKSTARTER_VIDEO_HEIGHT', 360);	// ビデオウィジェットの標準の高さ（px）

function plugin_kickstarter_convert() {
	list($user, $project, $type, $width) = func_get_args();

	$user = trim($user);
	$project = trim($project);
	if ($user && $project) {
		$user = urlencode($user);
		$project = urlencode($project);
		$type = strtolower($type);

		switch ($type) {
		case 'video';
			$width = ($width > 0)? (int)$width : PLUGIN_KICKSTARTER_VIDEO_WIDTH;
			$height = $width * PLUGIN_KICKSTARTER_VIDEO_HEIGHT / PLUGIN_KICKSTARTER_VIDEO_WIDTH;
			$widgetTag = '<div class="_p_kickstarter _p_kickstarter-video" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe width="' . $width . '" height="' . $height . '" src="https://www.kickstarter.com/projects/' . $user . '/' . $project . '/widget/video.html" frameborder="0" scrolling="no" loading="lazy"></iframe></div>';
			break;

		case 'card';
		case '';
		default:
			$width = 220;
			$height = 420;
			$widgetTag = '<div class="_p_kickstarter _p_kickstarter-card" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://www.kickstarter.com/projects/' . $user . '/' . $project . '/widget/card.html?v=2" width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no"></iframe></div>';
			break;
		}

		static	$included = false;
		if ($widgetTag && !$included) {
			$aspectCard = sprintf('%.5f', 100 * 420 / 220);
			$aspectVideo = sprintf('%.5f', 100 * PLUGIN_KICKSTARTER_VIDEO_HEIGHT / PLUGIN_KICKSTARTER_VIDEO_WIDTH);
			$widgetTag .= <<<EOT
<style>
._p_kickstarter{position:relative;width:100%;height:100%;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_kickstarter:before{display:block;content:'';padding:0;margin:0;background:transparent}
._p_kickstarter._p_kickstarter-card:before{padding-top:{$aspectCard}%}
._p_kickstarter._p_kickstarter-video:before{padding-top:{$aspectVideo}%}
._p_kickstarter>iframe{position:absolute;top:0;left:0;width:100%;height:100%;min-width:0;min-height:0;max-width:100%;max-height:100%;padding:0;margin:0;border:none}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#kickstarter(creator,project[,[type][,width]])';
}
