<?php

namespace Frc\WP\Base\Theme\DisableUpdateChecks;

function disable_update_checks() {

    // Disable core updates
    remove_action('admin_init', '_maybe_update_core');
    remove_action('wp_version_check', 'wp_version_check');
    remove_action('wp_maybe_auto_update', 'wp_maybe_auto_update');
    remove_action('admin_init', 'wp_maybe_auto_update');
    remove_action('admin_init', 'wp_auto_update_core');

    // Disable theme updates
    remove_action('load-plugins.php', 'wp_update_plugins');
    remove_action('load-update.php', 'wp_update_plugins');
    remove_action('load-update-core.php', 'wp_update_plugins');
    remove_action('admin_init', '_maybe_update_plugins');
    remove_action('wp_update_plugins', 'wp_update_plugins');

    // Disable plugin updates
    remove_action('load-themes.php', 'wp_update_themes');
    remove_action('load-update.php', 'wp_update_themes');
    remove_action('load-update-core.php', 'wp_update_themes');
    remove_action('admin_init', '_maybe_update_themes');
    remove_action('wp_update_themes', 'wp_update_themes');

    // Disable updates from plugins
    remove_action('update_option_WPLANG', 'wp_clean_update_cache');

    // Disable Language Pack Upgrader
    remove_action('upgrader_process_complete', array( 'Language_Pack_Upgrader', 'async_upgrade' ), 20 );
    remove_action('upgrader_process_complete', 'wp_version_check' );
    remove_action('upgrader_process_complete', 'wp_update_plugins' );
    remove_action('upgrader_process_complete', 'wp_update_themes' );

}

function hide_wordpress_update_notices() {
    remove_action( 'admin_notices', 'update_nag', 3 );
}

add_action( 'admin_init', __NAMESPACE__ . '\\disable_update_checks' );
add_action( 'admin_menu', __NAMESPACE__ . '\\hide_wordpress_update_notices' );

remove_action('init', 'wp_schedule_update_checks');
remove_action('init', 'wp_check_browser_version');
