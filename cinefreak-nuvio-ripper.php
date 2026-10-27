<?php
/*
Plugin Name: CineFreak Nuvio Ripper Pro
Description: Silent stream & download from cinefreak.net Nuvio embeds
Version: 6.66
Author: MR. OFFENSIVE
*/

if (!defined('ABSPATH')) exit;

define('CF_DIR', plugin_dir_path(__FILE__));
define('CF_URL', plugin_dir_url(__FILE__));

// Load shortcode
include_once CF_DIR . 'includes/core.php';
add_shortcode('cinefreak', 'cf_rip_video');
