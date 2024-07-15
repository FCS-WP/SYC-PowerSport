<?php
/**
 * @version 1.0
 * @package Booking Calendar
 * @subpackage  Nonce functions - excluding from  front-end
 * @category    Functions
 *
 * @author wpdevelop
 * @link https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2024-06-14
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

//FixIn: 10.1.1.2

// =====================================================================================================================
// ==  Nonce functions  ==
// =====================================================================================================================

/**
 * Is use nonce fields at Front-Edn side in king forms
 * If we do not use nonce,  then  it can  prevent issues on websites with  cache plugins regarding these Errors: Forbidden (403) Probably nonce for this page has been expired.
 *                                                                                                     or Error: Request do not pass security check! Please refresh the page and try one more time. Please check more here https://wpbookingcalendar.com/faq/request-do-not-pass-security-check/
 * Find more information at these pages:    https://konstantin.blog/2012/nonces-on-the-front-end-is-a-bad-idea/
 *                                          https://contactform7.com/2017/08/18/contact-form-7-49/
 *                                          https://developer.wordpress.org/apis/security/nonces/
 *
 * @return bool
 */
function wpbc_is_use_nonce_at_front_end() {
	return( 'On' === get_bk_option( 'booking_is_nonce_at_front_end' ) );
}

// ---------------------------------------------------------------------------------------------------------------------
//    S u p p o r t    f u n c t i o n s    f o r     A j a x    ///////////////
// ---------------------------------------------------------------------------------------------------------------------

/**
 * Verify the nonce in Admin Panel          - during Ajax request
 *
 * @param $action_check
 *
 * @return bool|void
 */
function wpbc_check_nonce_in_admin_panel( $action_check = 'wpbc_ajax_admin_nonce' ){

    $nonce = ( isset($_REQUEST['wpbc_nonce']) ) ? $_REQUEST['wpbc_nonce'] : '';

	if ( '' === $nonce ) return false;	// Its was request  from  some other plugin										//FixIn: 7.2.1.10

    if ( ! wp_verify_nonce( $nonce, $action_check ) ) {                         										// This nonce is not valid.
        ?>
        <script type="text/javascript">
			if (jQuery("#ajax_respond").length > 0 ){
				jQuery( "#ajax_respond" ).after( "<div class='wpdevelop'><div style='margin: 0 0 40px;' class='wpbc-general-settings-notice wpbc-settings-notice notice-error 0alert 0alert-warning 0alert-danger'><?php

					echo '<strong>' . esc_js( __( 'Error' , 'booking') ) . '!</strong> ';

					echo  sprintf( esc_js( __( 'Probably nonce for this page has been expired. Please %sreload the page%s.', 'booking' ) )
							,"<a href='javascript:void(0)' onclick='javascript:location.reload();'>", "</a>");

					echo '<br/>' . sprintf( esc_js(  __( 'Please check more here %s', 'booking' ) )
													, "<a href='https://wpbookingcalendar.com/faq/request-do-not-pass-security-check/?update=" . WP_BK_VERSION_NUM . '&ver=' . wpbc_get_version_type__and_mu(). "'>FAQ</a>"
									);        //FixIn: 8.8.3.6

					?></div></div>" );
			} else if (jQuery(".ajax_respond_insert").length > 0 ){
				jQuery( ".ajax_respond_insert" ).after( "<div class='wpdevelop'><div class='alert alert-warning alert-danger'><?php
					printf( __( '%sError!%s Request do not pass security check! Please refresh the page and try one more time.', 'booking' ), '<strong>', '</strong>' );
					echo '<br/>' . sprintf( __( 'Please check more here %s', 'booking' ), 'https://wpbookingcalendar.com/faq/request-do-not-pass-security-check/?update=' . WP_BK_VERSION_NUM . '&ver=' . wpbc_get_version_type__and_mu() );        //FixIn: 8.8.3.6
					?></div></div>" );
			}
			if ( jQuery( "#ajax_message" ).length ){
				jQuery( "#ajax_message" ).slideUp();
			}
        </script>
        <?php
        die;
    }
	return  true;																										//FixIn: 7.2.1.10
}


// ---------------------------------------------------------------------------------------------------------------------
// For test only,  where Nonce time can  be adjusted
// ---------------------------------------------------------------------------------------------------------------------
// add_filter( 'nonce_life', 'wpbc_nonce_life_test' );
//function wpbc_nonce_life_test( $lifespan ) {
//	return 60;  //4 * HOUR_IN_SECONDS;
//}


function wpbc_do_not_cache() {

	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}

	if ( ! defined( 'DONOTCACHEDB' ) ) {
		define( 'DONOTCACHEDB', true );
	}

	if ( ! defined( 'DONOTMINIFY' ) ) {
		define( 'DONOTMINIFY', true );
	}

	if ( ! defined( 'DONOTCDN' ) ) {
		define( 'DONOTCDN', true );
	}

	if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
		define( 'DONOTCACHEOBJECT', true );
	}

	// Set the headers to prevent caching for the different browsers.
	nocache_headers();
}
//wpbc_do_not_cache();


// =====================================================================================================================
// Exclude from  Minify  and caching from  different CACHE Plugins
// =====================================================================================================================

/**
 * Add exclusion  of minify JS files in 'WP-Optimize' plugin            //FixIn: 10.1.3.3
 *
 *  Otherwise default rules:
 *  *plugins/booking*
 *  *jquery/jquery.min.js
 *  *jquery/jquery-migrate.min.js
 *
 * @param $excluded_filter_arr
 *
 * @return mixed
 */
function wpbc_exclude_for_wp_optimize( $excluded_filter_arr ) {

	if ( is_array( $excluded_filter_arr ) ) {
		$excluded_filter_arr[] = '*/plugins/booking*';
		$excluded_filter_arr[] = '*/jquery/jquery.min.js';
		$excluded_filter_arr[] = '*/jquery/jquery-migrate.min.js';
	}

	return $excluded_filter_arr;
}
add_filter( 'wp-optimize-minify-default-exclusions', 'wpbc_exclude_for_wp_optimize', 10, 1 );