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
    return $message . '<p class="message" style="border-left: 4px solid #FFBA00;">' . wp_kses(__('<strong>Note:</strong> You are about to login to a ' . WP_ENV . ' environment', '_frc'), 'strong') . '</p>';
}

function login_styles() {
    wp_enqueue_style('base/login', helpers\asset_path('styles/login.css'), false, null);
}
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\login_styles' );
