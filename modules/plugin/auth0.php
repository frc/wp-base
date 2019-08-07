<?php

namespace Frc\WP\Base\Plugin\Auth0;

use Frc\WP\Base as helpers;

function enqueue_styles() {
    wp_enqueue_style('base/login-auth0', helpers\asset_path('styles/login-auth0.css'), false, null);

    $options = helpers\get_options(__FILE__);

    if ( !empty($options['primaryColor']) ) {
        wp_add_inline_style('base/login-auth0', "
.auth0-lock.auth0-lock .auth0-lock-header-bg.auth0-lock-header-bg {
    background: {$options['primaryColor']} !important;
}
        ");
    }

    if ( isset($options['header']) && $options['header'] === false ) {
        wp_add_inline_style('base/login-auth0', "
#auth0-login-form {
    min-height: 125px;
}
.auth0-lock.auth0-lock .auth0-lock-header {
    display: none !important;
}
        ");
    }
}
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles', 999 );

function login_message($html) {

    $options = helpers\get_options(__FILE__);

    $options['language'] =  $options['language'] ?? substr(get_locale(), 0, 2);

    wp_register_script( 'dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'dummy-handle-footer'  );

    if ( !empty($options['language']) ) {
        wp_add_inline_script( 'dummy-handle-footer', "wpAuth0LockGlobal.settings.language = '{$options['language']}';");
    }

    wp_add_inline_script( 'dummy-handle-footer', "wpAuth0LockGlobal.settings.theme = {};");

    if ( !empty($options['logo']) ) {
        wp_add_inline_script( 'dummy-handle-footer', "wpAuth0LockGlobal.settings.theme.logo = '{$options['logo']}';");
    }

    if ( isset($options['logo']) && $options['logo'] === false ) {
        wp_add_inline_script( 'dummy-handle-footer', "wpAuth0LockGlobal.settings.theme.logo = '';");
    }

    if ( !empty($options['primaryColor']) ) {
        wp_add_inline_script( 'dummy-handle-footer', "wpAuth0LockGlobal.settings.theme.primaryColor = '{$options['primaryColor']}';");
    }

    if ( isset($options['title']) ) {
        wp_add_inline_script( 'dummy-handle-footer', "wpAuth0LockGlobal.settings.languageDictionary = { title: '{$options['title']}' };");
    }

    return $html;
}

add_filter( 'login_message', __NAMESPACE__ . '\\login_message');

function gettext($translation, $text, $domain) {

    if ( $domain !== 'wp-auth0' ) {
        return $translation;
    }

    if ( get_locale() !== 'fi' ) {
        return $translation;
    }

    switch($text) {
        case 'Login with WordPress username':
            return 'Kirjaudu WordPress-tunnuksilla';
        case '← Back to %s login':
            return '← %s kirjautuminen';
    }

    return $translation;
}
add_filter( 'gettext', __NAMESPACE__ . '\\gettext', 10, 3 );
