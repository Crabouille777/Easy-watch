<?php
/*
 * Plugin Name: Easy-watch
 * Description: Affiche un lecteur vidéo avec une playlist via un shortcode [easy_watch]
 * Version: 1.0
 * Author: Crabouille777
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: easy-watch
 *
 * Note de l'auteur :
 * Ce plugin est distribué gratuitement dans un esprit de partage.
 * Merci de ne pas le vendre ou monétiser sous une forme quelconque.
 */

if (!defined('ABSPATH')) exit;

// Définition des constantes
define('EASYWATCH_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('EASYWATCH_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('EASYWATCH_PLUGIN_FILE')) {
    define('EASYWATCH_PLUGIN_FILE', __FILE__);
}


// Chargement des fichiers nécessaires

require_once EASYWATCH_PLUGIN_PATH . 'admin/ajax-handler.php';
require_once EASYWATCH_PLUGIN_PATH . 'includes/admin-page.php';
require_once EASYWATCH_PLUGIN_PATH . 'includes/admin-init.php';
require_once EASYWATCH_PLUGIN_PATH . 'includes/public-init.php';
require_once EASYWATCH_PLUGIN_PATH . 'includes/core.php';

if (!is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
}


// Charger les textes pour la traduction
function easywatch_load_textdomain() {
    load_plugin_textdomain('easy-watch', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'easywatch_load_textdomain');

// Ajouter la page admin (à modifier si bug à l'install =>code dans admin-page.php)

/*add_action('admin_menu', function () {
    add_menu_page(
        __('Easy-watch', 'easy-watch'),
        __('Easy-watch', 'easy-watch'),
        'manage_options',
        'easy-watch',
        'easywatch_admin_page_callback',
        'dashicons-video-alt3',
        26
    );
}); */

// Rappel de la fonction d'affichage de la page admin (dans includes/admin-init.php)
if (!function_exists('easywatch_admin_page_callback')) {
    function easywatch_admin_page_callback() {
        require EASYWATCH_PLUGIN_PATH . 'admin/admin-ui.php';
    }
}

// Enregistrement du shortcode [easywatch]
add_shortcode('easywatch', function ($atts) {
    // Exemple : [easywatch id="1"]
    $atts = shortcode_atts(['id' => ''], $atts, 'easywatch');
    $id = intval($atts['id']);

    if ($id <= 0) {
        return '<p>' . esc_html__('Vidéo non trouvée.', 'easy-watch') . '</p>';
    }

    // Appeler une fonction dans core.php pour générer le HTML
    if (function_exists('easywatch_render_shortcode')) {
        return easywatch_render_shortcode($id);
    }

    return '';
});

// Ajoute le lien "Paramètres" sur la page des extensions
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'easywatch_add_settings_link');

function easywatch_add_settings_link($links) {
    $settings_link = '<a href="admin.php?page=easywatch">Paramètres</a>';
    array_unshift($links, $settings_link); // Le met en premier
    return $links;
}


