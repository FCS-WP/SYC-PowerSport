<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = '';

extract( shortcode_atts( array(
    'auto_scroll' => 'true',
    'gap' => '30',
    'padding' => '15',
    'slide' => '3',
    'show_bullets' => '',
    'bullet_between' => '50',
), $atts ) );

$cls .= 'gap-'. $gap;
if ( $padding ) $padding = $padding .'%';
if ( $bullet_between == '50' ) $cls .= ' bullet50';
if ( $bullet_between == '40' ) $cls .= ' bullet40';
if ( $bullet_between == '30' ) $cls .= ' bullet30';
if ( $bullet_between == '20' ) $cls .= ' bullet20';
if ( $bullet_between == '10' ) $cls .= ' bullet10';
if ( $bullet_between == '0' ) $cls .= ' bullet0';

wp_enqueue_script( 'agrikole-slick' );
printf(
    '<div class="agrikole-center-carousel-box %1$s" data-auto="%3$s" data-gap="%4$s" data-padding="%5$s" data-slide="%6$s">
        %2$s
	</div>',
    $cls,
	do_shortcode( $content ),
    $auto_scroll,
    intval( $gap ),
    $padding,
    $slide
);