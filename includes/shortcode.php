<?php
// Fichier : includes/shortcode.php



function easywatch_transform_url($url) {
    // Transforme une URL YouTube normale en embed
    if (strpos($url, 'youtube.com/watch?v=') !== false) {
        return preg_replace(
            '#^https?://(www\.)?youtube\.com/watch\?v=([^\&]+)#',
            'https://www.youtube.com/embed/$2',
            $url
        );
    }
    return $url;
}

function easywatch_render_video_shortcode($atts) {

    // Désactive l'autoembed et les filtres de contenu uniquement pour ce shortcode
remove_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed'), 8);
remove_filter('the_content', 'wp_filter_content_tags');


    $atts = shortcode_atts([
        'id' => '',
    ], $atts, 'easywatch');

    $block_id = sanitize_text_field($atts['id']);
    if (!$block_id) return '';

    $blocks = get_option('easywatch_blocks', []);



    if (!isset($blocks[$block_id])) return '<p>Bloc vidéo introuvable.</p>';



    $block = $blocks[$block_id];
    $main_video = esc_url($block['video_url']);
    $playlist_raw = isset($block['playlist']) ? trim($block['playlist']) : '';
    $playlist = [];

    if (!empty($playlist_raw)) {
        foreach (explode("\n", $playlist_raw) as $line) {
            $parts = explode('|', $line);
            if (count($parts) === 2) {
                $playlist[] = [
    'title' => esc_html(trim($parts[0])),
    'url'   => esc_url(easywatch_transform_url(trim($parts[1]))),
];

        }
    }
    }
ob_start();
?>
<script>console.log("✅ EasyWatch shortcode chargé");</script>

<?php if (!empty($playlist)): ?>

<div class="easywatch-wrapper" style="display: flex; max-width: 1000px; margin: auto; gap: 20px; flex-wrap: nowrap;">

    <!-- PLAYER à gauche -->
    <div class="easywatch-player" style="flex: 1 1 660px; min-width: 300px;">
        <iframe id="easywatch-main-video"
            src="<?php echo esc_url(easywatch_transform_url($main_video)); ?>"
            frameborder="0" allowfullscreen
            style="width: 100%; aspect-ratio: 16 / 9;">
        </iframe>
    </div>

    <!-- CONTAINER DROIT : champ recherche + playlist -->
    <div class="easywatch-playlist" style="flex: 0 0 250px; display: flex; flex-direction: column;">

        <!-- Champ de recherche -->
        <div class="easywatch-search-container" style="margin-bottom: 10px;">
            <input
                type="text"
                id="easywatch-search"
                placeholder="Rechercher une vidéo..."
                style="width: 100%; padding: 6px; border: 1px solid #ccc; border-radius: 4px;"
            >
        </div>

<button id="easywatch-scroll-top" style="
    display: none;
    margin-bottom: 6px;
    padding: 2px 4px;
    width: 45px;
    font-size: 12px;
    background-color:rgb(185, 210, 221);
    color: black;
    border: none;
    border-radius: 4px;
    cursor: pointer;
">
    haut
</button>


        <!-- Playlist -->
        <h3>Playlist</h3>
        <ul id="easywatch-playlist-list" style="list-style: none; padding-left: 0; margin: 0; overflow-y: auto; max-height: 400;">
            <?php foreach ($playlist as $item): ?>
                <li class="easywatch-playlist-item" style="margin-bottom: 8px; cursor: pointer; padding: 5px; border-radius: 4px;">
                    <a href="#" data-src="<?php echo esc_url($item['url']); ?>" style="text-decoration: none; color: #0073aa;">
                        <?php echo esc_html($item['title']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>

<?php else: ?>
<!-- Si pas de playlist, affiche juste le player avec une largeur fixe centrée -->
<div class="easywatch-wrapper" style="max-width: 1000px; margin: auto;">
    <div class="easywatch-player" style="width: 660px; max-width: 100%; margin: 0 auto;">
        <iframe id="easywatch-main-video"
            src="<?php echo esc_url(easywatch_transform_url($main_video)); ?>"
            frameborder="0" allowfullscreen
            style="width: 100%; aspect-ratio: 16 / 9;">
        </iframe>
    </div>
</div>
<?php endif; ?>




<?php
return ob_get_clean();


}




add_action('init', function() {

    add_shortcode('easywatch', 'easywatch_render_video_shortcode');
});

