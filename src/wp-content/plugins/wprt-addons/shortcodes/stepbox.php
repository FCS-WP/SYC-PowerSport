<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$html = $cls = $wrap_css = $item_css = '';

extract( shortcode_atts( array(
	'numberbox' => '',
), $atts ) );

$numberbox = (array) vc_param_group_parse_atts( $numberbox );

$count = 1;
$html .= '<div class="step-wrap clearfix">';

foreach ( $numberbox as $data ) {
	$h_css = $d_css = '';
	$total = count( $numberbox );

	if ( $count == $total ) $item_css = 'last';

	$html .= '<div class="number-box col-'. $total .'" style="'. $item_css .'">';

	if ( ! empty( $data['heading_color'] ) ) $h_css .= 'color:'. $data['heading_color'] .';';
	if ( ! empty( $data['heading_margin'] ) ) $h_css .= 'margin:'. $data['heading_margin'] .';';

	if ( ! empty( $data['desc_color'] ) ) $d_css .= 'color:'. $data['desc_color'] .';';
	if ( ! empty( $data['desc_margin'] ) ) $d_css .= 'margin:'. $data['desc_margin'] .';';

	$html .= '<div class="text-item">';
	$html .= '<div class="number">'. $count .'</div>';
 	if ( ! empty( $data['heading'] ) ) $html .= '<h3 class="heading" style="'. $h_css .'">'. $data['heading'] .'</h3>';
 	if ( ! empty( $data['description'] ) ) $html .= '<div class="desc" style="'. $d_css .'">'. $data['description'] .'</div>';
 	$html .= '</div>';

 	$html .= '</div>';

 	$count++;
}

$html .= '</div>';

echo '<div class="agrikole-step-box '. $cls .'">'. $html .'</div>';
?>