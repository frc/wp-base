<?php

namespace Frc\WP\Base\DefaultsTinymc;

/**
 * Always show second bar
 */
function show_tinymce_toolbar($settings) {
    $settings['wordpress_adv_hidden'] = false;
    return $settings;
}
add_filter('tiny_mce_before_init', __NAMESPACE__ . '\\show_tinymce_toolbar');

/*
 * Enable style select
 */
function show_tinymce_buttons_2($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', __NAMESPACE__ . '\\show_tinymce_buttons_2');

/**
 * Remove redundant buttons
 */
function remove_tinymce_buttons1($buttons) {
    // Remove more separator and second bar toggle
    $remove = ['wp_more', 'wp_adv'];

    return array_diff($buttons, $remove);
}
add_filter('mce_buttons', __NAMESPACE__ . '\\remove_tinymce_buttons1');

function remove_tinymce_buttons2($buttons) {
    // Remove text color selector, outdent and indent
    $remove = ['forecolor', 'outdent', 'indent'];

    return array_diff($buttons, $remove);
}
add_filter('mce_buttons_2',  __NAMESPACE__ . '\\remove_tinymce_buttons2');

/**
 *  Remove the h1 tag from the WordPress editor.
 */
function remove_tinymce_h1($settings) {
    $settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre;';

    return $settings;
}
add_filter('tiny_mce_before_init',  __NAMESPACE__ . '\\remove_tinymce_h1');
