<?php

if (!defined('ABSPATH')) {
    exit;
}



function wp_fine_tuning_export_posts() {
    $system_message = get_option('wp_fine_tuning_system_message', '');
    $selected_post_types = get_option('wp_fine_tuning_post_types', []);

    if (empty($selected_post_types)) {
        return;
    }

    $lines = array();

    foreach ($selected_post_types as $post_type) {
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
        );
        $posts = get_posts($args);

        foreach ($posts as $post) {
            $title = wp_strip_all_tags($post->post_title); 
            $content = wp_strip_all_tags($post->post_content); 

            $messages = array(
                array('role' => 'system', 'content' => $system_message),
                array('role' => 'user', 'content' => $title),
                array('role' => 'assistant', 'content' => $content),
                
            );
            $lines[] = json_encode(array('messages' => $messages), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
    }

    $output = implode("\n", $lines);
    $filename = 'posts-' . date('Y-m-d-H-i-s') . '.jsonl';
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['path'] . '/' . $filename;
    file_put_contents($file_path, $output);

    $file_url = preg_replace('/^http:/i', 'https:', $upload_dir['url'] . '/' . $filename);
    return $file_url;
}