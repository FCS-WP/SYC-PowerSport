<?php
/**
 * Blog setting for Customizer
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Blog Posts General
$this->sections['agrikole_blog_post'] = array(
	'title' => esc_html__( 'General', 'agrikole' ),
	'panel' => 'agrikole_blog',
	'settings' => array(
		array(
			'id' => 'blog_featured_title',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Blog Featured Title', 'agrikole' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'blog_entry_content_background',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Entry Content Background Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.post-content-wrap',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'blog_entry_content_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Entry Content Padding', 'agrikole' ),
				'description' => esc_html__( 'Top Right Bottom Left.', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-content-wrap',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'blog_entry_bottom_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Entry Bottom Margin', 'agrikole' ),
				'description' => esc_html__( 'Example: 30px.', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry',
				'alter' => 'margin-top',
			),
		),
		array(
			'id' => 'blog_entry_border_width',
			'transport' => 'postMessage',
			'control' => array (
				'type' => 'text',
				'label' => esc_html__( 'Entry Border Width', 'agrikole' ),
				'description' => esc_html__( 'Top Right Bottom Left. Example: 0px 2px 0px 0px', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-content-wrap',
				'alter' => 'border-width',
			),
		),
		array(
			'id' => 'blog_entry_border_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Entry Border Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-content-wrap',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'blog_entry_composer',
			'default' => 'meta,title,excerpt_content,readmore',
			'control' => array(
				'label' => esc_html__( 'Entry Content Elements', 'agrikole' ),
				'type' => 'agrikole-sortable',
				'object' => 'Agrikole_Customize_Control_Sorter',
				'choices' => array(
					'meta'            => esc_html__( 'Meta', 'agrikole' ),
					'title'           => esc_html__( 'Title', 'agrikole' ),
					'excerpt_content' => esc_html__( 'Excerpt', 'agrikole' ),
					'readmore'        => esc_html__( 'Read More', 'agrikole' ),

				),
				'desc' => esc_html__( 'Drag and drop elements to re-order.', 'agrikole' ),
			),
		),
	),
);

// Blog Custom Date
$this->sections['agrikole_blog_post_custom_date'] = array(
	'title' => esc_html__( 'Blog Post - Custom Date', 'agrikole' ),
	'panel' => 'agrikole_blog',
	'settings' => array(
		array(
			'id' => 'blog_custom_date',
			'default' => false,
			'control' => array(
				'label' => esc_html__( 'Enable Custom Date on Posts', 'agrikole' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Blog Posts Media
$this->sections['agrikole_blog_post_media'] = array(
	'title' => esc_html__( 'Blog Post - Media', 'agrikole' ),
	'panel' => 'agrikole_blog',
	'settings' => array(
		array(
			'id' => 'blog_media_margin_bottom',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Bottom Margin', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-media',
				'alter' => 'margin-bottom',
			),
		),
	),
);

// Blog Posts Title
$this->sections['agrikole_blog_post_title'] = array(
	'title' => esc_html__( 'Blog Post - Title', 'agrikole' ),
	'panel' => 'agrikole_blog',
	'settings' => array(
		array(
			'id' => 'blog_title_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Margin', 'agrikole' ),
				'description' => esc_html__( 'Top Right Bottom Left.', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-title',
				'alter' => 'margin',
			),
		),
		array(
			'id' => 'blog_title_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => array(
					'.hentry .post-title a',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'blog_title_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color Hover', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-title a:hover',
				'alter' => 'color',
			),
		),
	),
);

// Blog Posts Meta
$this->sections['agrikole_blog_post_meta'] = array(
	'title' => esc_html__( 'Blog Post - Meta', 'agrikole' ),
	'panel' => 'agrikole_blog',
	'settings' => array(
		array(
			'id' => 'blog_entry_meta_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Meta Margin', 'agrikole' ),
				'description' => esc_html__( 'Top Right Bottom Left. Example: 0 0 20px 0.', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-meta',
				'alter' => 'margin',
			),
		),
		array(
			'id'  => 'blog_entry_meta_items',
			'default' => array( 'author', 'comments' ),
			'control' => array(
				'label' => esc_html__( 'Meta Items', 'agrikole' ),
				'desc' => esc_html__( 'Click and drag and drop elements to re-order them.', 'agrikole' ),
				'type' => 'agrikole-sortable',
				'object' => 'Agrikole_Customize_Control_Sorter',
				'choices' => array(
					'author'     => esc_html__( 'Author', 'agrikole' ),
					'comments' => esc_html__( 'Comments', 'agrikole' ),
					'date'       => esc_html__( 'Date', 'agrikole' ),
					'categories' => esc_html__( 'Categories', 'agrikole' ),
				),
			),
		),
		array(
			'id' => 'heading_blog_entry_meta_item',
			'control' => array(
				'type' => 'agrikole-heading',
				'label' => esc_html__( 'Item Meta', 'agrikole' ),
			),
		),
		array(
			'id' => 'blog_entry_meta_item_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Text Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-meta .item',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'blog_entry_meta_item_link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-meta .item a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'blog_entry_meta_item_link_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color Hover', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-meta .item a:hover',
				'alter' => 'color',
			),
		),
	),
);

// Blog Posts Excerpt
$this->sections['agrikole_blog_post_excerpt'] = array(
	'title' => esc_html__( 'Blog Post - Excerpt', 'agrikole' ),
	'panel' => 'agrikole_blog',
	'settings' => array(
		array(
			'id' => 'blog_content_style',
			'default' => 'style-1',
			'control' => array(
				'label' => esc_html__( 'Content Style', 'agrikole' ),
				'type' => 'select',
				'choices' => array(
					'style-1' => esc_html__( 'Normal', 'agrikole' ),
					'style-2' => esc_html__( 'Excerpt', 'agrikole' ),
				),
			),
		),
		array(
			'id' => 'blog_excerpt_length',
			'default' => '50',
			'control' => array(
				'label' => esc_html__( 'Excerpt length', 'agrikole' ),
				'type' => 'text',
				'desc' => esc_html__( 'This option only apply for Content Style: Excerpt.', 'agrikole' )
			),
		),
		array(
			'id' => 'blog_excerpt_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Margin', 'agrikole' ),
				'description' => esc_html__( 'Top Right Bottom Left. Example: 0 0 30px 0.', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-excerpt',
				'alter' => 'margin',
			),
		),
		array(
			'id' => 'blog_excerpt_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color', 'agrikole' ),
			),
			'inline_css' => array(
				'target' => '.hentry .post-excerpt',
				'alter' => 'color',
			),
		),
	),
);

// Blog Posts Read More
$this->sections['agrikole_blog_post_read_more'] = array(
	'title' => esc_html__( 'Blog Post - Read More', 'agrikole' ),
	'panel' => 'agrikole_blog',
	'settings' => array(
		array(
			'id' => 'blog_entry_button_read_more_text',
			'default' => esc_html__( 'Read More', 'agrikole' ),
			'control' => array(
				'label' => esc_html__( 'Button Text', 'agrikole' ),
				'type' => 'text',
			),
		),
	),
);

