<?php

namespace Frc\WP\Base\Plugin\Auth0;

function enqueue_styles() {
    wp_enqueue_style('base/login-auth0', frc_base_asset_path('styles/login-auth0.css'), false, null);
}
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles' );
