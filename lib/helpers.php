<?php

namespace Frc\WP\Base;

function is_env($env) {
    return defined('WP_ENV') && WP_ENV === $env;
}

function is_production() {
    return !defined('WP_ENV') || is_env('production');
}

function frc_is_plugin_active($plugin) {
    if ( !function_exists('is_plugin_active') )
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

    return is_plugin_active(
        frc_locate_plugin($plugin)
    );
}

function frc_plugin_alias($name) {
    $mapper = [
        'advanced-custom-fields-pro' => 'acf',
        'yoast' => 'wordpress-seo',
        'gravity-forms' => 'gravityforms',
    ];

    if ( isset($mapper[$name]) )
        return $mapper[$name];
    return $name;
}

function frc_locate_plugin($name) {
    $name = frc_plugin_alias($name);

    $mapper = [
        'acf' => 'advanced-custom-fields-pro/acf.php',
        'auth0' => 'auth0/WP_Auth0.php',
        'wordpress-seo' => 'wordpress-seo/wp-seo.php',
        'wp-no-admin-ajax' => 'wp-no-admin-ajax/plugin.php',
    ];

    if ( isset($mapper[$name]) )
        return $mapper[$name];

    return $name . '/' . $name . '.php';
}

function asset_path($path) {
    return plugins_url( 'assets/' . $path , dirname(__DIR__) . '/plugin.php' );
}
