<?php
/**
 * Gets all theme mods and stores them in an easily accessable global var to limit DB requests
 *
 * @package agrikole
 * @version 3.6.8
 */

global $agrikole_theme_mods;
$agrikole_theme_mods = get_theme_mods();

// Returns theme mod from global var
function agrikole_get_mod( $id, $default = '' ) {

	// Return get_theme_mod on customize_preview
	if ( is_customize_preview() ) {
		return get_theme_mod( $id, $default );
	}
   
	// Get global object
	global $agrikole_theme_mods;

	// Return data from global object
	if ( ! empty( $agrikole_theme_mods ) ) {

		// Return value
		if ( isset( $agrikole_theme_mods[$id] ) ) {
			return $agrikole_theme_mods[$id];
		} 
		else {
			return $default;
		}
	}

	// Global object not found return using get_theme_mod
	else {
		return get_theme_mod( $id, $default );
	}
}

// Returns global mods
function agrikole_get_mods() {
	global $agrikole_theme_mods;
	return $agrikole_theme_mods;
}