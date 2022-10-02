<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
youtube.inc.php, v1.0.1 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

YouTube動画再生プレイヤーを表示するプラグイン。

【使い方】
#youtube(id[,[width][,[loop][,[start][,autoplay]]]])

id       … 動画ID。YouTubeサイトの動画ページURL「//www.youtube.com/watch?v=XXXXXXXXXXX」の「XXXXXXXXXXX」部分
width    … 動画の幅（px）。省略時の既定値は 640
loop     … 1：ループ再生、0：通常再生。省略時の既定値は 0
start    … 再生開始位置（秒）。省略時の既定値は 0
autoplay … 1：自動再生、0：手動再生。省略時の既定値は 0。モバイル環境では効かないことがある

【使用例】
#youtube(00000000000)
#youtube(00000000000,800)
#youtube(00000000000,,1)
#youtube(00000000000,,,60)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

/////////////////////////////////////////////////
// YouTubeプラグイン（youtube.inc.php）
if (!defined('PLUGIN_YOUTUBE_WIDTH'))  define('PLUGIN_YOUTUBE_WIDTH',  640); // 動画幅の既定値（px）
if (!defined('PLUGIN_YOUTUBE_ASPECT')) define('PLUGIN_YOUTUBE_ASPECT', (9.0 / 16.0)); // 動画の縦横比


function plugin_youtube_convert() {
	list($id, $width, $loop, $start, $autoplay) = func_get_args();

	$id = trim($id);
	if ($id) {
		$id = urlencode($id);
		$width = ($width > 0)? (int)$width : PLUGIN_YOUTUBE_WIDTH;
		$height = round($width * PLUGIN_YOUTUBE_ASPECT);
		$start = ($start > 0)? '&start=' . round($start) : '';
		$loop = ($loop)? '&loop=1&playlist=' . $id : '';
		$autoplay = ($autoplay)? '&autoplay=1' : '';

		$widgetTag = '<div class="_p_youtube" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $id . '?rel=0&playsinline=1' . $start . $autoplay . $loop . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" loading="lazy" allowfullscreen></iframe></div>';

		static	$included = false;
		if ($widgetTag && !$included) {
			$aspect = sprintf('%.5f', 100 * PLUGIN_YOUTUBE_ASPECT);
			$widgetTag .= <<<EOT
<style>
._p_youtube{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_youtube:before{display:block;content:'';padding:${aspect}% 0 0 0;margin:0;background:transparent}
._p_youtube>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;margin:0;max-width:100%;max-height:auto}
</style>
EOT;
			$included = true;
		}
	}

	return ($widgetTag)? $widgetTag : '#youtube(id[,[width][,[loop][,[start][,autoplay]]]])';
}
