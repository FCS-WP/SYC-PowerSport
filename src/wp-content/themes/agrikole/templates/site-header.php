<?php
/**
 * Header / Top
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get header style
$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
if ( is_page() && agrikole_metabox('header_style') )
	$header_style = agrikole_metabox('header_style');

agrikole_mobi_nav_extra(); ?>

<?php if ( 'style-1' == $header_style ) : ?>
	<header id="site-header" style="<?php echo agrikole_header_style(); ?>">
        <div class="site-header-inner agrikole-container">
        	<div class="wrap-inner">
		        <?php
		        agrikole_header_logo();
		        agrikole_header_menu();
		        ?>
	    	</div>
        </div><!-- /.site-header-inner -->
	</header><!-- /#site-header -->
<?php endif; ?>

<?php if ( 'style-2' == $header_style || 'style-3' == $header_style ) : ?>
	<header id="site-header" style="<?php echo agrikole_header_style(); ?>">
        <div class="site-header-inner agrikole-container">
        	<div class="wrap-inner">
	        <?php
			agrikole_header_logo();
	        agrikole_header_info();
        	agrikole_header_socials();
	        ?>
	    	</div>
        </div><!-- /.site-header-inner -->

		<div class="site-navigation-wrap">
			<div class="agrikole-container inner">
				<div class="wrap-inner">
				<?php
				agrikole_header_menu();
				?>
				</div>
			</div>
		</div><!-- /.site-navigation-wrap -->
	</header><!-- /#site-header -->
<?php endif; ?>

<?php if ( 'style-4' == $header_style || 'style-5' == $header_style ) : ?>
	<header id="site-header" style="<?php echo agrikole_header_style(); ?>">
        <div class="site-header-inner agrikole-container">
        	<div class="wrap-inner">
	        	<?php agrikole_header_logo(); ?>
	        	<div class="nav-wrap">
					<?php
					agrikole_header_menu();
					?>
		        </div>
		        <?php agrikole_header_socials(); ?>
		    </div>
        </div><!-- /.site-header-inner -->
	</header><!-- /#site-header -->
<?php endif; ?>








