<?php
/**
 * Projects setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Project Related General
$this->sections['agrikole_projects_general'] = array(
	'title' => esc_html__( 'General', 'agrikole' ),
	'panel' => 'agrikole_projects',
	'settings' => array(
		array(
			'id' => 'project_related',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Enable', 'agrikole' ),
				'type' => 'checkbox',
				'active_callback' => 'agrikole_cac_has_single_project',
			),
		),
		array(
			'id' => 'project_single_featured_title_background_img',
			'control' => array(
				'type' => 'image',
				'label' => esc_html__( 'Single Project: Featured Title Background', 'agrikole' ),
				'active_callback' => 'agrikole_cac_has_related_project',
			),
		),
		array(
			'id' => 'related_pre_title', 
			'default' => esc_html__( 'EXPLORE PROJECTS', 'agrikole' ),
			'control' => array(
				'label' => esc_html__( 'Project Related Pre-Title', 'agrikole' ),
				'type' => 'agrikole_textarea',
				'rows' => 3,
				'active_callback' => 'agrikole_cac_has_related_project',
			),
		),
		array(
			'id' => 'related_title',
			'default' => esc_html__( 'OUR RECENT PROJECTS', 'agrikole' ),
			'control' => array(
				'label' => esc_html__( 'Project Related Title', 'agrikole' ),
				'type' => 'agrikole_textarea',
				'rows' => 3,
				'active_callback' => 'agrikole_cac_has_related_project',
			),
		),
		array(
			'id' => 'project_related_query',
			'default' => 7,
			'control' => array(
				'label' => esc_html__( 'Number of items', 'agrikole' ),
				'type' => 'number',
				'active_callback' => 'agrikole_cac_has_related_project',
			),
		),
		array(
			'id' => 'project_related_column',
			'default' => '3',
			'control' => array(
				'label' => esc_html__( 'Columns', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'4' => '4',
					'3' => '3',
					'2' => '2',
				),
				'active_callback' => 'agrikole_cac_has_related_project',
			),
		),
		array(
			'id' => 'project_related_item_spacing',
			'default' => 30,
			'control' => array(
				'label' => esc_html__( 'Spacing between items', 'agrikole' ),
				'type' => 'number',
				'active_callback' => 'agrikole_cac_has_related_project',
			),
		),
	),
);