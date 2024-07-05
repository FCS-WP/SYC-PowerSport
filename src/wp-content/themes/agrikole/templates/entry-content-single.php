<?php
/**
 * Entry Content / Single
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	<?php get_template_part( 'templates/entry-content-media' ); ?>
	<div class="inner-content">
		<?php get_template_part( 'templates/entry-content-meta' ); ?>
		<?php get_template_part( 'templates/entry-content-title' ); ?>
		<?php get_template_part( 'templates/entry-content-body' ); ?>
		<?php get_template_part( 'templates/entry-content-tags' ); ?>
	</div>
	<?php get_template_part( 'templates/entry-content-author' ); ?>
	<?php get_template_part( 'templates/entry-content-related' ); ?>
</article><!-- /.hentry -->