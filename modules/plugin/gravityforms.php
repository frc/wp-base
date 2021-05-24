<?php

namespace Frc\WP\Base\Plugin\GravityForms;

/**
 * Disable Gravity Forms stylesheets and enable HTML5
 */
function set_gforms_settings() {
    update_option('rg_gforms_disable_css', true);
    update_option('rg_gforms_enable_html5', true);
}
add_action('after_switch_theme', __NAMESPACE__ . '\\set_gforms_settings');

/**
 * Allow Gravity Forms access to 'editor' role
 */
function add_gforms_enable_editor_role() {
    $role = get_role('editor');
    $role->add_cap('gform_full_access');
}
add_action('after_switch_theme', __NAMESPACE__ . '\\add_gforms_enable_editor_role');

/**
 * Disable default admin notification
 *
 * @link https://docs.gravityforms.com/gform_default_notification/
 */
add_filter('gform_default_notification', '__return_false');

/**
 * Override default notification_from value {admin_email} with empty string
 */
function override_gforms_notification_default_sender($ui_settings, $notification, $form) {
    if (isset($ui_settings['notification_from'])) {
        $ui_settings['notification_from'] = str_replace('{admin_email}', '', $ui_settings['notification_from']);
    }
    return $ui_settings;
}
add_filter('gform_notification_ui_settings', __NAMESPACE__ . '\\override_gforms_notification_default_sender', 10, 3);

/**
 * Automatically set settings for new forms
 *
 * @param $form
 * @param $is_new
 */
function force_gforms_settings($form, $is_new) {
    if ($is_new) {
        // Enable honeypot
        $form['enableHoneypot'] = true;
        // Set labels above
        $form['subLabelPlacement'] = 'above';
        // Set descriptions above
        $form['descriptionPlacement'] = 'above';
        // Form inactivates automatically if we don't force it active
        // http://inlinedocs.gravityhelp.com/source-class-GFAPI.html#209
        $form['is_active'] = true;
        \GFAPI::update_form($form);
    }
}
add_action('gform_after_save_form', __NAMESPACE__ . '\\force_gforms_settings', 10, 2);

/**
 * Disable bad Gravity Forms field types
 */
function disable_bad_gforms_fields($field_groups) {
    $disable = [
        'standard_fields' => ['list'],
        'advanced_fields' => ['name']
    ];
    foreach ($field_groups as $gkey => $field_group) {
        if (!isset($disable[$field_group['name']])) continue;
        foreach ($field_group['fields'] as $key => $field) {
            if (in_array($field['data-type'], $disable[$field_group['name']])) {
                unset($field_groups[$gkey]['fields'][$key]);
            }
        }
    }
    return array_values($field_groups);
}
add_filter('gform_add_field_buttons', __NAMESPACE__ . '\\disable_bad_gforms_fields');

/**
 * Bypass Gravity Forms secure link generation because of the S3 integration
 *
 * @link https://www.gravityhelp.com/documentation/article/gform_secure_file_download_location/
 */
add_filter('gform_secure_file_download_location', '__return_false', 10, 3);
