<?php
get_header();
?>

<div class="container">
    <?php custom_breadcrumb();?>
    <h1 class="title"><?php single_term_title(); ?></h1>
    <form id="custom-search-form" method="get">
        <select name="sterne" id="sterne-filter">
            <option value="" disabled selected hidden>Sterne</option>
            <option value="1">1 Stern</option>
            <option value="2">2 Sterne</option>
            <option value="3">3 Sterne</option>
            <option value="4">4 Sterne</option>
            <option value="5">5 Sterne</option>
        </select><input type="date" name="datum" id="event_date">
    </form>
</div>
<?php 
// Erhalte die ausgewählten Filterwerte
$selected_sterne = isset( $_GET['sterne'] ) ? $_GET['sterne'] : '';
$selected_datum = isset( $_GET['datum'] ) ? $_GET['datum'] : '';
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
if (!empty($selected_sterne) && empty($selected_datum)) {
    // Nur Hotels anzeigen, wenn Sterne ausgewählt sind und kein Datum
    $args_hotels['meta_query'][] = array(
        'key' => 'hotel_sterne',
        'value' => $selected_sterne,
        'compare' => '='
    );
} 
elseif (empty($selected_sterne) && !empty($selected_datum)) {
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
// Wähle alle Buttons und das exit-content-Element aus
var toggleButtons = document.querySelectorAll('.toggle-content-btn');
var exitContent = document.querySelectorAll('.exit-content');

toggleButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var content = this.previousElementSibling;
        var parentContainer = content.parentElement;
        var exitContentx = parentContainer.querySelector('.exit-content');
        // Umschalten der Anzeige des Inhalts
        if (content.style.display === 'none' || content.style.display === '') {
            content.style.display = 'block';
            exitContentx.style.display = 'block';
            this.textContent = 'Weniger anzeigen';
            // Hinzufügen der Klasse "border"
            parentContainer.classList.add('border');
            // Ändern der Breite von .thumbnail auf 1920px
            var thumbnailcontainer = this.parentElement;
            var thumbnail = thumbnailcontainer.parentElement.querySelector('.thumbnail');
            if (thumbnail) {
                thumbnail.style.maxWidth = '1920px';
            } 
            else {
                console.error("Thumbnail not found.");
            }
        } 
        else {
            content.style.display = 'none';
            exitContentx.style.display = 'none';
            this.textContent = 'Mehr anzeigen';
            // Entfernen der Klasse "border"
            parentContainer.classList.remove('border');
            // Ändern der Breite von .thumbnail auf 1200px
            var thumbnailcontainer = this.parentElement;
            var thumbnail = thumbnailcontainer.parentElement.querySelector('.thumbnail');
            if (thumbnail) {
                thumbnail.style.maxWidth = '1200px';
            } 
            else {
                console.error("Thumbnail not found.");
            }
        }
    });
});

// Füge das Klicken-Ereignis zum exit-content-Element hinzu
exitContent.forEach(function(exit) {
    exit.addEventListener('click', function() {
        // Auslösen der toggleButtons-Aktion
        var siblingButton = this.parentElement.querySelector('.toggle-content-btn');
        if (siblingButton) {
            siblingButton.click();
        }
    });
});
</script>

<?php
get_footer();
?>
