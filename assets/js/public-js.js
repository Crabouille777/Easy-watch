document.addEventListener('DOMContentLoaded', function () {
    const iframe = document.getElementById('easywatch-main-video');
    const playlistLinks = document.querySelectorAll('.easywatch-playlist-item a');

    playlistLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const newSrc = this.getAttribute('data-src');
            if (newSrc && iframe) {
                iframe.src = newSrc;
            }

            // Retirer active de tous les liens
            playlistLinks.forEach(l => l.classList.remove('active'));

            // Ajouter active au lien cliqué
            this.classList.add('active');
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('easywatch-search');
    const playlist = document.getElementById('easywatch-playlist-list');
    if (!searchInput || !playlist) return;

    const scrollTopBtn = document.getElementById('easywatch-scroll-top');

if (scrollTopBtn) {
    scrollTopBtn.addEventListener('click', function () {
        playlist.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    searchInput.addEventListener('input', function () {
        // Affiche le bouton si recherche en cours
        scrollTopBtn.style.display = this.value.length > 0 ? 'block' : 'none';
    });
}


    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const items = playlist.querySelectorAll('.easywatch-playlist-item');

        let firstMatch = null; // 🔍 on mémorise la première correspondance

        items.forEach(function(item) {
            const text = item.textContent.toLowerCase();

            if (query && text.includes(query)) {
                item.classList.add('highlighted');
                if (!firstMatch) {
                    firstMatch = item; // 💾 première correspondance trouvée
                }
            } else {
                item.classList.remove('highlighted');
            }
        });

        // 🟡 On fait défiler vers la première correspondance trouvée
        if (firstMatch) {
            firstMatch.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    });
});
