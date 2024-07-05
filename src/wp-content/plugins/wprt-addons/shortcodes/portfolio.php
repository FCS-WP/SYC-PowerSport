<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$inner_css = $space = '';

extract( shortcode_atts( array(
	'content_padding' => '',
	'margin' => '',
	'image_crop' => 'full',
	'image_rounded' => 'false',
	'items'			=> '8',
	'gap'			=> '0',
	'cat_slug'	=> '',
	'exclude_cat_slug' => '',
	'auto_scroll' => 'false',
	'center_mode' => 'false',
	'loop' => 'false',
	'show_opacity' => 'false',
	'column'		=> '3c',
	'column2'		=> '2c',
	'column3'		=> '1c',
	'show_bullets' => '',
	'show_arrows' => '',
	'bullet_show' => 'bullet-square',
	'bullet_between' => '50',
    'arrow_offset' => 'center',
    'arrow_offset_v' => '0'
), $atts ) );

$gap = intval( $gap );
$items = intval( $items );
$column = intval( $column );
$column2 = intval( $column2 );
$column3 = intval( $column3 );

if ( empty( $items ) ) return;

$cls = 'arrow-center '. $bullet_show .' ';
$cls .= 'offset'. $arrow_offset .' offset-v'. $arrow_offset_v;

if ( $show_opacity == 'true' ) $cls .= ' show-opacity'; 
if ( $image_rounded == 'true' ) $cls .= ' image-rounded'; 

if ( $margin ) $inner_css .= 'margin:'. $margin .';';

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

$query_args = array(
    'post_type' => 'project',
    'posts_per_page' => $items
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

$query = new WP_Query( $query_args );
if ( ! $query->have_posts() ) { echo "Project item not found!"; return; }
ob_start(); ?>

<div class="agrikole-project <?php echo esc_attr( $cls ); ?>" data-center="<?php echo esc_attr( $center_mode ); ?>" data-loop="<?php echo esc_attr( $loop ); ?>" data-auto="<?php echo esc_attr( $auto_scroll ); ?>" data-column="<?php echo esc_attr( $column ); ?>" data-column2="<?php echo esc_attr( $column2 ); ?>" data-column3="<?php echo esc_attr( $column3 ); ?>" data-gap="<?php echo esc_html( $gap ); ?>">
<div style="<?php echo esc_attr( $inner_css ); ?>">

<?php if ( $query->have_posts() ) : ?>
	<?php wp_enqueue_script( 'agrikole-owlcarousel' ); wp_enqueue_script( 'agrikole-magnificpopup' ); ?>

	<div class="owl-carousel owl-theme">
	    <?php while ( $query->have_posts() ) : $query->the_post(); global $post; ?>
			<div class="project-box">
				<div class="inner">
					<?php
					$img_size = $title = $arrow_html = $btn_html = $desc_html = '';

					if ( $content_padding ) $space .= 'padding:' . $content_padding .';';

					if ( has_post_thumbnail() ) {
				    	if ( $image_crop == 'default' ) $img_size = 'agrikole-'. agrikole_metabox( 'image_crop' );
						if ( $image_crop == 'full' ) $img_size = 'full';
						if ( $image_crop == 'std1' ) $img_size = 'agrikole-std1';
						if ( $image_crop == 'std2' ) $img_size = 'agrikole-std2';
						if ( $image_crop == 'square' ) $img_size = 'agrikole-square';
						if ( $image_crop == 'rectangle' ) $img_size = 'agrikole-rectangle';
						if ( $image_crop == 'rectangle2' ) $img_size = 'agrikole-rectangle2';
						if ( $image_crop == 'rectangle3' ) $img_size = 'agrikole-rectangle3';
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
		<?php endwhile; ?>
	</div><!-- /.owl-carousel -->

<?php endif; ?>
<?php wp_reset_postdata(); ?>

</div>
</div><!-- /.agrikole-project -->

<?php
$return = ob_get_clean();
echo $return;