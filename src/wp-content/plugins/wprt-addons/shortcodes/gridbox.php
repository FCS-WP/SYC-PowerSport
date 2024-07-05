<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $data = '';

extract( shortcode_atts( array(
	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',
	'grid' => '3',
    'border_type' => 'separator',
    'border_color' => 'light',
    'gapv' => '30',
    'gaph' => '15',
), $atts ) );
$content = wpb_js_remove_wpautop($content, true);

$cls = 'grid'. $grid .' border-'. $border_color .' v-'. $gapv .' h-'. $gaph;
if ( $border_type == 'separator' ) $cls .= ' no-border-wrap';
if ( $border_type == 'no' ) $cls .= ' no-borders';

if ( $animation ) {
	$cls .= ' wow '. $animation_effect;
	$data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

printf(
	'<div class="agrikole-grid-box clearfix %2$s" data-grid="%3$s" %4$s>
		%1$s
	</div>',
	do_shortcode($content),
	$cls,
	$grid,
	$data
);