<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

extract( shortcode_atts( array(
    'auto_scroll' => 'false',
    'loop' => 'false',
    'gap' => '30',
    'show_bullets' => '',
    'show_arrows' => '',
    'arrow_style' => 'arrow-style-1',
    'arrow_position' => 'center',
    'arrow_between' => '50',
    'bullet_between' => '50',
    'arrow_offset' => 'center',
    'arrow_offset_v' => '0',
    'arrow_offset_s' => '50',
    'column'        => '3c',
    'column2'       => '2c',
    'column3'       => '1c'
), $atts ) );

$gap = intval( $gap );
$column = intval( $column );
$column2 = intval( $column2 );
$column3 = intval( $column3 );

$cls = $arrow_style .' arrow-'. $arrow_position .' offset'. $arrow_offset .' offset-v'. $arrow_offset_v;
if ( $show_bullets ) $cls .= ' has-bullets'; 
if ( $show_arrows ) $cls .= ' has-arrows';
if ( $arrow_offset_s ) $cls .= ' arrow'.$arrow_offset_s;

if ( $bullet_between == '45' ) $cls .= ' bullet45';
if ( $bullet_between == '40' ) $cls .= ' bullet40';
if ( $bullet_between == '35' ) $cls .= ' bullet35';
if ( $bullet_between == '30' ) $cls .= ' bullet30';
if ( $bullet_between == '25' ) $cls .= ' bullet25';
if ( $bullet_between == '20' ) $cls .= ' bullet20';
if ( $bullet_between == '15' ) $cls .= ' bullet15';
if ( $bullet_between == '10' ) $cls .= ' bullet10';

wp_enqueue_script( 'agrikole-owlcarousel' );

printf(
    '<div class="agrikole-carousel-box %8$s" data-auto="%5$s" data-loop="%6$s" data-gap="%7$s" data-column="%2$s" data-column2="%3$s" data-column3="%4$s">
        <div class="owl-carousel owl-theme">%1$s</div>
	</div>',
	do_shortcode( $content ),
    $column,
    $column2,
    $column3,
    $auto_scroll,
    $loop,
    $gap,
    $cls
);