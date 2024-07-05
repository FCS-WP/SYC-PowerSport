<?php
/**
 * Footer setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Footer General
$this->sections['agrikole_footer_general'] = array(
	'title' => esc_html__( 'General', 'agrikole' ),
	'panel' => 'agrikole_footer',
	'settings' => array(
		array(
			'id' => 'footer_columns',
			'default' => '4',
			'control' => array(
				'label' => esc_html__( 'Footer Column(s)', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'5' => '4-2-3-3',
					'4' => '3-3-3-3',
					'3' => '4-4-4',
					'2' => '6-6',
					'1' => '12',
				),
			),
		),
		array(
			'id' => 'footer_column_gutter',
			'default' => '30',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Footer Column Gutter', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'5'    => '5px',
					'10'   => '10px',
					'15'   => '15px',
					'20'   => '20px',
					'25'   => '25px',
					'30'   => '30px',
					'35'   => '35px',
					'40'   => '40px',
					'45'   => '45px',
					'50'   => '50px',
					'60'   => '60px',
					'70'   => '70px',
					'80'   => '80px',
				),
				'active_callback' => 'agrikole_cac_has_footer_simple',
			),
		),
		array(
			'id' => 'footer_text_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Text Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '#footer-widgets .widget',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'footer_background',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '#footer',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'footer_bg_img',
			'control' => array(
				'type' => 'image',
				'label' => esc_html__( 'Background Image', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '#footer',
				'alter' => 'background-image',
			),
		),
		array(
			'id' => 'footer_bg_img_style',
			'default' => '',
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
			),
				'inline_css' => array(
				'target' => '#footer',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'footer_top_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Top Padding', 'agrikole' ),
				'description' => esc_html__( 'Example: 60px.', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '#footer',
				'alter' => 'padding-top',
			),
		),
		array(
			'id' => 'footer_bottom_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Bottom Padding', 'agrikole' ),
				'description' => esc_html__( 'Example: 60px.', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '#footer',
				'alter' => 'padding-bottom',
			),
		),
	),
);