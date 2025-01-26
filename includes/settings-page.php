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
        // Save the font selection
        $selected_font = sanitize_text_field($_POST['assamese_font_selection']);
        update_option('assamese_font_selection', $selected_font);
    }

    $selected_font = get_option('assamese_font_selection', 'rangmon');
    $uploaded_font_url = get_option('assamese_font_uploaded');
    
    ?>
    <div class="wrap">
        <h1 class="assamese-settings-header">Assamese Fonts Settings</h1>
        <form method="post" enctype="multipart/form-data" class="assamese-font-settings-form">
            <?php wp_nonce_field('assamese_fonts_options'); ?>
            
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="assamese_font_selection">Select Font</label></th>
                    <td>
                        <?php assamese_font_selection_callback($selected_font); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="assamese_custom_fonts">Upload Custom Font</label></th>
                    <td>
                        <input type="file" name="assamese_custom_fonts" accept=".ttf,.otf" class="upload-font-input" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="font_rating">Rate the Font Selection</label></th>
                    <td>
                        <div class="rating-stars">
                            <span class="star" data-rating="1">&#9733;</span>
                            <span class="star" data-rating="2">&#9733;</span>
                            <span class="star" data-rating="3">&#9733;</span>
                            <span class="star" data-rating="4">&#9733;</span>
                            <span class="star" data-rating="5">&#9733;</span>
                        </div>
                    </td>
                </tr>
            </table>

            <?php submit_button('Save Settings', 'primary', 'submit', true); ?>
        </form>
    </div>

    <div class="footer-info">
        <p>Author: Himangshu Kalita</p>
        <p>Website: <a href="https://lachit.org" target="_blank">lachit.org</a></p>
    </div>

    <div class="font-download-button">
        <button class="download-font-btn" onclick="window.location.href='https://lachit.org/#Fonts'">Download Custom Assamese Font</button>
    </div>
    
    <?php
}

// Font selection dropdown
function assamese_font_selection_callback($selected_font) {
    $uploaded_font_url = get_option('assamese_font_uploaded');
    ?>
    <select name="assamese_font_selection" class="font-selection-dropdown">
        <option value="rangmon" <?php selected($selected_font, 'rangmon'); ?>>Rangmon</option>
        <option value="jyotirupa" <?php selected($selected_font, 'jyotirupa'); ?>>Jyotirupa</option>
        <?php if ($uploaded_font_url): ?>
            <option value="custom" <?php selected($selected_font, 'custom'); ?>>Custom Uploaded Font</option>
        <?php endif; ?>
    </select>
    <p class="uploaded-font-info">
        <?php if ($uploaded_font_url): ?>
            Current Custom Font: <strong><?php echo basename($uploaded_font_url); ?></strong>
        <?php else: ?>
            No custom font uploaded yet.
        <?php endif; ?>
    </p>
    <?php
}

// Add custom styles
function assamese_font_settings_page_styles() {
    echo '
    <style>
        .assamese-settings-header {
            color: #2c3e50;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .assamese-font-settings-form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .font-selection-dropdown {
            width: 200px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .upload-font-input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .rating-stars {
            display: flex;
            gap: 5px;
        }
        .star {
            font-size: 24px;
            cursor: pointer;
            color: #f39c12;
        }
        .star:hover {
            color: #e67e22;
        }
        .footer-info {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .footer-info a {
            color: #3498db;
            text-decoration: none;
        }
        .font-download-button {
            text-align: center;
            margin-top: 20px;
        }
        .download-font-btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .download-font-btn:hover {
            background-color: #2980b9;
        }
    </style>
    ';
}
add_action('admin_head', 'assamese_font_settings_page_styles');

?>
