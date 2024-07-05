<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$html = '';

extract( shortcode_atts( array(
    'image_crop' => 'full',
    'images'    => '',
    'show_borders' => '',
    'auto_scroll' => 'false',
    'loop' => 'false',
    'gap' => '30',
    'show_bullets' => '',
    'bullet_between' => '50',
    'show_arrows' => '',
    'arrow_position' => 'center',
    'column'        => '3c',
    'column2'       => '2c',
    'column3'       => '1c'
), $atts ) );

$gap = intval( $gap );
$column = intval( $column );
$column2 = intval( $column2 );
$column3 = intval( $column3 );

$cls = ' arrow-'. $arrow_position;
if ( $show_borders ) $cls .= ' has-borders';
if ( $show_bullets ) $cls .= ' has-bullets'; 
if ( $show_arrows ) $cls .= ' has-arrows';

if ( $bullet_between == '45' ) $cls .= ' bullet45';
if ( $bullet_between == '40' ) $cls .= ' bullet40';
if ( $bullet_between == '35' ) $cls .= ' bullet35';
if ( $bullet_between == '30' ) $cls .= ' bullet30';
if ( $bullet_between == '25' ) $cls .= ' bullet25';
if ( $bullet_between == '20' ) $cls .= ' bullet20';
if ( $bullet_between == '15' ) $cls .= ' bullet15';
if ( $bullet_between == '10' ) $cls .= ' bullet10';

if ( ! empty( $images ) ) {
    wp_enqueue_script( 'agrikole-owlcarousel' ); wp_enqueue_script( 'agrikole-magnificpopup' );
    $images = explode( ',', trim( $images ) );

    $html  .= '<div class="agrikole-images-carousel '. $cls .'" data-auto="'. $auto_scroll .'" data-loop="'. $loop .'" data-gap="'. $gap .'" data-column="'. $column .'" data-column2="'. $column2 .'" data-column3="'. $column3 .'">
        <div class="owl-carousel owl-theme">';

    for ( $i=0; $i<count( $images ); $i++ ) {
        $img_size = 'full';
        if ( $image_crop == 'square' ) $img_size = 'agrikole-square';
        if ( $image_crop == 'rectangle' ) $img_size = 'agrikole-rectangle';

        $img_b = wp_get_attachment_image_src( $images[$i], $img_size );
        $img_f = wp_get_attachment_image_src( $images[$i], 'full' );

        $html .= sprintf(
            '<div class="item-wrap"><img src="%1$s" alt="Image"><a class="popup-image" href="%2$s"></a></div>',
            $img_b[0],
            $img_f[0]
        );
    }

    $html .= '</div></div>';
}

echo $html;