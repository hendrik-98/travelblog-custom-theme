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
        // Sanitize und speichere den Wert des Metafelds
        $eventdatum = sanitize_text_field( $_POST['eventdatum'] );
        update_post_meta( $post_id, 'eventdatum', $eventdatum );
    }
}
add_action( 'save_post', 'speichern_eventdatum_metafeld' );

// Funktion zum Hinzufügen des Metafelds für den externen Link
function hinzufuegen_externer_link_metafeld() {
    add_meta_box(
        'externer_link_metafeld',       // ID des Metafelds
        'Externer Link',                // Titel des Metafelds
        'zeige_externer_link_metafeld', // Callback-Funktion zum Anzeigen des Metafelds
        'events',                       // Der Posttyp, für den das Metafeld angezeigt werden soll
        'normal',                       // Die Position des Metafelds im Editor (hier: rechts)
        'default'                       // Priorität des Metafelds
    );
}
add_action( 'add_meta_boxes', 'hinzufuegen_externer_link_metafeld' );

// Callback-Funktion zum Anzeigen des Metafelds für den externen Link
function zeige_externer_link_metafeld( $post ) {
    // Hole den Wert des Metafelds, falls vorhanden
    $externer_link = get_post_meta( $post->ID, 'externer_link', true );
    ?>
    <label for="externer_link">Externer Link:</label>
    <input type="url" id="externer_link" name="externer_link" value="<?php echo esc_attr( $externer_link ); ?>">
    <?php
}

// Funktion zum Speichern des Metafelds für den externen Link
function speichern_externer_link_metafeld( $post_id ) {
    // Überprüfe, ob das Feld gespeichert werden soll
    if ( isset( $_POST['externer_link'] ) ) {
        // Sanitize und speichere den Wert des Metafelds
        $externer_link = sanitize_url( $_POST['externer_link'] );
        update_post_meta( $post_id, 'externer_link', $externer_link );
    }
}
add_action( 'save_post', 'speichern_externer_link_metafeld' );

