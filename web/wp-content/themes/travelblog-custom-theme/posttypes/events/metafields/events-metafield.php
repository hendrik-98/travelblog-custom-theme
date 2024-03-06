<?php
// Funktion zum Hinzufügen des Metafelds für das Eventdatum
function hinzufuegen_eventdatum_metafeld() {
    add_meta_box(
        'eventdatum_metafeld',          // ID des Metafelds
        'Eventdatum',                   // Titel des Metafelds
        'zeige_eventdatum_metafeld',    // Callback-Funktion zum Anzeigen des Metafelds
        'events',                       // Der Posttyp, für den das Metafeld angezeigt werden soll
        'normal',                       // Die Position des Metafelds im Editor (hier: rechts)
        'default'                       // Priorität des Metafelds
    );
}
add_action( 'add_meta_boxes', 'hinzufuegen_eventdatum_metafeld' );

// Callback-Funktion zum Anzeigen des Metafelds
function zeige_eventdatum_metafeld( $post ) {
    // Hole den Wert des Metafelds, falls vorhanden
    $eventdatum = get_post_meta( $post->ID, 'eventdatum', true );
    ?>
    <label for="eventdatum">Eventdatum:</label>
    <input type="date" id="eventdatum" name="eventdatum" value="<?php echo esc_attr( $eventdatum ); ?>">
    <?php
}

// Funktion zum Speichern des Metafelds für das Eventdatum
function speichern_eventdatum_metafeld( $post_id ) {
    // Überprüfe, ob das Feld gespeichert werden soll
    if ( isset( $_POST['eventdatum'] ) ) {
        // Speichere den Wert des Metafelds
        update_post_meta( $post_id, 'eventdatum', $_POST['eventdatum'] );
    }
}
add_action( 'save_post', 'speichern_eventdatum_metafeld' );
