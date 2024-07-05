<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$html = $cls = $wrap_css = $item_css = '';

extract( shortcode_atts( array(
	'style' => 'style-1',
	'boxicon' => '',
	'item_spacing' => '',
	'show_line' => '',
	'line_style' => 'dashed',
	'line_color' => '',
	'line_width' => '',
	'line_offset' => ''
), $atts ) );

$boxicon = (array) vc_param_group_parse_atts( $boxicon );

$count = 1;
$cls = $style;
if ( $item_spacing ) $item_css .= 'margin-bottom:'. intval( $item_spacing ) .'px;';

$html .= '<div class="icon-list-wrap">';

if ( $show_line ) {
	if ( $line_width ) $wrap_css .= 'border-width:'. intval( $line_width ) .'px;';
	if ( $line_color ) $wrap_css .= 'border-color:'. intval( $line_color ) .';';
	if ( $line_style != 'dashed' ) $wrap_css .= 'border-style:'. intval( $line_style ) .';';
	if ( $line_offset ) $wrap_css .= 'left:'. intval( $line_offset ) .'px;';

	$html .= '<div class="line" style="'. $wrap_css .'"></div>';
}

foreach ( $boxicon as $data ) {
	if ( $count == count( $boxicon ) ) $item_css = '';

	$html .= '<div class="icon-list-item" style="'. $item_css .'">';

	$icon = '';
	if ( ! empty( $data['icon_type'] ) ) $icon = 'icon_'. $data['icon_type'];

	if ( ! empty( $data[$icon] ) ) {
		$irand = rand();
		$icon_data = $icon_cls = $icon_css = $text_css = $h_css = $d_css = '';
		$icon_cls = 'icon-'. $irand;

		if ( ! empty( $data['icon_font_size'] ) ) $icon_css .= 'font-size:'. intval( $data['icon_font_size'] ) .'px;';
		if ( ! empty( $data['icon_width'] ) ) $icon_css .= 'width:'. intval( $data['icon_width'] ) .'px;';
		if ( ! empty( $data['icon_border_style'] ) ) $icon_css .= 'border-style:'. $data['icon_border_style'] .';';
		if ( ! empty( $data['icon_height'] ) ) {
			$icon_css .= 'height:'. intval( $data['icon_height'] ) .'px;';
			$text_css .= 'min-height:'. intval( $data['icon_height'] ) .'px;';
		}

		if ( ! empty( $data['icon_border_width'] ) ) $icon_css .= 'border-width:'. intval( $data['icon_border_width'] ) .'px;';
		if ( ! empty( $data['icon_rounded'] ) ) $icon_css .= 'border-radius:'. intval( $data['icon_rounded'] ) .'px;';
		if ( ! empty( $data['icon_line_height'] ) ) $icon_css .= 'line-height:'. intval( $data['icon_line_height'] ) .'px;';

		if ( ! empty( $data['icon_color'] ) ) $icon_data .= ' data-icon="'. $data['icon_color'] .'"';
		if ( ! empty( $data['icon_background'] ) ) $icon_data .= ' data-background="'. $data['icon_background'] .'"';
		if ( ! empty( $data['icon_border'] ) ) $icon_data .= ' data-border="'. $data['icon_border'] .'"';

		if ( ! empty( $data['icon_color_hover'] ) ) $icon_data .= ' data-icon-hover="'. $data['icon_color_hover'] .'"';
		if ( ! empty( $data['icon_background_hover'] ) ) $icon_data .= ' data-background-hover="'. $data['icon_background_hover'] .'"';
		if ( ! empty( $data['icon_border_hover'] ) ) $icon_data .= ' data-border-hover="'. $data['icon_border_hover'] .'"';

		$html .= '<div class="agrikole-icon '. $icon_cls .'"'. $icon_data .'><span class="icon" style="'. $icon_css .'"><i class="'. $data[$icon] .'"></i></span></div>';
	}

	if ( ! empty( $data['heading_color'] ) ) $h_css .= 'color:'. $data['heading_color'] .';';
	if ( ! empty( $data['heading_margin'] ) ) $h_css .= 'margin:'. $data['heading_margin'] .';';

	if ( ! empty( $data['desc_color'] ) ) $d_css .= 'color:'. $data['desc_color'] .';';
	if ( ! empty( $data['desc_margin'] ) ) $d_css .= 'margin:'. $data['desc_margin'] .';';

	$html .= '<div class="text-item" style="'. $text_css .'">';
 	if ( ! empty( $data['heading'] ) ) $html .= '<h3 class="heading" style="'. $h_css .'">'. $data['heading'] .'</h3>';
 	if ( ! empty( $data['description'] ) ) $html .= '<div class="desc" style="'. $d_css .'">'. $data['description'] .'</div>';
 	$html .= '</div>';

 	$html .= '</div>';

 	$count++;
}

$html .= '</div>';

echo '<div class="agrikole-icon-list clearfix '. $cls .'">'. $html .'</div>';
?>