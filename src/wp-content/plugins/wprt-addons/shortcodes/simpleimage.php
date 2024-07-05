<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $css = $cls2 = $data = $data2 = $icon_cls = $icon_css = $icon_html = $image_html = $new_tab = '';

extract( shortcode_atts( array(
	'image' => '',
	'img_stretch' => '',
	'image_width' => '',
	'rounded' => '',
	'center_align' => '',
	'url' => '',
	'new_tab' => 'yes',
	'icon_style' => 'white',
	'icon_size' => 'big',
	'video_url' => '',
    'inset' => '',
    'horizontal' => '',
    'vertical' => '',
    'blur' => '',
    'spread' => '',
    'shadow_color' => '',
    'effect' => 'simple',
    'reveal_dir' => 'lr',
    'bg_pos' => 'top',
	'stretch' => '',
	'offset_left' => '-22vw',
	'offset_right' => '-22vw',
), $atts ) );

if ( $img_stretch ) $cls .= 'img-stretch';
if ( $stretch == 'stretch_mobi' ) $cls = 'stretch-on-mobile';

if ( $stretch == 'stretch_left' || $stretch == 'stretch_right' ) {
	$cls2 .= ' stretch ctb-'. rand();
	if ( $stretch == 'stretch_left' && !empty( $offset_left ) ) $data2 .= ' data-stretch-left='. $offset_left;
	if ( $stretch == 'stretch_right' && !empty( $offset_right ) ) $data2 .= ' data-stretch-right='. $offset_right;
}

if ( $video_url ) {
	$icon_cls = $icon_style .' '. $icon_size;

	$icon_html = sprintf(
		'<div class="agrikole-video-icon clearfix %2$s" style="%3$s"><a class="icon-wrap popup-video" href="%1$s"><span class="circle"></span></a></div>',
		$video_url,
		$icon_cls,
		$icon_css
	);
}

if ( $image ) {
	$image_html = sprintf( '<img alt="image" src="%1$s" />', wp_get_attachment_image_src( $image, 'full' )[0] );

	if ( $url ) {
		$new_tab = $new_tab == 'yes' ? '_blank' : '_self';
		$image_html = sprintf( '<a target="%3$s" href="%2$s">%1$s</a>', $image_html, $url, $new_tab );
	}

	if ( $effect == 'simple' ) {
		if ( $image_width ) $css .= ' max-width:'.  intval($image_width) .'px;';
		if ( $rounded ) $css .= 'border-radius:'.  intval($rounded) .'px;overflow:hidden;';
		if ( $center_align ) $css .= 'text-align:center; margin:0 auto;';
		if ( $horizontal && $vertical && $blur && $spread && $shadow_color )
		    $css .= ' box-shadow:'. $inset .' '. $horizontal .' '. $vertical .' '. $blur .' '. $spread .' '. $shadow_color;

		printf(
			'<div class="agrikole-simple-image simple %3$s" style="%4$s">
				%1$s %2$s
			</div>',
			$image_html,
			$icon_html,
			$cls,
			$css
		);
	}

	if ( $effect == 'reveal' ) {
		$cls .= ' '. $reveal_dir;
		if ( $rounded ) $css .= 'border-radius:'.  intval($rounded) .'px;overflow:hidden;';
		if ( $horizontal && $vertical && $blur && $spread && $shadow_color )
		    $css .= ' box-shadow:'. $inset .' '. $horizontal .' '. $vertical .' '. $blur .' '. $spread .' '. $shadow_color;

		printf(
			'<div class="agrikole-simple-image reveal wow %3$s %6$s" %5$s>
				<figure style="%4$s">%1$s %2$s</figure>
			</div>',
			$image_html,
			$icon_html,
			$cls,
			$css,
			$data2,
			$cls2
		);
	}

	if ( $effect == 'background' ) {

		$data = 'data-in-viewport="true"';
		$cls .= ' bg-'. $bg_pos;

		printf(
			'<div class="agrikole-fancy-img %3$s" %5$s %6$s>
				<div class="agrikole-fancy-img-inner">
					<span class="agrikole-fancy-img-bg"></span>

					<div class="agrikole-fancy-img-holder" style="%4$s">
						%1$s %2$s
					</div>
				</div>
			</div>',
			$image_html,
			$icon_html,
			$cls,
			$css,
			$data,
			$data2
		);
	}
}