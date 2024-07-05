<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $css1 = $css2 = $css3 = '';

extract( shortcode_atts( array(
    'alignment' => 'text-left',
    'tag' => 'h2',
    'text1' => '',
    'text2' => '',
    'text3' => '',
    'color1' => '',
    'color2' => '',
    'color3' => '',
    'text1_font_family' => '',
    'text1_font_weight' => '',
    'text1_font_size' => '',
    'text1_font_style' => '',
    'text2_font_family' => '',
    'text2_font_weight' => '',
    'text2_font_size' => '',
    'text2_font_style' => '',
    'text3_font_family' => '',
    'text3_font_weight' => '',
    'text3_font_size' => '',
    'text3_font_style' => '',
    'text1_right_padding' => '',
    'text2_right_padding' => ''
), $atts ) );

$text1_font_size = intval($text1_font_size);
$text2_font_size = intval($text2_font_size);
$text3_font_size = intval($text3_font_size);
$text1_right_padding = intval($text1_right_padding);
$text2_right_padding = intval($text2_right_padding);

$cls = $alignment;

if ( $color1 ) $css1 .= 'color:'. $color1 .';';
if ( $color2 ) $css2 .= 'color:'. $color2 .';';
if ( $color3 ) $css3 .= 'color:'. $color3 .';';

if ( $text1_font_family != 'Default' ) {
    agrikole_enqueue_google_font( $text1_font_family );
    $css1 .= 'font-family:'. $text1_font_family .';';
}
if ( $text1_font_weight ) $css1 .= 'font-weight:'. $text1_font_weight .';';
if ( $text1_font_size ) $css1 .= 'font-size:'. $text1_font_size .'px;';
if ( $text1_font_style ) $css1 .= 'font-style:'. $text1_font_style .';';
if ( $text1_right_padding ) $css1 .= 'padding-right:'. $text1_right_padding .'px;';

if ( $text2_font_family != 'Default' ) {
    agrikole_enqueue_google_font( $text2_font_family );
    $css2 .= 'font-family:'. $text2_font_family .';';
}
if ( $text2_font_weight ) $css2 .= 'font-weight:'. $text2_font_weight .';';
if ( $text2_font_size ) $css2 .= 'font-size:'. $text2_font_size .'px;';
if ( $text2_font_style ) $css2 .= 'font-style:'. $text2_font_style .';';
if ( $text2_right_padding ) $css2 .= 'padding-right:'. $text2_right_padding .'px;';

if ( $text3_font_family != 'Default' ) {
    agrikole_enqueue_google_font( $text3_font_family );
    $css3 .= 'font-family:'. $text3_font_family .';';
}
if ( $text3_font_weight ) $css3 .= 'font-weight:'. $text3_font_weight .';';
if ( $text3_font_size ) $css3 .= 'font-size:'. $text3_font_size .'px;';
if ( $text3_font_style ) $css3 .= 'font-style:'. $text3_font_style .';';

printf(
	'<%1$s class="agrikole-special-text %8$s">
        <span style="%5$s">%2$s</span><span style="%6$s">%3$s</span><span style="%7$s">%4$s</span>
    </%1$s>',
    $tag,
    esc_html($text1),
    esc_html($text2),
    esc_html($text3),
    $css1,
    $css2,
    $css3,
    $cls
);

