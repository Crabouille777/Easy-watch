<?php

// Fichier : includes/admin-init.php (ou équivalent)
add_action('admin_enqueue_scripts', 'easywatch_enqueue_admin_assets');

function easywatch_enqueue_admin_assets($hook) {
    // Tu peux conditionner ici au bon écran si tu veux
    wp_enqueue_script(
        'easywatch-admin-js',
        plugin_dir_url(__DIR__) . 'admin/admin.js',
        ['jquery'],
        '1.0',
        true
    );

    wp_localize_script('easywatch-admin-js', 'easywatch_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('easywatch_nonce')
    ]);
}


// Sécurité : empêche l'accès direct
if (!defined('ABSPATH')) exit;

/**
 * Chargement des scripts publics
 */
function easywatch_enqueue_public_assets() {
    $plugin_url = plugin_dir_url(__DIR__);

    // CSS public général
    wp_enqueue_style(
        'easywatch-public-style',
        $plugin_url . 'assets/css/public-css.css',
        [],
        '1.0'
    );

    // CSS spécifique player (YouTube)
    wp_enqueue_style(
        'easywatch-player-style',
        $plugin_url . 'assets/css/player.css',
        [],
        '1.0'
    );

    // JS public
    wp_enqueue_script(
        'easywatch-public-js',
        $plugin_url . 'assets/js/public-js.js',
        [],
        '1.0',
        true
    );
}

add_action('wp_enqueue_scripts', 'easywatch_enqueue_public_assets');
