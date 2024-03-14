setTimeout(function() {

    var inputField = document.getElementById("externer_link");
    var publishButton = document.querySelector(".editor-post-publish-panel__toggle");

    // Funktion zum Überprüfen und Aktualisieren des Button-Status
    function updateButtonStatus() {
        var isButtonEnabled = publishButton.getAttribute("aria-disabled") === "false";
        var hasInputValue = inputField.value.trim() !== "";

        if (isButtonEnabled && !hasInputValue) {
            publishButton.setAttribute("aria-disabled", "true");
        }
    }

    // Überwache Änderungen am Veröffentlichungsbutton
    var buttonObserver = new MutationObserver(function(mutationsList) {
        for (var mutation of mutationsList) {
            if (mutation.attributeName === "aria-disabled" && mutation.target === publishButton) {
                updateButtonStatus();
            }
        }
    });

    // Konfiguration für den Beobachter
    var observerConfig = { attributes: true };

    // Button-Beobachter starten
    buttonObserver.observe(publishButton, observerConfig);

    // Überwache Änderungen im Eingabefeld
    inputField.addEventListener("input", function() {
        var eingabeWert = inputField.value.trim();

        if (eingabeWert === "") {
            publishButton.setAttribute("aria-disabled", "true");
        } 
        else {
            publishButton.setAttribute("aria-disabled", "false");
        }
    });

    // Initialer Status des Buttons basierend auf dem Wert des Eingabefelds
    updateButtonStatus();

}, 2000); // 2000 Millisekunden entsprechen 2 Sekunden