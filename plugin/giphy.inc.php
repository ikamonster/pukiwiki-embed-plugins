<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
giphy.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

GIPHY画像を埋め込むプラグイン。

【使い方】
#giphy(id,width,height)

id     … 画像ID。GIPHYサイト発行の埋め込みコード内「//giphy.com/embed/XXXXXXXXXXXXXXXXXX」の「XXXXXXXXXXXXXXXXXX」部分
width  … 画像の幅（px）。GIPHYサイト発行の埋め込みコード内「width="XXX"」の「XXX」部分
height … 画像の高さ（px）。GIPHYサイト発行の埋め込みコード内「height="XXX"」の「XXX」部分

【使用例】
#giphy(000000000000000000,480,270)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適切に書き換えてください。
*/

function plugin_giphy_convert() {
	static	$included = 0;

	list($id, $width, $height) = func_get_args();

	$id = trim($id);
	$width = (int)trim($width);
	$height = (int)trim($height);
	if ($id && $width && $height) {
		$id = urlencode($id);
		$aspect = sprintf('%.5f', $height / $width * 100);

		$widgetTag = '<div class="_p_giphy _p_giphy-' . $included . '" style="max-width:' . $width . 'px;max-height:' . $height . 'px"><iframe src="https://giphy.com/embed/' . $id . '" width="' . $width . '" height="' . $height . '" frameBorder="0" class="giphy-embed" loading="lazy" allowFullScreen></iframe></div>';

		if ($included == 0) {
			$widgetTag .= <<<EOT
<style>
._p_giphy{position:relative;width:100%;height:auto;min-width:0;min-height:0;padding:0;border:none;overflow:hidden}
._p_giphy:before{display:block;content:'';padding:0;margin:0;background:transparent}
._p_giphy>iframe{position:absolute;top:0;left:0;width:100%;height:100%;padding:0;margin:0;max-width:100%;max-height:auto;border:none}
</style>
EOT;
		}

		$widgetTag .= '<style>._p_giphy-' . $included . ':before{padding-top:' . $aspect . '%}</style>';

		$included++;
	}

	return ($widgetTag)? $widgetTag : '#giphy(id,width,height)';
}
