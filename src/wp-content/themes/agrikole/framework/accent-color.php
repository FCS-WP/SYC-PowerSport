<?php
/**
 * Accent color
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
if ( ! class_exists( 'Agrikole_Accent_Color' ) ) {
	class Agrikole_Accent_Color {
		// Main constructor
		function __construct() {
			add_filter( 'agrikole_custom_colors_css', array( 'Agrikole_Accent_Color', 'head_css' ), 999 );
		}

		// Generates arrays of elements to target
		public static function arrays( $return ) {
			// Color
			$texts = apply_filters( 'agrikole_accent_texts', array(
				'.text-accent-color',
				'.link-dark:hover',
				'.link-gray:hover',
				'.sticky-post',
				'#site-logo .site-logo-text:hover',
				'.header-style-3 #site-header .nav-top-cart-wrapper .nav-cart-trigger:hover',
				'.header-style-3 #site-header .header-search-trigger:hover',
				'.header-style-3 .header-info > .content:before',
				'.header-style-5 #site-header .nav-top-cart-wrapper .nav-cart-trigger:hover',
				'.header-style-5 #site-header .header-search-trigger:hover',
				'.hentry .post-tags .inner:before',
				'#featured-title #breadcrumbs a:hover',
				'.hentry .page-links span',
				'.hentry .page-links a span',
				'.hentry .post-tags .inner:before',
				'.hentry .post-tags a:hover',
				'.hentry .post-author .author-socials .socials a',
				'.related-news .related-title',
				'.related-news .post-item .post-categories a:hover',
				'.related-news .post-item .text-wrap h3 a:hover',
				'.related-news .related-post .slick-next:hover:before',
				'.related-news .related-post .slick-prev:hover:before',
				'.comment-edit-link',
				'.unapproved',
				'.logged-in-as a',
				'#sidebar .widget.widget_calendar caption',
				'.widget.widget_nav_menu .menu > li.current-menu-item > a',
				'.widget.widget_nav_menu .menu > li.current-menu-item',
				'#sidebar .widget.widget_calendar tbody #today',
				'#sidebar .widget.widget_calendar tbody #today a',
				'#sidebar .widget_information ul li.accent-icon i',
				'#footer-widgets .widget_mc4wp_form_widget .mc4wp-form .submit-wrap button:before',
				'#footer-widgets .widget.widget_recent_posts .post-author',
				'#footer-widgets .widget.widget_recent_posts .post-author a',
				'#bottom .bottom-bar-copyright a:hover',

				// shortcodes
				'.agrikole-step-box .number-box .number',
				'.agrikole-links.link-style-1.accent',
				'.agrikole-links.link-style-2.accent',
				'.agrikole-links.link-style-3.accent',
				'.agrikole-arrow.hover-accent:hover',
				'.agrikole-button.outline.outline-accent',
				'.agrikole-button.outline.outline-accent .icon',
				'.agrikole-counter .icon.accent',
				'.agrikole-counter .prefix.accent',
				'.agrikole-counter .suffix.accent',
				'.agrikole-counter .number.accent',
				'.agrikole-divider.has-icon .icon-wrap > span.accent',
				'.agrikole-single-heading .heading.accent',
				'.agrikole-headings .heading.accent',
				'.agrikole-icon.accent > .icon',
				'.agrikole-image-box .item .title a:hover',
				'.agrikole-news .meta .author a:hover',
				'.agrikole-news .meta .comment a:hover ',
				'.agrikole-progress .perc.accent',
				'.agrikole-list .icon.accent',

				 // Woocommerce
				'.woocommerce-page .woocommerce-MyAccount-content .woocommerce-info .button',
				'.products li .product-info .button',
				'.products li .product-info .added_to_cart',
				'.products li .product-cat:hover',
				'.products li h2:hover',
				'.woo-single-post-class .woocommerce-grouped-product-list-item__label a:hover',
				'.woocommerce-page .shop_table.cart .product-name a:hover',
				'.product_list_widget .product-title:hover',
				'.widget_recent_reviews .product_list_widget a:hover',
				'.widget_product_categories ul li a:hover',
				'.widget.widget_product_search .woocommerce-product-search .search-submit:hover:before',
				'.widget_shopping_cart_content ul li a:hover',

				 // Default Link
				 'a',
			) );

			// Background color
			$backgrounds = apply_filters( 'agrikole_accent_backgrounds', array(
				'blockquote:before',
				'button, input[type="button"], input[type="reset"], input[type="submit"]',
				'bg-accent',
				'#main-nav > ul > li > a > span:before',
				'#main-nav .sub-menu li a:before',
				'.header-style-3 #main-nav > ul > li.current-menu-item > a > span',
				'.header-style-3 #main-nav > ul > li.current-menu-parent > a > span',
				'.header-style-5 #main-nav > ul > li.current-menu-item > a > span',
				'.header-style-5 #main-nav > ul > li.current-menu-parent > a > span',
				'.hentry .post-media .post-date-custom',
				'.post-media .slick-prev:hover',
				'.post-media .slick-next:hover',
				'.post-media .slick-dots li.slick-active button',
				'.hentry .post-link a > span:before',
				'.comment-reply a',
				'#cancel-comment-reply-link',
				'#footer-widgets .widget .widget-title > span:after ',
				'#sidebar .widget.widget_search .search-form',
				'.widget.widget_search .search-form .search-submit',
				'.widget_mc4wp_form_widget .mc4wp-form .submit-wrap button',
				'#sidebar .widget.widget_tag_cloud .tagcloud a:hover',
				'.widget_product_tag_cloud .tagcloud a:hover',
				'.no-results-content .search-form .search-submit:before',

				// shortcodes
				'.agrikole-accordions .accordion-item.active .accordion-heading > .inner:before',
				'.agrikole-step-box .number-box:hover .number',
				'.agrikole-links > span:before',
				'.agrikole-links.link-style-1.accent > span:before',
				'.agrikole-links.link-style-1.accent > span:after',
				'.agrikole-links.link-style-1.dark > span:after',
				'.agrikole-links.link-style-2.accent > span:before',
				'.agrikole-links.link-style-3.accent > span:after',
				'.agrikole-links.link-style-3.dark > span:after',
				'.agrikole-button.accent',
				'.agrikole-button.outline.outline-accent:hover',
				'.agrikole-content-box > .inner.accent',
				'.agrikole-content-box > .inner.dark-accent',
				'.agrikole-content-box > .inner.light-accent',
				'.agrikole-single-heading .line.accent',
				'.agrikole-headings .sep.accent',
				'.agrikole-headings .heading > span',
				'.agrikole-icon-box:hover .icon-number',
				'.agrikole-icon.accent-bg .icon',
				'.agrikole-image-box .item .thumb .hover-image .arrow',
				'.agrikole-image-box.style-2 .url-wrap .arrow',
				'.agrikole-images-grid .zoom-popup:after',
				'.agrikole-news .image-wrap .post-date-custom',
				'.project-box .project-text .button a',
				'.project-box .project-text .arrow a',
				'.agrikole-progress .progress-animate.accent',
				'.agrikole-images-carousel.has-borders:after',
				'.agrikole-images-carousel.has-borders:before',
				'.agrikole-images-carousel.has-arrows.arrow-bottom .owl-nav',
				'.agrikole-team .socials li a:hover',
				'.agrikole-video-icon.accent a',

				// woocemmerce
				'.woocommerce-page .wc-proceed-to-checkout .button',
				'.woocommerce-page .return-to-shop a',
				'#payment #place_order',
				'.widget_price_filter .price_slider_amount .button:hover',
				'.widget_shopping_cart_content .buttons a.checkout',
			) );

			// Border color
			$borders = apply_filters( 'agrikole_accent_borders', array(
				'.underline-solid:after, .underline-dotted:after, .underline-dashed:after' => array( 'bottom' ),
				'.widget.widget_links ul li a:after' => array( 'bottom' ),
				'.widget_mc4wp_form_widget .mc4wp-form .email-wrap input:focus',
				'#sidebar .widget.widget_tag_cloud .tagcloud a:hover',
				'.widget_product_tag_cloud .tagcloud a:hover',
				'.no-results-content .search-form .search-field:focus',

				// shortcodes
				'.agrikole-step-box .number-box .number',
				'.agrikole-button.outline.outline-accent',
				'.agrikole-button.outline.outline-accent:hover',
				'.divider-icon-before.accent',
				'.divider-icon-after.accent',
				'.agrikole-divider.has-icon .divider-double.accent',

				// woocommerce
				'.widget_price_filter .ui-slider .ui-slider-handle',
			) );

			// Gradient color
			$gradients = apply_filters( 'agrikole_accent_gradient', array(
				'.agrikole-progress .progress-animate.accent.gradient'
			) );

			// Return array
			if ( 'texts' == $return ) {
				return $texts;
			} elseif ( 'backgrounds' == $return ) {
				return $backgrounds;
			} elseif ( 'borders' == $return ) {
				return $borders;
			} elseif ( 'gradients' == $return ) {
				return $gradients;
			}
		}

		// Generates the CSS output
		public static function head_css( $output ) {

			// Get custom accent
			$default_accent = '#eddd5e';
			$custom_accent  = agrikole_get_mod( 'accent_color' );

			// Return if accent color is empty or equal to default
			if ( ! $custom_accent || ( $default_accent == $custom_accent ) )
				return $output;

			// Define css var
			$css = '';

			// Get arrays
			$texts       = self::arrays( 'texts' );
			$backgrounds = self::arrays( 'backgrounds' );
			$borders     = self::arrays( 'borders' );
			$gradients    = self::arrays( 'gradients' );

			// Texts
			if ( ! empty( $texts ) )
				$css .= implode( ',', $texts ) .'{color:'. $custom_accent .';}';

			// Backgrounds
			if ( ! empty( $backgrounds ) )
				$css .= implode( ',', $backgrounds ) .'{background-color:'. $custom_accent .';}';

			// Borders
			if ( ! empty( $borders ) ) {
				foreach ( $borders as $key => $val ) {
					if ( is_array( $val ) ) {
						$css .= $key .'{';
						foreach ( $val as $key => $val ) {
							$css .= 'border-'. $val .'-color:'. $custom_accent .';';
						}
						$css .= '}'; 
					} else {
						$css .= $val .'{border-color:'. $custom_accent .';}';
					}
				}
			}

			// Gradients
			if ( ! empty( $gradients ) )
				$css .= implode( ',', $gradients ) .'{background: '. agrikole_hex2rgba($custom_accent, 1) .';background: -moz-linear-gradient(left, '. agrikole_hex2rgba($custom_accent, 1) .' 0%, '. agrikole_hex2rgba($custom_accent, 0.3) .' 100%);background: -webkit-linear-gradient( left, '. agrikole_hex2rgba($custom_accent, 1) .' 0%, '. agrikole_hex2rgba($custom_accent, 0.3) .' 100% );background: linear-gradient(to right, '. agrikole_hex2rgba($custom_accent, 1) .' 0%, '. agrikole_hex2rgba($custom_accent, 0.3) .' 100%) !important;}';

			// Return CSS
			if ( ! empty( $css ) )
				$output .= '/*ACCENT COLOR*/'. $css;

			// Return output css
			return $output;
		}
	}
}

new Agrikole_Accent_Color();
