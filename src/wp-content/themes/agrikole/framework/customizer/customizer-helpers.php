<?php

/* Headers */
function agrikole_cac_has_header_one() {
	$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
	if ( is_page() && agrikole_metabox( 'header_style' ) )
		$header_style = agrikole_metabox( 'header_style' );

	if ( 'style-1' == $header_style ) { return true;
	} else { return false; }
}

function agrikole_cac_has_header_two() {
	$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
	if ( is_page() && agrikole_metabox( 'header_style' ) )
		$header_style = agrikole_metabox( 'header_style' );

	if ( 'style-2' == $header_style ) { return true;
	} else { return false; }
}

function agrikole_cac_has_header_three() {
	$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
	if ( is_page() && agrikole_metabox( 'header_style' ) )
		$header_style = agrikole_metabox( 'header_style' );

	if ( 'style-3' == $header_style ) { return true;
	} else { return false; }
}

function agrikole_cac_has_header_four() {
	$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
	if ( is_page() && agrikole_metabox( 'header_style' ) )
		$header_style = agrikole_metabox( 'header_style' );

	if ( 'style-4' == $header_style ) { return true;
	} else { return false; }
}

function agrikole_cac_has_header_five() {
	$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
	if ( is_page() && agrikole_metabox( 'header_style' ) )
		$header_style = agrikole_metabox( 'header_style' );

	if ( 'style-5' == $header_style ) { return true;
	} else { return false; }
}

function agrikole_cac_has_header_center() {
	$header_style = agrikole_get_mod( 'header_site_style', 'style-1' );
	if ( is_page() && agrikole_metabox( 'header_style' ) )
		$header_style = agrikole_metabox( 'header_style' );

	if ( 'style-2' == $header_style || 'style-3' == $header_style  ) { return true;
	} else { return false; }
}

function agrikole_cac_header_search_icon() {
	return get_theme_mod( 'header_search_icon', true );
}

function agrikole_cac_header_cart_icon() {
	if ( class_exists( 'woocommerce' ) && get_theme_mod( 'header_cart_icon', true ) ) {
		return true;	
	} else {
		return false;
	}
}

function agrikole_cac_has_header_socials() {
	return get_theme_mod( 'header_socials', true );
}

function agrikole_cac_has_header_fixed() {
	return get_theme_mod( 'header_fixed', true );
}

/* WooCommerce */
function agrikole_cac_has_woo() {
	if ( class_exists( 'woocommerce' ) ) { return true;	}
	else { return false; }
}

/* Scroll Top Button */
function agrikole_cac_has_scroll_top() {
	return get_theme_mod( 'scroll_top', true );
}

/* Layout */
function agrikole_cac_has_boxed_layout() {
	if ( 'boxed' == get_theme_mod( 'site_layout_style', 'full-width' ) ) {
		return true;
	} else {
		return false;
	}
}

/* Featured Title */
function agrikole_cac_has_featured_title() {
	return get_theme_mod( 'featured_title', true );
}

function agrikole_cac_has_featured_title_center() {
	if ( agrikole_cac_has_featured_title_heading()
		&& 'centered' == get_theme_mod( 'featured_title_style' ) ) {
		return true;
	} else {
		return false;
	}
}

function agrikole_cac_has_featured_title_breadcrumbs() {
	if ( agrikole_cac_has_featured_title() && get_theme_mod( 'featured_title_breadcrumbs' ) ) {
		return true;
	} else {
		return false;
	}
}

function agrikole_cac_has_featured_title_heading() {
	if ( agrikole_cac_has_featured_title() && get_theme_mod( 'featured_title_heading' ) ) {
		return true;
	} else {
		return false;
	}
}

/* Project Single */
function agrikole_cac_has_single_project() {
	if ( is_singular( 'project' ) ) {
		return true;
	} else {
		return false;
	}
}

function agrikole_cac_has_related_project() {
	if ( agrikole_get_mod( 'project_related', true ) && agrikole_cac_has_single_project() ) {
		return true;
	};
}

/* Footer
-------------------------------------------------------------- */
function agrikole_cac_has_footer_widgets() {
	return get_theme_mod( 'footer_widgets', true );
}

function agrikole_cac_has_footer_simple() {
	$fcol = agrikole_get_mod( 'footer_columns', '4' );

	if ( '5' != $fcol ) { return true;
	} else { return false; }
}


/* Bottom Bar
-------------------------------------------------------------- */
function agrikole_cac_has_bottombar() {
	return get_theme_mod( 'bottom_bar', true );
}