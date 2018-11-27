<?php

namespace Frc\WP\Base\Theme\Defaults;

/**
 * Remove links from images by default
 *
 * @link http://andrewnorcross.com/tutorials/stop-hyperlinking-images/
 */
function remove_image_links() {
    update_option('image_default_link_type', 'none');
}
add_action('after_switch_theme', __NAMESPACE__ . '\\remove_image_links');
