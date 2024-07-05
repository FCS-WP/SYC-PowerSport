<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css = $item_css = $row_css = $content_css = '';
$thumb_css = $heading_css = $desc_css = $button_css = '';
$name_css = $position_css = $text_css = '';

extract( shortcode_atts( array(
	'style' => 'style-1',
	'alignment' => 'text-center',
	'image_crop' => 'full',
	'items'		=> '3',
	'cat_slug' => '',
	'gapv'		=> '30',
	'gaph'		=> '40',
	'column'		=> '3c',
	'name_font_family' => 'Default',
	'name_font_weight' => 'Default',
	'name_color' => '',
	'name_font_size' => '',
	'name_line_height' => '',
	'position_font_family' => 'Default',
	'position_font_weight' => 'Default',
	'position_color' => '',
	'position_font_size' => '',
	'position_line_height' => '',
	'text_font_family' => 'Default',
	'text_font_weight' => 'Default',
	'text_color' => '',
	'text_font_size' => '',
	'text_line_height' => '',
	'name_top_margin' => '',
	'name_bottom_margin' => '',
	'position_top_margin' => '',
	'position_bottom_margin' => '',
	'text_top_margin' => '',
	'text_bottom_margin' => ''
), $atts ) );

$items = intval( $items );
$column = intval( $column );
$gapv = intval( $gapv );
$gaph = intval( $gaph );

$name_line_height = intval( $name_line_height );
$name_font_size = intval( $name_font_size );
$position_line_height = intval( $position_line_height );
$position_font_size = intval( $position_font_size );
$text_line_height = intval( $text_line_height );
$text_font_size = intval( $text_font_size );

$name_top_margin = intval( $name_top_margin );
$name_bottom_margin = intval( $name_bottom_margin );
$position_top_margin = intval( $position_top_margin );
$position_bottom_margin = intval( $position_bottom_margin );
$text_top_margin = intval( $text_top_margin );
$text_bottom_margin = intval( $text_bottom_margin );

if ( empty( $items ) ) return;

$cls = $alignment .' col-'. $column;

$css = 'margin:-'. $gaph/2 .'px -'. $gapv/2 .'px;';
$item_css = 'padding:0 '. $gapv/2 .'px;';
$row_css = 'padding:'. $gaph/2 .'px 0;';

if ( $name_font_weight != 'Default' ) $name_css .= 'font-weight:'. $name_font_weight .';';
if ( $name_color ) $name_css .= 'color:'. $name_color .';';
if ( $name_font_size ) $name_css .= 'font-size:'. $name_font_size .'px;';
if ( $name_line_height ) $name_css .= 'line-height:'. $name_line_height .'px;';
if ( $name_top_margin ) $name_css .= 'margin-top:'. $name_top_margin .'px;';
if ( $name_bottom_margin ) $name_css .= 'margin-bottom:'. $name_bottom_margin .'px;';
if ( $name_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $name_font_family );
	$name_css .= 'font-family:'. $name_font_family .';';
}

if ( $position_font_weight != 'Default' ) $position_css .= 'font-weight:'. $position_font_weight .';';
if ( $position_color ) $position_css .= 'color:'. $position_color .';';
if ( $position_font_size ) $position_css .= 'font-size:'. $position_font_size .'px;';
if ( $position_line_height ) $position_css .= 'line-height:'. $position_line_height .'px;';
if ( $position_top_margin ) $position_css .= 'margin-top:'. $position_top_margin .'px;';
if ( $position_bottom_margin ) $position_css .= 'margin-bottom:'. $position_bottom_margin .'px;';
if ( $position_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $position_font_family );
	$position_css .= 'font-family:'. $position_font_family .';';
}

if ( $text_font_weight != 'Default' ) $text_css .= 'font-weight:'. $text_font_weight .';';
if ( $text_color ) $text_css .= 'color:'. $text_color .';';
if ( $text_font_size ) $text_css .= 'font-size:'. $text_font_size .'px;';
if ( $text_line_height ) $text_css .= 'line-height:'. $text_line_height .'px;';
if ( $text_top_margin ) $text_css .= 'margin-top:'. $text_top_margin .'px;';
if ( $text_bottom_margin ) $text_css .= 'margin-bottom:'. $text_bottom_margin .'px;';
if ( $text_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $text_font_family );
	$text_css .= 'font-family:'. $text_font_family .';';
}

$query_args = array(
    'post_type' => 'member',
    'posts_per_page' => $items
);

if ( ! empty( $cat_slug ) ) {
	$query_args['tax_query'] = array(
		array(
			'taxonomy' => 'member_category',
			'field'    => 'slug',
			'terms'    => $cat_slug
		),
	);
}

$query = new WP_Query( $query_args );
if ( ! $query->have_posts() ) { echo "Member post not found!"; return; }
ob_start(); ?>

<div class="agrikole-team-grid <?php echo esc_attr( $cls ); ?>" style="<?php echo esc_attr( $css ); ?>">
<?php $i = 0; if ( $query->have_posts() ) : ?>
	<div class="team-wrap clearfix">
    <?php while ( $query->have_posts() ) : $query->the_post();
    	if ( $i == 0 ) { echo '<div class="team-row clearfix" style="'. $row_css .'">'; } ?>
    	<div class="member-item clearfix <?php echo esc_attr( $style ); ?>" style="<?php echo esc_attr( $item_css ); ?>">
    		<div class="inner">
    			<?php
    			$socials_html = '';

	        	if ( agrikole_metabox( 'facebook' )
    			|| agrikole_metabox( 'twitter' )
    			|| agrikole_metabox( 'linkedin' )
    			|| agrikole_metabox( 'instagram' ) ) :

	        	$socials_html .= '<ul class="socials clearfix">';
	        	if ( agrikole_metabox( 'facebook' ) )
        		$socials_html .= '<li class="facebook"><a target="_blank" href="'. esc_url( agrikole_metabox( 'facebook' ) ) .'"><i class="fa fa-facebook"></i></a></li>';

        		if ( agrikole_metabox( 'twitter' ) )
        		$socials_html .= '<li class="twitter"><a target="_blank" href="'. esc_url( agrikole_metabox( 'twitter' ) ) .'"><i class="fa fa-twitter"></i></a></li>';

        		if ( agrikole_metabox( 'linkedin' ) )
        		$socials_html .= '<li class="linkedin"><a target="_blank" href="'. esc_url( agrikole_metabox( 'linkedin' ) ) .'"><i class="fa fa-linkedin"></i></a></li>';

        		if ( agrikole_metabox( 'instagram' ) )
        		$socials_html .= '<li class="instagram"><a target="_blank" href="'. esc_url( agrikole_metabox( 'instagram' ) ) .'"><i class="fa fa-instagram"></i></a></li>';
	        	$socials_html .= '</ul>';

	        	endif; ?>

	            <?php if ( has_post_thumbnail() ) : ?>
    				<div class="thumb">
	    				<?php
				    	$img_size = 'full';
						if ( $image_crop == 'square' ) $img_size = 'agrikole-square';
						if ( $image_crop == 'rectangle' ) $img_size = 'agrikole-rectangle';
						if ( $image_crop == 'rectangle1' ) $img_size = 'agrikole-rectangle1';
						if ( $image_crop == 'rectangle2' ) $img_size = 'agrikole-rectangle2';

    					echo get_the_post_thumbnail( get_the_ID(), $img_size ); ?>
    				</div><!-- /.thumb -->
         		<?php endif; ?>

             	<?php if ( agrikole_metabox( 'name' ) || agrikole_metabox( 'position' ) || agrikole_metabox( 'text' ) ) : ?>
             		<div class="text-wrap">
				        <?php if ( agrikole_metabox( 'position' ) ) : ?>
				        	<div class="position" style="<?php echo esc_attr( $position_css ); ?>">
				        	<?php echo agrikole_metabox( 'position' ); ?></div>
				        <?php endif; ?>

				        <?php if ( agrikole_metabox( 'name' ) ) : ?>
				        	<h4 class="name" style="<?php echo esc_attr( $name_css ); ?>">
				        	<?php echo esc_html( agrikole_metabox( 'name' ) ); ?></h4>
				        <?php endif; ?>

				        <?php if ( agrikole_metabox( 'text' ) ) : ?>
				        	<div class="text" style="<?php echo esc_attr( $text_css ); ?>">
				        	<?php echo agrikole_metabox( 'text' ); ?></div>
				        <?php endif; ?>

				        <?php echo $socials_html; ?>
			        </div>
		        <?php endif; ?>
    		</div><!-- /.inner -->
        </div><!-- /.member-item -->
		<?php
		$i++;
		if ( $i == $column ) { $i = 0; echo '</div>'; }
		?>
	<?php endwhile; ?>
	<?php
	if ( $i > 0 ) echo '</div>';
	?>
	</div><!-- /.team-wrap -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>
</div><!-- /.agrikole-team-grid -->

<?php
$return = ob_get_clean();
echo $return;