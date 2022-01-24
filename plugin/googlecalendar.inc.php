<?php
/*
PukiWiki - Yet another WikiWikiWeb clone.
googlecalendar.inc.php, v1.0 2020 M.Taniguchi
License: GPL v3 or (at your option) any later version

Googleカレンダーを埋め込むプラグイン。

【使い方】
#googlecalendar([width][,[height],id[,id2,id3,...]])

width       … カレンダーの幅（px）。省略時の既定値は 800
height      … カレンダーの高さ（px）。省略時の既定値は 600
第3引数以降 … カレンダーID。Googleカレンダーサイト発行の埋め込みコード内「src=XXXXXXXXXXX」の「XXXXXXXXXXX」部分。複数指定可能

【使用例】
#googlecalendar(,,0000000000)
#googlecalendar(400,300,0000000000)
#googlecalendar(,,0000000000,1111111111)

【ご注意】
埋め込みウィジェットの仕様はサービス提供者に依存します。
もし仕様が変更されたら、下記の定数値やコード内のタグを適宜書き換えてください。
*/

/////////////////////////////////////////////////
// Googleカレンダープラグイン（googlecalendar.inc.php）
if (!defined('PLUGIN_GOOGLECALENDAR_WIDTH'))    define('PLUGIN_GOOGLECALENDAR_WIDTH',     800); // カレンダー幅の既定値（px）
if (!defined('PLUGIN_GOOGLECALENDAR_HEIGHT'))   define('PLUGIN_GOOGLECALENDAR_HEIGHT',    600); // カレンダー幅の既定値（px）
if (!defined('PLUGIN_GOOGLECALENDAR_TIMEZONE')) define('PLUGIN_GOOGLECALENDAR_TIMEZONE', 'Asia/Tokyo'); // タイムゾーンの既定値（px）


function plugin_googlecalendar_convert() {
	$args = func_get_args();

	$id = trim($args[2]);
	if ($id) {
		$id = htmlsc($id);
		$width = trim($args[0]);
		$height = trim($args[1]);
		$width = ($width > 0)? (int)$width : PLUGIN_GOOGLECALENDAR_WIDTH;
		$height = ($height > 0)? (int)$height : PLUGIN_GOOGLECALENDAR_HEIGHT;
		$timezone = date_default_timezone_get();
		if (!$timezone) $timezone = PLUGIN_GOOGLECALENDAR_TIMEZONE;
		for ($cals = '', $i = count($args) - 1; $i >= 2; --$i) $cals = '&src=' . $args[$i] . $cals;

		$widgetTag = '<div class="_p_googlecalendar"><iframe src="https://calendar.google.com/calendar/embed?ctz=' . urlencode($timezone) . '&color=%23808080&showTitle=0&showNav=1&showCalendars=0&showTz=0&showTabs=0&showPrint=0&showDate=1' . $cals . '" style="border: 0" width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" loading="lazy"></iframe></div>';
	}

	return ($widgetTag)? $widgetTag : '#googlecalendar([width][,[height],id[,id2,id3,...]])';
}
