<?php
// Funktion zum Einbinden von JavaScript in den Editor für den benutzerdefinierten Post-Typ "hotels"
function custom_hotels_editor_scripts() {
    global $typenow;

    // Stellen Sie sicher, dass der benutzerdefinierte Post-Typ "hotels" aktiv ist
    if ($typenow == 'hotels'|| $typenow == 'events' ) {
        // Den Pfad zum JavaScript-Skript angeben
        $script_url = get_template_directory_uri() . '/js/input-requiered.js';

        // Skript einbinden
        wp_enqueue_script('required-script', $script_url, '1.0', true);
    }
}

// Hook, um die Funktion zu registrieren, mit niedrigerer Priorität
add_action('admin_enqueue_scripts', 'custom_hotels_editor_scripts', 999);