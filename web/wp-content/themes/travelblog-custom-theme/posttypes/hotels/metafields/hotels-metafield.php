<?php
// Funktion zum Hinzufügen des benutzerdefinierten Metafields für den Posttyp "hotels"
function hinzufuegen_hotel_sterne_metafeld() {
    add_meta_box(
        'hotel_sterne_metafeld',            // ID des Metafields
        'Sternebewertung',                  // Titel des Metafields
        'ausgabe_hotel_sterne_metafeld',    // Callback-Funktion, die den Inhalt des Metafields ausgibt
        'hotels',                           // Posttyp, zu dem das Metafeld hinzugefügt werden soll
        'normal',                           // Position auf der Bearbeitungsseite
        'default'                           // Priorität 
    );
}
add_action( 'add_meta_boxes', 'hinzufuegen_hotel_sterne_metafeld' );

// Callback-Funktion, um den Inhalt des benutzerdefinierten Metafields auszugeben
function ausgabe_hotel_sterne_metafeld( $post ) {
    // Hole den aktuellen Wert des Metafields
    $sterne = get_post_meta( $post->ID, 'hotel_sterne', true );
    ?>
    <p>
        <label for="hotel_sterne">Sternebewertung:</label>
        <select name="hotel_sterne" id="hotel_sterne">
            <?php
            // Optionen von 1 bis 5 Sterne ausgeben
            for ( $i = 1; $i <= 5; $i++ ) {
                echo '<option value="' . $i . '" ' . selected( $sterne, $i, false ) . '>' . $i . '</option>';
            }
            ?>
        </select>
    </p>
    <?php
}

// Funktion zum Speichern des benutzerdefinierten Metafields
function speichern_hotel_sterne_metafeld( $post_id ) {
    // Überprüfe, ob das Feld gespeichert werden soll
    if ( isset( $_POST['hotel_sterne'] ) ) {
        // Speichere den Wert des Metafields als Ganzzahl
        $sterne = $_POST['hotel_sterne'];
        update_post_meta( $post_id, 'hotel_sterne', $sterne );
    }
}
add_action( 'save_post', 'speichern_hotel_sterne_metafeld' );

