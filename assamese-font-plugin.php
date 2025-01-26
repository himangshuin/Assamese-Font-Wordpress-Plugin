<?php
/**
 * Plugin Name: Assamese Font Plugin
 * Description: A WordPress plugin for applying Assamese custom fonts (Rangmon, Jyotirupa, or uploaded fonts).
 * Version: 1.0
 * Author: Your Name
 */

defined('ABSPATH') || exit;

// Include additional files
include_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';
include_once plugin_dir_path(__FILE__) . 'includes/font-uploader.php';

// Enqueue admin styles
function assamese_font_admin_styles() {
    wp_enqueue_style('assamese-font-admin', plugin_dir_url(__FILE__) . 'assets/css/styles.css');
}
add_action('admin_enqueue_scripts', 'assamese_font_admin_styles');

// Dynamic font CSS for the frontend
function assamese_font_custom_css() {
    $selected_font = get_option('assamese_font_selection', 'rangmon');
    $uploaded_font_url = get_option('assamese_font_uploaded');

    $font_css = '';

    if ($selected_font === 'custom' && $uploaded_font_url) {
        $font_css .= "
            @font-face {
                font-family: 'CustomAssameseFont';
                src: url('$uploaded_font_url') format('truetype');
            }
            * {
                font-family: 'CustomAssameseFont', sans-serif !important;
            }
        ";
    } elseif ($selected_font === 'rangmon') {
        $font_css .= "
            @font-face {
                font-family: 'Rangmon';
                src: url('" . plugin_dir_url(__FILE__) . "assets/fonts/rangmon.ttf') format('truetype');
            }
            * {
                font-family: 'Rangmon', sans-serif !important;
            }
        ";
    } elseif ($selected_font === 'jyotirupa') {
        $font_css .= "
            @font-face {
                font-family: 'Jyotirupa';
                src: url('" . plugin_dir_url(__FILE__) . "assets/fonts/jyotirupa.ttf') format('truetype');
            }
            * {
                font-family: 'Jyotirupa', sans-serif !important;
            }
        ";
    }

    echo "<style>$font_css</style>";
}
add_action('wp_head', 'assamese_font_custom_css');
