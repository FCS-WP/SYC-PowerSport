<?php
/**
 * Shop setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Main Shop
$this->sections['agrikole_shop_general'] = array(
	'title' => esc_html__( 'Main Shop', 'agrikole' ),
	'panel' => 'agrikole_shop',
	'settings' => array(
		array(
			'id' => 'shop_layout_position',
			'default' => 'no-sidebar',
			'control' => array(
				'label' => esc_html__( 'Shop Layout Position', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Right Sidebar', 'agrikole' ),
					'sidebar-left'  => esc_html__( 'Left Sidebar', 'agrikole' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'agrikole' ),
				),
				'desc' => esc_html__( 'Specify layout for main shop page.', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
		array(
			'id' => 'shop_featured_title',
			'default' => esc_html__( 'Our Shop', 'agrikole' ),
			'control' => array(
				'label' => esc_html__( 'Shop: Featured Title', 'agrikole' ),
				'type' => 'agrikole_textarea',
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
		array(
			'id' => 'shop_featured_title_background_img',
			'control' => array(
				'type' => 'image',
				'label' => esc_html__( 'Shop: Featured Title Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
		array(
			'id' => 'shop_products_per_page',
			'default' => 6,
			'control' => array(
				'label' => esc_html__( 'Products Per Page', 'agrikole' ),
				'type' => 'number',
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
		array(
			'id' => 'shop_columns',
			'default' => '3',
			'control' => array(
				'label' => esc_html__( 'Shop Columns', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
		array(
			'id' => 'shop_item_bottom_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Item Bottom Margin', 'agrikole' ),
				'description' => esc_html__( 'Example: 30px.', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_woo',
			),
			'inline_css' => array(
				'target' => '.products li',
				'alter' => 'margin-top',
			),
		),
	),
);

// Single Shop
$this->sections['agrikole_single_shop_general'] = array(
	'title' => esc_html__( 'Single Shop', 'agrikole' ),
	'panel' => 'agrikole_shop',
	'settings' => array(
		array(
			'id' => 'shop_single_layout_position',
			'default' => 'no-sidebar',
			'control' => array(
				'label' => esc_html__( 'Shop Single Layout Position', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Right Sidebar', 'agrikole' ),
					'sidebar-left'  => esc_html__( 'Left Sidebar', 'agrikole' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'agrikole' ),
				),
				'desc' => esc_html__( 'Specify layout on the shop single page.', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
		array(
			'id' => 'shop_single_featured_title',
			'default' => esc_html__( 'Our Shop', 'agrikole' ),
			'control' => array(
				'label' => esc_html__( 'Shop Single: Featured Title', 'agrikole' ),
				'type' => 'text',
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
		array(
			'id' => 'shop_single_featured_title_background_img',
			'control' => array(
				'type' => 'image',
				'label' => esc_html__( 'Shop Single: Featured Title Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
	),
);