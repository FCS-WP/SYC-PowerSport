<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css = $data = $inner_cls = $inner_content_css = $content_html = $line_html = $line_css = $line_cls = '';

extract( shortcode_atts( array(
	'alignment' => '',
	'style' => 'style-1',
	'margin' => '',
	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',
	'color' => 'dark',
	'link_url' => '',
	'content_font_family' => 'Default',
	'content_font_weight' => 'Default',
	'content_font_size' => '',
), $atts ) );

$inner_cls .= ' link-'. $style .' '. $color;

$content_font_size = intval( $content_font_size );

if ( $content_font_weight != 'Default' ) $inner_content_css .= 'font-weight:'. $content_font_weight .';';
if ( $content_font_size ) $inner_content_css .= 'font-size:'. $content_font_size .'px;';
if ( $content_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $content_font_family );
	$inner_content_css .= 'font-family:'. $content_font_family .';';
}

if ( $content )
	$content_html = sprintf(
		'<span class="text" style="%2$s">%1$s</span>',
		$content,
		$inner_content_css
	);

if ( $margin ) $css .= 'margin:'. $margin .';';

if ( $animation ) {
	$cls .= ' wow '. $animation_effect;
	$data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

if ( $link_url )
	printf(
		'<div style="%4$s"><a class="agrikole-links %3$s" href="%2$s" %5$s>
			%1$s
		</a></div>',
		$content_html,
		$link_url,
		$inner_cls,
		$css,
		$data
	);