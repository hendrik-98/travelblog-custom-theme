// Wähle alle Buttons und das exit-content-Element aus
var toggleButtons = document.querySelectorAll('.toggle-content-btn');
var exitContent = document.querySelectorAll('.exit-content');

toggleButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var content = this.previousElementSibling;
        var parentContainer = content.parentElement;
        var exitContentx = parentContainer.querySelector('.exit-content');
        // Umschalten der Anzeige des Inhalts
        if (content.style.display === 'none' || content.style.display === '') {
            content.style.display = 'block';
            exitContentx.style.display = 'block';
            this.textContent = 'Weniger anzeigen';
            // Hinzufügen der Klasse "border"
            parentContainer.classList.add('border');
            // Ändern der Breite von .thumbnail auf 100%
            var thumbnailcontainer = this.parentElement;
            var thumbnail = thumbnailcontainer.parentElement.querySelector('.thumbnail');
            if (thumbnail) {
                thumbnail.classList.add('width-100');
            } 
            else {
                console.error("Thumbnail not found.");
            }
        } 
        else {
            content.style.display = 'none';
            exitContentx.style.display = 'none';
            this.textContent = 'Mehr anzeigen';
            // Entfernen der Klasse "border"
            parentContainer.classList.remove('border');
            // Ändern der Breite von .thumbnail auf 1200px
            var thumbnailcontainer = this.parentElement;
            var thumbnail = thumbnailcontainer.parentElement.querySelector('.thumbnail');
            if (thumbnail) {
                thumbnail.classList.remove('width-100');
            } 
            else {
                console.error("Thumbnail not found.");
            }
        }
    });
});

// Füge das Klicken-Ereignis zum exit-content-Element hinzu
exitContent.forEach(function(exit) {
    exit.addEventListener('click', function() {
        // Auslösen der toggleButtons-Aktion
        var siblingButton = this.parentElement.querySelector('.toggle-content-btn');
        if (siblingButton) {
            siblingButton.click();
        }
    });
});