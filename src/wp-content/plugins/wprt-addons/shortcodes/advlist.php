<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $data = $list_css = $inner_css = $inner_content_css = '';
$icon_cls = $icon_css = $icon_html = $content_html = '';

extract( shortcode_atts( array(
	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',
	'icon_type' => '',
	'icon' => '',
	'icon_style' => 'simple',
	'icon_bg' => '',
	'icon_width' => '',
	'icon_height' => '',
	'icon_line_height' => '',
	'icon_rounded' => '',
	'icon_color' => '',
	'icon_font_size' => '',
	'icon_position' => 'icon-middle',
	'icon_top_margin' => '',
	'content_color' => '',
	'content_left_padding' => '30',
	'content_padding' => '',
	'content_bottom_margin' => '',
	'content_background_color' => '',
	'content_border_style' => 'solid',
	'content_border_color' => '',
	'content_border_width' => '',
	'content_font_family' => 'Default',
	'content_font_weight' => 'Default',
	'content_font_size' => '',
	'content_line_height' => '',
), $atts ) );

$icon_font_size = intval( $icon_font_size );
$icon_top_margin = intval( $icon_top_margin );
$content_left_padding = intval( $content_left_padding );
$content_font_size = intval( $content_font_size );
$content_line_height = intval( $content_line_height );
$icon_width = intval( $icon_width );
$icon_height = intval( $icon_height );
$icon_line_height = intval( $icon_line_height );
$icon_rounded = intval( $icon_rounded );
$content_bottom_margin = intval( $content_bottom_margin );

$cls = $icon_position;
if ( $content_font_weight != 'Default' ) $inner_content_css .= 'font-weight:'. $content_font_weight .';';
if ( $content_font_size ) $inner_content_css .= 'font-size:'. $content_font_size .'px;';
if ( $content_line_height ) $inner_content_css .= 'line-height:'. $content_line_height .'px;';
if ( $content_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $content_font_family );
	$inner_content_css .= 'font-family:'. $content_font_family .';';
}

if ( $content_left_padding ) $inner_css .= 'padding-left:'. $content_left_padding .'px;';
if ( $content_color ) $inner_css .= 'color:'. $content_color;

if ( $content_padding ) $list_css .= 'padding:'. $content_padding .';';
if ( $content_bottom_margin ) $list_css .= 'margin-bottom:'. $content_bottom_margin .'px;';
if ( $content_background_color ) $list_css .= 'background-color:'. $content_background_color .';';
if ( $content_border_color ) $list_css .= 'border-color:'. $content_border_color .';';
if ( $content_border_width ) $list_css .= 'border-width:'. $content_border_width .';border-style:'. $content_border_style .';';

$icon = agrikole_get_icon_class( $atts, 'icon' );
if ( $icon && $icon_type != '' ) {
	vc_icon_element_fonts_enqueue( $icon_type );

	if ( $icon_color == '#eddd5e' ) { $icon_cls .= ' accent'; }
	else { if ( $icon_color ) $icon_css .= 'color:'. $icon_color .';'; }
	
	if ( $icon_font_size ) $icon_css .= 'font-size:'. $icon_font_size .'px;';
	if ( $icon_top_margin ) $icon_css .= 'margin-top:'. $icon_top_margin .'px;';
	if ( $icon_bg ) $icon_css .= 'background:'. $icon_bg .';';
	if ( $icon_width ) $icon_css .= 'width:'. $icon_width .'px;';
	if ( $icon_height ) $icon_css .= 'height:'. $icon_height .'px;';
	if ( $icon_line_height ) $icon_css .= 'line-height:'. $icon_line_height .'px;';
	if ( $icon_rounded ) $icon_css .= 'border-radius:'. $icon_rounded .'px;';

	$icon_html = sprintf(
		'<span class="icon %3$s" style="%2$s">
			<i class="%1$s"></i>
		</span>',
		$icon,
		$icon_css,
		$icon_cls
	);
}

if ( $content )
	$content_html = sprintf(
		'<span style="%2$s">%1$s</span>',
		$content,
		$inner_content_css
	);

if ( $animation ) {
	$cls .= ' wow '. $animation_effect;
	$data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

printf(
	'<div class="agrikole-list clearfix %1$s" %6$s>
		<div style="%3$s">
			<span style="%2$s">%4$s %5$s</span>
		</div>
	</div>',
	$cls,
	$inner_css,
	$list_css,
	$icon_html,
	$content_html,
	$data
);
