<?php
// Funktion zum Erstellen der Taxonomie "destinations" für die Posttypen "hotels" und "events"
function destination_taxonomie() {
    // Labels für die Taxonomie
    $labels = array(
        'name'                       => 'Destinations',
        'singular_name'              => 'Destination',
        'search_items'               => 'Destinations durchsuchen',
        'popular_items'              => 'Beliebte Destinations',
        'all_items'                  => 'Alle Destinations',
        'parent_item'                => 'Übergeordnete Destination',
        'parent_item_colon'          => 'Übergeordnete Destination:',
        'edit_item'                  => 'Destination bearbeiten',
        'update_item'                => 'Destination aktualisieren',
        'add_new_item'               => 'Neue Destination hinzufügen',
        'new_item_name'              => 'Neue Destination',
        'separate_items_with_commas' => 'Destinations durch Kommas trennen',
        'add_or_remove_items'        => 'Destinations hinzufügen oder entfernen',
        'choose_from_most_used'      => 'Aus den meistverwendeten Destinations wählen',
        'menu_name'                  => 'Destinations',
    );
    // Argumente für die Taxonomie
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'destination' ),
    );
    // Taxonomie für die Posttypen "hotels" und "events"
    register_taxonomy( 'destination', array( 'hotels', 'events' ), $args );
}
// Hook, um die Funktion bei der Initialisierung von WordPress aufzurufen
add_action( 'init', 'destination_taxonomie' );
