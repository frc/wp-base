<?php

namespace Frc\WP\Base;

function get_feature_id($side, $module) {
    return sprintf('%s%s-%s', FRC_WP_BASE_FEATURE_PREFIX, $side, $module);
}

function is_env($env) {

    return strtolower(WP_ENV) === strtolower($env);

}

function frc_is_plugin_active($plugin) {

    if ( !function_exists('is_plugin_active') ) {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

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

    if ( isset($mapper[$name]) ) {
        return $mapper[$name];
    }

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

    if ( isset($mapper[$name]) ) {
        return $mapper[$name];
    }

    return $name . '/' . $name . '.php';

}

function asset_path($path) {

    return plugins_url( 'assets/' . $path , dirname(__DIR__) . '/plugin.php' );

}

function get_options($path) {

    $dir = pathinfo(dirname($path));
    $file = pathinfo($path);

    $feature = get_feature_id($dir['filename'], $file['filename']);

    $options = get_theme_support($feature);
    if ( isset($options[0]) && is_array($options[0]) ) {
        return $options[0];
    }

    return [];

}
