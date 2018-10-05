<?php

namespace Frc\WP\Base\Login\Force;

add_action('template_redirect', __NAMESPACE__ . '\\force_login');
add_filter('rest_authentication_errors', __NAMESPACE__ . '\\force_login_api');

function force_login() {

    if ( is_user_logged_in() )
        return;

    if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ||
        ( defined( 'DOING_CRON' ) && DOING_CRON ) ||
        ( defined( 'WP_CLI' ) && WP_CLI )
    ) {
        return;
    }

    // List of pages that will not be blocked
    $whitelist = apply_filters('frc/base/login/force/whitelist', [
        'import-csv',
        'wp-login.php',
        'wp-register.php',
        'wp-cron.php',
        'wp-trackback.php',
        'wp-app.php',
        'xmlrpc.php'
    ]);

    if ( in_array(basename($_SERVER['PHP_SELF']), $whitelist) ) {
        return;
    }

    auth_redirect();

}

function force_login_api($result ) {

	if ( ! is_user_logged_in() ) {
		return new WP_Error( 'rest_forbidden', __( 'Sorry, you are not allowed to do that.' ), array( 'status' => rest_authorization_required_code() ) );
    }

    return $result;

}
