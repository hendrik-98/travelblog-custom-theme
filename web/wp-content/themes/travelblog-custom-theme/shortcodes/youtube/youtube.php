<?php
// Shortcode für YouTube-Video mit Thumbnail und Play-Button
function youtube_video_shortcode($atts) {
    // Extrahieren der YouTube-Video-ID aus dem übergebenen Link
    $video_url = $atts['url'];
    preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches);
    $video_id = $matches[1];
    // Erstellen des HTML-Codes für das Video
    $html = '<div class="video-container">';
    $html .= '<img class="video-thumbnail" src="https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg" alt="Video Thumbnail">';
    $html .= '<button class="play-button" data-video-id="' . $video_id . '">&#9654;</button>';
    $html .= '</div>';
    // Enqueue des JavaScripts nur, wenn der Shortcode verwendet wird
    wp_enqueue_script('youtube-video-script', get_template_directory_uri() . '/shortcodes/youtube/youtube.js', array('jquery'), '1.0', true);
    return $html;
}
add_shortcode('youtube_video', 'youtube_video_shortcode');