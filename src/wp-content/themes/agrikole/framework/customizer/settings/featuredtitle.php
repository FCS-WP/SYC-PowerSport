<?php
/**
 * Featured Title setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Featured Title General
$this->sections['agrikole_featuredtitle_general'] = array(
	'title' => esc_html__( 'General', 'agrikole' ),
	'panel' => 'agrikole_featuredtitle',
	'settings' => array(
		array(
			'id' => 'featured_title',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Enable', 'agrikole' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'featured_title_style',
			'default' => 'heading_breadcrumbs',
			'control' => array(
				'label'  => esc_html__( 'Style', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'heading_breadcrumbs' => esc_html__( 'Simple', 'agrikole' ),
					'heading_breadcrumbs_centered' => esc_html__( 'Centered', 'agrikole' ),
				),
				'active_callback' => 'agrikole_cac_has_featured_title',
			),
		),
		array(
			'id' => 'featured_title_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Padding', 'agrikole' ),
				'description' => esc_html__( 'Example: 250px 0px 150px 0px', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title',
			),
			'inline_css' => array(
				'media_query' => '(min-width: 992px)',
				'target' => '#featured-title .inner-wrap',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'featured_title_background',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title',
			),
			'inline_css' => array(
				'target' => '#featured-title',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'featured_title_background_img',
			'control' => array(
				'type' => 'image',
				'label' => esc_html__( 'Background Image', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title',
			),
		),
		array(
			'id' => 'featured_title_background_img_style',
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
				'active_callback' => 'agrikole_cac_has_featured_title',
			),
		),
	),
);

// Featured Title Headings
$this->sections['agrikole_featuredtitle_heading'] = array(
	'title' => esc_html__( 'Headings', 'agrikole' ),
	'panel' => 'agrikole_featuredtitle',
	'settings' => array(
		array(
			'id' => 'featured_title_heading',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Enable', 'agrikole' ),
				'type' => 'checkbox',
				'active_callback' => 'agrikole_cac_has_featured_title',
			),
		),
		array(
			'id' => 'featured_title_heading_bottom_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Heading Bottom Margin', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title_center',
				'description' => esc_html__( 'Example: 5px.', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '#featured-title.centered .title-group',
				'alter' => 'margin-bottom',
			),
		),
		array(
			'id' => 'featured_title_heading_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Title Color', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title_heading',
			),
			'inline_css' => array(
				'target' => '#featured-title .main-title',
				'alter' => 'color',
			),
		),
	),
);

// Featured Title Breadcrumbs
$this->sections['agrikole_featuredtitle_breadcrumbs'] = array(
	'title' => esc_html__( 'Breadcrumbs', 'agrikole' ),
	'panel' => 'agrikole_featuredtitle',
	'settings' => array(
		array(
			'id' => 'featured_title_breadcrumbs',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Enable', 'agrikole' ),
				'type' => 'checkbox',
				'active_callback' => 'agrikole_cac_has_featured_title',
			),
		),
		array(
			'id' => 'featured_title_breadcrumbs_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Text Color', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title_breadcrumbs',
			),
			'inline_css' => array(
				'target' => array(
					'#featured-title #breadcrumbs',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'featured_title_breadcrumbs_link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '#featured-title #breadcrumbs a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'featured_title_breadcrumbs_link_hover_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color: Hover', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_featured_title_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '#featured-title #breadcrumbs a:hover',
				'alter' => 'color',
			),
		),
	),
);