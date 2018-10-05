<?php

namespace Frc\WP\Base\Theme\DisableRESTApi;

use WP_Error;

if ( is_array($options) ) {
    if ( isset($options['disabled']) && is_array($options['disabled']) ) {
        add_filter('frc/base/rest/disabled', function($items) use ($options) {
            return array_merge($items, $options['disabled']);
        });
    }
    if ( isset($options['allowed']) && is_array($options['allowed']) ) {
        add_filter('frc/base/rest/allowed', function($items) use ($options) {
            return array_merge($items, $options['allowed']);
        });
    }
}

function get_current_route() {

    $rest_route = $GLOBALS['wp']->query_vars['rest_route'];

    return ( empty( $rest_route ) || '/' == $rest_route ) ? $rest_route : untrailingslashit( $rest_route );

}

function is_whitelisted($router) {

    $blocked = apply_filters('frc/base/rest/disabled', []);
    $allowed = apply_filters('frc/base/rest/allowed', []);

    foreach( $blocked as $item ) {
        if ( !in_array($item, $allowed) && strpos($router, $item) !== false )
            return false;
    }

    return true;

}

add_filter( 'rest_authentication_errors', function( $result ) {

    if ( is_user_logged_in() ) {
        return $result;
    }

    $current_route = get_current_route();

    if ( ! empty( $current_route ) && !is_whitelisted( $current_route ) ) {
        return new WP_Error( 'rest_forbidden', __( 'Sorry, you are not allowed to do that.' ), array( 'status' => rest_authorization_required_code() ) );
    }

    return $result;

});
