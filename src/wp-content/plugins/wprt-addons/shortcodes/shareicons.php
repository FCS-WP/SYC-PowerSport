<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css = '';

extract( shortcode_atts( array(
	'style' => 'style-1',
	'facebook' => '',
	'twitter' => '',
	'pinterest' => '',
	'linkedin' => ''
), $atts ) );

echo '<ul class="agrikole-share-social clearfix '. esc_attr( $style ) .'">';
	if ( $facebook )
		echo '<li><div class="facebook-social"><a target="_blank" class="facebook"  href="https://www.facebook.com/sharer.php?u=' . urlencode( get_permalink() ) . '" title="' . esc_attr__( 'Facebook', 'agrikole' ) . '"><i class="fa fa-facebook"></i></a></div></li>';

	if ( $twitter )
		echo '<li><div class="twitter-social"><a target="_blank" class="twitter" href="https://twitter.com/share?url=' . urlencode( get_permalink() ) . '&amp;text=' . rawurlencode( esc_attr( get_the_title() ) ) . '" title="' . esc_attr__( 'Twitter', 'agrikole' ) . '"><i class="fa fa-twitter"></i></a></div></li>';

	if ( $pinterest )
		echo '<li><div class="pinterest-social"><a target="_blank" class="pinterest"  href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;description=' . rawurlencode( esc_attr( get_the_excerpt() ) ) . '&amp;media=' . urlencode( wp_get_attachment_url( get_post_thumbnail_id() ) ) . '" onclick="window.open(this.href); return false;" title="' . esc_attr__( 'Pinterest', 'agrikole' ) . '"><i class="fa fa-pinterest-p"></i></a></div></li>';

	if ( $linkedin )
		echo '<li><div class="linkedin-social"><a target="_blank" class="linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_permalink() ) . '&title=' . rawurlencode( esc_attr( get_the_title() ) ) . '&summary=&source=' . rawurlencode( esc_attr( get_the_excerpt() ) ) . '"><i class="fa fa-linkedin-square"></i></a></div></li>';

echo '</ul>';