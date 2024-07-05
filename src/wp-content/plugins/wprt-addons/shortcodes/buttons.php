<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css = $icon_html = $icon_css = $wrap_css = $btn_html = $inner_css = $data = $data_animate = '';

extract( shortcode_atts( array(
	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',
	'text' => 'Button Text',
	'size' => 'medium',
	'text_color' => '',
	'background_color' => '',
	'border_color' => '',
	'border_width' => '1px',
	'border_style' => 'solid',
	'rounded' => '',
	'padding' => '',
	'margin' => '',
	'full_width' => '',
	'text_color_hover' => '',
	'background_color_hover' => '',
	'border_color_hover' => '',
	'icon_color_hover' => '',
	'icon_style' => 'no_icon',
	'icon_type' => '',
	'icon' => '',
	'icon_color' => '',
	'icon_font_size' => '',
	'icon_position' => 'icon-right',
	'icon_left_padding' => '',
	'icon_right_padding' => '',
	'icon_offset' => '0',
	'font_family' => 'Default',
	'font_weight' => 'Default',
	'font_size' => '',
	'line_height' => '',
	'link_url' => '',
	'new_tab' => 'yes',
    'inset' => '',
    'horizontal' => '',
    'vertical' => '',
    'blur' => '',
    'spread' => '',
    'shadow_color' => '',
), $atts ) );

$rand = rand();
$rounded = intval( $rounded );
$icon_font_size = intval( $icon_font_size );
$icon_right_padding = intval( $icon_right_padding );
$icon_left_padding = intval( $icon_left_padding );
$font_size = intval( $font_size );
$line_height = intval( $line_height );

$wrap_cls = $icon_position;
if ( $full_width ) $css = $wrap_css .= 'display: block; text-align: center;';
$cls = 'btn-'. $rand .' '. $size .' '. $icon_style;

if ( $padding ) $css .= 'padding:'. $padding .';';
if ( $margin ) $css .= 'margin:'. $margin .';';
if ( $icon_left_padding ) $inner_css = 'padding-right:'. $icon_left_padding .'px;';
if ( $icon_right_padding ) $inner_css = 'padding-left:'. $icon_right_padding .'px;';
$new_tab = $new_tab == 'yes' ? '_blank' : '_self';

if ( $font_weight != 'Default' ) $css .= 'font-weight:'. $font_weight .';';
if ( $font_size ) $css .= 'font-size:'. $font_size .'px;';
if ( $line_height ) $css .= 'line-height:'. $line_height .'px;';
if ( $rounded ) $css .= 'border-radius:'. $rounded .'px;';
if ( $border_width ) $css .= 'border-width:'. $border_width .';';
if ( $font_family != 'Default' ) {
	agrikole_enqueue_google_font( $font_family );
	$css .= 'font-family:'. $font_family .';';
}

if ( $background_color == '#eddd5e' ) {
	$cls .= ' accent';
} else {
	$cls .= ' custom';
	$data .= ' data-background="'. $background_color .'"';
}

if ( $text_color == '#eddd5e' ) {
	$cls .= ' text-accent';
} else {
	$cls .= ' custom';
	$data .= ' data-text="'. $text_color .'"';
}

if ( $border_width ) {
	$cls .= ' outline '. $border_style;
	if ( $border_color == '#eddd5e' ) {
		$cls .= ' outline-accent';
	} else {
		$cls .= ' custom';
		$data .= ' data-border="'. $border_color .'"';
	}
}

// if ( $text_color ) $data .= ' data-text="'. $text_color .'"';
if ( $text_color_hover ) $data .= ' data-text-hover="'. $text_color_hover .'"';
if ( $background_color_hover ) $data .= ' data-background-hover="'. $background_color_hover .'"';
if ( $border_color_hover ) $data .= ' data-border-hover="'. $border_color_hover .'"';
if ( $icon_color_hover ) $data .= ' data-icon-hover="'. $icon_color_hover .'"';

if ( $icon_style == 'custom' ) {
	if ( $icon_color ) $data .= ' data-icon="'. $icon_color .'"';
	$icon = agrikole_get_icon_class( $atts, 'icon' );

	if ( $icon && $icon_type != '' ) {
		$wrap_cls .= ' has-icon';
		vc_icon_element_fonts_enqueue( $icon_type );

		if ( $icon_font_size ) $icon_css .= 'font-size:'. $icon_font_size .'px;';
		if ( $icon_offset ) $icon_css .= 'top:'. $icon_offset .'px;';

		$icon_html = sprintf('<span class="icon" style="%2$s"><i class="%1$s"></i></span>', $icon, $icon_css );
	}
}

if ( $horizontal && $vertical && $blur && $spread && $shadow_color )
    $css .= ' box-shadow:'. $inset .' '. $horizontal .' '. $vertical .' '. $blur .' '. $spread .' '. $shadow_color;

$btn_html = sprintf(
	'<a href="%5$s" target="%6$s" class="agrikole-button %1$s" style="%2$s" %8$s>
		<span style="%4$s">%7$s %3$s</span>
	</a>',
	$cls,
	$css,
	$icon_html,
	$inner_css,
	$link_url,
	$new_tab,
	$text,
	$data
);

if ( $animation ) {
	$wrap_cls .= ' wow '. $animation_effect;
	$data_animate .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

printf(
	'<div class="button-wrap %1$s" style="%2$s" %4$s>%3$s</div>',
	$wrap_cls,
	$wrap_css,
	$btn_html,
	$data_animate
);
