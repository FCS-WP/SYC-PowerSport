<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

extract( shortcode_atts( array(
	'style' => 'style-1',
    'items' => '3',
), $atts ) );

printf( '
	<div class="agrikole-iconboxs group-%2$s clearfix %3$s"><div class="inner-wrap">%1$s</div></div>',
	do_shortcode($content),
	$items,
	$style
);