<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css = '';

extract( shortcode_atts( array(
	'id_target' => '',
	'color' => '',
	'size' => '',
	'alignment' => 'text-center',
), $atts ) );

if ( $color ) $css .= 'color:'. $color .';';
if ( $size ) $css .= 'font-size:'. intval( $size ) .'px;';

if ( $id_target ) {
	printf(
		'<div class="agrikole-scroll-target %3$s">
			<a href="#%1$s" style="%2$s">
			</a>
		</div>',
		$id_target,
		$css,
		$alignment
	);
}

