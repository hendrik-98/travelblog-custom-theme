<?php
get_header();
?>

<div class="container">
    <?php custom_breadcrumb();?>
    <h1 class="title">
        Hotels
    </h1>

    <form id="custom-search-form" method="get" action="<?php echo esc_url( home_url( '/hotels/' ) ); ?>">
    <!-- Destination filter -->
    <select name="destination" id="destination-select">
        <option value="" <?php selected( isset( $_GET['destination'] ) ? $_GET['destination'] : '', '' ); ?>>Alle Destinationen</option>
        <?php
        // Get all terms for 'destination' taxonomy
        $terms = get_terms( 'destination', array( 'hide_empty' => true ) );
        // Filter terms to include only those with associated hotels
        foreach ( $terms as $term ) {
            $hotels_query = new WP_Query( array(
                'post_type'      => 'hotels',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'destination',
                        'field'    => 'slug',
                        'terms'    => $term->slug
                    )
                ),
                'posts_per_page' => 1 // Check if at least one event exists
            ) );
            // Display the term in the dropdown if it has hotels
            if ( $hotels_query->have_posts() ) {
                echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( isset( $_GET['destination'] ) ? $_GET['destination'] : '', $term->slug, false ) . '>' . esc_html( $term->name ) . '</option>';
            }
            // Reset the query
            wp_reset_postdata();
        }
        ?>
    </select>
    <!-- Sterne filter -->
    <select name="sterne" id="sterne-filter">
        <option value="" <?php selected( isset( $_GET['sterne'] ) ? $_GET['sterne'] : '', '' ); ?>>Alle Sterne</option>
        <option value="1" <?php selected( isset( $_GET['sterne'] ) ? $_GET['sterne'] : '', '1' ); ?>>1 Stern</option>
        <option value="2" <?php selected( isset( $_GET['sterne'] ) ? $_GET['sterne'] : '', '2' ); ?>>2 Sterne</option>
        <option value="3" <?php selected( isset( $_GET['sterne'] ) ? $_GET['sterne'] : '', '3' ); ?>>3 Sterne</option>
        <option value="4" <?php selected( isset( $_GET['sterne'] ) ? $_GET['sterne'] : '', '4' ); ?>>4 Sterne</option>
        <option value="5" <?php selected( isset( $_GET['sterne'] ) ? $_GET['sterne'] : '', '5' ); ?>>5 Sterne</option>
    </select>
    <input class="search" type="submit" value="Suchen" />
</form>



</div>
<?php
// Query hotels based on filters
$args = array(
    'post_type'      => 'hotels',
    'posts_per_page' => -1, // Display all hotels
);
// Apply destination and sterne filters if set
if ( isset( $_GET['destination'] ) && ! empty( $_GET['destination'] ) || isset( $_GET['sterne'] ) && ! empty( $_GET['sterne'] ) ) {
    $args['tax_query'] = array(
        'relation' => 'AND',
    );

    if ( isset( $_GET['destination'] ) && ! empty( $_GET['destination'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'destination',
            'field'    => 'slug',
            'terms'    => $_GET['destination'],
        );
    }

    if ( isset( $_GET['sterne'] ) && ! empty( $_GET['sterne'] ) ) {
        $args['meta_query'][] = array(
            'key'     => 'hotel_sterne',
            'value'   => $_GET['sterne'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        );
    }
}

$hotels_query = new WP_Query( $args );
// Start the loop
if ( $hotels_query->have_posts() ) :
    while ( $hotels_query->have_posts() ) :
        $hotels_query->the_post();
        $sterne = get_post_meta( get_the_ID(), 'hotel_sterne', true );
        $externer_link = get_post_meta( $post->ID, 'externer_link', true );
        // Display hotel content
        ?>
        <div class="hotel-container">
            <div class="thumbnail">
                <?php the_post_thumbnail('large'); ?>
            </div>
            <div class="container">
                <span class="exit-content"> </span>
                <!-- Display stars based on meta field value -->
                <div class="hotel-stars">
                    <?php
                    // Output stars based on the meta field value
                    for ($i = 0; $i < $sterne; $i++) {
                        echo '★';
                    }
                    ?>
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
                    <?php if($externer_link !== ''){
                        ?>
                        <a href="<?php echo $externer_link;?>" class="link-btn">ZUM HOTEL</a>
                        <?php
                    }
                    ?>
                </div>
                <button class="toggle-content-btn">Mehr anzeigen</button>
            </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();
else :
    ?>
        <div class="container"><p>Keine Hotels gefunden.</p></div>
    <?php
endif;
?>

<?php
wp_enqueue_script('content-toggle-script', get_template_directory_uri() . '/js/content-toggle.js', '1.0', true);

get_footer();
