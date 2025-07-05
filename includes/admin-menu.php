<?php

if (!defined('ABSPATH')) {
    exit;
}

function wp_fine_tuning_menu() {
    add_menu_page(
        'WP Fine-tuning',
        'WP Fine-tuning',
        'manage_options',
        'wp-fine-tuning',
        'wp_fine_tuning_page'
    );
}

add_action('admin_menu', 'wp_fine_tuning_menu');



function wp_fine_tuning_page() {
    $post_types = get_post_types(array('public' => true), 'objects');
    $selected_post_types = get_option('wp_fine_tuning_post_types', array());
    ?>
    <div class="wrap">
        <h1>WP Fine-tuning</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wp_fine_tuning_options');
            do_settings_sections('wp_fine_tuning_options');
            $system_message = get_option('wp_fine_tuning_system_message', '');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Message du système</th>
                    <td><textarea name="wp_fine_tuning_system_message" rows="5" cols="50"><?php echo esc_textarea($system_message); ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Types de contenu à inclure</th>
                    <td>
                        <?php foreach ($post_types as $post_type) : ?>
                            <?php if ($post_type->name !== 'attachment') : ?>
                                <label>
                                    <input type="checkbox" name="wp_fine_tuning_post_types[]" value="<?php echo esc_attr($post_type->name); ?>" <?php checked(in_array($post_type->name, $selected_post_types)); ?>>
                                    <?php echo esc_html($post_type->label); ?>
                                </label><br>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>

        <form method="post" action="">
            <input type="hidden" name="export_posts" value="true">
            <button type="submit" class="button button-primary">Exporter</button>
        </form>
        <div id="download-link"></div>
    </div>
    
    <?php
    if (isset($_POST['export_posts']) && $_POST['export_posts'] === 'true') {
        $file_url = wp_fine_tuning_export_posts();
        ?>
        <script type="text/javascript">

            // pour simuler clic*
            document.addEventListener('DOMContentLoaded', function() {
                var downloadLinkDiv = document.getElementById('download-link');
                var downloadLink = document.createElement('a');
                downloadLink.href = '<?php echo $file_url; ?>';
                downloadLink.download = '<?php echo basename($file_url); ?>';
                downloadLink.style.display = 'none'; 
                downloadLinkDiv.appendChild(downloadLink);
                downloadLink.click();
            });
        </script>
        <?php
    }
}