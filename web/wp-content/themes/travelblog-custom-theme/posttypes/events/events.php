<?php
// Funktion zum Erstellen des Posttyps "events"
function events_posttyp() {
    // Labels für den Posttyp
    $labels = array(
        'name'               => 'Events',
        'singular_name'      => 'Event',
        'menu_name'          => 'Events',
        'name_admin_bar'     => 'Event',
        'add_new'            => 'Neues Event hinzufügen',
        'add_new_item'       => 'Neues Event hinzufügen',
        'new_item'           => 'Neues Event',
        'edit_item'          => 'Event bearbeiten',
        'view_item'          => 'Event anzeigen',
        'all_items'          => 'Alle Events',
        'search_items'       => 'Events durchsuchen',
        'not_found'          => 'Keine Events gefunden',
        'not_found_in_trash' => 'Keine Events im Papierkorb gefunden'
    );
    // Argumente für den Posttyp
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'events' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    // Registering the post type
    register_post_type( 'events', $args );
}
// Hook, um die Funktion bei der Initialisierung von WordPress aufzurufen
add_action( 'init', 'events_posttyp' );
