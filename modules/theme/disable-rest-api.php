<?php

namespace Frc\WP\Base\Theme\DisableRESTApi;

use WP_Error;

/**
 * Options example:
 * $options = [
 *     'disabled' => ['/'],
 *     'allowed' => ['posts'],
 *     'authenticated' => [
 *          'disabled' => ['/'],
 *          'allowed' => ['posts'],
 *      ]
 * ];
 */

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

    if ( isset($options['authenticated']) && is_array($options['authenticated']) ) {

        $authenticated = $options['authenticated'];
        if (isset($authenticated['disabled']) && is_array($authenticated['disabled'])) {
            add_filter('frc/base/rest/authenticated/disabled', function ($items) use ($authenticated) {
                return array_merge($items, $authenticated['disabled']);
            });
        }

        if (isset($authenticated['allowed']) && is_array($authenticated['allowed'])) {
            add_filter('frc/base/rest/authenticated/allowed', function ($items) use ($authenticated) {
                return array_merge($items, $authenticated['allowed']);
            });
        }
    }

}

function get_current_route() {

    $rest_route = $GLOBALS['wp']->query_vars['rest_route'];

    return ( empty( $rest_route ) || '/' == $rest_route ) ? $rest_route : untrailingslashit( $rest_route );

}

function is_whitelisted($router, $authenticated = false) {

    $disabled = "frc/base/rest/disabled";
    $allowed = "frc/base/rest/allowed";

    if ($authenticated) {
        $disabled = "frc/base/rest/authenticated/disabled";
        $allowed  = "frc/base/rest/authenticated/allowed";
    }

    $blocked = apply_filters($disabled, []);
    $allowed = apply_filters($allowed, []);

    foreach( $blocked as $item ) {
        if ( !in_array($item, $allowed) && strpos($router, $item) !== false ) {
            return false;
        }
    }

    return true;

}

add_filter( 'rest_authentication_errors', function( $result ) {
    $current_route = get_current_route();

    if ( is_user_logged_in() ) {
        if ( is_super_admin() ) {
            return $result;
        }

        if (!is_whitelisted($current_route, true)) {
            return new WP_Error('rest_forbidden', __('Sorry, you are not allowed to do that.'), ['status' => rest_authorization_required_code()]);
        }

        return $result;
    }

    if ( ! empty( $current_route ) && !is_whitelisted( $current_route ) ) {
        return new WP_Error( 'rest_forbidden', __( 'Sorry, you are not allowed to do that.' ), array( 'status' => rest_authorization_required_code() ) );
    }

    return $result;

});
