<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$html = $cls = $css = $text_css = $value_css = '';

extract( shortcode_atts( array(
	'background' => '#f5f5f5',
	'border_color' => '#b2b2b2',
	'border_width' => '1px 0px 1px 0px',
	'border_style' => 'solid',
	'padding' => '',
	'bottom_margin' => '10',
	'text' => '',
	'text_color' => '',
	'value' => '',
	'value_color' => '',
	'text_font_family' => 'Default',
	'text_font_weight' => 'Default',
	'text_font_size' => '',
	'value_font_family' => 'Default',
	'value_font_weight' => 'Default',
	'value_font_size' => '',
), $atts ) );

$bottom_margin = intval( $bottom_margin );
$text_font_size = intval( $text_font_size );

$css .= 'border-style:'. $border_style .';';
if ( $padding ) $css .= 'padding:'. $padding .';';

if ( $border_color && $border_width ) $css .= 'border-width:'. $border_width .';border-color:'. $border_color .';';
if ( $background ) $css .= 'background-color:'. $background .';';
if ( $bottom_margin ) $css .= 'margin-bottom:'. $bottom_margin .'px;';

if ( $text_font_weight != 'Default' ) $text_css .= 'font-weight:'. $text_font_weight .';';
if ( $text_color ) $text_css .= 'color:'. $text_color .';';
if ( $text_font_size ) $text_css .= 'font-size:'. $text_font_size .'px;';
if ( $text_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $text_font_family );
	$text_css .= 'font-family:'. $text_font_family .';';
}

if ( $value_font_weight != 'Default' ) $value_css .= 'font-weight:'. $value_font_weight .';';
if ( $value_color ) $value_css .= 'color:'. $value_color .';';
if ( $value_font_size ) $value_css .= 'font-size:'. $value_font_size .'px;';
if ( $value_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $value_font_family );
	$value_css .= 'font-family:'. $value_font_family .';';
}

if ( $text ) {
	$html .= sprintf('
		<span class="text" style="%1$s">
			%2$s
		</span>',
		$text_css,
		$text
	);	
}

if ( $value ) {
	$html .= sprintf('
		<span class="value" style="%1$s">
			%2$s
		</span>',
		$value_css,
		$value
	);	
}

printf(
	'<div class="agrikole-menu-list clearfix %1$s" style="%2$s">%3$s</div>',
	$cls,
	$css,
	$html 
);