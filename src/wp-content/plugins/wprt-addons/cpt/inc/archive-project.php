<?php get_header(); ?>

<div id="content-wrap" class="agrikole-container">
    <div id="site-content" class="site-content archive-project clearfix">
    	<div id="inner-content" class="inner-content-wrap">
			<?php if ( have_posts() ) : ?>
				<div class="agrikole-project-grid image-rounded" data-layout="grid" data-column="3" data-column2="3" data-column3="2" data-column4="1" data-gaph="30" data-gapv="30">
					<div id="portfolio" class="cbp">
					    <?php while ( have_posts() ) : the_post();
							wp_enqueue_script( 'agrikole-cubeportfolio' ); ?>

				            <div class="cbp-item">
								<div class="project-box">
									<div class="inner">
									<?php
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
				            </div><!-- /.cbp-item -->
						<?php endwhile; ?>
					</div><!-- /#portfolio -->

					<?php agrikole_pagination(); ?>
				</div><!-- /.agrikole-project-grid -->
			<?php endif; ?>
    	</div>
    </div><!-- /#site-content -->
</div><!-- /#content-wrap -->

<?php get_footer(); ?>