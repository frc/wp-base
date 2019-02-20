<?php

namespace Frc\WP\Base\Login\Defaults;

use Frc\WP\Base as helpers;

if ( defined( 'WP_ENV' ) && WP_ENV !== 'production' ) {

    add_filter('login_message', __NAMESPACE__ . '\\add_development_login_message');

}

/**
 * Add warning message to login
 * Inform the user that they're about to login to a development environment
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/login_message
 */
function add_development_login_message($message) {
    return '<p class="message" style="border-left: 4px solid #FFBA00;">' .
        wp_kses(
            sprintf(
                __('<strong>Note:</strong> You are about to login to a <strong>%s</strong> environment', 'frc-wp-base'),
                WP_ENV
            ),
            'strong'
        ) . '</p>' . $message;
}

function login_styles() {
    wp_enqueue_style('base/login', helpers\asset_path('styles/login.css'), false, null);

    $options = helpers\get_options(__FILE__);

    if ( isset($options['logo']) && $options['logo'] === false ) {
        wp_add_inline_style('base/login', "
.login h1 a {
    display: none;
}
        ");
    }

    if ( !empty($options['logo'])  ) {
        wp_add_inline_style('base/login', "
.login h1 a {
    background-image: url('{$options['logo']}');
}
        ");
    }
}
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\login_styles' );
