<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $css = '';

extract( shortcode_atts( array(
	'items' => '4',
	'show_arrows' => '',
	'content_padding' => ''
), $atts ) );

$query_args = array(
    'post_type' => 'testimonials',
    'posts_per_page' => $items
);

if ( $show_arrows ) $cls .= ' has-arrows arrow-center offset100';
if ( $content_padding ) $css .= ' padding:'. $content_padding .';';

if ( ! empty( $cat_slug ) ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'testimonials_category'
		),
	);
}

$query = new WP_Query( $query_args );
if ( ! $query->have_posts() ) { echo "Testimonials post not found!"; return; }
ob_start(); ?>

<div class="agrikole-testimonials-box has-bullets <?php echo esc_attr( $cls ); ?>" style="<?php echo esc_attr( $css ); ?>">
<?php $i = 0; if ( $query->have_posts() ) : ?>

	<?php wp_enqueue_script( 'agrikole-owlcarousel' ); ?>

	<div class="owl-carousel owl-theme">
	    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<div class="item">

	        	<div class="text"><?php echo esc_html( agrikole_metabox( 'text' ) ); ?></div>

	        	<div class="person clearfix">
	        		<div class="thumb"><?php echo get_the_post_thumbnail( get_the_ID(), 'full' );?></div>
	        		<div class="info">
		    			<div class="name"><?php echo esc_html( agrikole_metabox( 'name' ) ); ?></div>
						<div class="position"><?php echo esc_html( agrikole_metabox( 'position' ) ); ?></div>
					</div>
				</div>

			</div>
		<?php endwhile; ?>
	</div>

<?php endif; ?>
<?php wp_reset_postdata(); ?>
</div><!-- /.agrikole-testimonails-g3 -->

<?php
$return = ob_get_clean();
echo $return;