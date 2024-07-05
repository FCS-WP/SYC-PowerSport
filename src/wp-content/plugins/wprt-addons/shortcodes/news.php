<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$item_css = $content_css = $heading_css ='';

extract( shortcode_atts( array(
	'style' => 'style-1',
	'thumb' => 'featured-image',
	'content_padding' => '',
	'content_background' => '#f7f7f7',
	'link_text' => 'Read more',
	'column'		=> '3c',
	'column2'		=> '2c',
	'column3'		=> '1c',
	'items'		=> '3',
	'gap'		=> '30',
	'auto_scroll' => 'false',
	'show_bullets' => '',
	'show_arrows' => '',
	'bullet_between' => '50',
	'arrow_position' => 'center',
    'arrow_offset' => 'center',
    'arrow_offset_v' => '0',
    'arrow_offset_s' => '50',
	'cat_slug' => '',
	'heading_font_family' => 'Default',
	'heading_font_weight' => 'Default',
	'heading_color' => '',
	'heading_font_size' => '',
	'heading_line_height' => '',
	'heading_top_margin' => '',
	'heading_bottom_margin' => ''
), $atts ) );

$gap = intval( $gap );
$items = intval( $items );
$column = intval( $column );
$column2 = intval( $column2 );
$column3 = intval( $column3 );

$heading_line_height = intval( $heading_line_height );
$heading_font_size = intval( $heading_font_size );
$heading_top_margin = intval( $heading_top_margin );
$heading_bottom_margin = intval( $heading_bottom_margin );

if ( empty( $items ) ) return;

$cls = $style .' arrow-'. $arrow_position .' offset'. $arrow_offset .' offset-v'. $arrow_offset_v;
if ( $show_bullets ) $cls .= ' has-bullets'; 
if ( $show_arrows ) $cls .= ' has-arrows';
if ( $arrow_offset_s ) $cls .= ' arrow'.$arrow_offset_s;

if ( $content_padding ) $content_css .= 'padding:'. $content_padding .';';
if ( $content_background ) $item_css .= 'background-color:'. $content_background .';';

if ( $bullet_between == '45' ) $cls .= ' bullet45';
if ( $bullet_between == '40' ) $cls .= ' bullet40';
if ( $bullet_between == '35' ) $cls .= ' bullet35';
if ( $bullet_between == '30' ) $cls .= ' bullet30';
if ( $bullet_between == '25' ) $cls .= ' bullet25';
if ( $bullet_between == '20' ) $cls .= ' bullet20';
if ( $bullet_between == '15' ) $cls .= ' bullet15';
if ( $bullet_between == '10' ) $cls .= ' bullet10';

if ( $heading_font_weight != 'Default' ) $heading_css .= 'font-weight:'. $heading_font_weight .';';
if ( $heading_color ) $heading_css .= 'color:'. $heading_color .';';
if ( $heading_font_size ) $heading_css .= 'font-size:'. $heading_font_size .'px;';
if ( $heading_line_height ) $heading_css .= 'line-height:'. $heading_line_height .'px;';
if ( $heading_top_margin ) $heading_css .= 'margin-top:'. $heading_top_margin .'px;';
if ( $heading_bottom_margin ) $heading_css .= 'margin-bottom:'. $heading_bottom_margin .'px;';
if ( $heading_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $heading_font_family );
	$heading_css .= 'font-family:'. $heading_font_family .';';
}

$query_args = array(
    'post_type' => 'post',
    'posts_per_page' => $items
);

if ( ! empty( $cat_slug ) )
	$query_args['category_name'] = $cat_slug;

$query = new WP_Query( $query_args );
if ( ! $query->have_posts() ) { return; }
ob_start(); ?>

<div class="agrikole-news <?php echo esc_attr( $cls ); ?>" data-auto="<?php echo esc_attr( $auto_scroll ); ?>" data-column="<?php echo esc_attr( $column ); ?>" data-column2="<?php echo esc_attr( $column2 ); ?>" data-column3="<?php echo esc_attr( $column3 ); ?>" data-gap="<?php echo esc_html( $gap ); ?>">
<?php if ( $query->have_posts() ) : ?>
	<?php wp_enqueue_script( 'agrikole-owlcarousel' ); ?>

	<div class="owl-carousel owl-theme">
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

		<?php
		$img = $img_size = 'agrikole-post-element';

		if ( $thumb == 'element-thumbnail'  ) {
			$images = agrikole_metabox( 'element_thumbnail', "type=image&size=$img_size" );

			foreach ( $images as $image ) {
				$img = $image['url'];
			}
		}

		if ( $thumb == 'featured-image' && has_post_thumbnail() )
			$img = agrikole_get_image( array( 'size' => $img_size, 'format' => 'src' ) );
		?>
		<div class="post-item clearfix">
			<div class="inner">
			<?php
			if ( $img ) {
				echo '<div class="image-wrap"><div class="post-date-custom"><span>'. get_the_date('j M, Y') .'</span></div>';
				echo '<img src="'. esc_attr( $img ) .'" alt="'. esc_html__('Image', 'agrikole') .'"></div>';
			}

			echo '<div class="content-wrap">';
				echo '<div class="meta">';
		            printf( '<span class="author"><a class="name" href="%s" title="%s">%s</a></span>',
		                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		                esc_attr( sprintf( esc_html__( 'View all posts by %s', 'agrikole' ), get_the_author() ) ),
		                get_the_author()
		            );

					if ( comments_open() || get_comments_number() ) {
						echo '<span class="comment">';
						comments_popup_link( esc_html__( '0 comment', 'agrikole' ), esc_html__( '1 Comment', 'agrikole' ), esc_html__( '% Comments', 'agrikole' ) );
						echo '</span>';
					}
				echo '</div>';

				echo '<h3 class="title"><span><a href="'. esc_url( get_the_permalink() ) .'">'. get_the_title() .'</a></span></h3>';

	            if ( $style == 'style-2' ) echo '<div class="excerpt">'. agrikole_trim_words( get_the_excerpt(), 14 ) .'</div>';
				
				echo '<div class="post-link"><a href="'. get_the_permalink() .'" class=""><span>'. esc_html__('Read More', 'agrikole') .'</span></a></div>';

			echo '</div>';
			?>
	        </div>
	    </div><!-- /.posts-item -->
	    
	<?php endwhile; ?>
	</div><!-- /.owl-carousel -->

<?php endif; ?>

<?php wp_reset_postdata(); ?>
</div><!-- /.agrikole-news -->
<?php
$return = ob_get_clean();
echo $return;