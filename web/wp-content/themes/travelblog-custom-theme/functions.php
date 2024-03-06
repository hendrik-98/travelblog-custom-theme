<?php

//add some theme settings
include_once( get_template_directory() . '/functions/settings.php' );

//Custom Post Type einbinden
include_once( get_template_directory() . '/posttypes/hotels/hotels.php' );
include_once( get_template_directory() . '/posttypes/events/events.php' );

//Custom  Metafield einbinden
include_once( get_template_directory() . '/posttypes/hotels/metafields/hotels-metafield.php' );
include_once( get_template_directory() . '/posttypes/events/metafields/events-metafield.php' );

//Custom  Taxonomy einbinden
include_once( get_template_directory() . '/taxonomie/destinations.php' );