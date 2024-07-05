<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $cls1 = $wrap_css = $css = $pcls = $pcss = $css1 = $css2 = $tit = $per = '';

extract( shortcode_atts( array(
	'title' => 'Title',
	'percent' => '90',
	'per_color' => '',
	'space_between' => '10px',
	'height' => '10px',
	'rounded' => '',
	'bottom_margin' => '',
	'line_one' => '#636363',
	'line_two' => '#e5e5e5',
	'gradient' => '',
	'font_family' => 'Default',
	'font_weight' => 'Default',
	'title_color' => '',
	'font_size' => '',
	'per_font_family' => 'Default',
	'per_font_weight' => 'Default',
	'per_font_size' => ''
), $atts ) );

$height = intval( $height );
$rounded = intval( $rounded );
$percent = intval( $percent );
$font_size = intval( $font_size );
$space_between = intval( $space_between );
$bottom_margin = intval( $bottom_margin );

if ( $bottom_margin ) $wrap_css .= 'margin-bottom:'. $bottom_margin .'px;';

if ( empty( $percent ) ) $percent = 90;
if ( empty( $height ) ) $height = 10;

if ( $line_one == '#eddd5e' ) { $cls1 .= ' accent';
} else { if ( $line_one ) $css1 = 'background-color:'. $line_one .';'; }

if ( $gradient && function_exists('agrikole_hex2rgba') ) {
	$cls1 .= ' gradient';
	$css1 = 'background: '. agrikole_hex2rgba($line_one, 1) .';background: -moz-linear-gradient(left, '. agrikole_hex2rgba($line_one, 1) .' 0%, '. agrikole_hex2rgba($line_one, 0.3) .' 100%);background: -webkit-linear-gradient( left, '. agrikole_hex2rgba($line_one, 1) .' 0%, '. agrikole_hex2rgba($line_one, 0.3) .' 100% );background: linear-gradient(to right, '. agrikole_hex2rgba($line_one, 0.3) .' 0%, '. agrikole_hex2rgba($line_one, 1) .' 100%);';
}

if ( $height ) $css1 .= 'height:'. $height .'px;';

if ( $line_two ) $css2 = 'background-color:'. $line_two .';';
if ( $rounded ) {
	$css1 .= 'overflow:hidden;border-radius:'. $rounded .'px;';
	$css2 .= 'overflow:hidden;border-radius:'. $rounded .'px;';
}
if ( $font_weight != 'Default' ) $css .= 'font-weight:'. $font_weight .';';
if ( $title_color ) $css .= 'color:'. $title_color .';';
if ( $font_size ) $css .= 'font-size:'. $font_size .'px;';
if ( $font_family != 'Default' ) {
	agrikole_enqueue_google_font( $font_family );
	$css .= 'font-family:'. $font_family .';';
}

if ( $per_color == '#eddd5e' ) { $pcls .= ' accent';
} else { if ( $per_color ) $pcss .= 'color:'. $per_color .';'; }


if ( ! empty( $title ) )
	$tit = '<div class="title" style="'. $css .'">'. esc_html( $title ) .'</div>';
if ( ! empty( $percent ) )
	$per = '<div class="perc-wrap" style="'. $css .'"><div class="perc '. $pcls .'" style="'. $pcss .'"><span>'. $percent .'%</span></div></div>';

if ( $space_between ) $css2 .= 'margin-top:'. $space_between .'px;';

wp_enqueue_script( 'agrikole-appear' );
printf( '
	<div class="agrikole-progress clearfix %7$s" style="%6$s">%1$s %2$s
		<div class="progress-wrap" style="%4$s">
			<div class="progress-animate %8$s" data-valuemax="100" data-valuemin="0" data-valuenow="%3$s" style="%5$s">
			</div>
		</div>
	</div>', $tit, $per, $percent, $css2, $css1, $wrap_css, $cls, $cls1
);