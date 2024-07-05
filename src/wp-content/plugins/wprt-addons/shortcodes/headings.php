<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css = $data = $heading_css = $preheading_css =$heading_cls = '';
$html = $pre_html = $heading_html = $sub_html = $sep_html = '';
$line_cls = $line_css = $image_css = '';

extract( shortcode_atts( array(
	'alignment' => 'text-center',

	'preheading' => '',
	'preheading_color' => '',

    'heading' => '',
    'heading_color' => '',
    'heading_width' => '',

    'subheading' => '',

	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',

	'separator' => '',
	'sep_margin' => '',
	'sep_position' => 'between',
	'line_width' => '70',
	'line_height' => '2',
	'line_right_margin' => '20',
	'line_color' => '#eddd5e',
	'image' => '',
	'image_width' => '',

	'preheading_font_family' => 'Default',
	'preheading_font_weight' => 'Default',
	'preheading_font_size' => '',
	'preheading_line_height' => '',
	'preheading_letter_spacing' => '',

	'tag' => 'h2',
	'heading_font_family' => 'Default',
	'heading_font_weight' => 'Default',
	'heading_font_size' => '',
    'heading_font_size_mobile' => '',
	'heading_line_height' => '',
	'heading_letter_spacing' => '',

	'heading_top_margin' => '',
	'heading_bottom_margin' => '',
), $atts ) );
$content = wpb_js_remove_wpautop($content, true);

$image_width = intval( $image_width );
$heading_width = intval( $heading_width );

$line_width = intval( $line_width );
$line_height = intval( $line_height );
$line_right_margin = intval( $line_right_margin );

$preheading_font_size = intval( $preheading_font_size );
$preheading_line_height = intval( $preheading_line_height );
$preheading_letter_spacing = intval( $preheading_letter_spacing );

$heading_font_size = intval( $heading_font_size );
$heading_font_size_mobile = intval( $heading_font_size_mobile );
$heading_line_height = intval( $heading_line_height );
$heading_top_margin = intval( $heading_top_margin );
$heading_bottom_margin = intval( $heading_bottom_margin );

$cls = $alignment;

if ( $preheading_font_weight != 'Default' ) $preheading_css .= 'font-weight:'. $preheading_font_weight .';';
if ( $preheading_color ) $preheading_css .= 'color:'. $preheading_color .';';
if ( $preheading_font_size ) $preheading_css .= 'font-size:'. $preheading_font_size .'px;';
if ( $preheading_line_height ) $preheading_css .= 'line-height:'. $preheading_line_height .'px;';
if ( $preheading_letter_spacing ) $preheading_css .= 'letter-spacing:'. $preheading_letter_spacing .'px;';

if ( $preheading_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $preheading_font_family );
	$preheading_css .= 'font-family:'. $preheading_font_family .';';
}

if ( $preheading ) $pre_html .= sprintf(
	'<div class="pre-heading clearfix" style="%2$s">
		%1$s
	</div>',
	$preheading,
	$preheading_css
);



if ( $heading_font_weight != 'Default' ) $heading_css .= 'font-weight:'. $heading_font_weight .';';
if ( $heading_color == '#eddd5e' ) { $heading_cls .= ' accent';
} else { if ( $heading_color ) $heading_css .= 'color:'. $heading_color .';'; }
if ( $heading_width ) {
	$heading_css .= 'max-width:'. $heading_width .'px;';
	if ( $alignment == 'text-center' ) $heading_css .= 'margin-left: auto; margin-right: auto;';
}
if ( $heading_line_height ) $heading_css .= 'line-height:'. $heading_line_height .'px;';
if ( $heading_letter_spacing ) $heading_css .= 'letter-spacing:'. $heading_letter_spacing .'px;';
if ( $heading_top_margin ) $heading_css .= 'margin-top:'. $heading_top_margin .'px;';
if ( $heading_bottom_margin ) $heading_css .= 'margin-bottom:'. $heading_bottom_margin .'px;';
if ( $heading_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $heading_font_family );
	$heading_css .= 'font-family:'. $heading_font_family .';';
}

if ( $heading_font_size ) {
	$heading_css .= 'font-size:'. $heading_font_size .'px;';
    $data .= 'data-font='. $heading_font_size;
}
if ( $heading_font_size_mobile ) $data .= ' data-mfont='. $heading_font_size_mobile;

if ( $heading ) $heading_html .= sprintf(
	'<%4$s class="heading clearfix %3$s" style="%2$s">
		%1$s
	</%4$s>',
	$heading,
	$heading_css,
	$heading_cls,
	$tag
);


if ( $content ) $sub_html .= sprintf(
	'<div class="sub-heading clearfix">
		%1$s
	</div>',
	$content
);


if ( $separator == 'line' ) {
	if ( empty( $line_width ) ) $line_width = 50;
	if ( empty( $line_height ) ) $line_height = 2;

	if ( $line_width == '100%' ) {
		$line_css .= 'width:'. $line_width .'%;';
	} else {
		$line_css .= 'width:'. $line_width .'px;';
	}

	$line_css .= 'height:'. $line_height .'px;';
	$line_css .= 'margin:'. $sep_margin .';';

	if ( $line_color == '#eddd5e' ) {
		$line_cls .= 'accent';
	} elseif ( $line_color ) {
		$line_css .= 'background-color:'. $line_color .';';
	}

	$sep_html .= sprintf( '<div class="sep %2$s clearfix" style="%1$s"></div>', $line_css, $line_cls );
}

if ( $separator == 'image' ) {
	if ( $image_width )
		$image_css = 'width:'. $image_width .'px;';

	$image_css .= 'margin:'. $sep_margin .';';

	if ( $image )
		$sep_html = sprintf(
			'<div class="sep clearfix" style="%2$s">
				<img alt="image" src="%1$s">
			</div>',
			wp_get_attachment_image_src( $image, 'full' )[0],
			$image_css
		);
}

if ( $sep_position == 'between' ) {
	$html = $pre_html . $heading_html . $sep_html . $sub_html;
} elseif ( $sep_position == 'top' ) {
	$html = $sep_html . $pre_html . $heading_html . $sub_html;
} else { $html = $pre_html . $heading_html . $sub_html . $sep_html; }

if ( $line_right_margin && $sep_position == 'left' ) {
	$css .= 'padding-left:'. $line_right_margin .'px';
	$cls .= ' left-sep';
}

if ( $animation ) {
	$cls .= ' wow '. $animation_effect;
	$data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

printf(
	'<div class="agrikole-headings clearfix %2$s" %3$s style="%4$s">%1$s</div>',
	$html,
	$cls,
	$data,
	$css
);