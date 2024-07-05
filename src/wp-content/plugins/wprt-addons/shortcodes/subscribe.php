<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css = '';

extract( shortcode_atts( array(
	'style' => 'style-1',
	'alignment' => '',
	'width' => '',
), $atts ) );

if ( $width ) {
	$css .= 'max-width:'. intval( $width ) .'px;';
	if ( $alignment == 'text-center' )
		$css .= 'margin-left: auto; margin-right: auto;';
}

if ( class_exists('MC4WP_MailChimp') ) {
	echo '<div class="agrikole-subscribe clearfix '. $style .'" style="'. $css .'">';
	echo '<div class="form-wrap">';
	mc4wp_show_form(0);
	echo '</div>';
	echo '</div>';
}