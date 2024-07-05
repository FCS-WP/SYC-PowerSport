<?php
if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly!');
}

add_action('init', 'register_testimonials_post_type');
/**
  * Register testimonials post type
*/
function register_testimonials_post_type() {
    $testimonials_slug = 'testimonials';

    $labels = array(
        'name'               => esc_html__( 'Testimonials', 'agrikole' ),
        'singular_name'      => esc_html__( 'Testimonials Item', 'agrikole' ),
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
        'rewrite'       => array( 'slug' => $testimonials_slug ),
        'supports'      => array( 'title', 'thumbnail' ),
        'public'        => true
    );

    register_post_type( 'testimonials', $args );
}

add_filter( 'post_updated_messages', 'testimonials_updated_messages' );
/**
  * Testimonials update messages.
*/
function testimonials_updated_messages( $messages ) {
    $post             = get_post();
    $post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );

    $messages['testimonials'] = array(
        0  => '', // Unused. Messages start at index 1.
        1  => esc_html__( 'Testimonials updated.', 'agrikole' ),
        2  => esc_html__( 'Custom field updated.', 'agrikole' ),
        3  => esc_html__( 'Custom field deleted.', 'agrikole' ),
        4  => esc_html__( 'Testimonials updated.', 'agrikole' ),
        5  => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Testimonials restored to revision from %s', 'agrikole' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6  => esc_html__( 'Testimonials published.', 'agrikole' ),
        7  => esc_html__( 'Testimonials saved.', 'agrikole' ),
        8  => esc_html__( 'Testimonials submitted.', 'agrikole' ),
        9  => sprintf(
            esc_html__( 'Testimonials scheduled for: <strong>%1$s</strong>.', 'agrikole' ),
            date_i18n( esc_html__( 'M j, Y @ G:i', 'agrikole' ), strtotime( $post->post_date ) )
        ),
        10 => esc_html__( 'Testimonials draft updated.', 'agrikole' )
    );
    return $messages;
}

add_action( 'init', 'register_testimonials_taxonomy' );
/**
  * Register testimonials taxonomy
*/
function register_testimonials_taxonomy() {
    $cat_slug = 'testimonials_category';

    $labels = array(
        'name'                       => esc_html__( 'Testimonials Categories', 'agrikole' ),
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
        'rewrite'             => array('slug'=>$cat_slug),
        'hierarchical'  => true,
    );
    register_taxonomy( 'testimonials_category', 'testimonials', $args );
}