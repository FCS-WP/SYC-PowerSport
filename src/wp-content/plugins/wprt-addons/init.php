<?php 
/*
Plugin Name: WPRT Addons for Agrikole
Plugin URI: https://ninzio.com/
Description: Adding Hooks, Custom Post Type, VC Shortcodes, Google API - for Agrikole Theme
Version: 1.0
Author: Ninzio Themes
Domain Path: /languages
Author URI: https://ninzio.com/
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin translation
add_action( 'plugins_loaded', 'text_domain_load' );
function text_domain_load() {
    load_plugin_textdomain( 'agrikole', false, dirname( plugin_basename( __FILE__ ) ) .'/languages' );
}

// Enqueue scripts
add_action( 'wp_enqueue_scripts', 'loadCssAndJs', 999999 );
function loadCssAndJs() {
	wp_enqueue_style( 'agrikole-owlcarousel', plugins_url('assets/owl.carousel.css', __FILE__), array(), '2.2.1' );
	wp_register_script( 'agrikole-owlcarousel', plugins_url('assets/owl.carousel.min.js', __FILE__), array('jquery'), '2.2.1', true );

	wp_enqueue_style( 'slick', plugins_url('assets/slick.css', __FILE__), array(), '1.6.0' );
	wp_register_script( 'slick', plugins_url('assets/slick.js', __FILE__), array('jquery'), '1.6.0', true );
	
	wp_enqueue_script( 'agrikole-imagesloaded', plugins_url('assets/imagesloaded.js', __FILE__), array('jquery'), '4.1.3', true );
	wp_enqueue_style( 'agrikole-cubeportfolio', plugins_url('assets/cubeportfolio.min.css', __FILE__), array(), '3.4.0' );
	wp_register_script( 'agrikole-cubeportfolio', plugins_url('assets/cubeportfolio.min.js', __FILE__), array('jquery'), '3.4.0', true );
	wp_register_script( 'agrikole-countto', plugins_url('assets/countto.js', __FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'agrikole-equalize', plugins_url('assets/equalize.min.js', __FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_style( 'agrikole-magnificpopup', plugins_url('assets/magnific.popup.css', __FILE__), array(), '1.0.0' );
	wp_enqueue_script( 'agrikole-magnificpopup', plugins_url('assets/magnific.popup.min.js', __FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_style( 'agrikole-vegas', plugins_url('assets/vegas.css', __FILE__), array(), '2.3.1' );
	wp_register_script( 'agrikole-vegas', plugins_url('assets/vegas.js', __FILE__), array('jquery'), '2.3.1', true );
	wp_enqueue_style( 'agrikole-ytplayer', plugins_url('assets/ytplayer.css', __FILE__), array(), '3.0.2' );
	wp_register_script( 'agrikole-ytplayer', plugins_url('assets/ytplayer.js', __FILE__), array('jquery'), '3.0.2', true );
	wp_register_script( 'agrikole-fittext', plugins_url('assets/fittext.js', __FILE__), array('jquery'), '1.1.0', true );
	wp_register_script( 'agrikole-flowtype', plugins_url('assets/flowtype.js', __FILE__), array('jquery'), '1.3.0', true );
	wp_register_script( 'agrikole-typed', plugins_url('assets/typed.js', __FILE__), array('jquery'), '1.1.0', true );
	wp_register_script( 'agrikole-countdown', plugins_url('assets/countdown.js', __FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'agrikole-appear', plugins_url('assets/appear.js', __FILE__), array('jquery'), '0.3.6', true );
	wp_enqueue_style( 'flickity', plugins_url('assets/flickity.css', __FILE__), array(), '2.2.1' );
	wp_register_script( 'flickity', plugins_url('assets/flickity.js', __FILE__), array('jquery'), '2.2.1', true );
	wp_enqueue_script( 'flickityside', plugins_url('assets/flickityside.js', __FILE__), array('jquery'), '0.1.0', true );
	wp_enqueue_script( 'agrikole-wow', plugins_url('assets/wow.min.js', __FILE__), array('jquery'), '0.3.6', true );
	wp_enqueue_script( 'agrikole-waitforimages', plugins_url('assets/waitforimages.js', __FILE__), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'agrikole-parallaxscroll', plugins_url('assets/parallax-scroll.js', __FILE__), array('jquery'), '0.2.6', true );
	wp_enqueue_script( 'agrikole-shortcode', plugins_url('assets/shortcodes.js', __FILE__), array('jquery'), '1.0', true );
}

// Add image sizes
add_action( 'after_setup_theme', 'add_image_sizes' );
function add_image_sizes() {
	add_image_size( 'agrikole-std1', 640, 640, true );
	add_image_size( 'agrikole-std2', 640, 430, true );
	add_image_size( 'agrikole-square', 370, 370, true );
	add_image_size( 'agrikole-rectangle', 370, 484, true );
	add_image_size( 'agrikole-rectangle1', 270, 354, true );
	add_image_size( 'agrikole-rectangle2', 370, 400, true );
	add_image_size( 'agrikole-rectangle3', 465, 603, true );
}

// Include Icons to Visual Composer
require_once __DIR__ . '/icons.php';

// Map shortcodes to Visual Composer
require_once __DIR__ . '/vc-map.php';

// Include shortcodes files for Visual Composer
foreach ( glob( plugin_dir_path( __FILE__ ) .'/shortcodes/*.php' ) as $file ) {
	$filename = basename( $file );
	$tagname  = str_replace( '-', '_', pathinfo( $file, PATHINFO_FILENAME ) );

	add_shortcode( $tagname, function( $atts, $content = '' ) use( $file, $filename ) {
		ob_start();
		include $file;
		return ob_get_clean();
	} );
}

// Add user contact methods
function agrikole_socials_user_contact_methods() {
	$user_contact['user_facebook']   = esc_html( 'Facebook URL' );
	$user_contact['user_twitter'] = esc_html( 'Twitter URL' );
	$user_contact['user_linkedin'] = esc_html( 'LinkedIn URL' );
	$user_contact['user_pinterest'] = esc_html( 'Pinterest URL' );
	$user_contact['user_instagram'] = esc_html( 'Instagram URL' );

	return $user_contact;
}
add_filter( 'user_contactmethods', 'agrikole_socials_user_contact_methods' );

// Custom Post Type
require_once __DIR__ . '/cpt/init.php';

// Widgets
require_once __DIR__ . '/widgets/init.php';

// Advanced Tabs
require_once __DIR__ . '/shortcodes/advtabs.php';