<?php

namespace Frc\WP\Base\Login\Expiration;

function login_expiration($seconds, $user_id, $remember) {
    //WP default = 2 weeks;
    $rememberExpiration = 1 * 24 * 60 * 60; //1 day

    //WP default = 2 days;
    $expiration = 12 * 60 * 60; //12 hours

    //if "remember me" is checked;
    if ($remember) {
        $expiration = $rememberExpiration; //UPDATE HERE;
    }

    //http://en.wikipedia.org/wiki/Year_2038_problem
    if (PHP_INT_MAX - time() < $expiration) {
        //Fix to a little bit earlier!
        $expiration = PHP_INT_MAX - time() - 5;
    }

    return $expiration;
}
add_filter('auth_cookie_expiration', __NAMESPACE__ . '\\login_expiration', 99, 3);
