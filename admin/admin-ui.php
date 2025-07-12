<?php
if (!defined('ABSPATH')) exit;

// Interface d’administration Easy-watch
function easywatch_render_admin_interface() {
    $blocks = get_option('easywatch_blocks', []);


wp_localize_script('easywatch-admin-js', 'easywatch_admin_vars', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('easywatch_nonce')
]);


    // Traitement du formulaire de création de bloc
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['easywatch_new_block'])) {
        $blocks = get_option('easywatch_blocks', []);

        $block_id = sanitize_text_field($_POST['label']);
        $video_url = esc_url_raw($_POST['video_url']);
        $playlist = sanitize_textarea_field($_POST['playlist']);

        if (!empty($block_id)) {
            if (isset($blocks[$block_id])) {
                echo '<div class="error"><p>Ce bloc existe déjà.</p></div>';
            } else {
                $blocks[$block_id] = [
                    'video_url' => $video_url,
                    'playlist'  => $playlist
                ];
                update_option('easywatch_blocks', $blocks);
                echo '<div class="updated"><p>Bloc enregistré.</p></div>';
            }
        } else {
            echo '<div class="error"><p>Veuillez saisir un identifiant de bloc.</p></div>';
        }
    }

    ?>

    <div class="wrap">
        <h1>Paramètres de Easy-watch</h1>

        <h2>Créer un nouveau bloc vidéo</h2>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="label">Identifiant du bloc (unique)</label></th>
                    <td><input type="text" name="label" id="label" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="video_url">URL de la vidéo principale</label></th>
                    <td><input type="url" name="video_url" id="video_url" required></td>
                </tr>
               <tr>
    <th scope="row">
        <label for="easywatch-playlist">Playlist (1 URL par ligne)</label>
        <p class="description">Syntaxe : <code>Titre | URL</code></p>
    </th>
    <td>
        <textarea name="playlist" id="easywatch-playlist" rows="4" style="width: 400px;"></textarea>
    </td>
</tr>

            </table>
            <p><input type="submit" name="easywatch_new_block" class="button button-primary" value="Enregistrer"></p>
        </form>

        <h2>Blocs enregistrés</h2>
        <?php if (!empty($blocks)): ?>
            <div style="max-width: 800px;">
                <?php foreach ($blocks as $id => $block): ?>
                    <?php include plugin_dir_path(__FILE__) . '/../templates/block-template.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun bloc enregistré.</p>
        <?php endif; ?>
    </div>

    <?php
}

