<?php

namespace Frc\WP\Base\Admin\CleanUp;

function clean_widgets() {
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']);

    remove_action('welcome_panel', 'wp_welcome_panel');
}
add_action('wp_dashboard_setup',  __NAMESPACE__ . '\\clean_widgets' );

function clean_plugin_widgets() {
    remove_meta_box('sendgrid_statistics_widget', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup',  __NAMESPACE__ . '\\clean_plugin_widgets', 999 );
