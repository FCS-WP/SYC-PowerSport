<?php
/**
 * General setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Accent Colors
$this->sections['agrikole_accent_colors'] = array(
	'title' => esc_html__( 'Accent Colors', 'agrikole' ),
	'panel' => 'agrikole_general',
	'settings' => array(
		array(
			'id' => 'accent_color',
			'default' => '#eddd5e',
			'control' => array(
				'label' => esc_html__( 'Accent Color', 'agrikole' ),
				'type' => 'color',
			),
		),
	)
);

// Favicon
$this->sections['agrikole_favicon'] = array(
	'title' => esc_html__( 'Favicon', 'agrikole' ),
	'panel' => 'agrikole_general',
	'settings' => array(
		array(
			'id' => 'favicon',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Site Icon', 'agrikole' ),
				'type' => 'image',
				'description' => esc_html__( 'The Site Icon is used as a browser and app icon for your site. Icons must be square, and at least 512 pixels wide and tall.', 'agrikole' ),
			),
		),
	)
);

// PreLoader
$this->sections['agrikole_preloader'] = array(
	'title' => esc_html__( 'PreLoader', 'agrikole' ),
	'panel' => 'agrikole_general',
	'settings' => array(
		array(
			'id' => 'preloader',
			'default' => 'animsition',
			'control' => array(
				'label' => esc_html__( 'Preloader Option', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'animsition' => esc_html__( 'Enable','agrikole' ),
					'' => esc_html__( 'Disable','agrikole' )
				),
			),
		),
		array(
			'id' => 'preload_color_1',
			'default' => '#eddd5e',
			'control' => array(
				'label' => esc_html__( 'Color 1', 'agrikole' ),
				'type' => 'color',
			),
			'inline_css' => array(
				'target' => '.animsition-loading',
				'alter' => 'border-top-color',
			),
		),
		array(
			'id' => 'preload_color_2',
			'default' => '#5b8c51',
			'control' => array(
				'label' => esc_html__( 'Color 2', 'agrikole' ),
				'type' => 'color',
			),
			'inline_css' => array(
				'target' => '.animsition-loading:before',
				'alter' => 'border-top-color',
			),
		),
	)
);

// Header Site
$this->sections['agrikole_header_site'] = array(
	'title' => esc_html__( 'Header Site', 'agrikole' ),
	'panel' => 'agrikole_general',
	'settings' => array(
		array(
			'id' => 'header_site_style',
			'default' => 'style-1',
			'control' => array(
				'label' => esc_html__( 'Header Style', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'style-1' => esc_html__( 'Basic', 'agrikole' ),
					'style-2' => esc_html__( 'Center', 'agrikole' ),
					'style-3' => esc_html__( 'Center Float', 'agrikole' ),
					'style-4' => esc_html__( 'Fullwidth', 'agrikole' ),
					'style-5' => esc_html__( 'Fullwidth Float', 'agrikole' ),
				),
				'desc' => esc_html__( 'Header Style for all pages on website. (e.g. pages, blog posts, single post, archives, etc ). Single page can override this setting in Page Settings metabox when edit.', 'agrikole' )
			),
		),
		array(
			'id' => 'header_fixed',
			'default' => false,
			'control' => array(
				'label' => esc_html__( 'Header Fixed: Enable', 'agrikole' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Scroll to top
$this->sections['agrikole_scroll_top'] = array(
	'title' => esc_html__( 'Scroll Top Button', 'agrikole' ),
	'panel' => 'agrikole_general',
	'settings' => array(
		array(
			'id' => 'scroll_top',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Enable', 'agrikole' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Forms
$this->sections['agrikole_general_forms'] = array(
	'title' => esc_html__( 'Forms', 'agrikole' ),
	'panel' => 'agrikole_general',
	'settings' => array(
		array(
			'id' => 'input_border_rounded',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Rounded', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"]',
				),
				'alter' => 'border-radius',
			),
		),
		array(
			'id' => 'input_background_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"]',
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'input_border_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"]',
				),
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'input_border_width',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Width', 'agrikole' ),
				'description' => esc_html__( 'Enter a value in pixels. Example: 1px', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"]',
				),
				'alter' => 'border-width',
			),
		),
		array(
			'id' => 'input_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"]',
				),
				'alter' => 'color',
			),
		),
	),
);

// Responsive
$this->sections['agrikole_responsive'] = array(
	'title' => esc_html__( 'Responsive', 'agrikole' ),
	'panel' => 'agrikole_general',
	'settings' => array(
		// Mobile Logo
		array(
			'id' => 'heading_mobile_logo',
			'control' => array(
				'type' => 'agrikole-heading',
				'label' => esc_html__( 'Mobile Logo', 'agrikole' ),
			),
		),
		array(
			'id' => 'mobile_logo_width',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Mobile Logo: Width', 'agrikole' ),
				'description' => esc_html__( 'Example: 150px', 'agrikole' ),
			),
			'inline_css' => array(
				'media_query' => '(max-width: 991px)',
				'target' => '#site-logo',
				'alter' => 'max-width',
			),
		),
		array(
			'id' => 'mobile_logo_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Mobile Logo: Margin', 'agrikole' ),
				'description' => esc_html__( 'Example: 20px 0px 20px 0px', 'agrikole' ),
			),
			'inline_css' => array(
				'media_query' => '(max-width: 991px)',
				'target' => '#site-logo-inner',
				'alter' => 'margin',
			),
		),
		// Mobile Menu
		array(
			'id' => 'heading_mobile_menu',
			'control' => array(
				'type' => 'agrikole-heading',
				'label' => esc_html__( 'Mobile Menu', 'agrikole' ),
			),
		),
		array(
			'id' => 'mobile_menu_item_height',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Item Height', 'agrikole' ),
				'description' => esc_html__( 'Example: 40px', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'#main-nav-mobi ul > li > a',
					'#main-nav-mobi .menu-item-has-children .arrow'
				),
				'alter' => 'line-height'
			),
		),
		array(
			'id' => 'mobile_menu_logo',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Mobile Menu Logo', 'agrikole' ),
				'type' => 'image',
			),
		),
		array(
			'id' => 'mobile_menu_logo_width',
			'control' => array(
				'label' => esc_html__( 'Mobile Menu Logo: Width', 'agrikole' ),
				'type' => 'text',
			),
		),
		// Featured Title
		array(
			'id' => 'heading_featured_title',
			'control' => array(
				'type' => 'agrikole-heading',
				'label' => esc_html__( 'Mobile Featured Title', 'agrikole' ),
			),
		),
		array(
			'id' => 'mobile_featured_title_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Padding', 'agrikole' ),
				'description' => esc_html__( 'Top Right Bottom Left.', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title',
			),
			'inline_css' => array(
				'media_query' => '(max-width: 991px)',
				'target' => '#featured-title .inner-wrap',
				'alter' => 'padding',
			),
		),
	)
);