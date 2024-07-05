<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$html = $css = '';

extract( shortcode_atts( array(
	'mode' => 'grid',
	'image_crop'	=> 'full',
	'images'	=> '',
	'rounded' => '',
	'column'		=> '4c',
	'column2'		=> '3c',
	'column3'		=> '2c',
	'column4'		=> '1c',
	'gapv'			=> '0',
	'gaph'			=> '0'
), $atts ) );

$gapv = intval( $gapv );
$gaph = intval( $gaph );
$column = intval( $column );
$column2 = intval( $column2 );
$column3 = intval( $column3 );
$column4 = intval( $column4 );

if ( empty( $gapv ) ) $gapv = 0;
if ( empty( $gaph ) ) $gaph = 0;

if ( $rounded ) $css .= 'border-radius:'.  intval($rounded) .'px;overflow:hidden;';

if ( ! empty( $images ) ) {

	wp_enqueue_script( 'agrikole-cubeportfolio' );

	$images = explode( ',', trim( $images ) );

	$html  .= '<div class="agrikole-images-grid clearfix" data-layout="'. $mode .'" data-column="'. esc_attr( $column ) .'" data-column2="'. esc_attr( $column2 ) .'" data-column3="'. esc_attr( $column3 ) .'" data-column4="'. esc_attr( $column4 ) .'" data-gaph="'. esc_html( $gaph ) .'" data-gapv="'. esc_html( $gapv ) .'">';

	$html .= '<div id="images-wrap" class="cbp">';

	for ( $i=0; $i<count( $images ); $i++ ) {

		$img_size = '';
		if ( $image_crop == 'full' ) $img_size = 'full';
		if ( $image_crop == 'square' ) $img_size = 'agrikole-square';
		if ( $image_crop == 'square2' ) $img_size = 'agrikole-square2';
		if ( $image_crop == 'rectangle' ) $img_size = 'agrikole-rectangle';
		if ( $image_crop == 'rectangle2' ) $img_size = 'agrikole-rectangle2';
		if ( $image_crop == 'rectangle3' ) $img_size = 'agrikole-rectangle3';
		if ( $image_crop == 'rectangle4' ) $img_size = 'agrikole-rectangle4';
		if ( $image_crop == 'rectangle5' ) $img_size = 'agrikole-rectangle5';

		$img_b = wp_get_attachment_image_src( $images[$i], $img_size );
		$img_f = wp_get_attachment_image_src( $images[$i], 'full' );

		$html .= sprintf(
			'<div class="cbp-item"><div class="item-wrap" style="%3$s"><a class="zoom-popup cbp-lightbox" href="%2$s"></a><img src="%1$s" alt="image" /></div></div>',
			$img_b[0],
			$img_f[0],
			$css
		);

	}
	
	$html .= '</div></div>';

}

echo $html;
