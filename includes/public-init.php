<?php
// includes/public-init.php

if (!is_admin()) {
    require_once plugin_dir_path(__DIR__) . 'includes/shortcode.php';
}


if (!defined('ABSPATH')) {
    exit;
}

function easywatch_enqueue_front_assets() {
    if (!is_singular()) { 
        return;
    }

    global $post;

        if (isset($post->post_content) && has_shortcode($post->post_content, 'easywatch')) {
        // CSS
        wp_enqueue_style(
            'easywatch-public-style',
            plugin_dir_url(__DIR__) . 'assets/css/public-css.css',
            [],
            '1.0'
        );

        // JS
        wp_enqueue_script(
            'easywatch-public-script',
            plugin_dir_url(__DIR__) . 'assets/js/public-js.js',
            [],
            '1.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'easywatch_enqueue_front_assets');
