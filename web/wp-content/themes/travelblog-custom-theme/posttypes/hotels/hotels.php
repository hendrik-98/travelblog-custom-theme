<?php

// Funktion zum Erstellen des Posttyps "hotels"
function hotels_posttyp() {
    // Labels für den Posttyp
    $labels = array(
        'name'               => 'Hotels',
        'singular_name'      => 'Hotel',
        'menu_name'          => 'Hotels',
        'name_admin_bar'     => 'Hotel',
        'add_new'            => 'Neues Hotel hinzufügen',
        'add_new_item'       => 'Neues Hotel hinzufügen',
        'new_item'           => 'Neues Hotel',
        'edit_item'          => 'Hotel bearbeiten',
        'view_item'          => 'Hotel anzeigen',
        'all_items'          => 'Alle Hotels',
        'search_items'       => 'Hotels durchsuchen',
        'not_found'          => 'Keine Hotels gefunden',
        'not_found_in_trash' => 'Keine Hotels im Papierkorb gefunden'
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
        'rewrite'            => array( 'slug' => 'hotels' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-multisite',
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    // Registering the post type
    register_post_type( 'hotels', $args );
}
// Hook, um die Funktion bei der Initialisierung von WordPress aufzurufen
add_action( 'init', 'hotels_posttyp' );
