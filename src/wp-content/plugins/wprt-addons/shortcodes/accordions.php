<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

extract( shortcode_atts( array(
    'type' => 'accordions',
), $atts ) );

printf( '
	<div class="agrikole-accordions %2$s">%1$s</div>',
	do_shortcode($content),
	$type
);