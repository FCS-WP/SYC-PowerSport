<?php
/**
 * Header setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Header General
$this->sections['agrikole_header_general'] = array(
	'title' => esc_html__( 'General', 'agrikole' ),
	'panel' => 'agrikole_header',
	'settings' => array(
		// Header 1 - Basic
		array(
			'id' => 'header_background',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_one',
				'type' => 'color',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-1 #site-header:after'
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'header_background_opacity',
			'transport' => 'postMessage',
			'default' => '1',
			'control' => array(
				'label'  => esc_html__( 'Background Opacity', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_one',
				'type' => 'select',
				'choices' => array(
					'1' => esc_html__( '1', 'agrikole' ),
					'0.9' => esc_html__( '0.9', 'agrikole' ),
					'0.8' => esc_html__( '0.8', 'agrikole' ),
					'0.7' => esc_html__( '0.7', 'agrikole' ),
					'0.6' => esc_html__( '0.6', 'agrikole' ),
					'0.5' => esc_html__( '0.5', 'agrikole' ),
					'0.4' => esc_html__( '0.4', 'agrikole' ),
					'0.3' => esc_html__( '0.3', 'agrikole' ),
					'0.2' => esc_html__( '0.2', 'agrikole' ),
					'0.1' => esc_html__( '0.1', 'agrikole' ),
					'0.0001' => esc_html__( '0', 'agrikole' ),
				),
			),
			'inline_css' => array(
				'target' => '.header-style-1 #site-header:after',
				'alter' => 'opacity',
			),
		),
		array(
			'id' => 'header_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Padding', 'agrikole' ),
				'description' => esc_html__( 'Top Right Bottom Left.', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_one',
			),
			'inline_css' => array(
				'media_query' => '(min-width: 1199px)',
				'target' => '.header-style-1 .site-header-inner',
				'alter' => 'padding',
			),
			'sanitize_callback' => 'esc_url',
		),
		// Header 2 - Fullwidth
		array(
			'id' => 'header_two_background',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_two',
				'type' => 'color',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-2 #site-header'
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'header_two_background_opacity',
			'transport' => 'postMessage',
			'default' => '1',
			'control' => array(
				'label'  => esc_html__( 'Background Opacity', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_two',
				'type' => 'select',
				'choices' => array(
					'1' => esc_html__( '1', 'agrikole' ),
					'0.9' => esc_html__( '0.9', 'agrikole' ),
					'0.8' => esc_html__( '0.8', 'agrikole' ),
					'0.7' => esc_html__( '0.7', 'agrikole' ),
					'0.6' => esc_html__( '0.6', 'agrikole' ),
					'0.5' => esc_html__( '0.5', 'agrikole' ),
					'0.4' => esc_html__( '0.4', 'agrikole' ),
					'0.3' => esc_html__( '0.3', 'agrikole' ),
					'0.2' => esc_html__( '0.2', 'agrikole' ),
					'0.1' => esc_html__( '0.1', 'agrikole' ),
					'0.0001' => esc_html__( '0', 'agrikole' ),
				),
			),
			'inline_css' => array(
				'target' => '.header-style-2 #site-header:after',
				'alter' => 'opacity',
			),
		),
		// Header 3 - Fullwidth Float
		array(
			'id' => 'header_three_background',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_three',
				'type' => 'color',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-3 #site-header'
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'header_three_background_opacity',
			'transport' => 'postMessage',
			'default' => '1',
			'control' => array(
				'label'  => esc_html__( 'Background Opacity', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_three',
				'type' => 'select',
				'choices' => array(
					'1' => esc_html__( '1', 'agrikole' ),
					'0.9' => esc_html__( '0.9', 'agrikole' ),
					'0.8' => esc_html__( '0.8', 'agrikole' ),
					'0.7' => esc_html__( '0.7', 'agrikole' ),
					'0.6' => esc_html__( '0.6', 'agrikole' ),
					'0.5' => esc_html__( '0.5', 'agrikole' ),
					'0.4' => esc_html__( '0.4', 'agrikole' ),
					'0.3' => esc_html__( '0.3', 'agrikole' ),
					'0.2' => esc_html__( '0.2', 'agrikole' ),
					'0.1' => esc_html__( '0.1', 'agrikole' ),
					'0.0001' => esc_html__( '0', 'agrikole' ),
				),
			),
			'inline_css' => array(
				'target' => '.header-style-3 #site-header:after',
				'alter' => 'opacity',
			),
		),
		// Header 4 - Center
		array(
			'id' => 'header_four_background',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_four',
				'type' => 'color',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-4 #site-header:after'
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'header_four_background_opacity',
			'transport' => 'postMessage',
			'default' => '0.0001',
			'control' => array(
				'label'  => esc_html__( 'Background Opacity', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_four',
				'type' => 'select',
				'choices' => array(
					'1' => esc_html__( '1', 'agrikole' ),
					'0.9' => esc_html__( '0.9', 'agrikole' ),
					'0.8' => esc_html__( '0.8', 'agrikole' ),
					'0.7' => esc_html__( '0.7', 'agrikole' ),
					'0.6' => esc_html__( '0.6', 'agrikole' ),
					'0.5' => esc_html__( '0.5', 'agrikole' ),
					'0.4' => esc_html__( '0.4', 'agrikole' ),
					'0.3' => esc_html__( '0.3', 'agrikole' ),
					'0.2' => esc_html__( '0.2', 'agrikole' ),
					'0.1' => esc_html__( '0.1', 'agrikole' ),
					'0.0001' => esc_html__( '0', 'agrikole' ),
				),
			),
			'inline_css' => array(
				'target' => '.header-style-4 #site-header:after',
				'alter' => 'opacity',
			),
		),
		// Header 5 - Center Float
		array(
			'id' => 'header_five_background',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_five',
				'type' => 'color',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-5 #site-header:after'
				),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'header_five_background_opacity',
			'transport' => 'postMessage',
			'default' => '0.0001',
			'control' => array(
				'label'  => esc_html__( 'Background Opacity', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_five',
				'type' => 'select',
				'choices' => array(
					'1' => esc_html__( '1', 'agrikole' ),
					'0.9' => esc_html__( '0.9', 'agrikole' ),
					'0.8' => esc_html__( '0.8', 'agrikole' ),
					'0.7' => esc_html__( '0.7', 'agrikole' ),
					'0.6' => esc_html__( '0.6', 'agrikole' ),
					'0.5' => esc_html__( '0.5', 'agrikole' ),
					'0.4' => esc_html__( '0.4', 'agrikole' ),
					'0.3' => esc_html__( '0.3', 'agrikole' ),
					'0.2' => esc_html__( '0.2', 'agrikole' ),
					'0.1' => esc_html__( '0.1', 'agrikole' ),
					'0.0001' => esc_html__( '0', 'agrikole' ),
				),
			),
			'inline_css' => array(
				'target' => '.header-style-5 #site-header:after',
				'alter' => 'opacity',
			),
		),
	)
);

// Header Info
$this->sections['agrikole_header_info'] = array(
	'title' => esc_html__( 'Information', 'agrikole' ),
	'panel' => 'agrikole_header',
	'settings' => array(
		array(
			'id' => 'header_info_email',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Email', 'agrikole' ),
				'type' => 'agrikole_textarea',
				'rows' => 3,
				'active_callback' => 'agrikole_cac_has_header_center',
			),
		),
		array(
			'id' => 'header_info_phone',
			'default' => '+1 (139) 946 2758',
			'control' => array(
				'label' => esc_html__( 'Phone', 'agrikole' ),
				'type' => 'agrikole_textarea',
				'rows' => 3,
				'active_callback' => 'agrikole_cac_has_header_center',
			),
		),
	),
);

// Header Logo
$this->sections['agrikole_header_logo'] = array(
	'title' => esc_html__( 'Logo', 'agrikole' ),
	'panel' => 'agrikole_header',
	'settings' => array(
		// Logo 1
		array(
			'id' => 'logo_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Logo Margin', 'agrikole' ),
		 		'description' => esc_html__( 'Top Right Bottom Left. Example: 30px 0px 0px 0px.', 'agrikole' ),
		 		'active_callback' => 'agrikole_cac_has_header_one',
			),
			'inline_css' => array(
				'media_query' => '(min-width: 992px)',
				'target' => '.header-style-1 #site-logo-inner',
				'alter' => 'margin',
			),
		),
		array(
			'id' => 'custom_logo',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Logo Image', 'agrikole' ),
				'type' => 'image',
				'active_callback' => 'agrikole_cac_has_header_one',
			),
		),
		array(
			'id' => 'logo_width',
			'control' => array(
				'label' => esc_html__( 'Logo Width', 'agrikole' ),
				'type' => 'text',
				'active_callback' => 'agrikole_cac_has_header_one',
			),
		),
		// Logo 2
		array(
			'id' => 'logotwo_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Logo Margin', 'agrikole' ),
		 		'description' => esc_html__( 'Top Right Bottom Left. Example: 30px 0px 0px 0px.', 'agrikole' ),
		 		'active_callback' => 'agrikole_cac_has_header_two',
			),
			'inline_css' => array(
				'media_query' => '(min-width: 992px)',
				'target' => '.header-style-2 #site-logo-inner',
				'alter' => 'margin',
			),
		),
		array(
			'id' => 'custom_logotwo',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Logo Image', 'agrikole' ),
				'type' => 'image',
				'active_callback' => 'agrikole_cac_has_header_two',
			),
		),
		array(
			'id' => 'logotwo_width',
			'control' => array(
				'label' => esc_html__( 'Logo Width', 'agrikole' ),
				'type' => 'text',
				'active_callback' => 'agrikole_cac_has_header_two',
			),
		),
		// Logo 3
		array(
			'id' => 'logothree_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Logo Margin', 'agrikole' ),
		 		'description' => esc_html__( 'Top Right Bottom Left. Example: 30px 0px 0px 0px.', 'agrikole' ),
		 		'active_callback' => 'agrikole_cac_has_header_three',
			),
			'inline_css' => array(
				'media_query' => '(min-width: 992px)',
				'target' => '.header-style-3 #site-logo-inner',
				'alter' => 'margin',
			),
		),
		array(
			'id' => 'custom_logothree',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Logo Image', 'agrikole' ),
				'type' => 'image',
				'active_callback' => 'agrikole_cac_has_header_three',
			),
		),
		array(
			'id' => 'logothree_width',
			'control' => array(
				'label' => esc_html__( 'Logo Width', 'agrikole' ),
				'type' => 'text',
				'active_callback' => 'agrikole_cac_has_header_three',
			),
		),
		// Logo 4
		array(
			'id' => 'logofour_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Logo Margin', 'agrikole' ),
		 		'description' => esc_html__( 'Top Right Bottom Left. Example: 30px 0px 0px 0px.', 'agrikole' ),
		 		'active_callback' => 'agrikole_cac_has_header_four',
			),
			'inline_css' => array(
				'media_query' => '(min-width: 992px)',
				'target' => '.header-style-4 #site-logo-inner',
				'alter' => 'margin',
			),
		),
		array(
			'id' => 'custom_logofour',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Logo Image', 'agrikole' ),
				'type' => 'image',
				'active_callback' => 'agrikole_cac_has_header_four',
			),
		),
		array(
			'id' => 'logofour_width',
			'control' => array(
				'label' => esc_html__( 'Logo Width', 'agrikole' ),
				'type' => 'text',
				'active_callback' => 'agrikole_cac_has_header_four',
			),
		),
		// Logo 5
		array(
			'id' => 'logofive_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Logo Margin', 'agrikole' ),
		 		'description' => esc_html__( 'Top Right Bottom Left. Example: 30px 0px 0px 0px.', 'agrikole' ),
		 		'active_callback' => 'agrikole_cac_has_header_five',
			),
			'inline_css' => array(
				'media_query' => '(min-width: 992px)',
				'target' => '.header-style-5 #site-logo-inner',
				'alter' => 'margin',
			),
		),
		array(
			'id' => 'custom_logofive',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Logo Image', 'agrikole' ),
				'type' => 'image',
				'active_callback' => 'agrikole_cac_has_header_five',
			),
		),
		array(
			'id' => 'logofive_width',
			'control' => array(
				'label' => esc_html__( 'Logo Width', 'agrikole' ),
				'type' => 'text',
				'active_callback' => 'agrikole_cac_has_header_five',
			),
		),
	)
);

// Header Menu
$this->sections['agrikole_header_menu'] = array(
	'title' => esc_html__( 'Menu', 'agrikole' ),
	'panel' => 'agrikole_header',
	'settings' => array(
		// General
		array(
			'id' => 'menu_link_spacing',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Link Spacing', 'agrikole' ),
				'description' => esc_html__( 'Example: 20px', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'#main-nav > ul > li',
				),
				'alter' => array(
					'padding-left',
					'padding-right',
				),
			),
		),
		array(
			'id' => 'menu_height',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Menu Height', 'agrikole' ),
				'description' => esc_html__( 'Example: 100px', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'#site-header #main-nav > ul > li > a',
				),
				'alter' => array(
					'height',
					'line-height',
				),
			),
		),
		// Header 1
		array(
			'id' => 'menu_link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_one',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-1 #main-nav > ul > li > a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'menu_link_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color: Hover', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_one',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-1 #main-nav > ul > li > a:hover',
				),
				'alter' => 'color',
			),
		),
		// Header 2
		array(
			'id' => 'menu_two_link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_two',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-2 #main-nav > ul > li > a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'menu_two_link_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color: Hover', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_two',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-2 #main-nav > ul > li > a:hover',
				),
				'alter' => 'color',
			),
		),
		// Header 3
		array(
			'id' => 'menu_three_link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_three',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-3 #main-nav > ul > li > a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'menu_three_link_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color: Hover', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_three',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-3 #main-nav > ul > li > a:hover',
				),
				'alter' => 'color',
			),
		),
		// Header 4
		array(
			'id' => 'menu_four_link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_four',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-4 #main-nav > ul > li > a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'menu_four_link_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color: Hover', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_four',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-4 #main-nav > ul > li > a:hover',
				),
				'alter' => 'color',
			),
		),
		// Header 5
		array(
			'id' => 'menu_five_link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_five',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-5 #main-nav > ul > li > a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'menu_five_link_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color: Hover', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_header_five',
			),
			'inline_css' => array(
				'target' => array(
					'.header-style-5 #main-nav > ul > li > a:hover',
				),
				'alter' => 'color',
			),
		),
	)
);

// Search & Cart
$this->sections['agrikole_header_search_cart'] = array(
	'title' => esc_html__( 'Search & Cart', 'agrikole' ),
	'panel' => 'agrikole_header',
	'settings' => array(
		// Search Icon
		array(
			'id' => 'header_search_icon',
			'default' => false,
			'control' => array(
				'label' => esc_html__( 'Search Icon', 'agrikole' ),
				'type' => 'checkbox',
			),
		),
		// Cart Icon
		array(
			'id' => 'header_cart_icon',
			'default' => false,
			'control' => array(
				'label' => esc_html__( 'Cart Icon', 'agrikole' ),
				'type' => 'checkbox',
				'active_callback' => 'agrikole_cac_has_woo',
			),
		),
	)
);

// Socials
$this->sections['agrikole_header_socials'] = array(
	'title' => esc_html__( 'Social', 'agrikole' ),
	'panel' => 'agrikole_header',
	'settings' => array(
		array(
			'id' => 'header_socials',
			'default' => false,
			'control' => array(
				'label' => esc_html__( 'Enable', 'agrikole' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Social settings
$social_options = agrikole_header_social_options();
foreach ( $social_options as $key => $val ) {
	$this->sections['agrikole_header_socials']['settings'][] = array(
		'id' => 'header_social_profiles[' . $key .']',
		'control' => array(
			'label' => $val['label'],
			'type' => 'text',
			'active_callback' => 'agrikole_cac_has_header_socials',
		),
	);
}

// Remove var from memory
unset( $social_options );
