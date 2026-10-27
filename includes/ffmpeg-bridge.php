<?php
// Convert m3u8 to mp4 (run via cron)
function hls_to_mp4($m3u8, $output) {
    if (file_exists($output)) return;
    $cmd = "ffmpeg -i '" . escapeshellcmd($m3u8) . "' -c copy -bsf:a aac_adtstoasc '" . escapeshellcmd($output) . "' -y";
    exec($cmd . " >> " . CF_DIR . "logs/ffmpeg.log 2>&1", $o, $c);
    if ($c === 0) {
        echo "[+] Converted: $output\n";
    } else {
        echo "[!] Failed: $m3u8\n";
    }
}
