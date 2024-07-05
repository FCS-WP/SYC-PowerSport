<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$heading_html = $prices_html = $url = $link = '';

extract( shortcode_atts( array(
	'switch_text_1' => '',
	'switch_text_2' => '',
	'pricebox' => '',
	'heading' => '',
	'price' => '',
	'currency' => '$',
	'features' => '',
	'button_style' => 'background',
	'button_content' => '',
	'button_content_ex' => '',
	'button_url' => '',
	'new_tab' => 'yes',
	'button_rounded' => '',
	'button_text' => '',
	'button_background' => '',
	'button_border' => '',
	'button_text_hover' => '',
	'button_background_hover' => '',
	'button_border_hover' => ''
), $atts ) );

$pricebox = (array) vc_param_group_parse_atts( $pricebox );

if ( count( $pricebox ) != 6 ) {
	echo 'You need to add 6 price tables for this shortcode!';
	return;
}

$heading_html .= '<div class="pricing-switcher-wrap">
					<div class="switch-text switch-text-1">'. $switch_text_1 .'</div>
					<div class="pricing-switcher">
						<span class="switch"></span>
						<span class="switch"></span>
						<span class="switch-bg"></span>
					</div>
					<div class="switch-text switch-text-2">'. $switch_text_2 .'</div>
				</div>';

$prices_html .= '<div class="pricing-content">';
$count = 0;

foreach ( $pricebox as $data ) {
 	$data['heading'] = isset( $data['heading'] ) ? $data['heading'] : '';
	$data['price'] = isset( $data['price'] ) ? $data['price'] : '';
	$data['currency'] = isset( $data['currency'] ) ? $data['currency'] : '$';
	$data['features'] = isset( $data['features'] ) ? $data['features'] : '';
	$data['button_style'] = isset( $data['button_style'] ) ? $data['button_style'] : 'accent';
	$data['button_content'] = isset( $data['button_content'] ) ? $data['button_content'] : '';
	$data['button_url'] = isset( $data['button_url'] ) ? $data['button_url'] : '';
	$data['new_tab'] = isset( $data['new_tab'] ) ? $data['new_tab'] : 'yes';


	$data['button_rounded'] = isset( $data['button_rounded'] ) ? intval($data['button_rounded']) : '';

	$data['button_text'] = isset( $data['button_text'] ) ? $data['button_text'] : '';
	$data['button_content_ex'] = isset( $data['button_content_ex'] ) ? $data['button_content_ex'] : '';
	$data['button_background'] = isset( $data['button_background'] ) ? $data['button_background'] : '';
	$data['button_border'] = isset( $data['button_border'] ) ? $data['button_border'] : '';
	$data['button_text_hover'] = isset( $data['button_text_hover'] ) ? $data['button_text_hover'] : '';
	$data['button_background_hover'] = isset( $data['button_background_hover'] ) ? $data['button_background_hover'] : '';
	$data['button_border_hover'] = isset( $data['button_border_hover'] ) ? $data['button_border_hover'] : '';

	$rand = rand();
	$btn_cls = 'medium btn-'. $rand;
	$btn_data = '';
	$h_css = '';
	$p_cls = '';
	$text_css = '';
	$btn_css = '';

	$data['new_tab'] = $data['new_tab'] == 'yes' ? '_blank' : '_self';

	if ( $data['button_rounded'] ) $btn_css .= 'border-radius:'. $data['button_rounded'] .'px;';

	if ( $count % 3 == 0 ) $prices_html .='<div class="pricing-boxs"><div class="flex-boxs">';

	$prices_html .= '<div class="pricing-item">';
 	
	 	if ( $data['heading'] ) $prices_html .= '<div class="title" style="'. $h_css .'"><span>'. $data['heading'] .'</span></div>';
		if ( $data['price'] ) $prices_html .= '<div class="price"><span class="inner"><span class="currency">'. $data['currency'] .'</span><span>'. $data['price'] .'</span></span></div>';
		if ( $data['features'] ) $prices_html .= '<div class="features">'. $data['features'] .'</div>';

		if ( $data['button_content'] ) {

			if ( $data['button_text'] )
				$btn_data .= ' data-text="'. $data['button_text'] .'"';

			if ( $data['button_style'] == 'background' ) {
				if ( $data['button_background'] == '#eddd5e' ) {
					$btn_cls .= ' accent';
				} else {
					$btn_cls .= ' custom';
					$btn_data .= ' data-background="'. $data['button_background'] .'"';
				}
			}

			if ( $data['button_style'] == 'outline' ) {
				$btn_cls .= ' outline-2 solid';
				if ( $data['button_border'] == '#eddd5e' ) {
					$btn_cls .= ' outline-accent';
				} else {
					$btn_cls .= ' custom';
					$btn_data .= ' data-border="'. $data['button_border'] .'"';
				}
			}

			if ( $data['button_text_hover'] ) $btn_data .= ' data-text-hover="'. $data['button_text_hover'] .'"';
			if ( $data['button_background_hover'] ) $btn_data .= ' data-background-hover="'. $data['button_background_hover'] .'"';
			if ( $data['button_border_hover'] ) $btn_data .= ' data-border-hover="'. $data['button_border_hover'] .'"';

		    $prices_html .= '<div class="button-wrap"><a target="'. $data['new_tab'] .'" class="agrikole-button '. $btn_cls .'" href="'. $data['button_url'] .'" style="'. $btn_css .'" '. $btn_data .'>'. $data['button_content'] .'</a></div><div class="btn-ex">'. $data['button_content_ex'] .'</div>';
		}
 
	$prices_html .= '</div>';
 	$count++;
	if ( $count % 3 == 0 ) $prices_html .= '</div></div>';
}

$prices_html .= '</div>';

echo '<div class="agrikole-pricing-group">'. $heading_html . $prices_html .'</div>';

?>