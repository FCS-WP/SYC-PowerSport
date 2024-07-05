<?php 
/*
Plugin Name: WPRT Custom Post Type
Plugin URI: http://rollthemes.com/plugins
Description: This plugin register Custom Post Type.
Version: 3.6.8
Author: RollThemes
Author URI: http://RollThemes.com
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPRT_CPT' ) ) {
	class WPRT_CPT {
		function __construct() {
			require_once dirname( __FILE__ ) . '/project.php';
			require_once dirname( __FILE__ ) . '/project-config.php';
			
			require_once dirname( __FILE__ ) . '/team.php';
			require_once dirname( __FILE__ ) . '/testimonials.php';
			require_once dirname( __FILE__ ) . '/partner.php';

			add_filter( 'single_template', array( $this,'agrikole_single_project' ) );	    
			add_filter( 'archive_template', array( $this,'agrikole_archive_project' ) );	    
	    }

		function agrikole_single_project( $single_template ) {
			global $post;
			if ( $post->post_type == 'project' ) $single_template = dirname( __FILE__ ) . '/inc/single-project.php';
			return $single_template;
		}

		function agrikole_archive_project( $archive_template ) {
			global $post;
			if ( $post->post_type == 'project' ) $archive_template = dirname( __FILE__ ) . '/inc/archive-project.php';
			return $archive_template;
		}
	}
}
new WPRT_CPT;