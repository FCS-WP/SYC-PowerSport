<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

extract( shortcode_atts( array(
    'desktop_height' => '',
    'mobile_height' => '',
    'smobile_height' => ''
), $atts ) );

$desktop_height = intval( $desktop_height );
$mobile_height = intval( $mobile_height );
$smobile_height = intval( $smobile_height );

printf( '
	<div class="agrikole-spacer clearfix" data-desktop="%1$s" data-mobi="%2$s" data-smobi="%3$s"></div>',
	esc_html( $desktop_height ),
	esc_attr( $mobile_height ),
	esc_attr( $smobile_height )
);