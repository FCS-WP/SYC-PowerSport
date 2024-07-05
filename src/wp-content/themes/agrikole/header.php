<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="mobi-overlay"><span class="close"></span></div>
<div id="wrapper" style="<?php echo agrikole_element_bg_css( 'wrapper_background_img' ); ?>">
	<?php if ( agrikole_get_mod( 'header_search_icon', false ) ) echo agrikole_search_fullscreen(); ?>
	
    <div id="page" class="clearfix <?php echo agrikole_preloader_class(); ?>">
    	<div id="site-header-wrap">
			<?php get_template_part( 'templates/site-header'); ?>
		</div><!-- /#site-header-wrap -->

		<?php get_template_part( 'templates/featured-title'); ?>

        <!-- Main Content -->
        <div id="main-content" class="site-main clearfix" style="<?php echo agrikole_main_content_bg(); ?>">