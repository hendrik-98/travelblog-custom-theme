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
            <option value="" disabled selected hidden>Destination</option>
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
                    echo '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
                }
                // Reset the query
                wp_reset_postdata();
            }
            ?>
        </select><select name="sterne" id="sterne-filter">
            <option value="" disabled selected hidden>Sterne</option>
            <option value="1">1 Stern</option>
            <option value="2">2 Sterne</option>
            <option value="3">3 Sterne</option>
            <option value="4">4 Sterne</option>
            <option value="5">5 Sterne</option>
        </select>
    </form>
</div>
<script>
    // JavaScript code to submit the form when both selects are chosen
    document.getElementById('destination-select').addEventListener('change', function() {
        checkFormAndSubmit();
    });
    document.getElementById('sterne-filter').addEventListener('change', function() {
        checkFormAndSubmit();
    });
    function checkFormAndSubmit() {
        var destinationValue = document.getElementById('destination-select').value;
        var sterneValue = document.getElementById('sterne-filter').value;
        if (destinationValue && sterneValue) {
            document.getElementById('custom-search-form').submit();
        }
    }
</script>
<?php
// Query hotels based on filters
$args = array(
    'post_type'      => 'hotels',
    'posts_per_page' => -1, // Display all hotels
);
// Apply destination and sterne filters if set
if ( isset( $_GET['destination'] ) && ! empty( $_GET['destination'] ) && isset( $_GET['sterne'] ) && ! empty( $_GET['sterne'] ) ) {
    $args['tax_query'] = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'destination',
            'field'    => 'slug',
            'terms'    => $_GET['destination'],
        ),
    );
    $args['meta_query'] = array(
        array(
            'key'     => 'hotel_sterne',
            'value'   => $_GET['sterne'],
            'compare' => '=',
            'type'    => 'NUMERIC',
        ),
    );
}
$hotels_query = new WP_Query( $args );
// Start the loop
if ( $hotels_query->have_posts() ) :
    while ( $hotels_query->have_posts() ) :
        $hotels_query->the_post();
        $sterne = get_post_meta( get_the_ID(), 'hotel_sterne', true );
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
get_footer();
?>

<script>
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