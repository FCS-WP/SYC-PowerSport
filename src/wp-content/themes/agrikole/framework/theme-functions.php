<?php
/**
 * Framework functions
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return class for page reploader
function agrikole_preloader_class() {
	// Get page preloader option from theme mod
	$class = agrikole_get_mod( 'preloader', 'animsition' );
	return esc_attr( $class );
}

// Render favicon icon to head tag
function agrikole_site_icon() {
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		if ( $favicon = agrikole_get_mod( 'favicon' ) ) {
			echo '<link rel="shortcut icon" href="'. esc_url( $favicon ) .'" type="image/x-icon">';
		}
	}
}
add_action( 'wp_head', 'agrikole_site_icon' );

// Get layout position for pages
function agrikole_layout_position() {
	// Default layout position
	$layout = 'sidebar-right';

	// Get layout position for site
	$layout = agrikole_get_mod( 'site_layout_position', 'sidebar-right' );

	// Get layout position for single post
	if ( is_singular( 'post' ) )
		$layout = agrikole_get_mod('single_post_layout_position', 'sidebar-right');

	// Single post/page can have custom layout position
	if ( is_singular() && agrikole_metabox('page_layout') )
		$layout = agrikole_metabox('page_layout');

	// Get layout position for shop pages
	if ( class_exists( 'woocommerce' ) ) {
		if ( is_shop() || is_product_category() )
			$layout = agrikole_get_mod('shop_layout_position', 'no-sidebar');  
		if ( is_singular( 'product' ) )
			$layout = agrikole_get_mod('shop_single_layout_position', 'no-sidebar');
		if ( is_cart() || is_checkout() ) {
			if ( agrikole_metabox('page_layout') ) {
				$layout = agrikole_metabox('page_layout');
			} else {
				$layout = 'no-sidebar';
			}
		}
	}

	return $layout;
}

// Custom classes to body tag
function agrikole_body_classes() {
	$classes[] = '';

	if ( is_page() && agrikole_metabox('header_background') )
		$classes[] = 'header-has-custom-bg';

	// Header fixed
	if ( agrikole_get_mod( 'header_fixed', false ) )
		$classes[] = 'header-fixed';

	// Get layout position
	$classes[] = agrikole_layout_position();
	$layout_position = agrikole_layout_position();
	if ( ! is_page() && $layout_position != 'no-sidebar' && ! is_active_sidebar( 'sidebar-blog' ) )
		$classes[] = 'blog-empty-widget';

	if ( is_page() && $layout_position != 'no-sidebar' && ! is_active_sidebar( 'sidebar-page' ) )
		$classes[] = 'page-empty-widget';

	// Get layout style
	$layout_style = agrikole_get_mod( 'site_layout_style', 'full-width' );
	$classes[] = 'site-layout-'. $layout_style;

	// Get header style
	$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
	if ( is_page() && agrikole_metabox('header_style') )
		$header_style = agrikole_metabox('header_style');
	$classes[] = 'header-'. $header_style;

	// Get menu dropdown style
	$header_btn_style = agrikole_get_mod( 'header_btn_style', 'header-btn-1' );
	if ( is_page() && agrikole_metabox('header_btn_style') )
		$header_btn_style = agrikole_metabox('header_btn_style');
	$classes[] = $header_btn_style;

	if ( is_page() ) $classes[] = 'is-page';

	if ( is_page_template( 'templates/page-onepage.php' ) )
		$classes[] = 'one-page';

	if ( ( is_page() && agrikole_metabox('hide_padding_content') )
		|| ( is_singular('project') && agrikole_metabox('hide_padding_content') ) )
		$classes[] = 'no-padding-content';

	// Add classes for Woo pages
	if ( agrikole_is_woocommerce_page() )
		$classes[] = 'woocommerce-page';

	if ( agrikole_is_woocommerce_shop() )
		$classes[] = 'main-shop-page';

	if ( agrikole_is_woocommerce_shop() || agrikole_is_woocommerce_archive_product() ) {
		$shop_cols = agrikole_get_mod( 'shop_columns', '3' );
		$classes[] = 'shop-col-'. $shop_cols;
	}

	// Boxed Layout dropshadow
	if ( 'boxed' == $layout_style && agrikole_get_mod( 'site_layout_boxed_shadow' ) )
		$classes[] = 'box-shadow';

	if ( agrikole_get_mod( 'header_search_icon' ) )
		$classes[] = 'header-simple-search';

	if ( is_singular('post') )
		$classes[] = 'is-single-post';

	if ( is_singular( 'project' ) )
		$classes[] = 'page-single-project';

	if ( agrikole_get_mod( 'agrikole_blog_single_related', false ) )
		$classes[] = 'has-related-post';

	if ( agrikole_get_mod( 'project_related', false ) )
		$classes[] = 'has-related-project';

	if ( ! is_active_sidebar( 'sidebar-footer-1' ) &&
		! is_active_sidebar( 'sidebar-footer-2' ) &&
		! is_active_sidebar( 'sidebar-footer-3' ) &&
		! is_active_sidebar( 'sidebar-footer-4' ) )
		$classes[] = 'footer-no-widget';

	// Return classes
	return $classes;
}
add_filter( 'body_class', 'agrikole_body_classes' );

// Render blog entry blocks
function agrikole_blog_entry_layout_blocks() {

	// Get layout blocks
	$blocks = agrikole_get_mod( 'blog_entry_composer' );

	// If blocks are 100% empty return defaults
	$blocks = $blocks ? $blocks : 'meta,title,excerpt_content,readmore';

	// Convert blocks to array so we can loop through them
	if ( ! is_array( $blocks ) ) {
		$blocks = explode( ',', $blocks );
	}

	// Set block keys equal to vals
	$blocks = array_combine( $blocks, $blocks );

	// Return blocks
	return $blocks;
}

// Render blog meta items
function agrikole_entry_meta() {
	// Get meta items from theme mod
	$meta_item = agrikole_get_mod( 'blog_entry_meta_items', array( 'author', 'comments' ) );

	// If blocks are 100% empty return defaults
	$meta_item = $meta_item ? $meta_item : 'author,comments';

	// Turn into array if string
	if ( $meta_item && ! is_array( $meta_item ) ) {
		$meta_item = explode( ',', $meta_item );
	}

	// Set keys equal to values
	$meta_item = array_combine( $meta_item, $meta_item );

	// Loop through items
	foreach ( $meta_item as $item ) :
		if ( 'author' == $item ) {

			printf( '<span class="post-by-author item"><a class="name" href="%s" title="%s">%s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( esc_html__( 'View all posts by %s', 'agrikole' ), get_the_author() ) ),
				get_the_author()
			);
		}
		elseif ( 'comments' == $item ) {
			if ( comments_open() || get_comments_number() ) {
				echo '<span class="post-comment item"><span class="inner">';
				comments_popup_link( esc_html__( '0 comments', 'agrikole' ), esc_html__( '1 Comment', 'agrikole' ), esc_html__( '% Comments', 'agrikole' ) );
				echo '</span></span>';
			}
		}
		elseif ( 'date' == $item ) {
			printf( '<span class="post-date item"><span class="entry-date">%1$s</span></span>',
				get_the_date()
			);
		}
		elseif ( 'categories' == $item ) {
			echo '<span class="post-meta-categories item">';
			the_category( ', ', get_the_ID() );
			echo '</span>';
		}
	endforeach;
}

// Custom style for main header area
function agrikole_header_style() {
	$css = '';

	if ( is_page() && $bg = agrikole_metabox('header_background') )
		$css .= 'background-color: '. $bg .';';

	if ( is_page() && $border_width = agrikole_metabox('header_border_width') ) {
		$css .= 'border-width: '. $border_width .';';
		if ( $border_color = agrikole_metabox('header_border_color') )
			$css .= 'border-color: '. $border_color .';';
	}

	return esc_attr( $css );
}

// Custom socials from Customizer for headers
function agrikole_header_socials() {
	if ( agrikole_get_mod( 'header_socials', false ) ) {
	?>
	<div class="header-socials">
		<div class="header-socials-inner">
	    <?php
	    // Get social options array
	    $profiles =  agrikole_get_mod( 'header_social_profiles' );
	    $social_options = agrikole_header_social_options();

	    foreach ( $social_options as $key => $val ) :
	        // Get URL from the theme mods
	        $url = isset( $profiles[$key] ) ? $profiles[$key] : '';

	        if ( $url ) :
	            // Display link
	            echo '<a href="'. esc_url( $url ) .'" title="'. esc_attr( $val['label'] ) .'"><span class="'. esc_attr( $val['icon_class'] ) .'" aria-hidden="true"></span><span class="screen-reader-text">'. $val['label'] .' '. esc_html__( 'Profile', 'agrikole' ) .'</span></a>';
	        endif;
	    endforeach; ?>
		</div>
	</div><!-- /.header-socials -->
	<?php }
}

// Extra for mobile menu
function agrikole_mobi_nav_extra() {
	$logo_size = '';
	if ( $menu_logo_width = agrikole_get_mod( 'mobile_menu_logo_width' ) )
		$logo_size .= 'max-width:'. intval( $menu_logo_width ) .'px;';
	?>
	<ul class="mobi-nav-extra">
		<?php if ( $menu_logo = agrikole_get_mod( 'mobile_menu_logo' ) ) : ?>
			<li class="ext menu-logo"><span class="menu-logo-inner" style="<?php echo esc_attr( $logo_size ); ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $menu_logo ); ?>"/></a></span></li>
		<?php endif; ?>

		<?php if ( agrikole_get_mod( 'header_search_icon', false ) ) : ?>
		<li class="ext"><?php get_search_form(); ?></li>
		<?php endif; ?>

		<?php if ( class_exists( 'woocommerce' ) && agrikole_get_mod( 'header_cart_icon', false ) ) : ?>
		<li class="ext"><a class="cart-info" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'agrikole' ); ?>"><?php echo sprintf ( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'agrikole' ), WC()->cart->get_cart_contents_count() ); ?> <?php echo WC()->cart->get_cart_total(); ?></a></li>
		<?php endif; ?>
	</ul>
<?php }

// Header Info
function agrikole_header_info() {
	$email = agrikole_get_mod( 'header_info_email', '' );
	$phone = agrikole_get_mod( 'header_info_phone', '+1 (139) 946 2758' );
	?>

	<div class="header-info">
	    <?php
	    if ( $email ) : ?>
	        <span class="email content">
	            <?php echo do_shortcode( $email ); ?>
	        </span>
	    <?php endif;

	    if ( $phone ) : ?>
	        <span class="phone content">
	            <?php echo do_shortcode( $phone ); ?>
	        </span>
	    <?php endif; ?>
	</div><!-- /.header-info -->
	<?php
}

// Header Logo
function agrikole_header_logo() {
	$logo_size = '';
	$logo_url = home_url( '/' );
	$logo_title = get_bloginfo( 'name' );

	// Get header style
	$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
	if ( is_page() && agrikole_metabox('header_style') )
		$header_style = agrikole_metabox('header_style');

	switch ( $header_style ) {
	    case "style-2":
			$logo_img = agrikole_get_mod( 'custom_logotwo' );
			$logo_width = agrikole_get_mod( 'logotwo_width' );
	        break;
	    case "style-3":
			$logo_img = agrikole_get_mod( 'custom_logothree' );
			$logo_width = agrikole_get_mod( 'logothree_width' );
	        break;
	    case "style-4":
			$logo_img = agrikole_get_mod( 'custom_logofour' );
			$logo_width = agrikole_get_mod( 'logofour_width' );
	        break;
	    case "style-5":
			$logo_img = agrikole_get_mod( 'custom_logofive' );
			$logo_width = agrikole_get_mod( 'logofive_width' );
	        break;
	    default:
			$logo_img = agrikole_get_mod( 'custom_logo' );
			$logo_width = agrikole_get_mod( 'logo_width' );
	}

	if ( is_page() && $custom_logo = agrikole_metabox('custom_header_logo') )
		$logo_img = $custom_logo['full_url'];

	if ( $logo_width ) $logo_size .= 'max-width:'. intval( $logo_width ) .'px;'; ?>

	<div id="site-logo">
		<div id="site-logo-inner" style="<?php echo esc_attr( $logo_size ); ?>">
			<?php if ( $logo_img ) : ?>
				<a class="main-logo" href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo esc_attr( $logo_title ); ?>" rel="home" ><img src="<?php echo esc_url( $logo_img ); ?>" alt="<?php echo esc_attr( $logo_title ); ?>" /></a>
			<?php else : ?>
				<a class="site-logo-text" href="<?php echo esc_url( $logo_url ); ?>" title="<?php echo esc_attr( $logo_title ); ?>" rel="home"><?php echo esc_html( $logo_title ); ?></a>
			<?php endif; ?>
		</div>
	</div><!-- #site-logo -->
<?php
}

// Header Menu
function agrikole_header_menu() {
	// Search
	if ( agrikole_get_mod( 'header_search_icon', false ) ) {
		echo '<div class="header-search-wrap"><a href="#" class="header-search-trigger"></a></div>';
	}

	// Cart
	if ( agrikole_get_mod( 'header_cart_icon', false ) && class_exists( 'woocommerce' ) ) { ?>
        <div class="nav-top-cart-wrapper">
            <a class="nav-cart-trigger" href="<?php echo esc_url( wc_get_cart_url() ) ?>">
                <?php if ( $items_count = WC()->cart->get_cart_contents_count() ): ?>
                    <span class="shopping-cart-items-count"><?php echo esc_html( $items_count ) ?></span>
                <?php else: ?>
                    <span class="shopping-cart-items-count">0</span>
                <?php endif ?>
            </a>

            <div class="nav-shop-cart">
                <div class="widget_shopping_cart_content">
                    <?php woocommerce_mini_cart() ?>
                </div>
            </div>
        </div>
	<?php }

	// Menu
	if ( has_nav_menu( 'primary' ) || has_nav_menu( 'onepage' ) ) {
		$menu = is_page_template( 'templates/page-onepage.php' )
			? 'onepage'
			: 'primary';
		?>

		<div class="mobile-button"><span></span></div>

		<nav id="main-nav" class="main-nav">
			<?php
			wp_nav_menu( array(
				'theme_location' => $menu,
				'link_before' => '<span>',
				'link_after'=>'</span>',
				'fallback_cb' => false,
				'container' => false
			) );
			?>
		</nav>
	<?php }
}

// Return classes for elements
function agrikole_element_classes( $elm ) {
	// Get element style from theme mod
	$style = agrikole_get_mod( $elm, 'style-1' );
	return esc_attr( $style );
}

// Return background CSS
function agrikole_bg_css( $style ) {
	$css = '';
	if ( $style = agrikole_get_mod( $style ) ) {
		if ( 'fixed' == $style ) {
			$css .= ' background-position: center center; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;';
		} elseif ( 'fixed-top' == $style ) {
			$css .= ' background-position: center top; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;';
		} elseif ( 'fixed-bottom' == $style ) {
			$css .= ' background-position: center bottom; background-repeat: no-repeat; background-attachment: fixed; background-size: cover;';
		} elseif ( 'cover' == $style ) {
			$css .= ' background-repeat: no-repeat; background-position: center top; background-size: cover;';
		} elseif ( 'center-top' == $style ) {
			$css .= ' background-repeat: no-repeat; background-position: center top;';
		} elseif ( 'repeat' == $style ) {
			$css .= ' background-repeat: repeat;';
		} elseif ( 'repeat-x' == $style ) {
			$css .= ' background-repeat: repeat-x;';
		} elseif ( 'repeat-y' == $style ) {
			$css .= ' background-repeat: repeat-y;';
		}
	}

	return esc_attr( $css );
}

// Return background style for elements
function agrikole_element_bg_css( $bg ) {
	$css = '';
	$style = $bg .'_style';

	if ( $bg_img = agrikole_get_mod( $bg, null ) )
		$css .= 'background-image: url('. esc_url( $bg_img ). ');';

	$css .= agrikole_bg_css($style);

	return esc_attr( $css );
}

// Return background for featured title area
function agrikole_featured_title_bg() {
	$css = '';

	if ( is_page() && agrikole_metabox('featured_title_bg') ) {
		$images = agrikole_metabox( 'featured_title_bg', array( 'size' => 'full', 'limit' => 1 ) );
		$image = reset( $images );
		$css .= 'background-image: url('. esc_url( $image['url'] ). ');';
	} elseif ( is_single() && ( $bg_img = agrikole_get_mod( 'blog_single_featured_title_background_img' ) ) ) {
		$css .= 'background-image: url('. esc_url( $bg_img ). ');';
	} elseif ( $bg_img = agrikole_get_mod( 'featured_title_background_img' ) ) {
		$css .= 'background-image: url('. esc_url( $bg_img ). ');';
	}

	if ( agrikole_is_woocommerce_shop() && $bg_img = agrikole_get_mod( 'shop_featured_title_background_img' ) ) {
		$css .= 'background-image: url('. esc_url( $bg_img ). ');';
	}

	if ( is_singular( 'product' ) && $bg_img = agrikole_get_mod( 'shop_single_featured_title_background_img' ) ) {
		$css .= 'background-image: url('. esc_url( $bg_img ). ');';
	}

	if ( is_tax() || is_singular( 'project' ) ) {
		if ( $bg_img = agrikole_get_mod( 'project_single_featured_title_background_img' ) )
			$css .= 'background-image: url('. esc_url( $bg_img ). ');';
	}

	$css .= agrikole_bg_css('featured_title_background_img_style');

	return esc_attr( $css );
}

// Featured Title style
function agrikole_feature_title_cls() {
	// Define classes
	$classes = 'clearfix';

	// Get featured style from theme mod
	$style = agrikole_get_mod( 'featured_title_style', 'heading_breadcrumbs' );

	// Add classes based on top bar style
	if ( 'heading_breadcrumbs' == $style ) { $classes .= ' simple'; }
	elseif ( 'breadcrumbs_heading' == $style ) { $classes .= ' left-side'; }
	elseif ( 'heading_breadcrumbs_centered' == $style ) { $classes .= ' center'; }

	// Return classes
	return esc_attr( $classes );
}

// Return background for main content area
function agrikole_main_content_bg() {
	$css = '';

	if ( $bg_img = agrikole_get_mod( 'main_content_background_img', null ) ) {
		$css = 'background-image: url('. esc_url( $bg_img ). ');';
	}

	if ( is_page() ) {
		if ( agrikole_metabox('main_content_bg') ) {
			$css = 'background-color:'. agrikole_metabox('main_content_bg') .';';
		}
		if ( agrikole_metabox('main_content_bg_img') ) {
			$images = agrikole_metabox( 'main_content_bg_img', array( 'size' => 'full', 'limit' => 1 ) );
			$image = reset( $images );
			$css = 'background-image: url('. esc_url( $image['url'] ). ');';
		}
	}

	$css .= agrikole_bg_css('main_content_background_img_style');

	return esc_attr( $css );
}

// Return background for footer area
function agrikole_footer_bg() {
	$css = '';

	if ( is_page() ) {
		if ( agrikole_metabox('footer_bg') ) {
			$css .= 'background-color:'. agrikole_metabox('footer_bg') .';';
		}
		if ( agrikole_metabox('footer_bg_img') ) {
			$images = agrikole_metabox( 'footer_bg_img', array( 'size' => 'full', 'limit' => 1 ) );
			$image = reset( $images );
			$css .= 'background-image: url('. esc_url( $image['url'] ). ');';
		}
	} elseif ( $bg_img = agrikole_get_mod( 'footer_bg_img', null ) ) {
		$css .= 'background-image: url('. esc_url( $bg_img ). ');';
	}

	$css .= agrikole_bg_css('footer_bg_img_style');

	return esc_attr( $css );
}

// Search fullscreen 
function agrikole_search_fullscreen() { ?>
    <div class="search-style-fullscreen">
        <div class="search_form_wrap">
        	<a class="search-close"></a>
            <form role="search" method="get" class="search_form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <input type="search" class="search-field" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_attr_e( 'Type your search...', 'agrikole' ); ?>">
                <button type="submit" class="search-submit" title="<?php esc_attr_e('Search', 'agrikole'); ?>"><?php esc_html_e('Search', 'agrikole'); ?></button>
            </form>
        </div>
    </div><!-- /.search-style-fullscreen -->
<?php
}

// Remove products and pages results from the search form widget
function agrikole_custom_search_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() )
		return;

	if ( isset( $_GET['post_type'] ) && ( $_GET['post_type'] == 'product' ) )
		return;

	if ( $query->is_search() ) {
    	$in_search_post_types = get_post_types( array( 'exclude_from_search' => false ) );

	    $post_types_to_remove = array( 'product' );

	    foreach ( $post_types_to_remove as $post_type_to_remove ) {
			if ( is_array( $in_search_post_types ) 
				&& in_array( $post_type_to_remove, $in_search_post_types ) 
			) {
				unset( $in_search_post_types[ $post_type_to_remove ] );
				$query->set( 'post_type', $in_search_post_types );
			}
	    }
	}
}
add_action( 'pre_get_posts', 'agrikole_custom_search_query' );

function agrikole_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();

	if ( class_exists( 'woocommerce' ) ) : ?>
		<a class="cart-info" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php echo esc_attr__('View your shopping cart', 'agrikole'); ?>"><?php echo sprintf( _n( '%d item', '%d items', WC()->cart->cart_contents_count, 'agrikole' ), WC()->cart->cart_contents_count); ?> <?php echo WC()->cart->get_cart_total(); ?></a>
	<?php endif;

	$fragments['a.cart-info'] = ob_get_clean();
	
	return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'agrikole_woocommerce_header_add_to_cart_fragment');

// Sets the content width in pixels, based on the theme's design and stylesheet.
function agrikole_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'agrikole_content_width', 1170 );
}
add_action( 'after_setup_theme', 'agrikole_content_width', 0 );

// Modifies tag cloud widget arguments to have all tags in the widget same font size.
function agrikole_widget_tag_cloud_args( $args ) {
	$args['largest'] = 14;
	$args['smallest'] = 14;
	$args['unit'] = 'px';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'agrikole_widget_tag_cloud_args' );

// Change default read more style
function agrikole_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'agrikole_excerpt_more', 10 );

// Custom excerpt length for posts
function agrikole_content_length() {
	$length = agrikole_get_mod( 'blog_excerpt_length', '50' );
	$length = intval( $length );
	if ( ! empty( $length ) || $length != 0 )
	return $length;
}
add_filter( 'excerpt_length', 'agrikole_content_length', 999 );

// Prevent page scroll when clicking the more link
function agrikole_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'agrikole_remove_more_link_scroll' );

// Remove read-more link so we can custom it
function agrikole_remove_read_more_link() {
    return '';
}
add_filter( 'the_content_more_link', 'agrikole_remove_read_more_link' );

// Minify CSS
function agrikole_minify_css( $css = '' ) {
	// Return if no CSS
	if ( ! $css ) return;

	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { }
	$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Trim
	$css = trim( $css );

	// Return minified CSS
	return $css;
}

// Get post meta, using rwmb_meta() function from Meta Box class
function agrikole_metabox( $key, $args = array(), $post_id = null ) {
    if ( ! function_exists( 'rwmb_meta' ) )
      	return false;
    return rwmb_meta( $key, $args, $post_id );
}

// Render numeric pagination
function agrikole_pagination( $query = '', $echo = true ) {
	
	// Arrows with RTL support
	$prev_arrow = '<i class="fa fa-angle-left"></i>';
	$next_arrow = '<i class="fa fa-angle-right"></i>';
	
	// Get global $query
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	// Set vars
	$total  = $query->max_num_pages;
	$big    = 999999999;

	// Display pagination
	if ( $total > 1 ) {

		// Get current page
		if ( $current_page = get_query_var( 'paged' ) ) {
			$current_page = $current_page;
		} elseif ( $current_page = get_query_var( 'page' ) ) {
			$current_page = $current_page;
		} else {
			$current_page = 1;
		}

		// Get permalink structure
		if ( get_option( 'permalink_structure' ) ) {
			if ( is_page() ) {
				$format = 'page/%#%/';
			} else {
				$format = '/%#%/';
			}
		} else {
			$format = '&paged=%#%';
		}

		$args = array(
			'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
			'format'    => $format,
			'current'   => max( 1, $current_page ),
			'total'     => $total,
			'mid_size'  => 3,
			'type'      => 'list',
			'prev_text' => $prev_arrow,
			'next_text' => $next_arrow
		);

		// Output pagination
		if ( $echo ) {
			echo '<div class="agrikole-pagination clearfix">'. paginate_links( $args ) .'</div>';
		} else {
			return '<div class="agrikole-pagination clearfix">'. paginate_links( $args ) .'</div>';
		}

	}
}

// Returns array of Social Options for the Top Bar
function agrikole_header_social_options() {
	return apply_filters ( 'agrikole_header_social_options', array(
		'facebook' => array(
			'label' => esc_html__( 'Facebook', 'agrikole' ),
			'icon_class' => 'fa fa-facebook-f',
		),
		'twitter' => array(
			'label' => esc_html__( 'Twitter', 'agrikole' ),
			'icon_class' => 'fa fa-twitter',
		),
		'instagram'  => array(
			'label' => esc_html__( 'Instagram', 'agrikole' ),
			'icon_class' => 'fa fa-instagram',
		),
		'youtube' => array(
			'label' => esc_html__( 'Youtube', 'agrikole' ),
			'icon_class' => 'fa fa-youtube',
		),
		'dribbble'  => array(
			'label' => esc_html__( 'Dribbble', 'agrikole' ),
			'icon_class' => 'fa fa-dribbble',
		),
		'vimeo' => array(
			'label' => esc_html__( 'Vimeo', 'agrikole' ),
			'icon_class' => 'fa fa-vimeo',
		),
		'tumblr'  => array(
			'label' => esc_html__( 'Tumblr', 'agrikole' ),
			'icon_class' => 'fa fa-tumblr',
		),
		'pinterest'  => array(
			'label' => esc_html__( 'Pinterest', 'agrikole' ),
			'icon_class' => 'fa fa-pinterest',
		),
		'linkedin'  => array(
			'label' => esc_html__( 'LinkedIn', 'agrikole' ),
			'icon_class' => 'fa fa-linkedin',
		),
		'whatsapp'  => array(
			'label' => esc_html__( 'WhatsApp', 'agrikole' ),
			'icon_class' => 'fa fa-whatsapp',
		),
	) );
}

// Display or get post image
function agrikole_get_image( $args = array() ) {
	$default =  array(
		'post_id'  => get_the_ID(),
		'size'     => 'thumbnail',
		'format'   => 'html', // html or src
		'attr'     => '',
		'meta_key' => '',
		'scan'     => true,
		'default'  => '',
	);

	$args = wp_parse_args( $args, $default );

	if ( ! $args['post_id'] )
		$args['post_id'] = get_the_ID();

	// Get image from cache
	$key = md5( serialize( $args ) );
	$image_cache = wp_cache_get( $args['post_id'], 'agrikole_get_image' );

	if ( ! is_array( $image_cache ) )
		$image_cache = array();

	if ( empty( $image_cache[$key] ) ) {
		// Get post thumbnail
		if ( has_post_thumbnail( $args['post_id'] ) ) {
			$id = get_post_thumbnail_id();
			$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
			list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
		}

		// Get the first image in the custom field
		if ( ! isset( $html, $src ) && $args['meta_key'] ) {
			$id = get_post_meta( $args['post_id'], $args['meta_key'], true );

			// Check if this post has attached images
			if ( $id ) {
				$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
				list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
			}
		}

		// Get the first attached image
		if ( ! isset( $html, $src ) ) {
			$image_ids = array_keys( get_children( array(
				'post_parent'    => $args['post_id'],
				'post_type'	     => 'attachment',
				'post_mime_type' => 'image',
				'orderby'        => 'menu_order',
				'order'	         => 'ASC',
			) ) );

			// Check if this post has attached images
			if ( ! empty( $image_ids ) ) {
				$id = $image_ids[0];
				$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
				list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
			}
		}

		// Get the first image in the post content
		if ( ! isset( $html, $src ) && ( $args['scan'] ) ) {
			preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );

			if ( !empty( $matches ) ) {
				$html = $matches[0];
				$src = $matches[1];
			}
		}

		// Use default when nothing found
		if ( ! isset( $html, $src ) && !empty( $args['default'] ) ) {
			if ( is_array( $args['default'] ) ) {
				$html = $args['html'];
				$src = $args['src'];
			} else {
				$html = $src = $args['default'];
			}
		}

		// Still no images found?
		if ( ! isset( $html, $src ) )
			return false;

		$output = 'html' === strtolower( $args['format'] ) ? $html : $src;

		$image_cache[$key] = $output;
		wp_cache_set( $args['post_id'], $image_cache, 'agrikole_get_image' );
	}
	// If image already cached
	else {
		$output = $image_cache[$key];
	}

	$output = apply_filters( 'agrikole_get_image', $output, $args );

	return $output;
}

// Check if it is WooCommerce Page
function agrikole_is_woocommerce_page() {
    if ( function_exists ( "is_woocommerce" ) && is_woocommerce() )
		return true;

    $woocommerce_keys = array (
    	"woocommerce_shop_page_id" ,
        "woocommerce_terms_page_id" ,
        "woocommerce_cart_page_id" ,
        "woocommerce_checkout_page_id" ,
        "woocommerce_pay_page_id" ,
        "woocommerce_thanks_page_id" ,
        "woocommerce_myaccount_page_id" ,
        "woocommerce_edit_address_page_id" ,
        "woocommerce_view_order_page_id" ,
        "woocommerce_change_password_page_id" ,
        "woocommerce_logout_page_id" ,
        "woocommerce_lost_password_page_id" );

    foreach ( $woocommerce_keys as $wc_page_id ) {
		if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
			return true ;
		}
    }
    
    return false;
}

// Checks if is WooCommerce Shop page
function agrikole_is_woocommerce_shop() {
	if ( ! class_exists( 'woocommerce' ) ) {
		return false;
	} elseif ( is_shop() ) {
		return true;
	}
}

// Checks if is WooCommerce archive product page
function agrikole_is_woocommerce_archive_product() {
	if ( ! class_exists( 'woocommerce' ) ) {
		return false;
	} elseif ( is_product_category() || is_product_tag() ) {
		return true;
	}
}

function agrikole_trim_words( $text, $limit ) {
    if ( str_word_count($text, 0) > $limit ) {
		$words = str_word_count( $text, 2 );
		$pos = array_keys( $words );
		$text = substr( $text, 0, $pos[$limit] );
	}
  return $text;
}

// TinyMCE from removing span tags
function agrikole_tinymce_init( $initArray ) {
	$opts = '*[*]';
	$initArray['valid_elements'] = $opts;
	$initArray['extended_valid_elements'] = $opts;
	return $initArray;
}
add_filter('tiny_mce_before_init', 'agrikole_tinymce_init');

// Custom html categories widget
add_filter('wp_list_categories', 'cat_count_span');
function cat_count_span($links) {
  $links = str_replace('</a> (', '</a> <span>', $links);
  $links = str_replace(')', '</span>', $links);
  return $links;
}

// Hexdec color string to rgb(a) string
function agrikole_hex2rgba( $color, $opacity = false ) {
 	$default = 'rgb(0,0,0)';

	if ( empty( $color ) ) return $default; 
    if ( $color[0] == '#' ) $color = substr( $color, 1 );

    if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    $rgb =  array_map( 'hexdec', $hex );

    if ( $opacity ) {
    	if ( abs( $opacity ) > 1 ) $opacity = 1.0;
    	$output = 'rgba('. implode( ",", $rgb ) .','. $opacity .')';
    } else {
    	$output = 'rgb('. implode( ",", $rgb ) .')';
    }

    return $output;
}

// Returns correct ID for any object
function agrikole_parse_obj_id( $id = '', $type = 'page' ) {
	if ( $id && function_exists( 'icl_object_id' ) ) {
		$id = icl_object_id( $id, $type );
	}
	return $id;
}