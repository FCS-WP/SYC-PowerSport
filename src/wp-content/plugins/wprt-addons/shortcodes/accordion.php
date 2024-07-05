<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $css = $html = $heading_css = $heading_inner_css = $content_css = '';

extract( shortcode_atts( array(
	'open' => '',
	'color' => 'accent',
	'bg_image' => '',
	'bottom_margin' => '10',
	'tag' => 'h3',
	'heading' => '',
	'heading_padding' => '',
	'heading_rounded' => '',
	'content_padding' => '',
	'heading_font_family' => 'Default',
	'heading_font_weight' => 'Default',
	'heading_font_size' => '',
	'heading_line_height' => '',
), $atts ) );
$content = wpb_js_remove_wpautop($content, true);

$heading_font_size = intval( $heading_font_size );
$heading_line_height = intval( $heading_line_height );
$heading_rounded = intval( $heading_rounded );

$cls = $color;
if ( $open ) $cls .= ' active';
$css .= $bottom_margin == '0'
	? 'margin-bottom:0;'
	: 'margin-bottom:'. $bottom_margin .'px;';

if ( $bg_image ) $css .= 'background:url('. wp_get_attachment_image_src( $bg_image, 'full' )[0] .') no-repeat left top;';

if ( $heading_font_weight != 'Default' ) $heading_css .= 'font-weight:'. $heading_font_weight .';';
if ( $heading_font_size ) $heading_css .= 'font-size:'. $heading_font_size .'px;';
if ( $heading_line_height ) $heading_css .= 'line-height:'. $heading_line_height .'px;';
if ( $heading_padding ) $heading_css .= 'padding:'. $heading_padding .';';
if ( $heading_rounded ) $heading_css .= 'border-radius:'. $heading_rounded .'px;';
if ( $heading_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $heading_font_family );
	$heading_css .= 'font-family:'. $heading_font_family .';';
}

if ( $content_padding ) $content_css .= 'padding:'. $content_padding .';';

if ( $heading )
	$html .= sprintf(
		'<%4$s class="accordion-heading" style="%1$s">
			<span class="inner" style="%2$s">
				%3$s
			</span>
		</%4$s>',
		$heading_css,
		$heading_inner_css,
		$heading,
		$tag
	);

if ( $content )
	$html .= sprintf(
		'<div class="accordion-content" style="%1$s">%2$s</div>',
		$content_css,
		$content
	);

printf(
	'<div class="accordion-item %2$s" style="%3$s">%1$s</div>',
	$html,
	$cls,
	$css
);