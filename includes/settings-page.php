<?php

defined('ABSPATH') || exit;

// Add settings page to admin menu
function assamese_font_settings_page() {
    add_options_page(
        'Assamese Fonts',
        'Assamese Fonts',
        'manage_options',
        'assamese-fonts',
        'assamese_font_settings_page_html'
    );
}
add_action('admin_menu', 'assamese_font_settings_page');

// Settings page HTML
function assamese_font_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['submit'])) {
        check_admin_referer('assamese_fonts_options');
        assamese_font_handle_upload();
    }

    ?>
    <div class="wrap">
        <h1>Assamese Fonts Settings</h1>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('assamese_fonts_options'); ?>
            
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Select Font</th>
                    <td>
                        <?php assamese_font_selection_callback(); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Upload Custom Font</th>
                    <td>
                        <input type="file" name="assamese_custom_fonts" accept=".ttf,.otf" />
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Font selection dropdown
function assamese_font_selection_callback() {
    $selected_font = get_option('assamese_font_selection', 'rangmon');
    $uploaded_font_url = get_option('assamese_font_uploaded');

    ?>
    <select name="assamese_font_selection">
        <option value="rangmon" <?php selected($selected_font, 'rangmon'); ?>>Rangmon</option>
        <option value="jyotirupa" <?php selected($selected_font, 'jyotirupa'); ?>>Jyotirupa</option>
        <?php if ($uploaded_font_url): ?>
            <option value="custom" <?php selected($selected_font, 'custom'); ?>>Custom Uploaded Font</option>
        <?php endif; ?>
    </select>
    <p>
        <?php if ($uploaded_font_url): ?>
            Current Custom Font: <strong><?php echo basename($uploaded_font_url); ?></strong>
        <?php else: ?>
            No custom font uploaded yet.
        <?php endif; ?>
    </p>
    <?php
}
