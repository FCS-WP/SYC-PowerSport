<?php
get_header();

$term_ids = array();
$pre_title = agrikole_get_mod( 'related_pre_title', esc_html__( 'EXPLORE PROJECTS', 'agrikole'));
$title = agrikole_get_mod( 'related_title', esc_html__( 'OUR RECENT PROJECTS', 'agrikole'));
$related_query = agrikole_get_mod( 'project_related_query', '7' );
$related_column = agrikole_get_mod( 'project_related_column', '3' );
$related_item_gap = agrikole_get_mod( 'project_related_item_spacing', '30' );

if ( $terms = get_the_terms( $post->ID, 'project_category' ) )
	$term_ids = wp_list_pluck( $terms, 'term_id' );

$query_args = array(
	'post_type' => 'project',
	'tax_query' => array(
		array(
		'taxonomy' => 'project_category',
		'field' => 'term_id',
		'terms' => $term_ids,
		'operator'=> 'IN'
		)),
	'ignore_sticky_posts' => 1,
	'post__not_in'=> array( $post->ID )
);

$query_args['posts_per_page'] = $related_query;

$query = new WP_Query( $query_args ); ?>

<div class="project-detail-wrap">
	<?php
	while ( have_posts() ) : the_post();
		the_content();
	endwhile; ?>
</div>

<?php if ( $query->have_posts() && $terms && agrikole_get_mod( 'project_related', true ) ): ?>
<div class="project-related-wrap">
	<div class="agrikole-container">
		<div class="title-wrap">
			<div class="pre-title"><?php echo esc_html( $pre_title ); ?></div>
			<h2 class="title"><?php echo esc_html( $title ); ?></h2>
		</div>
		<?php if ( $query->have_posts() ) : ?>
			<div class="project-related" data-gap="<?php echo esc_html( $related_item_gap ); ?>" data-column="<?php echo esc_html( $related_column ); ?>">
				<div class="owl-carousel owl-theme">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php wp_enqueue_script( 'agrikole-owlcarousel' ); ?>

					<div class="project-box">
						<div class="inner">
							<?php
							$img_size = $title = $arrow_html = $btn_html = $desc_html = '';

							if ( has_post_thumbnail() ) {
								$img_size = 'agrikole-rectangle3';
							}

			            	$title = agrikole_metabox( 'title' ) ? agrikole_metabox( 'title' ) : get_the_title();
			            	$title_html = sprintf('<h4 class="title"><a href="%1$s" title="%2$s">%2$s</a></h4>', esc_url( get_the_permalink() ), $title );

							$desc = agrikole_metabox( 'project_desc' ) ? agrikole_metabox( 'project_desc' ) : '';
							if ( $desc ) { $desc_html = sprintf('<div class="desc">%s</div>', $desc ); }

							$btn_html = '<div class="button"><a href="'. esc_url( get_the_permalink() ) .'">'. esc_html__('Read More', 'agrikole') .'</a></div>';
							$arrow_html = '<div class="arrow"><a href="'. esc_url( get_the_permalink() ) .'"><span class="core-icon-next"></span></a></div>';

							echo '<div class="project-image">'. get_the_post_thumbnail( get_the_ID(), $img_size ) .'<div class="title-wrap">'. $title_html .'</div><div class="project-text">'. $title_html . $desc_html . $btn_html . $arrow_html .'</div></div>';
							?>
		                </div>
					</div><!-- /.project-box -->
					<?php endwhile; ?>
				</div><!-- /.owl-carousel -->
			</div><!-- /.project-related -->
		<?php endif; wp_reset_postdata(); ?>
	</div><!-- /.agrikole-container -->
</div><!-- /.project-related-wrap -->
<?php endif; ?>

<?php get_footer(); ?>