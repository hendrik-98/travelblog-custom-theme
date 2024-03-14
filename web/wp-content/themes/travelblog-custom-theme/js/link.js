document.addEventListener('DOMContentLoaded', function() {
    // Alle Container auswählen
    const containers = document.querySelectorAll('.content');

    // Für jeden Container
    containers.forEach(container => {
        // Link und Galerie im Container suchen
        const eventLink = container.querySelector('.link-btn');
        const gallery = container.querySelector('.wp-block-gallery');

        // Wenn eine Galerie gefunden wurde
        if (gallery) {
            // Das Event-Element vor der Galerie einfügen
            gallery.parentNode.insertBefore(eventLink, gallery);
        }
    });
});
