<?php
function custom_breadcrumb() {
    echo '<div class="breadcrumb">';
    echo '<ul>';
    // Startseite
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a><span>&nbsp;&nbsp;>&nbsp;&nbsp;</span></li>';
    if (is_category()) {
        $category = get_queried_object();
        $parent_id = $category->category_parent;
        if ($parent_id != 0) {
            $parent_category = get_category($parent_id);
            echo '<li><a href="' . esc_url(get_category_link($parent_category->term_id)) . '">' . $parent_category->name . '</a></li>';
            echo ' > ';
        }
        echo '<li>' . single_cat_title('', false) . '</li>';
    } 
    elseif (is_tag()) {
        echo '<li>' . single_tag_title('', false) . '</li>';
    } 
    elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo '<li>' . $userdata->display_name . '</li>';
    } 
    elseif (is_day()) {
        echo '<li>' . get_the_date() . '</li>';
    } 
    elseif (is_month()) {
        echo '<li>' . get_the_date('F Y') . '</li>';
    } 
    elseif (is_year()) {
        echo '<li>' . get_the_date('Y') . '</li>';
    } 
    elseif (is_search()) {
        echo '<li>Search results for "' . get_search_query() . '"</li>';
    } 
    elseif (is_post_type_archive()) {
        echo '<li>' . post_type_archive_title('', false) . '</li>';
    } 
    elseif (is_tax()) {
        $term = get_queried_object();
        if ($term->parent != 0) {
            $parent_term = get_term($term->parent, $term->taxonomy);
            echo '<li><a href="' . esc_url(get_term_link($parent_term)) . '">' . $parent_term->name . '</a></li>';
            echo ' > ';
        }
        echo '<li>' . $term->name . '</li>';
    } 
    elseif (is_home()) {
        echo '<li>Blog</li>';
    } 
    elseif (is_singular()) {
        $post = get_queried_object();
        $post_type = get_post_type_object(get_post_type($post));
        if ($post_type->has_archive) {
            echo '<li><a href="' . esc_url(get_post_type_archive_link($post_type->name)) . '">' . $post_type->labels->name . '</a></li>';
            echo ' > ';
        }
        echo '<li>' . get_the_title() . '</li>';
    }
    echo '</ul>';
    echo '</div>';
}
