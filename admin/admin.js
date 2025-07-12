document.addEventListener('DOMContentLoaded', function () {

    // Copier le shortcode
    window.copyShortcode = function (id) {
        const input = document.getElementById('shortcode-' + id);
        input.select();
        input.setSelectionRange(0, 99999); // Mobile support
        document.execCommand('copy');
        alert('Shortcode copié : ' + input.value);
    };

    // Slide toggle du formulaire de modification
    window.toggleEditForm = function (id) {
        const form = document.getElementById('edit-form-' + id);
        if (form.style.maxHeight && form.style.maxHeight !== '0px') {
            form.style.maxHeight = '0';
        } else {
            form.style.maxHeight = form.scrollHeight + 'px';
        }
    };

    // Enregistrer les modifications (AJAX)
    window.saveBlockEdit = function (id) {
        const videoInput = document.getElementById('edit-video-' + id);
        const playlistInput = document.getElementById('edit-playlist-' + id);
        const videoUrl = videoInput.value.trim();
        const playlist = playlistInput.value.trim();

        if (!videoUrl) {
            alert('URL de la vidéo obligatoire.');
            return;
        }

        fetch(easywatch_admin_vars.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'easywatch_update_block',
                nonce: easywatch_admin_vars.nonce,
                block_id: id,
                video_url: videoUrl,
                playlist: playlist
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Modifications enregistrées.');
                location.reload();
            } else {
                alert('Erreur : ' + data.data);
            }
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
            alert('Une erreur est survenue.');
        });
    };

    // Supprimer un bloc (AJAX)
    window.deleteBlock = function (id) {
        if (!confirm('Confirmer la suppression de ce bloc ?')) return;

        fetch(easywatch_admin_vars.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'easywatch_delete_block',
                nonce: easywatch_admin_vars.nonce,
                block_id: id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const block = document.getElementById('easywatch-block-' + id);
                block.style.transition = 'opacity 0.5s ease-out';
                block.style.opacity = '0';
                setTimeout(() => block.remove(), 500);
            } else {
                alert('Erreur : ' + data.data);
            }
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
            alert('Une erreur est survenue.');
        });
    };

});
