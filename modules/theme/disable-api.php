<?php

namespace Frc\WP\Base\Theme\DisableApi;

function disable_api() {
    remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'template_redirect', 'rest_output_link_header', 11 );
}
add_action('init', __NAMESPACE__ . '\\disable_api');
