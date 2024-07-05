<?php
/**
 * Layout setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Layout Style
$this->sections['agrikole_layout_style'] = array(
	'title' => esc_html__( 'Layout Site', 'agrikole' ),
	'panel' => 'agrikole_layout',
	'settings' => array(
		array(
			'id' => 'site_layout_style',
			'default' => 'full-width',
			'control' => array(
				'label' => esc_html__( 'Layout Style', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'full-width' => esc_html__( 'Full Width','agrikole' ),
					'boxed' => esc_html__( 'Boxed','agrikole' )
				),
			),
		),
		array(
			'id' => 'site_layout_boxed_shadow',
			'control' => array(
				'label' => esc_html__( 'Box Shadow', 'agrikole' ),
				'type' => 'checkbox',
				'active_callback' => 'agrikole_cac_has_boxed_layout',
			),
		),
		array(
			'id' => 'site_layout_wrapper_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Wrapper Margin', 'agrikole' ),
				'desc' => esc_html__( 'Top Right Bottom Left. Default: 30px 0px 30px 0px.', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_boxed_layout',
			),
			'inline_css' => array(
				'target' => '.site-layout-boxed #wrapper',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'wrapper_background_color',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Outer Background Color', 'agrikole' ),
				'type' => 'color',
				'active_callback' => 'agrikole_cac_has_boxed_layout',
			),
			'inline_css' => array(
				'target' => '.site-layout-boxed #wrapper',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'wrapper_background_img',
			'control' => array(
				'label' => esc_html__( 'Outer Background Image', 'agrikole' ),
				'type' => 'image',
				'active_callback' => 'agrikole_cac_has_boxed_layout',
			),
		),
		array(
			'id' => 'wrapper_background_img_style',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Outer Background Image Style', 'agrikole' ),
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
				'active_callback' => 'agrikole_cac_has_boxed_layout',
			),
		),
	),
);

// Layout Position
$this->sections['agrikole_layout_position'] = array(
	'title' => esc_html__( 'Layout Position', 'agrikole' ),
	'panel' => 'agrikole_layout',
	'settings' => array(
		array(
			'id' => 'site_layout_position',
			'default' => 'sidebar-right',
			'control' => array(
				'label' => esc_html__( 'Site Layout Position', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Right Sidebar', 'agrikole' ),
					'sidebar-left'  => esc_html__( 'Left Sidebar', 'agrikole' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'agrikole' ),
				),
				'desc' => esc_html__( 'Specify layout for all pages on website. (e.g. pages, blog posts, single post, archives, etc ). Single page can override this setting in Page Settings metabox when edit.', 'agrikole' )
			),
		),
		array(
			'id' => 'single_post_layout_position',
			'default' => 'sidebar-right',
			'control' => array(
				'label' => esc_html__( 'Single Post Layout Position', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Right Sidebar', 'agrikole' ),
					'sidebar-left'  => esc_html__( 'Left Sidebar', 'agrikole' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'agrikole' ),
				),
				'desc' => esc_html__( 'Specify layout for all single post pages.', 'agrikole' )
			),
		),
	),
);

// Layout Widths
$this->sections['agrikole_layout_widths'] = array(
	'title' => esc_html__( 'Layout Widths', 'agrikole' ),
	'panel' => 'agrikole_layout',
	'settings' => array(
		array(
			'id' => 'site_desktop_container_width',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Container', 'agrikole' ),
				'type' => 'text',
				'desc' => esc_html__( 'Default: 1170px', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array( 
					'.site-layout-full-width .agrikole-container',
					'.site-layout-boxed #page'
				),
				'alter' => 'width',
			),
		),
		array(
			'id' => 'left_container_width',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Content', 'agrikole' ),
				'type' => 'text',
				'desc' => esc_html__( 'Example: 66%', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '#site-content',
				'alter' => 'width',
			),
		),
		array(
			'id' => 'sidebar_width',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Sidebar', 'agrikole' ),
				'type' => 'text',
				'desc' => esc_html__( 'Example: 28%', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '#sidebar',
				'alter' => 'width',
			),
		),
	),
);