<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $inner_css = $space = $filter_css = $filter_wrap_css  = $filter_data = '';

extract( shortcode_atts( array(
	'margin' => '',
	'showcase' => 'masonry',
	'image_crop' => 'full',
	'image_rounded' => 'false',
	'content_padding' => '',
	'items'			=> '8',
	'cat_slug'	=> '',
	'exclude_cat_slug' => '',
	'pagination' => 'false',
	'gapv'			=> '0',
	'gaph'			=> '0',
	'show_filter'	=> 'true',
	'filter_by_default' => '',
	'filter_cat_slug' => '',
	'filter_button_all' => 'All',
	'bottom_filter' => '',
	'filter_align' => 'style-1',
	'filter_counter' => 'true',
	'column'		=> '4c',
	'column2'		=> '3c',
	'column3'		=> '2c',
	'column4'		=> '1c',
	'filter_font_family' => 'Default',
	'filter_font_weight' => 'Default',
	'filter_font_size' => '',
	'filter_line_height' => '',
	'filter_letter_spacing' => '',
	'filter_text_tranform' => 'uppercase'
), $atts ) );

$gapv = intval( $gapv );
$gaph = intval( $gaph );
$items = intval( $items );
$column = intval( $column );
$column2 = intval( $column2 );
$column3 = intval( $column3 );
$column4 = intval( $column4 );
$bottom_filter = intval( $bottom_filter );
$filter_font_size = intval( $filter_font_size );
$filter_line_height = intval( $filter_line_height );
$filter_letter_spacing = intval( $filter_letter_spacing );

if ( empty( $items ) ) return;

if ( empty( $gapv ) ) $gapv = 0;
if ( empty( $gaph ) ) $gaph = 0;

if ( $margin ) $inner_css .= 'margin:'. $margin .';';
if ( $image_rounded == 'true' ) $cls .= ' image-rounded'; 

if ( $bottom_filter ) $filter_wrap_css = 'margin-bottom:'. $bottom_filter . 'px;';
if ( $filter_text_tranform ) $filter_css .= 'text-transform:'. $filter_text_tranform .';';
if ( $filter_font_weight != 'Default' ) $filter_css .= 'font-weight:'. $filter_font_weight .';';
if ( $filter_font_size ) $filter_css .= 'font-size:'. $filter_font_size .'px;';
if ( $filter_line_height ) $filter_css .= 'line-height:'. $filter_line_height .'px;';
if ( $filter_letter_spacing ) $filter_css .= 'letter-spacing:'. $filter_letter_spacing .'px;';
if ( $filter_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $filter_font_family );
	$filter_css .= 'font-family:'. $filter_font_family .';';
}

if ( ! empty( $filter_cat_slug ) && $filter_by_default  )
	$filter_data = strtolower( $filter_cat_slug );

if ( get_query_var('paged') ) {
   $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
   $paged = get_query_var('page');
} else {
   $paged = 1;
}

$query_args = array(
    'post_type' => 'project',
    'posts_per_page' => $items,
    'paged'     => $paged
);

if ( ! empty( $cat_slug ) ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'project_category',
			'field'    => 'slug',
			'terms'    => $cat_slug
		),
	);
}

if ( ! empty( $exclude_cat_slug ) ) {
	$query_args['tax_query'] = array(
	    array(
	        'taxonomy' => 'project_category',
	        'field' => 'slug',
	        'terms' => $exclude_cat_slug,
	        'operator' => 'NOT IN',
	    ),
	);
}

$wp_query = new WP_Query( $query_args );
if ( ! $wp_query->have_posts() ) { echo "Project item not found!"; return; }
ob_start(); ?>

<div class="agrikole-project-grid <?php echo esc_attr( $cls ); ?>" data-layout="<?php echo esc_attr( $showcase ); ?>" data-column="<?php echo esc_attr( $column ); ?>" data-column2="<?php echo esc_attr( $column2 ); ?>" data-column3="<?php echo esc_attr( $column3 ); ?>" data-column4="<?php echo esc_attr( $column4 ); ?>" data-gaph="<?php echo esc_attr( $gaph ); ?>" data-gapv="<?php echo esc_attr( $gapv ); ?>" data-filter="<?php echo esc_attr( $filter_data ); ?>">
<div style="<?php echo esc_attr( $inner_css ); ?>">

	<?php if ( $wp_query->have_posts() ) :
	    if ( $show_filter == 'true' ) {
	        echo '<div id="project-filter" style="'. $filter_wrap_css .'" class="cbp-l-filters-alignCenter clearfix '. $filter_align .'"><div class="inner">';
        	if ( ! empty( $filter_button_all ) )
        		echo '<div data-filter="*" class="cbp-filter-item button-all" style="'. $filter_css .'"><span>'. esc_html( $filter_button_all ) .'</span><div class="cbp-filter-counter"></div></div>';

				if ( $cat_slug ) {

					$term = strtolower( str_replace( ' ', '-', $cat_slug ) );
					$term = get_term_by( 'slug', $cat_slug, 'project_category' ); 
					if ( $term ) $terms = get_term_children( $term->term_id, 'project_category' );

					foreach( $terms as $term ) {
						$t = get_term_by( 'id', $term, 'project_category' );
						echo '<div data-filter=".'. esc_attr( $t->slug ) .'" class="cbp-filter-item" title="'. esc_attr( $t->name ) .'" style="'. $filter_css .'"><span>'. $t->name . '</span><div class="cbp-filter-counter"></div></div>';
					}
				} else {

					$terms = get_terms('project_category');
				    foreach ( $terms as $term ) {
				        echo '<div data-filter=".'. esc_attr( $term->slug ) .'" class="cbp-filter-item" title="'. esc_attr( $term->name ) .'" style="'. $filter_css .'"><span>'. $term->name . '</span><div class="cbp-filter-counter"></div></div>';
				    }
				}
	        echo '</div></div>';
	    } ?>

		<div id="portfolio" class="cbp">
		    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post();
				wp_enqueue_script( 'agrikole-cubeportfolio' ); wp_enqueue_script( 'agrikole-magnificpopup' );
				
			    global $post;
				$term_list = '';
			    $terms = get_the_terms( $post->ID, 'project_category' );

			    if ( $terms ) {
			        foreach ( $terms as $term ) {
			            $term_list .= $term->slug .' ';
			        }
			    } ?>

	            <div class="cbp-item <?php echo esc_attr( $term_list ); ?>">
					<div class="project-box">
						<div class="inner">
							<?php
							$img_size = $title = $term_html = '';
							if ( $content_padding ) $space .= 'padding:' . $content_padding .';';

							if ( has_post_thumbnail() ) {
						    	if ( $image_crop == 'default' ) $img_size = 'agrikole-'. agrikole_metabox( 'image_crop' );
								if ( $image_crop == 'full' ) $img_size = 'full';
								if ( $image_crop == 'square' ) $img_size = 'agrikole-square';
								if ( $image_crop == 'square2' ) $img_size = 'agrikole-square2';
								if ( $image_crop == 'rectangle' ) $img_size = 'agrikole-rectangle';
								if ( $image_crop == 'rectangle2' ) $img_size = 'agrikole-rectangle2';
								if ( $image_crop == 'rectangle3' ) $img_size = 'agrikole-rectangle3';
								if ( $image_crop == 'rectangle4' ) $img_size = 'agrikole-rectangle4';
								if ( $image_crop == 'rectangle5' ) $img_size = 'agrikole-rectangle5';
							}

			            	$title = agrikole_metabox( 'title' ) ? agrikole_metabox( 'title' ) : get_the_title();
			            	$title_html = sprintf('<h4 class="title"><a href="%1$s" title="%2$s">%2$s</a></h4>', esc_url( get_the_permalink() ), $title );

							$desc = agrikole_metabox( 'project_desc' ) ? agrikole_metabox( 'project_desc' ) : '';
							if ( $desc ) { $desc_html = sprintf('<div class="desc">%s</div>', $desc ); }

							$btn_html = '<div class="button"><a href="'. esc_url( get_the_permalink() ) .'">'. esc_html__('Read More', 'agrikole') .'</a></div>';
							$arrow_html = '<div class="arrow"><a href="'. esc_url( get_the_permalink() ) .'"><span class="core-icon-next"></span></a></div>';

							echo '<div class="project-image">'. get_the_post_thumbnail( get_the_ID(), $img_size ) .'<div class="title-wrap" style="'. $space .'">'. $title_html .'</div><div class="project-text" style="'. $space .'">'. $title_html . $desc_html . $btn_html . $arrow_html .'</div></div>';
							?>
		                </div>
					</div><!-- /.project-box -->
	            </div><!-- /.cbp-item -->
			<?php endwhile; ?>
		</div><!-- /#portfolio -->

		<?php if ( 'true' == $pagination ) {
			echo '<div class="project-nav">';
			agrikole_pagination($wp_query);
			echo '</div>';
		}
		?>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

</div>
</div><!-- /.agrikole-project -->

<?php
$return = ob_get_clean();
echo $return;