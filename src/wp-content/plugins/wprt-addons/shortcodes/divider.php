<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css1 =  $css2 = $icon_html = $icon_cls = $icon_css = $icon_css2 = $border_css = '';

extract( shortcode_atts( array(
	'alignment' => 'divider-center',
	'style' => 'solid',
	'width' => '',
	'height' => '',
	'color' => '',
	'icon_display' => 'no-icon',
	'icon_type' => '',
	'icon' => '',
	'icon_color' => '',
	'icon_font_size' => '',
	'icon_padding' => '',
	'icon_top_margin' => '',
	'top_margin' => '',
	'bottom_margin' => '',
), $atts ) );

$width = intval( $width );
$height = intval( $height );
$icon_font_size = intval( $icon_font_size );
$icon_top_margin = intval( $icon_top_margin );
$top_margin = intval( $top_margin );
$bottom_margin = intval( $bottom_margin );

$cls = $alignment;

if ( $style == 'solid') $cls .= ' divider-solid';
if ( $style == 'dotted') $cls .= ' divider-dotted';
if ( $style == 'dashed') $cls .= ' divider-dashed';
if ( $style == 'double') $cls .= ' divider-double';

if ( $icon_display == 'no-icon' ) {
	if ( $width ) $css1 .= 'width:'. $width .'px;';
	if ( $height ) $css1 .= 'border-width:'. $height .'px;';

	if ( $color == '#eddd5e' ) { $cls .= ' accent'; }
	else { if ( $color ) $css1 .= 'border-top-color:'. $color .';'; }

	if ( $top_margin ) $css1 .= 'margin-top:'. $top_margin .'px;';
	if ( $bottom_margin ) $css1 .= 'margin-bottom:'. $bottom_margin .'px;';

	printf( '<div class="agrikole-divider %1$s" style="%2$s"></div><div class="clearfix"></div>', $cls, $css1 );
}

if ( $icon_display == 'icon-font' ) {
	$icon = agrikole_get_icon_class( $atts, 'icon' );

	if ( $width ) $css2 = 'width:'. $width .'px;';
	if ( $top_margin ) $css2 .= 'margin-top:'. $top_margin .'px;';
	if ( $bottom_margin ) $css2 .= 'margin-bottom:'. $bottom_margin .'px;';

	if ( $height ) $border_css = 'border-bottom-width:'. $height .'px;';
	if ( $color ) $border_css .= 'border-color:'. $color .';';

	if ( $icon_display == 'icon-font' && $icon && $icon_type != '' ) {
		vc_icon_element_fonts_enqueue( $icon_type );

		if ( $icon_font_size ) $icon_css .= 'font-size:'. $icon_font_size .'px;';
		if ( $icon_padding ) $icon_css2 = 'padding:'. $icon_padding .';';
		if ( $icon_top_margin ) $icon_css2 = 'margin-top:'. $icon_top_margin .'px;';

		if ( $icon_color == '#eddd5e' ) { $icon_cls .= ' accent'; }
		else { if ( $icon_color ) $icon_css .= 'color:'. $icon_color .';'; }

		$icon_html = sprintf( '<span class="%1$s %3$s" style="%2$s"></span>', $icon, $icon_css, $icon_cls );
	}

	printf(
		'<div class="agrikole-divider has-icon" style="%1$s">
			<div class="divider-icon">
				<span class="divider-icon-before %5$s" style="%4$s"></span>
				<span class="icon-wrap" style="%3$s">%2$s</span>
				<span class="divider-icon-after %5$s" style="%4$s"></span>
			</div>
		</div><div class="clearfix"></div>',
		$css2,
		$icon_html,
		$icon_css2,
		$border_css,
		$cls
	);
}

