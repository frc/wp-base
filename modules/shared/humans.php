<?php

namespace Frc\WP\Base\Shared\Humans;

use Frc\WP\Base as helpers;

add_action('init', function() {
    add_rewrite_rule('^humans\.txt$', 'index.php?humanstxt=true', 'top');
});

add_action('wp_head', function() {
    echo '<link rel="author" href="'. home_url('humans.txt'). '">' . "\n";
});

add_action('template_redirect', function() {

    if ( !get_query_var('humanstxt') ) {
        return;
    }

    $options = helpers\get_options(__FILE__);

    $content = file_get_contents(__DIR__ . '/humans.txt');

    $content = str_replace(':year', date('Y'), $content);

    $tab = "            ";
    $break = "\n";

    $team = $break;

    $teams = $options['team'] ?? [];

    foreach($teams as $title => $items) {

        // Print titles
        if ( is_string($title) ) {
            $team .= $tab. mb_strtoupper($title) . $break;
            $team .= $break;
        }

        // Print names
        if ( is_array($items) ) {
            $items = array_filter($items);
            foreach($items as $name) {
                $team .= $tab . $name . $break;
            }
        }

        // Print single
        if ( is_string($items) ) {
            $team .= $tab . $items . $break;
        }

        // End with line break
        $team .= $break;
    }

    $content = str_replace(':team', $team, $content);

    header('Content-Type: text/plain; charset=utf-8');
    echo $content;
    exit();
});

add_filter('query_vars', function($vars) {
    $vars[] = 'humanstxt';
    return $vars;
});

function redirect_canonical_callback( $redirect_url, $requested_url ) {
    $disable = get_query_var('humanstxt');
    if ( $disable ) {
        return $requested_url;
    }
    return $redirect_url;
}

add_filter('redirect_canonical', __NAMESPACE__ . '\\redirect_canonical_callback', 10, 2 );
