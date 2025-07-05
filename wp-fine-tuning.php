<?php
/*
Plugin Name: WP Fine-Tuning
Plugin URI: https://kevin-benabdelhak.fr/plugins/wp-fine-tuning/
Description: WP Fine-tuning exporte l'intégralité des titres et contenus de votre site dans un fichier jsonl compatible avec le fine-tuning d'OpenAI.
Version: 1.0
Author: Kevin BENABDELHAK
Author URI: https://kevin-benabdelhak.fr
Contributors: kevinbenabdelhak
*/

if (!defined('ABSPATH')) {
    exit;
}




if ( !class_exists( 'YahnisElsts\\PluginUpdateChecker\\v5\\PucFactory' ) ) {
    require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';
}
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$monUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/kevinbenabdelhak/WP-Fine-Tuning/', 
    __FILE__,
    'wp-fine-tuning' 
);

$monUpdateChecker->setBranch('main');










include_once(plugin_dir_path(__FILE__) . 'includes/admin-menu.php');
include_once(plugin_dir_path(__FILE__) . 'includes/settings.php');
include_once(plugin_dir_path(__FILE__) . 'includes/export.php');