<?php

if (!defined('ABSPATH')) {
    exit;
}

function wp_fine_tuning_settings() {
    register_setting('wp_fine_tuning_options', 'wp_fine_tuning_system_message');
    register_setting('wp_fine_tuning_options', 'wp_fine_tuning_post_types');
}

add_action('admin_init', 'wp_fine_tuning_settings');