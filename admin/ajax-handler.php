<?php
// admin/ajax-handler.php

// Sécurité : bloquer accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Met à jour un bloc vidéo
add_action('wp_ajax_easywatch_update_block', 'easywatch_update_block');
function easywatch_update_block() {
    // Vérification de sécurité
    check_ajax_referer('easywatch_nonce', 'nonce');

    $block_id  = isset($_POST['block_id']) ? sanitize_text_field($_POST['block_id']) : '';
    $video_url = isset($_POST['video_url']) ? esc_url_raw($_POST['video_url']) : '';
    $playlist  = isset($_POST['playlist']) ? sanitize_textarea_field($_POST['playlist']) : '';

    if (empty($block_id) || empty($video_url)) {
        wp_send_json_error('Données manquantes.');
    }

    $blocks = get_option('easywatch_blocks', []);

    if (!isset($blocks[$block_id])) {
        wp_send_json_error('Bloc introuvable.');
    }

    // Mise à jour
    $blocks[$block_id]['video_url'] = $video_url;
    $blocks[$block_id]['playlist']  = $playlist;

    update_option('easywatch_blocks', $blocks);

    wp_send_json_success('Bloc mis à jour.');
}

// Supprime un bloc vidéo
add_action('wp_ajax_easywatch_delete_block', 'easywatch_delete_block');
function easywatch_delete_block() {
    // Vérification de sécurité
    check_ajax_referer('easywatch_nonce', 'nonce');

    $block_id = isset($_POST['block_id']) ? sanitize_text_field($_POST['block_id']) : '';

    if (empty($block_id)) {
        wp_send_json_error('ID de bloc manquant.');
    }

    $blocks = get_option('easywatch_blocks', []);

    if (!isset($blocks[$block_id])) {
        wp_send_json_error('Bloc non trouvé.');
    }

    unset($blocks[$block_id]);
    update_option('easywatch_blocks', $blocks);

    wp_send_json_success('Bloc supprimé.');
}
