<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $css = $inner_css = $image_html = '';

extract( shortcode_atts( array(
	'image' => '',
	'image_width' => '',
	'image_rounded' => '',
	'stretch' => '',
	'parallax_x' => '',
	'parallax_y' => '',
	'smoothness' => '30',
	'left' => '',
	'right' => '',
	'top' => '',
    'inset' => '',
    'horizontal' => '',
    'vertical' => '',
    'blur' => '',
    'spread' => '',
    'shadow_color' => ''
), $atts ) );

if ( ! empty( $left ) ) $css .= 'left:'. $left .';';
if ( ! empty( $right ) ) $css .= 'left:auto;right:'. $right .';';
if ( ! empty( $top ) ) $css .= 'margin-top:'. $top .';';

if ( $image ) $image_html .= '<img class="parallax-image" src="'. wp_get_attachment_image_src( $image, 'full' )[0] .'" alt="image">';
if ( $image_width ) {
	$cls = 'has-width';
	$css .= 'width:'. intval( $image_width ) .'%;';
}
if ( $image_rounded ) $css .= 'border-radius:'. $image_rounded .';';

if ( $horizontal && $vertical && $blur && $spread && $shadow_color )
    $css .= 'box-shadow:'. $inset .' '. $horizontal .' '. $vertical .' '. $blur .' '. $spread .' '. $shadow_color .';';

printf(
	'<div class="agrikole-parallax-item %7$s" style="%2$s" data-parallax=\'{"y" : %4$s, "smoothness" : %5$s}\' data-top="%6$s">%1$s</div>',
	$image_html,
	$css,
	intval( $parallax_x ),
	intval( $parallax_y ),
	intval ($smoothness ),
	$top,
	$cls
);