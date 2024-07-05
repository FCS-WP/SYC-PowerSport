<?php
/**
 * Bottom Bar setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bottom Bar General
$this->sections['agrikole_bottombar_general'] = array(
	'title' => esc_html__( 'General', 'agrikole' ),
	'panel' => 'agrikole_bottombar',
	'settings' => array(
		array(
			'id' => 'bottom_bar',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Enable', 'agrikole' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'bottom_bar_style',
			'default' => 'style-1',
			'control' => array(
				'label' => esc_html__( 'Style', 'agrikole' ),
				'type' => 'select',
				'active_callback' => 'agrikole_cac_has_bottombar',
				'choices' => array(
					'style-1' => esc_html__( 'Centered Content', 'agrikole' ),
					'style-2' => esc_html__( 'Content & Navigation', 'agrikole' ),
				),
			),
		),
		array(
			'id' => 'bottom_copyright',
			'transport' => 'postMessage',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Copyright', 'agrikole' ),
				'type' => 'agrikole_textarea',
				'active_callback' => 'agrikole_cac_has_bottombar',
			),
		),
		array(
			'id' => 'bottom_padding',
			'transport' => 'postMessage',
			'control' =>  array(
				'type' => 'text',
				'label' => esc_html__( 'Padding', 'agrikole' ),
				'description' => esc_html__( 'Top Right Bottom Left.', 'agrikole' ),
				'active_callback'=> 'agrikole_cac_has_bottombar',
			),
			'inline_css' => array(
				'target' => '#bottom .bottom-bar-inner-wrap',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'bottom_background',
			'transport' => 'postMessage',
			'control' =>  array(
				'type' => 'color',
				'label' => esc_html__( 'Background', 'agrikole' ),
				'active_callback'=> 'agrikole_cac_has_bottombar',
			),
			'inline_css' => array(
				'target' => '#bottom',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'bottom_background_img',
			'control' => array(
				'type' => 'image',
				'label' => esc_html__( 'Background Image', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_bottombar',
			),
		),
		array(
			'id' => 'bottom_background_img_style',
			'default' => 'repeat',
			'control' => array(
				'label' => esc_html__( 'Background Image Style', 'agrikole' ),
				'type'  => 'image',
				'type'  => 'select',
				'choices' => array(
					''             => esc_html__( 'Default', 'agrikole' ),
					'cover'        => esc_html__( 'Cover', 'agrikole' ),
					'center-top'        => esc_html__( 'Center Top', 'agrikole' ),
					'fixed-top'    => esc_html__( 'Fixed Top', 'agrikole' ),
					'fixed'        => esc_html__( 'Fixed Center', 'agrikole' ),
					'fixed-bottom' => esc_html__( 'Fixed Bottom', 'agrikole' ),
					'repeat'       => esc_html__( 'Repeat', 'agrikole' ),
					'repeat-x'     => esc_html__( 'Repeat-x', 'agrikole' ),
					'repeat-y'     => esc_html__( 'Repeat-y', 'agrikole' ),
				),
				'active_callback' => 'agrikole_cac_has_bottombar',
			),
		),
		array(
			'id' => 'bottom_color',
			'transport' => 'postMessage',
			'control' =>  array(
				'type' => 'color',
				'label' => esc_html__( 'Color', 'agrikole' ),
				'active_callback'=> 'agrikole_cac_has_bottombar',
			),
			'inline_css' => array(
				'target' => '#bottom',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'line_color',
			'transport' => 'postMessage',
			'control' =>  array(
				'type' => 'color',
				'label' => esc_html__( 'Line Color', 'agrikole' ),
				'active_callback'=> 'agrikole_cac_has_bottombar',
			),
			'inline_css' => array(
				'target' => '#bottom .bottom-bar-inner-wrap:before',
				'alter' => 'background-color',
			),
		),
	),
);