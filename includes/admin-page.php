<?php
// Sécurité
if (!defined('ABSPATH')) exit;

// Fonction d'affichage de la page admin 
function easywatch_admin_page_content() {
    require_once EASYWATCH_PLUGIN_PATH . 'admin/admin-ui.php';
    easywatch_render_admin_interface();
}

// Enregistrement du menu admin
function easywatch_register_admin_menu() {
    add_menu_page(
        'Easy-watch',
        'Easy-watch',
        'manage_options',
        'easywatch',
        'easywatch_admin_page_content',
        'dashicons-video-alt3',
        81
    );
}
add_action('admin_menu', 'easywatch_register_admin_menu');

// Traitement AJAX pour suppression d’un bloc (placeholder)
add_action('wp_ajax_easywatch_delete_block', 'easywatch_delete_block_callback');
function easywatch_delete_block_callback() {
    check_ajax_referer('easywatch_nonce', 'nonce');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission refusée');
    }

    $block_id = sanitize_text_field($_POST['block_id']);
    if (!$block_id) {
        wp_send_json_error('ID invalide');
    }

    $blocks = get_option('easywatch_blocks', []);
    if (!isset($blocks[$block_id])) {
        wp_send_json_error('Bloc introuvable');
    }

    unset($blocks[$block_id]);
    update_option('easywatch_blocks', $blocks);

    wp_send_json_success();
}
