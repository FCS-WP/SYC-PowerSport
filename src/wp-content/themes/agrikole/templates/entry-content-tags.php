<?php
/**
 * Entry Content / Tags
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( is_single() && ! agrikole_get_mod( 'blog_single_tags', true ) )
	return;

$text = agrikole_get_mod( 'blog_single_tags_text', '' );
the_tags( '<div class="post-tags clearfix"><div class="inner">'. esc_html( $text ),', ','</div></div>' );


