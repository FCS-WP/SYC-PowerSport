<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$data = $css = $cls = '';

extract( shortcode_atts( array(
	'alignment' => '',
	'tag' => 'h2',
    'heading' => '',
    'color' => '',
    'max_width' => '',
    'bottom_margin' => '',
	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',
	'font_family' => 'Default',
	'font_weight' => 'Default',
	'font_size' => '',
	'line_height' => '',
), $atts ) );
$content = wpb_js_remove_wpautop($content, true);

$font_size = intval( $font_size );
$line_height = intval( $line_height );
$max_width = intval( $max_width );
$bottom_margin = intval( $bottom_margin );

$cls .= $alignment;

if ( $font_family != 'Default' ) {
	agrikole_enqueue_google_font( $font_family );
	$css .= 'font-family:'. $font_family .';';
}
if ( $font_weight != 'Default' ) $css .= 'font-weight:'. $font_weight .';';
if ( $font_size ) $css .= 'font-size:'. $font_size .'px;';
if ( $line_height ) $css .= 'line-height:'. $line_height .'px;';
if ( $color ) $css .= 'color:'. $color .';';
if ( $bottom_margin ) $css .= 'margin-bottom:'. $bottom_margin .'px;';

if ( $max_width ) {
	$css .= 'max-width:'. $max_width .'px;';
	if ( $alignment == 'text-center' ) $css .= 'margin-left: auto; margin-right: auto;';
}

if ( $animation ) {
	$cls .= ' wow '. $animation_effect;
	$data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

printf(
	'<%4$s class="agrikole-text clearfix %2$s" style="%3$s">%1$s</%4$s>',
	$content,
	$cls,
	$css,
	$tag
);