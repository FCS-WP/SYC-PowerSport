<?php
if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly!');
}

add_action('init', 'register_project_post_type');
/**
  * Register project post type
*/
function register_project_post_type() {
    $project_slug = 'project';

    $labels = array(
        'name'               => esc_html__( 'Projects', 'agrikole' ),
        'singular_name'      => esc_html__( 'Project Item', 'agrikole' ),
        'add_new'            => esc_html__( 'Add New', 'agrikole' ),
        'add_new_item'       => esc_html__( 'Add New Item', 'agrikole' ),
        'new_item'           => esc_html__( 'New Item', 'agrikole' ),
        'edit_item'          => esc_html__( 'Edit Item', 'agrikole' ),
        'view_item'          => esc_html__( 'View Item', 'agrikole' ),
        'all_items'          => esc_html__( 'All Items', 'agrikole' ),
        'search_items'       => esc_html__( 'Search Items', 'agrikole' ),
        'parent_item_colon'  => esc_html__( 'Parent Items:', 'agrikole' ),
        'not_found'          => esc_html__( 'No items found.', 'agrikole' ),
        'not_found_in_trash' => esc_html__( 'No items found in Trash.', 'agrikole' )
    );

    $args = array(
        'labels'        => $labels,
        'rewrite'       => array( 'slug' => $project_slug ),
        'supports'      => array( 'title', 'editor', 'thumbnail' ),
        'public'        => true
    );

    register_post_type( 'project', $args );
}

add_filter( 'post_updated_messages', 'project_updated_messages' );
/**
  * Project update messages.
*/
function project_updated_messages( $messages ) {
    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );

    $messages['project'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => esc_html__( 'Project updated.', 'agrikole' ),
        2  => esc_html__( 'Custom field updated.', 'agrikole' ),
        3  => esc_html__( 'Custom field deleted.', 'agrikole' ),
        4  => esc_html__( 'Project updated.', 'agrikole' ),
        5  => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Project restored to revision from %s', 'agrikole' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => esc_html__( 'Project published.', 'agrikole' ),
        7  => esc_html__( 'Project saved.', 'agrikole' ),
        8  => esc_html__( 'Project submitted.', 'agrikole' ),
        9  => sprintf(
            esc_html__( 'Project scheduled for: <strong>%1$s</strong>.', 'agrikole' ),
            date_i18n( esc_html__( 'M j, Y @ G:i', 'agrikole' ), strtotime( $post->post_date ) )
        ),
        10 => esc_html__( 'Project draft updated.', 'agrikole' )
    );
    return $messages;
}

add_action( 'init', 'register_project_taxonomy' );
/**
  * Register project taxonomy
*/
function register_project_taxonomy() {
    $cat_slug = 'project_category';

    $labels = array(
        'name'                       => esc_html__( 'Project Categories', 'agrikole' ),
        'singular_name'              => esc_html__( 'Category', 'agrikole' ),
        'search_items'               => esc_html__( 'Search Categories', 'agrikole' ),
        'menu_name'                  => esc_html__( 'Categories', 'agrikole' ),
        'all_items'                  => esc_html__( 'All Categories', 'agrikole' ),
        'parent_item'                => esc_html__( 'Parent Category', 'agrikole' ),
        'parent_item_colon'          => esc_html__( 'Parent Category:', 'agrikole' ),
        'new_item_name'              => esc_html__( 'New Category Name', 'agrikole' ),
        'add_new_item'               => esc_html__( 'Add New Category', 'agrikole' ),
        'edit_item'                  => esc_html__( 'Edit Category', 'agrikole' ),
        'update_item'                => esc_html__( 'Update Category', 'agrikole' ),
        'add_or_remove_items'        => esc_html__( 'Add or remove categories', 'agrikole' ),
        'choose_from_most_used'      => esc_html__( 'Choose from the most used categories', 'agrikole' ),
        'not_found'                  => esc_html__( 'No Category found.', 'agrikole' ),
        'menu_name'                  => esc_html__( 'Categories', 'agrikole' ),
    );
    $args = array(
        'labels'        => $labels,
        'rewrite'       => array('slug'=>$cat_slug),
        'hierarchical'  => true,
    );
    register_taxonomy( 'project_category', 'project', $args );
}