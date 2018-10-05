<?php

namespace Frc\WP\Base\Theme\DisableRESTApi;

use WP_Error;

add_filter( 'rest_authentication_errors', function( $result ) {

	if ( ! is_user_logged_in() ) {
		return new WP_Error( 'rest_forbidden', __( 'Sorry, you are not allowed to do that.' ), array( 'status' => rest_authorization_required_code() ) );
    }

    return $result;

});
