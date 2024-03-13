<?php
get_header();
?>

<div class="container">
    <?php custom_breadcrumb();?>
    <h1 class="title">Events</h1>
    <form id="custom-search-form" method="get" action="<?php echo esc_url( home_url( '/events/' ) ); ?>">
    <!-- Destination filter -->
    <?php
    // Keep the selected destination value if set
    $selected_destination = isset($_GET['destination']) ? $_GET['destination'] : '';
    ?>
    <select name="destination" id="destination-select">
    <option value="" <?php if($selected_destination === '') echo 'selected'; ?>>Alle Destinationen</option>
    <?php
    // Get all terms for 'destination' taxonomy
    $terms = get_terms( 'destination', array( 'hide_empty' => true ) );
    // Filter terms to include only those with associated events
    foreach ( $terms as $term ) {
        $events_query = new WP_Query( array(
            'post_type'      => 'events',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'destination',
                    'field'    => 'slug',
                    'terms'    => $term->slug
                )
            ),
            'posts_per_page' => 1 // Check if at least one event exists
        ) );
        // Display the term in the dropdown if it has events
        if ( $events_query->have_posts() ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $selected_destination, $term->slug, false ) . '>' . esc_html( $term->name ) . '</option>';
        }
        // Reset the query
        wp_reset_postdata();
    }
    ?>
    </select>

    <?php
    // Keep the selected event date if set
    $selected_event_date = isset($_GET['event_date']) ? $_GET['event_date'] : '';
    ?>
    <input type="date" name="event_date" id="event_date" value="<?php echo esc_attr($selected_event_date); ?>">
    <input class="search" type="submit" value="Suchen" />
    </form>

</div>

<?php
// Query events based on filters
$args = array(
    'post_type' => 'events',
    'posts_per_page' => -1, // Display all events
    // Add additional parameters based on filters
);
// Apply destination filter if set
if ( isset( $_GET['destination'] ) && ! empty( $_GET['destination'] ) ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'destination',
            'field'    => 'slug',
            'terms'    => $_GET['destination'],
        ),
    );
}
// Apply date filter if set
if ( isset( $_GET['event_date'] ) && ! empty( $_GET['event_date'] ) ) {
    $args['meta_query'] = array(
        array(
            'key'     => 'eventdatum',
            'value'   => $_GET['event_date'],
            'compare' => '=',
        ),
    );
}
$events_query = new WP_Query( $args );
// Start the loop
if ( $events_query->have_posts() ) :
    while ( $events_query->have_posts() ) :
        $events_query->the_post();
        $eventdate = get_post_meta( get_the_ID(), 'eventdatum', true );
        $eventdate_formatted = date('d.m.Y', strtotime($eventdate));
        ?>
        <div class="event-container">
            <div class="thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
            <div class="container">
                <span class="exit-content"> </span>
                <div class="event-date">
                    <?php echo $eventdate_formatted; ?>
                </div>
                <!-- Begriff der benutzerdefinierten Taxonomie "destination" ausgeben -->
                <div class="destination">
                    <?php
                    $terms = get_the_terms( get_the_ID(), 'destination' );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        foreach ( $terms as $term ) {
                            echo $term->name;
                        }
                    }
                    ?>
                </div>
                <h2 class="title">
                    <?php the_title(); ?>
                </h2>
                <!-- Content ausblenden -->
                <div class="content">
                    <?php the_content(); ?>
                </div>
                <button class="toggle-content-btn">Mehr anzeigen</button>
            </div>
        </div>
        <?php
        endwhile;
    wp_reset_postdata();
else :
    ?>
        <div class="container"><p>Keine events gefunden.</p></div>
    <?php
endif;
?>
    
<?php
wp_enqueue_script('content-toggle-script', get_template_directory_uri() . '/js/content-toggle.js', '1.0', true);

get_footer();
