<?php
/**
 * Metabox Options
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return the registered-widget array
function agrikole_get_widget_registered() {
	global $wp_registered_sidebars;

	$widgets_areas = array();
	if ( ! empty( $wp_registered_sidebars ) ) {
		foreach ( $wp_registered_sidebars as $widget_area ) {
			$name = isset ( $widget_area['name'] ) ? $widget_area['name'] : '';
			$id = isset ( $widget_area['id'] ) ? $widget_area['id'] : '';
			if ( $name && $id ) {
				$widgets_areas[$id] = $name;
			}
		}
	}

	return $widgets_areas;
}

// Return the all-widget array
function agrikole_get_widget_mods() {
	$new_arr = array();
	$widget_areas_mod = agrikole_get_mod( 'widget_areas' );
	
	if (is_array($widget_areas_mod) || is_object($widget_areas_mod)) {
		foreach( $widget_areas_mod as $key ) {
			$new_arr[sanitize_key($key)] = $key;
		}
	}
	
	$widget_areas = agrikole_get_widget_registered() + $new_arr;

	return $widget_areas;
}

// Registering meta boxes. Using Meta Box plugin: https://metabox.io/
function agrikole_register_meta_boxes( $meta_boxes ) {
	// Element Thumbnail
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Element Thumbnail', 'agrikole' ),
		'id'     => 'opt-meta-box-element-thumbnail',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Image', 'agrikole' ),
				'id'   => 'element_thumbnail',
				'type' => 'image_advanced',
				'max_file_uploads' => 1
			),
		),
	);
	// Post Format Gallery
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Post Format: Gallery', 'agrikole' ),
		'id'     => 'opt-meta-box-post-format-gallery',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Images', 'agrikole' ),
				'id'   => 'gallery_images',
				'type' => 'image_advanced',
			),
		),
	);

	// Post Format Video
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Post Format: Video ( Embeded video from youtube, vimeo...)', 'agrikole' ),
		'id'     => 'opt-meta-box-post-format-video',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Video URL or Embeded Code', 'agrikole' ),
				'id'   => 'video_url',
				'type' => 'textarea',
			),
		)
	);

	// Partner
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Partner Settings', 'agrikole' ),
		'id'     => 'opt-meta-box-partner',
		'pages'  => array( 'partner' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Hyperlink', 'agrikole' ),
				'id'   => 'partner_hyperlink',
				'type'       => 'text',
				'desc'  => esc_html__( "Partne's URL. Leave blank to disable (please 'http://' included).", 'agrikole' )
			),
		)
	);

	// Portfolio
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Project Settings', 'agrikole' ),
		'id'     => 'opt-meta-box-project',
		'pages'  => array( 'project' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Custom Title', 'agrikole' ),
				'id'   => 'title',
				'type' => 'textarea',
			),
			array(
				'name' => esc_html__( 'Short Description', 'agrikole' ),
				'id'   => 'project_desc',
				'type' => 'textarea',
			),
			array(
				'name'    => esc_html__( 'Image Cropping', 'agrikole' ),
				'id'      => 'image_crop',
				'type'    => 'select',
				'options' => array(
					'full' => esc_html__( 'Full', 'agrikole' ),
					'std1' => esc_html__( '640 x 640', 'agrikole' ),
					'std2' => esc_html__( '640 x 430', 'agrikole' ),
					'square' => esc_html__( '370 x 370', 'agrikole' ),
					'rectangle' => esc_html__( '370 x 480', 'agrikole' ),
					'rectangle2' => esc_html__( '370 x 400', 'agrikole' ),
					'rectangle3' => esc_html__( '370 x 310', 'agrikole' ),
				),
				'std'     => 'full',
			),
		)
	);

	// Member
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Member Information', 'agrikole' ),
		'id'     => 'opt-meta-box-pages',
		'pages'  => array( 'member' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Name', 'agrikole' ),
				'id'   => 'name',
				'type'       => 'text',
			),
			array(
				'name' => esc_html__( 'Position', 'agrikole' ),
				'id'   => 'position',
				'type'       => 'textarea',
			),
			array(
				'name' => esc_html__( 'Text', 'agrikole' ),
				'id'   => 'text',
				'type'       => 'textarea',
			),
			array(
				'name' => esc_html__( 'Facebook', 'agrikole' ),
				'id'   => 'facebook',
				'type'       => 'text',
			),
			array(
				'name' => esc_html__( 'Twitter', 'agrikole' ),
				'id'   => 'twitter',
				'type'       => 'text',
			),
			array(
				'name' => esc_html__( 'Linkedin', 'agrikole' ),
				'id'   => 'linkedin',
				'type'       => 'text',
			),
			array(
				'name' => esc_html__( 'Instagram', 'agrikole' ),
				'id'   => 'instagram',
				'type'       => 'text',
			),
		)
	);

	// Testimonials
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Testimonials Information', 'agrikole' ),
		'id'     => 'opt-meta-box-pages',
		'pages'  => array( 'testimonials' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Name', 'agrikole' ),
				'id'   => 'name',
				'type'       => 'text',
			),
			array(
				'name' => esc_html__( 'Position', 'agrikole' ),
				'id'   => 'position',
				'type'       => 'text',
			),
			array(
				'name' => esc_html__( 'Text', 'agrikole' ),
				'id'   => 'text',
				'type' => 'textarea',
			),
		)
	);

	// Header Settings
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Header Settings', 'agrikole' ),
		'id'     => 'opt-meta-box-header',
		'pages'  => array( 'page' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Custom Logo', 'agrikole' ),
			    'type' => 'single_image',
			    'id'   => 'custom_header_logo',
			),
			array(
				'name'    => esc_html__( 'Style', 'agrikole' ),
				'id'      => 'header_style',
				'type'    => 'select',
				'options' => array(
					'style-1' => esc_html__( 'Basic', 'agrikole' ),
					'style-2' => esc_html__( 'Center', 'agrikole' ),
					'style-3' => esc_html__( 'Center Float', 'agrikole' ),
					'style-4' => esc_html__( 'Fullwidth', 'agrikole' ),
					'style-5' => esc_html__( 'Fullwidth Float', 'agrikole' ),
				),
				'std'     => 'style-1',
			),
			array(
			    'name'	=> esc_html__( 'Background', 'agrikole' ),
			    'id'	=> 'header_background',
			    'type'	=> 'color',
			    'alpha_channel' => true,
			    'js_options'    => array(
			        'palettes' => array( '#000000', '#ffffff', '#dd3333', '#dd9933', '#eeee22', '#81d742', '#1e73be', '#8224e3' )
			    ),
			),
			array(
				'name' => esc_html__( 'Border Width', 'agrikole' ),
				'id'   => 'header_border_width',
				'type' => 'text',
				'desc'    => esc_html__( 'Top Right Bottom Left. Ex: 0px 0px 1px 0px', 'agrikole' )
			),
			array(
			    'name'	=> esc_html__( 'Border Color', 'agrikole' ),
			    'id'	=> 'header_border_color',
			    'type'	=> 'color',
			    'alpha_channel' => true,
			    'js_options'    => array(
			        'palettes' => array( '#000000', '#ffffff', '#dd3333', '#dd9933', '#eeee22', '#81d742', '#1e73be', '#8224e3' )
			    ),
			),
		)
	);

	// Featured Title Settings
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Featured Title Settings', 'agrikole' ),
		'id'     => 'opt-meta-box-featured-title',
		'pages'  => array( 'page' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Hide?', 'agrikole' ),
				'id'   => 'hide_featured_title',
				'type' => 'checkbox',
			),
			array(
				'type'		=>	'image_advanced',
				'name'		=>	esc_html__( 'Background', 'agrikole' ),
				'id'		=>	'featured_title_bg',
			    'max_file_uploads' => 1,
			),
			array(
				'type'		=>	'text',
				'name'		=>	esc_html__( 'Custom Title', 'agrikole' ),
				'id'		=>	'custom_featured_title',
			),
		)
	);

	// Main Content Settings
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Main Content Settings', 'agrikole' ),
		'id'     => 'opt-meta-box-main-content',
		'pages'  => array( 'page' ),
		'fields' => array(
			array(
				'name'    => esc_html__( 'Layout Position', 'agrikole' ),
				'id'      => 'page_layout',
				'type'    => 'image_select',
				'options' => array(
					'no-sidebar'  => get_template_directory_uri() . '/assets/admin/img/full-content.png',
					'sidebar-left'  => get_template_directory_uri() . '/assets/admin/img/sidebar-left.png',
					'sidebar-right' => get_template_directory_uri() . '/assets/admin/img/sidebar-right.png',
				),
				'std' 		=> 'no-sidebar',
			),
			array(
				'name'    => esc_html__( 'Sidebar', 'agrikole' ),
				'id'      => 'page_sidebar',
				'type'    => 'select',
				'options' => agrikole_get_widget_mods(),
				'std'     => 'sidebar-page',
				'desc'    => esc_html__( 'This option do not apply if Layout Position is full-width.', 'agrikole' )
			),
			array(
			    'name'          => 'Background Color',
			    'id'            => 'main_content_bg',
			    'type'          => 'color',
			    'alpha_channel' => true,
			),
			array(
				'type'		=>	'image_advanced',
				'name'		=>	esc_html__( 'Background Image', 'agrikole' ),
				'id'		=>	'main_content_bg_img',
			    'max_file_uploads' => 1,
			),
			array(
				'name' => esc_html__( 'Remove: Top & Bottom Padding?', 'agrikole' ),
				'id'   => 'hide_padding_content',
				'type' => 'checkbox',
			),
		)
	);

	// Footer Settings
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Footer Settings', 'agrikole' ),
		'id'     => 'opt-meta-box-footer',
		'pages'  => array( 'page' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Hide: Footer?', 'agrikole' ),
				'id'   => 'hide_footer',
				'type' => 'checkbox',
			),
			array(
			    'name'          => 'Footer Widget: Background',
			    'id'            => 'footer_bg',
			    'type'          => 'color',
			    'alpha_channel' => true,
			),
			array(
				'type'		=>	'image_advanced',
				'name'		=>	esc_html__( 'Footer Widget: Image Background', 'agrikole' ),
				'id'		=>	'footer_bg_img',
			    'max_file_uploads' => 1,
			),
			array(
			    'name'          => 'Bottom Bar: Background',
			    'id'            => 'bottom_bg',
			    'type'          => 'color',
			    'alpha_channel' => true,
			),
		)
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'agrikole_register_meta_boxes' );