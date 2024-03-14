<?php
get_header();

// Erhalte die ausgewählten Filterwerte
$selected_sterne = isset( $_GET['sterne'] ) ? $_GET['sterne'] : '';
$selected_datum = isset( $_GET['datum'] ) ? $_GET['datum'] : '';
?>

<div class="container">
    <?php custom_breadcrumb();?>
    <h1 class="title"><?php single_term_title(); ?></h1>
    <form id="custom-search-form" method="get">
        <select name="sterne" id="sterne-filter">
            <option value="" disabled hidden <?php selected( $selected_sterne, '' ); ?>>Sterne</option>
            <option value="all" <?php selected( $selected_sterne, 'all' ); ?>>Alle Sterne</option>
            <option value="1" <?php selected( $selected_sterne, '1' ); ?>>1 Stern</option>
            <option value="2" <?php selected( $selected_sterne, '2' ); ?>>2 Sterne</option>
            <option value="3" <?php selected( $selected_sterne, '3' ); ?>>3 Sterne</option>
            <option value="4" <?php selected( $selected_sterne, '4' ); ?>>4 Sterne</option>
            <option value="5" <?php selected( $selected_sterne, '5' ); ?>>5 Sterne</option>
        </select><input type="date" name="datum" id="event_date" value="<?php echo esc_attr( $selected_datum ); ?>">
    </form>

</div>
<?php 

// Erhalte die aktuelle Taxonomie-Termin-ID
$term_id = get_queried_object_id();
// Baue die Query-Argumente für Hotels
$args_hotels = array(
    'post_type' => 'hotels',
    'tax_query' => array(
        array(
            'taxonomy' => 'destination',
            'field'    => 'id',
            'terms'    => $term_id, // Nur Posts mit der aktuellen Term-ID der Taxonomie "Destination"
        ),
    ),
    'meta_query' => array() // Leeres Array für die Meta-Abfrage
);
// Baue die Query-Argumente für Events
$args_events = array(
    'post_type' => 'events',
    'tax_query' => array(
        array(
            'taxonomy' => 'destination',
            'field'    => 'id',
            'terms'    => $term_id, // Nur Posts mit der aktuellen Term-ID der Taxonomie "Destination"
        ),
    ),
    'meta_query' => array() // Leeres Array für die Meta-Abfrage
);
// Füge Metaabfragen basierend auf den ausgewählten Filtern hinzu
if (!empty($selected_sterne) && $selected_sterne !== 'all' && empty($selected_datum)) {
    // Nur Hotels anzeigen, wenn Sterne ausgewählt sind und kein Datum
    $args_hotels['meta_query'][] = array(
        'key' => 'hotel_sterne',
        'value' => $selected_sterne,
        'compare' => '='
    );
} elseif (empty($selected_sterne) && !empty($selected_datum)) {
    // Nur Events anzeigen, wenn Datum ausgewählt ist und keine Sterne
    $args_events['meta_query'][] = array(
        'key' => 'eventdatum',
        'value' => $selected_datum,
        'compare' => '='
    );
}
if (empty($selected_datum)) {
    $query_hotels = new WP_Query($args_hotels);
    // Überprüfe, ob Hotels vorhanden sind
    if ($query_hotels->have_posts()) {
        while ($query_hotels->have_posts()) : $query_hotels->the_post();
        $sterne = get_post_meta(get_the_ID(), 'hotel_sterne', true);
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
                <div class="destination">
                    <?php
                    $terms = get_the_terms(get_the_ID(), 'destination');
                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            echo $term->name;
                        }
                    }
                    ?>
                </div>
                <h2 class="title">
                    <?php the_title(); ?>
                </h2>
                <div class="content">
                    <?php the_content(); ?>
                    <?php if($externer_link !== ''){
                        ?>
                        <a href="<?php echo $externer_link;?>" class="link-btn">ZUM HOTEL</a>
                        <?php
                    }
                    ?>
                </div>
                <button class="toggle-content-btn">Mehr dazu</button>
            </div>
        </div>
        <?php
        endwhile;
    } 
    else {
        // Zeige eine Nachricht an, falls keine Hotels gefunden wurden
        ?>
            <div class="container">
                <p>Es wurden keine Hotels gefunden.</p>
            </div>
        <?php
    }
}
if (!empty($selected_datum) || empty($selected_datum) && empty($selected_sterne)) {
    $query_events = new WP_Query($args_events);
    if ($query_events->have_posts()) {
        while ($query_events->have_posts()) : $query_events->the_post();
        $eventdate = get_post_meta( get_the_ID(), 'eventdatum', true );
        $eventdate_formatted = date('d.m.Y', strtotime($eventdate));
        $externer_link = get_post_meta( $post->ID, 'externer_link', true );
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
                <div class="content">
                    <?php the_content(); ?>
                    <?php if($externer_link !== ''){
                        ?>
                        <a href="<?php echo $externer_link;?>" class="link-btn">ZUM EVENT</a>
                        <?php
                    }
                    ?>
                </div>
                <button class="toggle-content-btn">Mehr anzeigen</button>
            </div>
        </div>
        <?php
        endwhile;
    } 
    else {
        // Zeige eine Nachricht an, falls keine Events gefunden wurden
        ?>
            <div class="container">
                <p>Es wurden keine Events gefunden.</p>
            </div>
        <?php
    }
}
wp_reset_postdata();
?>
<script>
// JavaScript, um sicherzustellen, dass nur ein Filterfeld aktiv ist
document.addEventListener('DOMContentLoaded', function () {
const sterneFilter = document.getElementById('sterne-filter');
const datumFilter = document.getElementById('event_date');
const filterForm = document.querySelector('form[method="get"]');
const filterInputs = filterForm.querySelectorAll('select, input[type="date"]');
    sterneFilter.addEventListener('change', function () {
        if (sterneFilter.value !== '') {
            datumFilter.disabled = true;
        } 
        else {
            datumFilter.disabled = false;
        }
    });
    datumFilter.addEventListener('change', function () {
        if (datumFilter.value !== '') {
            sterneFilter.disabled = true;
        } 
        else {
            sterneFilter.disabled = false;
        }
    });
    filterInputs.forEach(input => {
        input.addEventListener('change', function () {
            filterForm.submit();
        });
    });
});

</script>

<?php
wp_enqueue_script('content-toggle-script', get_template_directory_uri() . '/js/content-toggle.js', '1.0', true);
wp_enqueue_script('link-script', get_template_directory_uri() . '/js/link.js', '1.0', true);

get_footer();

