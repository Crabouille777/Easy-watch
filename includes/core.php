<?php
// Sécurité : empêche l'accès direct
if (!defined('ABSPATH')) exit;

/**
 * Enregistrement du Custom Post Type "easywatch_video"
 */
/*
 function easywatch_register_cpt() {
    $labels = array(
        'name'               => 'Easywatch',
        'singular_name'      => 'Vidéo Easywatch',
        'add_new'            => 'Ajouter une vidéo',
        'add_new_item'       => 'Ajouter une nouvelle vidéo',
        'edit_item'          => 'Modifier la vidéo',
        'new_item'           => 'Nouvelle vidéo',
        'view_item'          => 'Voir la vidéo',
        'search_items'       => 'Rechercher des vidéos',
        'not_found'          => 'Aucune vidéo trouvée',
        'not_found_in_trash' => 'Aucune vidéo dans la corbeille',
        'menu_name'          => 'Easywatch',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-video-alt3',
        'supports'           => array('title'),
        'capability_type'    => 'post',
    );

    register_post_type('easywatch_video', $args);
}
add_action('init', 'easywatch_register_cpt');

*/