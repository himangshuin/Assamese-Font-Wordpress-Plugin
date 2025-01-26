<?php

defined('ABSPATH') || exit;

function assamese_font_handle_upload() {
    if (isset($_FILES['assamese_custom_fonts']) && !empty($_FILES['assamese_custom_fonts']['name'])) {
        $uploaded_file = $_FILES['assamese_custom_fonts'];

        $allowed_types = ['ttf', 'otf'];
        $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);

        if (!in_array($file_extension, $allowed_types)) {
            add_settings_error('assamese_font_upload_error', 'invalid_file', 'Invalid file type. Please upload a .ttf or .otf file.', 'error');
            return;
        }

        $upload_dir = wp_upload_dir();
        $destination = trailingslashit($upload_dir['basedir']) . basename($uploaded_file['name']);
        $font_url = trailingslashit($upload_dir['baseurl']) . basename($uploaded_file['name']);

        if (move_uploaded_file($uploaded_file['tmp_name'], $destination)) {
            update_option('assamese_font_uploaded', $font_url);
            update_option('assamese_font_selection', 'custom'); // Automatically select the custom font.
            add_settings_error('assamese_font_upload_success', 'upload_success', 'Custom font uploaded successfully.', 'updated');
        } else {
            add_settings_error('assamese_font_upload_error', 'upload_failed', 'Failed to upload the font. Please try again.', 'error');
        }
    }
}
