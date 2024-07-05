<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$html = $cls = $css = $data = '';
$heading_css = $heading_cls = '';
$line_cls = $line_css = '';

extract( shortcode_atts( array(
	'alignment' => '',
    'heading' => '',
    'heading_color' => '',
    'heading_padding' => '',
    'heading_bottom_margin' => '',
	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',
	'line_width' => '40',
	'line_height' => '2',
	'line_color' => '#eddd5e',
	'line_top' => '',
	'heading_font_family' => 'Default',
	'heading_font_weight' => 'Default',
	'heading_font_size' => '',
	'heading_line_height' => '',
	'heading_letter_spacing' => ''
), $atts ) );

$line_width = intval( $line_width );
$line_height = intval( $line_height );
$line_top = intval( $line_top );

$heading_font_size = intval( $heading_font_size );
$heading_line_height = intval( $heading_line_height );
$heading_padding = intval( $heading_padding );
$heading_bottom_margin = intval( $heading_bottom_margin );

$cls .= $alignment;

if ( $heading_bottom_margin ) $css .= 'margin-bottom:'. $heading_bottom_margin .'px;';

if ( $line_width ) $line_css .= 'width:'. $line_width .'px;';
if ( $line_height ) $line_css .= 'height:'. $line_height .'px;';
if ( $line_top ) $line_css .= 'top:'. $line_top .'px;';

if ( $line_color == '#eddd5e' ) {
	$line_cls .= 'accent';
} elseif ( $line_color ) {
	$line_css .= 'background-color:'. $line_color .';';
}

if ( $line_width && $line_height ) {
	$html .= sprintf( '<span class="line %2$s" style="%1$s"></span>', $line_css, $line_cls );
	$cls .= ' has-line';
}

if ( $heading_font_weight != 'Default' ) $heading_css .= 'font-weight:'. $heading_font_weight .';';
if ( $heading_color == '#eddd5e' ) { $heading_cls .= ' accent';
} else { if ( $heading_color ) $heading_css .= 'color:'. $heading_color .';'; }
if ( $heading_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $heading_font_family );
	$heading_css .= 'font-family:'. $heading_font_family .';';
}

if ( $heading_font_size ) $heading_css .= 'font-size:'. $heading_font_size .'px;';
if ( $heading_letter_spacing ) $heading_css .= 'letter-spacing:'. $heading_letter_spacing .'px;';

if ( $heading_padding ) $heading_css .= 'padding-left:'. $heading_padding .'px;';

if ( $heading ) $html .= sprintf(
	'<span class="heading clearfix %3$s" style="%2$s">
		%1$s
	</span>',
	$heading,
	$heading_css,
	$heading_cls
);

if ( $animation ) {
	$cls .= ' wow '. $animation_effect;
	$data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

printf(
	'<div class="agrikole-single-heading clearfix %2$s" style="%3$s"><span class="inner">%1$s</span></div>',
	$html,
	$cls,
	$css
);