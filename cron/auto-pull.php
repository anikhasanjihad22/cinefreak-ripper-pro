<?php
include_once '../wp-config.php';
include_once '../includes/ffmpeg-bridge.php';

$html = file_get_contents('https://cinefreak.net/');
preg_match_all('/href="(https?:\/\/cinefreak\.net\/episode\/[^"]+)"/', $html, $matches);

$log = file_get_contents('../storage/logs/scraped.log');

foreach (array_slice($matches[1], 0, 3) as $link) {
    if (strpos($log, $link) !== false) continue;

    $page = file_get_contents($link);
    preg_match('/src="https:\/\/(nuvio\.[a-z.]+\/embed\/[0-9a-zA-Z]+)/i', $page, $embed_match);
    if (!$embed_match) continue;

    $embed = 'https://' . $embed_match[1];
    $data = file_get_contents($embed, false, stream_context_create([
        'http' => ['header' => "Referer: https://cinefreak.net\r\n"]
    ]));

    if (preg_match('/"file":"(https?:[^"]+\.m3u8[^"]*)"/i', $data, $v)) {
        $url = str_replace('\\', '', $v[1]);
        $file = '../storage/downloads/' . md5($link) . '.mp4';
        hls_to_mp4($url, $file);
        file_put_contents('../storage/logs/scraped.log', $link . "\n", FILE_APPEND);
    }
}
