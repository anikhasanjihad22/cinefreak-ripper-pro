<?php
function cf_rip_video($atts) {
    $url = esc_url($atts['url']);
    $post_id = get_the_ID();

    return '<div style="margin:20px 0; font-family:Arial;">
        <h3>🔥 Instant Access</h3>
        <button onclick="cfStream(' . $post_id . ')" style="padding:12px 24px; background:#e74c3c; color:white; border:none; cursor:pointer; font-size:16px;">
            ▶️ Stream or Download
        </button>
        <div id="cf-output" style="margin-top:10px;"></div>
    </div>

    <script>
    function cfStream(id) {
        document.getElementById("cf-output").innerHTML = "🔄 Fetching stream...";
        fetch("' . CF_URL . 'includes/proxy-fetch.php", {
            method: "POST",
            body: "action=rip&post_id="+id
        })
        .then(r => r.json())
        .then(data => {
            if (data.stream) {
                let a = document.createElement("a");
                a.href = data.stream;
                a.download = "CineFreak-Video.mp4";
                a.style = "display:none";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                document.getElementById("cf-output").innerHTML = "✅ Download started!";
            } else {
                document.getElementById("cf-output").innerHTML = "❌ Failed: " + data.error;
            }
        });
    }
    </script>';
}
