<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $icon = $icon_html = $icon_css = $data = '';

extract( shortcode_atts( array(
	'style' => 'background',
	'width' => '60',
	'height' => '60',
	'rounded' => '',
	'color' => '',
	'background_color' => '',
	'border_color' => '',
	'border_width' => '',
	'border_style' => 'solid',
	'color_hover' => '',
	'background_color_hover' => '',
	'border_color_hover' => '',
	'margin' => '',
	'icon_type' => '',
	'font_size' => '',
	'line_height' => '',
	'link_url' => '',
	'new_tab' => 'yes'
), $atts ) );

$rand = rand();
$width = intval( $width );
$height = intval( $height );
$rounded = intval( $rounded );
$border_width = intval( $border_width );
$font_size = intval( $font_size );
$line_height = intval( $line_height );

if ( $icon_type ) {
	if ( isset( $atts["icon_{$icon_type}"] ) )
		$icon = $atts["icon_{$icon_type}"];
	vc_icon_element_fonts_enqueue( $icon_type );
}

$cls = 'icon-'. $rand;
if ( $font_size ) $icon_css .= 'font-size:'. $font_size .'px;';
if ( $width ) $icon_css .= 'width:'. $width .'px;';
if ( $height ) $icon_css .= 'height:'. $height .'px;';
if ( $border_style ) $icon_css .= 'border-style:'. $border_style .';';
if ( $border_width ) $icon_css .= 'border-width:'. $border_width .'px;';
if ( $rounded ) $icon_css .= 'border-radius:'. $rounded .'px;';
if ( $line_height ) $icon_css .= 'line-height:'. $line_height .'px;';
if ( $margin ) $icon_css .= 'margin:'. $margin .';';

if ( $color ) $data .= ' data-icon="'. $color .'"';
if ( $background_color ) $data .= ' data-background="'. $background_color .'"';
if ( $border_color ) $data .= ' data-border="'. $border_color .'"';

if ( $background_color_hover ) $data .= ' data-background-hover="'. $background_color_hover .'"';
if ( $border_color_hover ) $data .= ' data-border-hover="'. $border_color_hover .'"';
if ( $color_hover ) $data .= ' data-icon-hover="'. $color_hover .'"';

$icon_html = sprintf(
	'<span class="icon" style="%2$s"><i class="%1$s"></i></span>',
	$icon,
	$icon_css
);

if ( $link_url ) {
	$new_tab == 'yes' ? '_blank' : '_self';

	$icon_html = sprintf(
		'<a class="url-wrap" target="%3$s" href="%2$s">%1$s</a>',
		$icon_html,
		$link_url,
		$new_tab
	);
}

printf(
	'<div class="agrikole-icon %2$s" %3$s>%1$s</div>',
	$icon_html,
	$cls,
	$data
);