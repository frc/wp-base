<?php

namespace Frc\WP\Base\Theme\Meta;

use Frc\WP\Base as helpers;

function add_meta() {

    $options = helpers\get_options(__FILE__);

    if ( empty($options) || !is_array($options) ) {
        return;
    }

    foreach($options as $name => $content) {
        $content = apply_filters("frc/base/theme/meta=$name", $content);
        echo '<meta name="' . esc_attr($name) . '" content="' . esc_attr($content) . '">' . "\n";
    }

}
add_action('wp_head', __NAMESPACE__ . '\\add_meta');
