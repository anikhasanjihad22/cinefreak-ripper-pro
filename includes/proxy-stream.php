<?php
if (!isset($_GET['v'])) die();

$video_url = urldecode($_GET['v']);
if (!preg_match('/\.(mp4|m3u8)$/i', $video_url)) die('403');

header("Content-Type: " . (strpos($video_url, '.m3u8') ? 'application/vnd.apple.mpegurl' : 'video/mp4'));
header("Access-Control-Allow-Origin: *");
header("Referer: https://cinefreak.net");
header("Origin: https://cinefreak.net");

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $video_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_REFERER, 'https://cinefreak.net');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Origin: https://cinefreak.net',
    'X-Requested-With: XMLHttpRequest'
]);
curl_exec($ch);
curl_close($ch);
