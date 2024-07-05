<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $css = $data = $heading_css = '';
$left_css = $right_css = $center_css = '';
$img1_html = $img2_html = $heading_html = '';

extract( shortcode_atts( array(
    'image1'    => '',
    'image2'    => '',
    'heading' => 'Heading Text',
    'heading_color' => '',
    'animation' => '',
    'animation_effect' => 'fadeInUp',
    'animation_duration' => '0.75s',
    'animation_delay' => '0.3s',
    'heading_font_family' => 'Default',
    'heading_font_weight' => 'Default',
    'heading_font_size' => '',
    'heading_line_height' => '',
), $atts ) );

$heading_line_height = intval( $heading_line_height );
$heading_font_size = intval( $heading_font_size );

if ( $heading_font_weight != 'Default' ) $heading_css .= 'font-weight:'. $heading_font_weight .';';
if ( $heading_font_size ) $heading_css .= 'font-size:'. $heading_font_size .'px;';
if ( $heading_color ) $heading_css .= 'color:'. $heading_color .';';
if ( $heading_line_height ) $heading_css .= 'line-height:'. $heading_line_height .'px;';
if ( $heading_font_family != 'Default' ) {
    agrikole_enqueue_google_font( $heading_font_family );
    $heading_css .= 'font-family:'. $heading_font_family .';';
}

if ( $heading )
    $heading_html .= sprintf(
    '<h3 class="heading" style="%2$s">
        %1$s
    </h3>',
    $heading,
    $heading_css
    );

if ( $image1 ) {
    $img1_html .= sprintf(
        '<div class="image-wrap">%s</div>',
        wp_get_attachment_image( $image1, 'full' )
    );
}

if ( $image2 ) {
    $img2_html .= sprintf(
        '<div class="image-wrap">%s</div>',
        wp_get_attachment_image( $image2, 'full' )
    );
}

if ( $animation ) {
    $cls .= ' wow '. $animation_effect;
    $data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

printf(
    '<div class="agrikole-slogan-box clearfix %4$s" style="%5$s" %6$s>
        <div class="wrap">
            <div class="image-left item">
                %1$s
            </div>

            <div class="heading-wrap item">
                %3$s
            </div>

            <div class="image-right item">
                %2$s
            </div>
        </div>
    </div>', 
    $img1_html,
    $img2_html,
    $heading_html,
    $cls,
    $css,
    $data
);