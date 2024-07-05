<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $icon_html = $data = '';

extract( shortcode_atts( array(
	'alignment' => 'text-center',
	'style' => 'accent',
	'size' => 'big',
	'video_url' => '',
	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',
), $atts ) );

$cls = $style .' '. $alignment .' '. $size;

if ( $video_url ) {
	$icon_html = sprintf(
		'<a class="icon-wrap popup-video" href="%1$s">
		play<span class="circle"></span></a>',
		$video_url
	);
}

if ( $animation ) {
	$cls .= ' wow '. $animation_effect;
	$data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

printf(
	'<div class="agrikole-video-icon clearfix %2$s" %3$s>
		%1$s
	</div>',
	$icon_html,
	$cls,
	$data
);


