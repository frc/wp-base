<?php

namespace Frc\WP\Base\Admin\Defaults;

function move_excerpt_meta_box($post) {

    if ( has_action('edit_form_after_title', 'frc_move_excerpt_meta_box') ) {
        return;
    }

    if ( post_type_supports($post->post_type, 'excerpt') ) {
        remove_meta_box('postexcerpt', $post->post_type, 'normal');

        echo '<div class="postbox excerpt-postbox"><h2 class="hndle">' . __('Excerpt') . '</h2><div class="inside">';
        post_excerpt_meta_box($post);
        echo '</div></div>';
    }

}
add_action('edit_form_after_title', __NAMESPACE__ . '\\move_excerpt_meta_box');
