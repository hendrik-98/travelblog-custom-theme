<?php
function theme_enqueue_styles() {
    // Stylesheet (styles.css) in den <head> integrieren
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}
// Hook, um die Funktion in den wp_head einzufügen
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

//Theme Support Beitragsbilder
add_theme_support( 'post-thumbnails' );

//Enable upload for webp image files
function webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
        return $existing_mimes;
    }
add_filter('mime_types', 'webp_upload_mimes');



