<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$html = '';

extract( shortcode_atts( array(
    'images'    => '',
    'auto_scroll' => 'false',
    'loop' => 'false'
), $atts ) );



if ( ! empty( $images ) ) {
    $images = explode( ',', trim( $images ) );

    for ( $i=0; $i<count($images); $i++ ) {
        $img_b = wp_get_attachment_image_src( $images[$i], 'full' );
        $img_f = wp_get_attachment_image_src( $images[$i], 'full' );

        $html .= sprintf(
            '<div class="slide"><img src="%1$s" alt="image" /></div>',
            $img_b[0],
            $img_f[0]
        );
    }
}

wp_enqueue_script( 'agrikole-owlcarousel' );
printf(
    '<div class="carousel-outer"><div class="agrikole-app-carousel owl-carousel owl-theme" data-auto="%2$s" data-loop="%3$s">
        %1$s
    </div><div class="mockup-layer"><span class="m1"></span><span class="m2"></span></div></div>',
	$html,
    $auto_scroll,
    $loop
);