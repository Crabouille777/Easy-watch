<?php

if (!defined('ABSPATH')) exit; ?>


<div class="easywatch-block" id="easywatch-block-<?php echo esc_attr($id); ?>" style="border: 1px solid #ccc; padding: 1em; margin-bottom: 1em;">
    <p><strong>ID :</strong> <?php echo esc_html($id); ?></p>
    <p><strong>Vidéo :</strong> <?php echo esc_url($block['video_url']); ?></p>
    <p><strong>Playlist :</strong></p>
<div style="max-height: 5.5em; overflow-y: auto; border: 1px solid #ddd; padding: 0.5em; background: #f9f9f9;">
    <?php echo nl2br(esc_html($block['playlist'])); ?>
</div>

    <p>
        <input type="text" id="shortcode-<?php echo esc_attr($id); ?>" value="[easywatch id='<?php echo esc_attr($id); ?>']" readonly style="width: 100%;">
    </p>
    <p>
        
        <button class="button" onclick="copyShortcode('<?php echo esc_js($id); ?>')">Copier</button>

        <button class="button edit-button" onclick="toggleEditForm('<?php echo esc_js($id); ?>')">Modifier</button>
        <button class="button button-danger" onclick="deleteBlock('<?php echo esc_js($id); ?>')">Supprimer</button>
    </p>

    <div class="easywatch-edit-form" id="edit-form-<?php echo esc_attr($id); ?>" style="overflow: hidden; transition: max-height 0.4s ease; max-height: 0;">
        <p><label>Vidéo URL : <input type="url" id="edit-video-<?php echo esc_attr($id); ?>" value="<?php echo esc_url($block['video_url']); ?>" style="width: 100%;"></label></p>
        <p><label>Playlist : <textarea id="edit-playlist-<?php echo esc_attr($id); ?>" rows="4" style="width: 100%;"><?php echo esc_textarea($block['playlist']); ?></textarea></label></p>
        <p><button class="button button-primary" onclick="saveBlockEdit('<?php echo esc_js($id); ?>')">Enregistrer</button></p>
    </div>
</div>

