<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Change default size for single image shortcode
add_action('init', 'vc_update_defaults', 100);
function vc_update_defaults() {
	if ( class_exists( 'WPBMap' ) )  {
		// Set full size for single image by default
		$param = WPBMap::getParam( 'vc_single_image', 'img_size' );
		$param['value'] = 'full';
		vc_update_shortcode_param( 'vc_single_image', $param );
	}
}

// Get icon font base on font icon type
if ( ! function_exists('agrikole_get_icon_class') ) {
	function agrikole_get_icon_class( $atts, $icon_location ) {
		// Define vars
		$icon = '';
		$icon_type = ! empty( $atts['icon_type'] ) ? $atts['icon_type'] : 'fontawesome';

		// Generate fontawesome icon class
		if ( 'fontawesome' == $icon_type && ! empty( $atts[$icon_location] ) ) {
			$icon = $atts[$icon_location];
			$icon = str_replace( 'fa-', '', $icon );
			$icon = str_replace( 'fa ', '', $icon );
			$icon = 'fa fa-'. $icon;
		} elseif ( ! empty( $atts[ $icon_location .'_'. $icon_type ] ) ) {
			$icon = $atts[ $icon_location .'_'. $icon_type ];
		}

		// Sanitize
		$icon = in_array( $icon, array( 'icon', 'none' ) ) ? '' : $icon;

		// Return icon class
		return $icon;
	}
}

// Add moreparams
add_action('init', 'vc_add_new_para', 100);
	function vc_add_new_para() {
	if ( function_exists( 'add_shortcode_param' ) ) {
		if ( defined( 'WPB_VC_VERSION' ) && version_compare( '5.0', WPB_VC_VERSION, '>=' ) ) {
			add_shortcode_param( 'number' , 'agrikole_param_number' );
			add_shortcode_param( 'headings' , 'agrikole_param_heading' );
		}
	}
	if ( function_exists( 'vc_add_shortcode_param' ) ) {
		vc_add_shortcode_param( 'number' , 'agrikole_param_number' );
		vc_add_shortcode_param( 'headings' , 'agrikole_param_heading' );
	}

	// Add Number param
	function agrikole_param_number( $settings, $value ) {
		$dependency = '';
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$type = isset($settings['type']) ? $settings['type'] : '';
		$suffix = isset($settings['suffix']) ? $settings['suffix'] : '';
		$class = isset($settings['class']) ? $settings['class'] : '';
		$output = '<input type="number" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'. $value.'" style="max-width:100px; margin-right: 10px;" />'. $suffix;
		return $output;
	}

	// Add Heading param
	function agrikole_param_heading( $settings, $value ) {
		$dependency = '';
		$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
		$class = isset($settings['class']) ? $settings['class'] : '';
		$text = isset($settings['text']) ? $settings['text'] : '';
		$output = '<h4 '. $dependency .' class="wpb_vc_param_value '. $class .'" style="margin: 10px 0 0;padding:10px;font-size:14px; background:#ebebeb;color:#666;">'. $text .'</h4>';
		$output .= '<input type="hidden" name="'. $settings['param_name'].'" class="wpb_vc_param_value '. $settings['param_name'] .' '. $settings['type'] .'_field" value="'. $value.'" '. $dependency.'/>';
		return $output;
	}
}


// Return list of contact form 7
if ( ! function_exists('agrikole_list_contact_form_7') ) {
	function agrikole_list_contact_form_7() {
		$forms = array();
	    $posts = get_posts(array(
	        'post_type'     => 'wpcf7_contact_form',
	        'numberposts'   => -1
	    ));

	    foreach ( $posts as $p ) {
	        $forms[$p->post_title] = $p->ID;
	    }

		return $forms;
	}
}

// Return simple fonts array
if ( ! function_exists('agrikole_plugin_google_font') ) {
	function agrikole_plugin_google_font() {
		if ( function_exists('agrikole_google_fonts_array') ) {
			$default = array( 0 => 'Default' );
			return array_merge( $default, agrikole_google_fonts_array() );
		} else {
			return array(
				'Default', 'Arial, Helvetica, sans-serif', 'Arial Black, Gadget, sans-serif',
				'Bookman Old Style, serif', 'Comic Sans MS, cursive', 'Courier, monospace',
				'Georgia, serif', 'Garamond, serif', 'Impact, Charcoal, sans-serif', 'Lucida Console, Monaco, monospace',
				'Lucida Sans Unicode, Lucida Grande, sans-serif', 'MS Sans Serif, Geneva, sans-serif', 'MS Serif, New York, sans-serif',
				'Palatino Linotype, Book Antiqua, Palatino, serif', 'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif',
				'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif', 'Paratina Linotype', 'Trebuchet MS',
			);
		}
	}
}

// Spacing
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Spacing', 'agrikole'),
        'description' => esc_html__('Empty space with custom height.', 'agrikole'),
        'base' => 'spacing',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
	        array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Desktop: Height', 'agrikole'),
				'param_name' => 'desktop_height',
				'value' => '',
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Mobile: Height', 'agrikole'),
				'param_name' => 'mobile_height',
				'value' => '',
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Small Mobile: Height', 'agrikole'),
				'param_name' => 'smobile_height',
				'value' => '',
	        ),
        )
    ) );
} );

// Carousel Box
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_carouselbox extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
    vc_map( array(
		'name' => esc_html__('Carousel Box', 'agrikole'),
		'description' => esc_html__('Scrolling anything.', 'agrikole'),
		'base' => 'carouselbox',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array('only' => 'contentbox, imagebox, iconbox, videoicon, simpleimage, headings, fancytext, singleheading, pricetable, counter'),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Auto Scroll?', 'agrikole' ),
				'param_name' => 'auto_scroll',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Query', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Infinity Loop?', 'agrikole' ),
				'param_name' => 'loop',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Duplicate last and first items to get loop illusion.', 'agrikole'),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Item: Spacing Between', 'agrikole'),
				'param_name' => 'gap',
				'value' => '30',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
	        // Controls
			array(
				'type' => 'headings',
				'text' => esc_html__('Bullets', 'agrikole'),
				'param_name' => 'bullets_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Bullets?', 'agrikole' ),
				'param_name' => 'show_bullets',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Space between Bullets & Elements', 'agrikole' ),
				'param_name' => 'bullet_between',
				'value'      => array(
					'50px' => '50',
					'45px' => '45',
					'40px' => '40',
					'35px' => '35',
					'30px' => '30',
					'25px' => '25',
					'20px' => '20',
					'15px' => '15',
					'10px' => '10',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Arrows', 'agrikole'),
				'param_name' => 'arrows_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Arrows?', 'agrikole' ),
				'param_name' => 'show_arrows',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrow Position', 'agrikole' ),
				'param_name' => 'arrow_position',
				'value'      => array(
					'Top' => 'top',
					'Center' => 'center',
					'Bottom' => 'bottom',
				),
				'std'		=> 'center',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-70' => '-70',
					'-60' => '-60',
					'-50' => '-50',
					'-40' => '-40',
					'-30' => '-30',
					'-20' => '-20',
					'-10' => '-10',
					'Center' => 'center',
					'10' => '10',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
				),
				'std'		=> 'center',
				'dependency' => array( 'element' => 'arrow_position', 'value' => 'center' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Vertical', 'agrikole' ),
				'param_name' => 'arrow_offset_v',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-120' => '-120',
					'-110' => '-110',
					'-100' => '-100',
					'-90' => '-90',
					'-80' => '-80',
					'-70' => '-70',
					'-60' => '-60',
					'-50' => '-50',
					'-40' => '-40',
					'-30' => '-30',
					'-20' => '-20',
					'0' => '0',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'80' => '80',
					'90' => '90',
					'100' => '100',
					'110' => '110',
					'120' => '120',
				),
				'std'		=> '0',
				'dependency' => array( 'element' => 'arrow_position', 'value' => 'center' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset_s',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
					'45' => '45',
					'50' => '50',
					'55' => '55',
					'60' => '60',
					'65' => '65',
					'70' => '70',
					'75' => '75',
					'80' => '80',
					'85' => '85',
					'90' => '90',
					'95' => '95',
					'100' => '100',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'arrow_position', 'value' => array('top', 'bottom') ),
			),
			// Column
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen > 1000px', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
					'7 Columns' => '7c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen from 600px to 1000px', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen < 600px', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '1c',
			),
        )
    ) );
} );

// Center Carousel Box
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_centercarouselbox extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
    vc_map( array(
		'name' => esc_html__('Center Carousel Box', 'agrikole'),
		'description' => esc_html__('Scrolling anything.', 'agrikole'),
		'base' => 'centercarouselbox',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array('only' => 'contentbox, imagebox, iconbox, simpleimage, pricetable'),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Auto Scroll?', 'agrikole' ),
				'param_name' => 'auto_scroll',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'true',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Spacing Between', 'agrikole' ),
				'param_name' => 'gap',
				'value'      => array(
					'0px' => '0',
					'10px' => '10',
					'20px' => '20',
					'30px' => '30',
					'40px' => '40',
					'50px' => '50',
					'60px' => '60',
				),
				'std'		=> '30',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Slide Show', 'agrikole' ),
				'param_name' => 'slide',
				'value'      => array(
					'1' => '1',
					'3' => '3',
				),
				'std'		=> '3',
			),
	        array(
				'type' => 'number',
				'heading' => esc_html__('Padding Content', 'agrikole'),
				'param_name' => 'padding',
				'value' => 15,
				'suffix' => '%',
	        ),
	        // Controls
			array(
				'type' => 'headings',
				'text' => esc_html__('Bullets', 'agrikole'),
				'param_name' => 'bullets_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Bullets?', 'agrikole' ),
				'param_name' => 'show_bullets',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Space between Bullets & Elements', 'agrikole' ),
				'param_name' => 'bullet_between',
				'value'      => array(
					'50px' => '50',
					'40px' => '40',
					'30px' => '30',
					'20px' => '20',
					'10px' => '10',
					'0px' => '0',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
        )
    ) );
} );

// Portfolio Carousel
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Portfolio Carousel', 'agrikole'),
        'description' => esc_html__('Displaying project posts in carousel.', 'agrikole'),
        'base' => 'portfolio',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Wrap Margin', 'agrikole'),
				'param_name' => 'margin',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. You can use % or px value.', 'agrikole'),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Cropping', 'agrikole' ),
				'param_name' => 'image_crop',
				'value'      => array(
					'Default' => 'default',
					'Full' => 'full',
					'640 x 640' => 'std1',
					'640 x 430' => 'std2',
					'370 x 370' => 'square',
					'370 x 484' => 'rectangle',
					'370 x 400' => 'rectangle2',
					'465 x 603' => 'rectangle3'	
				),
				'std'		=> 'full',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Rounded?', 'agrikole' ),
				'param_name' => 'image_rounded',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Padding', 'agrikole'),
				'param_name' => 'content_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left.  Default: 0px 58px 0px 58px.', 'agrikole'),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing between items', 'agrikole'),
				'param_name' => 'gap',
				'value' => '0',
				'description'	=> esc_html__('Ex: 30', 'agrikole'),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Posts Per Page', 'agrikole'),
				'param_name' => 'items',
				'value' => '8',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Category Slug (Optional)', 'agrikole'),
				'param_name' => 'cat_slug',
				'value' => '',
				'description'	=> esc_html__('Displaying posts that have this category. Using category-slug.', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Exclude Category Slug (Optional)', 'agrikole'),
				'param_name' => 'exclude_cat_slug',
				'value' => '',
				'description'	=> esc_html__('Exclude posts that have this category. Using category-slug.', 'agrikole'),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Auto Scroll?', 'agrikole' ),
				'param_name' => 'auto_scroll',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Center Mode?', 'agrikole' ),
				'param_name' => 'center_mode',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
			),

			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Infinity Loop?', 'agrikole' ),
				'param_name' => 'loop',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'description'	=> esc_html__('Duplicate last and first items to get loop illusion.', 'agrikole'),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Show hidden items with opacity?', 'agrikole' ),
				'param_name' => 'show_opacity',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
			),
	        // Controls
			array(
				'type' => 'headings',
				'text' => esc_html__('Bullets', 'agrikole'),
				'param_name' => 'bullets_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Bullets?', 'agrikole' ),
				'param_name' => 'show_bullets',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Space between Bullets & Images', 'agrikole' ),
				'param_name' => 'bullet_between',
				'value'      => array(
					'50px' => '50',
					'45px' => '45',
					'40px' => '40',
					'35px' => '35',
					'30px' => '30',
					'25px' => '25',
					'20px' => '20',
					'15px' => '15',
					'10px' => '10',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Bullets Show', 'agrikole' ),
				'param_name' => 'bullet_show',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'Square' => 'bullet-square',
					'Circle' => 'bullet-circle',
				),
				'std'		=> 'bullet-square',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Arrows', 'agrikole'),
				'param_name' => 'arrows_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Arrows?', 'agrikole' ),
				'param_name' => 'show_arrows',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-40' => '-40',
					'-35' => '-35',
					'-30' => '-30',
					'-25' => '-25',
					'-20' => '-20',
					'-15' => '-15',
					'-10' => '-10',
					'Center' => 'center',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
				),
				'std'		=> 'center',
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Vertical', 'agrikole' ),
				'param_name' => 'arrow_offset_v',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-120' => '-120',
					'-110' => '-110',
					'-100' => '-100',
					'-90' => '-90',
					'-80' => '-80',
					'-70' => '-70',
					'-60' => '-60',
					'-50' => '-50',
					'-40' => '-40',
					'-30' => '-30',
					'-20' => '-20',
					'0' => '0',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'80' => '80',
					'90' => '90',
					'100' => '100',
					'110' => '110',
					'120' => '120',
				),
				'std'		=> '0',
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			// Columns
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen > 1000px.', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
					'7 Columns' => '7c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen from 600px to 1000px.', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen < 600px.', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '1c',
			),
        )
    ) );
} );

// Portfolio Grid
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Portfolio Grid', 'agrikole'),
        'description' => esc_html__('Displaying project posts in grid with filter bar.', 'agrikole'),
        'base' => 'portfoliogrid',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
					'Style 3' => 'style-3',
				),
				'std'		=> 'style-1',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text on Hover', 'agrikole'),
				'param_name' => 'hover_text',
				'value' => 'Show Detail',
				'dependency' => array( 'element' => 'style', 'value' => 'style-2' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Wrap Margin', 'agrikole'),
				'param_name' => 'margin',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. You can use % or px value.', 'agrikole'),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Showcase', 'agrikole' ),
				'param_name' => 'showcase',
				'value'      => array(
					'Masonry' => 'masonry',
					'Mosaic' => 'mosaic',
				),
				'std'		=> 'masonry',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Cropping', 'agrikole' ),
				'param_name' => 'image_crop',
				'value'      => array(
					'Default' => 'default',
					'Full' => 'full',
					'640 x 640' => 'std1',
					'640 x 430' => 'std2',
					'370 x 370' => 'square',
					'370 x 484' => 'rectangle',
					'370 x 400' => 'rectangle2',
					'465 x 603' => 'rectangle3'	
				),
				'std'		=> 'full',
				'description'	=> esc_html__('Choose <Default> to use Image-Cropping from metabox.', 'agrikole'),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Rounded?', 'agrikole' ),
				'param_name' => 'image_rounded',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Padding', 'agrikole'),
				'param_name' => 'content_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Default: 0px 58px 0px 58px.', 'agrikole'),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing between items', 'agrikole'),
				'param_name' => 'gapv',
				'value' => '0',
				'description'	=> esc_html__('Ex: 30', 'agrikole'),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing below items', 'agrikole'),
				'param_name' => 'gaph',
				'value' => '0',
				'description'	=> esc_html__('Ex: 30', 'agrikole'),
            ),
            // Query
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Posts Per Page', 'agrikole'),
				'param_name' => 'items',
				'group'      => esc_html__( 'Query', 'agrikole' ),
				'value' => '8',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Category Slug (Optional)', 'agrikole'),
				'param_name' => 'cat_slug',
				'value' => '',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Displaying posts that have this category. Using category-slug.', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Exclude Category Slug (Optional)', 'agrikole'),
				'param_name' => 'exclude_cat_slug',
				'value' => '',
				'description'	=> esc_html__('Exclude posts that have this category. Using category-slug.', 'agrikole'),
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Pagination?', 'agrikole' ),
				'param_name' => 'pagination',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'value' => array(
					'Yes' => 'true',
					'No' => 'false',
				),
				'std'		=> 'false',
			),
			// Filter
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Filter Bar?', 'agrikole' ),
				'param_name' => 'show_filter',
				'group' => esc_html__( 'Filter', 'agrikole' ),
				'value' => array(
					'Yes' => 'true',
					'No' => 'false',
				),
				'std'		=> 'true',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button: All', 'agrikole'),
				'param_name' => 'filter_button_all',
				'value' => 'All',
				'group' => esc_html__( 'Filter', 'agrikole' ),
				'description'	=> esc_html__('Leave it empty to disable.', 'agrikole'),
				'dependency' => array( 'element' => 'show_filter', 'value' => 'true' ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Bottom Margin', 'agrikole'),
				'param_name' => 'bottom_filter',
				'value' => '',
				'description'	=> esc_html__('Ex: 45px.', 'agrikole'),
				'group' => esc_html__( 'Filter', 'agrikole' ),
				'dependency' => array( 'element' => 'show_filter', 'value' => 'true' ),
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Filter Alignment', 'agrikole' ),
				'param_name' => 'filter_align',
				'value'      => array(
					'Left' => 'style-1',
					'Center' => 'style-2',
					'Right' => 'style-3',
				),
				'std'		=> 'style-1',
				'group' => esc_html__( 'Filter', 'agrikole' ),
				'dependency' => array( 'element' => 'show_filter', 'value' => 'true' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Show Counter?', 'agrikole' ),
				'param_name' => 'show_counter',
				'group' => esc_html__( 'Filter', 'agrikole' ),
				'value' => array(
					'Yes' => 'true',
					'No' => 'false',
				),
				'std'		=> 'true',
				'dependency' => array( 'element' => 'show_filter', 'value' => 'true' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Filter posts by default?', 'agrikole' ),
				'param_name' => 'filter_by_default',
				'group' => esc_html__( 'Filter', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
				'dependency' => array( 'element' => 'show_filter', 'value' => 'true' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Category Slug', 'agrikole'),
				'param_name' => 'filter_cat_slug',
				'value' => '',
				'group' => esc_html__( 'Filter', 'agrikole' ),
				'dependency' => array( 'element' => 'filter_by_default', 'value' => 'yes' ),
				'description'	=> esc_html__('Filter posts from this category by default. Using category-slug.', 'agrikole'),
	        ),
            // Typography
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Filter: Font Family', 'agrikole' ),
				'param_name' => 'filter_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Filter: Font Weight', 'agrikole' ),
				'param_name' => 'filter_font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Filter: Font Size', 'agrikole'),
				'param_name' => 'filter_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Filter: Line-Height', 'agrikole'),
				'param_name' => 'filter_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Filter: Letter Spacing', 'agrikole'),
				'param_name' => 'filter_letter_spacing',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Filter: Text Transform', 'agrikole' ),
				'param_name' => 'filter_text_tranform',
				'value'      => array(
					'Capitalize' => 'capitalize',
					'Uppercase' => 'uppercase',
				),
				'std'		=> 'uppercase',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'If Wrap > 1100px', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c'
				),
				'std'		=> '4c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'If Wrap from 800px to 1099px', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'If Wrap from 550px to 799px', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'If Wrap < 549px', 'agrikole' ),
				'param_name' => 'column4',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
				),
				'std'		=> '1c',
			),
        )
    ) );
} );

// Testimonials
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Testimonials', 'agrikole'),
	    'description' => esc_html__('Displaying testimonials.', 'agrikole'),
	    'base' => 'testimonialssingle',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
	        // Image
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'agrikole'),
				'param_name' => 'image',
				'value' => '',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Width (Optional)', 'agrikole'),
				'param_name' => 'image_width',
				'value' => '',
				'description'	=> esc_html__('Ex: 70px.', 'agrikole'),
	        ),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Box Shadow?', 'agrikole' ),
				'param_name' => 'box_shadow',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
	        // Text
			array(
				'type' 		=> 'textarea',
				'heading' 	=> esc_html__('Text', 'agrikole'),
				'param_name' 	=> 'text',
				'value' 		=> '',
				'group' => esc_html__( 'Text', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text Color', 'agrikole'),
				'param_name' => 'text_color',
				'value' => '',
				'group' => esc_html__( 'Text', 'agrikole' ),
            ),
            // Name
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Name', 'agrikole'),
				'param_name' => 'name',
				'value' => 'JOHN ROE',
				'group' => esc_html__( 'Name & Position', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Name Color', 'agrikole'),
				'param_name' => 'name_color',
				'value' => '',
				'group' => esc_html__( 'Name & Position', 'agrikole' ),
            ),
            // Position
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Position', 'agrikole'),
				'param_name' => 'position',
				'value' => 'Sale Manager',
				'group' => esc_html__( 'Name & Position', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Position Color', 'agrikole'),
				'param_name' => 'position_color',
				'value' => '',
				'group' => esc_html__( 'Name & Position', 'agrikole' ),
            ),
			// Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Text', 'agrikole'),
				'param_name' => 'text_typography',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Font Family', 'agrikole' ),
				'param_name' => 'text_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Font Weight', 'agrikole' ),
				'param_name' => 'text_font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text Font Size', 'agrikole'),
				'param_name' => 'text_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Font Style', 'agrikole' ),
				'param_name' => 'text_font_style',
				'value'      => array(
					'Normal' => 'normal',
					'Italic' => 'italic',
				),
				'std'		=> 'normal',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text Line-height', 'agrikole'),
				'param_name' => 'text_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Name', 'agrikole'),
				'param_name' => 'name_typography',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Name Font Family', 'agrikole' ),
				'param_name' => 'name_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Name Font Weight', 'agrikole' ),
				'param_name' => 'name_font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name Font Size', 'agrikole'),
				'param_name' => 'name_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name Line-height', 'agrikole'),
				'param_name' => 'name_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Position', 'agrikole'),
				'param_name' => 'position_typography',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Position Font Family', 'agrikole' ),
				'param_name' => 'position_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Position Font Weight', 'agrikole' ),
				'param_name' => 'company_font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position Font Size', 'agrikole'),
				'param_name' => 'position_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position Line-height', 'agrikole'),
				'param_name' => 'position_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	    )
	) );
} );

// Testimonials Box
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Testimonials Box', 'conceptseven'),
	    'description' => esc_html__('Displaying testimonials posts.', 'conceptseven'),
	    'base' => 'testimonials',
		'weight'	=>	180,
		'show_settings_on_create' => false,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'conceptseven'),
	    'params' => array(
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number of items', 'agrikole'),
				'param_name' => 'items',
				'value' => '4',
	        ),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Arrows?', 'agrikole' ),
				'param_name' => 'show_arrows',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Padding.', 'agrikole'),
				'param_name' => 'content_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 65px 70px 65px 70px', 'agrikole'),
	        ),
	    )
	) );
} );

// Testimonials Group
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Testimonials Group', 'conceptseven'),
	    'description' => esc_html__('Displaying testimonials posts.', 'conceptseven'),
	    'base' => 'testimonialsgroup',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'conceptseven'),
	    'params' => array(
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number of items', 'edukul'),
				'param_name' => 'items',
				'value' => '4',
	        ),
	    )
	) );
} );

// Contact Form 7
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Contact Form 7 (Styled)', 'conceptseven'),
	    'description' => esc_html__('Displaying Contact Form 7 with special style', 'conceptseven'),
	    'base' => 'contactform',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'conceptseven'),
	    'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Form', 'agrikole' ),
				'param_name' => 'form_id',
				'std' => '',
				'value'      =>  agrikole_list_contact_form_7(),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Input Background', 'agrikole' ),
				'param_name' => 'background',
				'value'      => array(
					'Gray' => 'gray',
					'White' => 'white',
				),
				'std'		=> 'gray',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button', 'agrikole' ),
				'param_name' => 'button',
				'value'      => array(
					'Accent' => 'accent',
					'Green' => 'green',
				),
				'std'		=> 'green',
			),
	    )
	) );
} );

// News Carousel
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('News Carousel', 'agrikole'),
	    'description' => esc_html__('Displaying blog posts in carousel.', 'agrikole'),
	    'base' => 'news',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
				),
				'std'		=> 'style-1',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Thumbnail Image', 'agrikole' ),
				'param_name' => 'thumb',
				'value'      => array(
					'Featured Image' => 'featured-image',
					'Custom Thumbnail' => 'custom-thumbnail',
				),
				'std'		=> 'featured-image',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Padding.', 'agrikole'),
				'param_name' => 'content_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 20px 17px 30px 17px', 'agrikole'),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Content Background', 'agrikole'),
				'param_name' => 'content_background',
				'value' => '#f7f7f7',
            ),
	        // Query
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number of items', 'agrikole'),
				'param_name' => 'items',
				'value' => '3',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Category Slug (Optional)', 'agrikole'),
				'param_name' => 'cat_slug',
				'value' => '',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Displaying posts that have this category. Using category-slug.', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Item: Space Between', 'agrikole'),
				'param_name' => 'gap',
				'value' => '30',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Important! Include the blur distance of the shadow.', 'agrikole'),
	        ),
	        // Controls
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Auto Scroll?', 'agrikole' ),
				'param_name' => 'auto_scroll',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Bullets', 'agrikole'),
				'param_name' => 'bullets_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Bullets?', 'agrikole' ),
				'param_name' => 'show_bullets',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Space between Bullets & Elements', 'agrikole' ),
				'param_name' => 'bullet_between',
				'value'      => array(
					'50px' => '50',
					'45px' => '45',
					'40px' => '40',
					'35px' => '35',
					'30px' => '30',
					'25px' => '25',
					'20px' => '20',
					'15px' => '15',
					'10px' => '10',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Arrows', 'agrikole'),
				'param_name' => 'arrows_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Arrows?', 'agrikole' ),
				'param_name' => 'show_arrows',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrow Position', 'agrikole' ),
				'param_name' => 'arrow_position',
				'value'      => array(
					'Center' => 'center',
					'Top' => 'top',
				),
				'std'		=> 'center',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-100' => '-100',
					'-90' => '-90',
					'-80' => '-80',
					'-70' => '-70',
					'-60' => '-60',
					'-50' => '-50',
					'-40' => '-40',
					'-30' => '-30',
					'-20' => '-20',
					'-10' => '-10',
					'Center' => 'center',
					'10' => '10',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'80' => '80',
					'90' => '90',
					'100' => '100',
				),
				'std'		=> 'center',
				'dependency' => array( 'element' => 'arrow_position', 'value' => 'center' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Vertical', 'agrikole' ),
				'param_name' => 'arrow_offset_v',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-100' => '-100',
					'-90' => '-90',
					'-80' => '-80',
					'-70' => '-70',
					'-60' => '-60',
					'-50' => '-50',
					'-40' => '-40',
					'-30' => '-30',
					'-20' => '-20',
					'-10' => '-10',
					'0' => '0',
					'10' => '10',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'80' => '80',
					'90' => '90',
					'100' => '100',
				),
				'std'		=> '0',
				'dependency' => array( 'element' => 'arrow_position', 'value' => 'center' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset_s',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
					'45' => '45',
					'50' => '50',
					'55' => '55',
					'60' => '60',
					'65' => '65',
					'70' => '70',
					'75' => '75',
					'80' => '80',
					'85' => '85',
					'90' => '90',
					'95' => '95',
					'100' => '100',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'arrow_position', 'value' => 'top' ),
			),
			// Columns
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen > 1000px.', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
					'7 Columns' => '7c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen from 600px to 1000px.', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen < 600px.', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '1c',
			),
			// Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Line-Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        // Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Top Margin', 'agrikole'),
				'param_name' => 'heading_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Bottom Margin', 'agrikole'),
				'param_name' => 'heading_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	    )
	) );
} );

// App Carousel
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('App Carousel', 'agrikole'),
	    'description' => esc_html__('Displaying app carousel.', 'agrikole'),
	    'base' => 'appcarousel',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__('Images', 'agrikole'),
				'param_name' => 'images',
				'value' => '',
				'description' => esc_html__('Choose multi-images for Carousel.', 'agrikole')
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Auto Play?', 'agrikole' ),
				'param_name' => 'auto_play',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Carousel Option', 'agrikole' ),
			),
	    )
	) );
} );

// ProgressBar
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Progress Bar', 'agrikole'),
        'description' => esc_html__('Displaying progress bars.', 'agrikole'),
        'base' => 'progressbar',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Title', 'agrikole'),
				'param_name' => 'title',
				'value' => esc_html__('Title', 'agrikole'),
				'description' => esc_html__('Title of the ProgressBar.', 'agrikole')
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text Color', 'agrikole'),
				'param_name' => 'title_color',
				'value' => '',
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Percentage', 'agrikole'),
				'param_name' => 'percent',
				'value' => '90',
				'description' => esc_html__('Percentage value of the ProgressBar', 'agrikole')
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Percentage Color', 'agrikole'),
				'param_name' => 'per_color',
				'value' => '',
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Height of Bars', 'agrikole'),
				'param_name' => 'height',
				'value' => '10px',
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Space between Text & Line', 'agrikole'),
				'param_name' => 'space_between',
				'value' => '10px',
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Rounded', 'agrikole'),
				'param_name' => 'rounded',
				'value' => '',
				'description'	=> esc_html__('Ex: 5px', 'agrikole'),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Bottom Margin', 'agrikole'),
				'param_name' => 'bottom_margin',
				'value' => '',
				'description'	=> esc_html__('Ex: 20px', 'agrikole'),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Line 1', 'agrikole'),
				'param_name' => 'line_one',
				'value' => '#636363',
				'group' => esc_html__( 'Line Color', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Line 2', 'agrikole'),
				'param_name' => 'line_two',
				'value' => '#e5e5e5',
				'group' => esc_html__( 'Line Color', 'agrikole' ),
            ),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable gradient color?', 'agrikole' ),
				'param_name' => 'gradient',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
				'group' => esc_html__( 'Line Color', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Family', 'agrikole' ),
				'param_name' => 'font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Weight', 'agrikole' ),
				'param_name' => 'font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Font Size', 'agrikole'),
				'param_name' => 'font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
        )
    ) );
} );

// Accordions
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_accordions extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Accordions or Toggles', 'agrikole' ),
        'description' => esc_html__('Displaying Accordions or Toggles', 'agrikole'),
		'base'        => 'accordions',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array( 'only' => 'accordion' ),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Type', 'agrikole' ),
				'param_name' => 'type',
				'value'      => array(
					'Accordions' => 'accordions',
					'Toggles' => 'toggles',
				),
				'std'		=> 'accordions',
			),
		)
	) );
} );

// Accordion
add_action( 'vc_before_init', function() {
	vc_map( array(
	'name'        => esc_html__( 'Item', 'agrikole' ),
    'description' => esc_html__('Item for Accordions or Toggles', 'agrikole'),
		'base'        => 'accordion',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'as_child'    => array( 'only' => 'accordions' ),
		'params'      => array(
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Active by default?', 'agrikole' ),
				'param_name' => 'open',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Color', 'agrikole' ),
				'param_name' => 'color',
				'value'      => array(
					'Acccent' => 'accent',
					'Blue' => 'blue',  //0575e6
					'Orange' => 'orange', //f7b446
					'Red' => 'red',  //ff3366
					'Purple' => 'purple', //7540ee
					'Picton' => 'picton', //3fb6dc
				),
				'std'		=> 'accent',
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Background Image', 'agrikole'),
				'param_name' => 'bg_image',
				'value' => '',
			),
			array(
				'type' => 'number',
				'heading' => esc_html__('Bottom Margin', 'agrikole'),
				'param_name' => 'bottom_margin',
				'value' => 10,
				'suffix' => 'px',
				'description'	=> esc_html__('Default: 10px', 'agrikole'),
		  	),
			// Heading
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Tag', 'agrikole' ),
				'param_name' => 'tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'		=> 'h3',
				'group' => esc_html__( 'Heading', 'agrikole' ),
			),
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading',
				'value' => '',
				'group' => esc_html__( 'Heading', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Padding', 'agrikole'),
				'param_name' => 'heading_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 13px 25px 13px 25px', 'agrikole'),
				'group' => esc_html__( 'Heading', 'agrikole' ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Rounded', 'agrikole'),
				'param_name' => 'heading_rounded',
				'value' => '',
				'description'	=> esc_html__('Ex: 25px', 'agrikole'),
				'group' => esc_html__( 'Heading', 'agrikole' ),
            ),
	        // Content
			array(
				'type' 		=> 'textarea_html',
				'heading' 	=> esc_html__('Content', 'agrikole'),
				'param_name' 	=> 'content',
				'value' 		=> '',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Padding', 'agrikole'),
				'param_name' => 'content_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 20px 0px 30px 0px', 'agrikole'),
				'group' => esc_html__( 'Content', 'agrikole' ),
	        ),
	        // Typography
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Line-Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
		)
	) );
} );

// Tabs
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_dtabs extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Simple Tabs', 'agrikole' ),
        'description' => esc_html__('Displaying Tabbed Content.', 'agrikole'),
		'base'        => 'dtabs',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array( 'only' => 'dtab' ),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
				),
				'std'		=> 'style-1',
			),
		)
	) );
} );

// Tab
add_action( 'vc_before_init', function() {
	vc_map( array(
	'name'        => esc_html__( 'Tab', 'agrikole' ),
    'description' => esc_html__('Displaying Tab.', 'agrikole'),
		'base'        => 'dtab',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'as_child'    => array( 'only' => 'dtabs' ),
		'params'      => array(
			// Title
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Title', 'agrikole'),
				'param_name' => 'title',
				'value' => 'Tab',
				'group' => esc_html__( 'Title', 'agrikole' ),
            ),
	        // Content
			array(
				'type' 		=> 'textarea_html',
				'heading' 	=> esc_html__('Content', 'agrikole'),
				'param_name' 	=> 'content',
				'value' 		=> '',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Padding', 'agrikole'),
				'param_name' => 'content_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left.', 'agrikole'),
				'group' => esc_html__( 'Content', 'agrikole' ),
	        ),
	        // Typography
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Title Font Family', 'agrikole' ),
				'param_name' => 'title_font_family',
				'value'      => agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Title Font Weight', 'agrikole' ),
				'param_name' => 'title_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Title Font Size', 'agrikole'),
				'param_name' => 'title_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Title Line-Height', 'agrikole'),
				'param_name' => 'title_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
		)
	) );
} );

// Advanced Tabs
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_deeper_advance_tabs extends WPBakeryShortCodesContainer{}
} );
add_action( 'vc_before_init', function() {
    vc_map(array(
        "name" => esc_html__("Advanced Tabs", 'vincent'),
        "base" => "deeper_advance_tabs",
        "as_parent" => array('only' => 'deeper_advance_tab'),
        'category' => 'WPRT VC Addons',
        "js_view" => 'VcColumnView',
        "content_element" => true,
        "show_settings_on_create" => false,
        "is_container" => true,
        'icon' => plugins_url('assets/icon.png', __FILE__),
    ));
} );

add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_deeper_advance_tab extends WPBakeryShortCodesContainer{}
} );
// Advanced Tab
add_action( 'vc_before_init', function() {
    vc_map(array(
        "name" => esc_html__("Child Tab", 'vincent'),
        "base" => "deeper_advance_tab",
        "as_child" => array('only' => 'deeper_advance_tabs'),
        'as_parent'			=> array(''),
        'allowed_container_element' => 'vc_row',
		'js_view'					=> 'VcColumnView',
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'params' => array_merge(
			array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'admin_label' => true,
					'heading' => esc_html__( 'Tab Title', 'agrikole' ),
					'param_name' => 'tab_title',
                    'std'       => 'Title',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon Type', 'agrikole' ),
					'param_name'  => 'icon_show',
					'value'       => array(
						'Font Icon' => 'font_icon',
						'Image Icon' => 'image_icon',
					),
					'std'		=> 'font_icon',
				),
				// Image Icon
				array(
					'heading'     => esc_html__( 'Custom Image', 'agrikole' ),
					'value'       => '',
					'type'        => 'attach_image',
					'param_name'  => 'img_icon',
					'dependency' => array( 'element' => 'icon_show', 'value' => array( 'image_icon' ) ),
					'group' => esc_html__( 'Image', 'agrikole' ),
				),
				array(
					'heading'     => esc_html__( 'Custom Image on Hover', 'agrikole' ),
					'value'       => '',
					'type'        => 'attach_image',
					'param_name'  => 'img_icon_hover',
					'dependency' => array( 'element' => 'icon_show', 'value' => array( 'image_icon' ) ),
					'group' => esc_html__( 'Image', 'agrikole' ),
				),
				array(
					'heading'     => esc_html__( 'Image Width', 'agrikole' ),
					'value'       => '',
					'type'        => 'textfield',
					'param_name'  => 'img_icon_width',
					'dependency' => array( 'element' => 'icon_show', 'value' => array( 'image_icon' ) ),
					'group' => esc_html__( 'Image', 'agrikole' ),
				),
				array(
					'heading'     => esc_html__( 'Image Height', 'agrikole' ),
					'value'       => '',
					'type'        => 'textfield',
					'param_name'  => 'img_icon_height',
					'dependency' => array( 'element' => 'icon_show', 'value' => array( 'image_icon' ) ),
					'group' => esc_html__( 'Image', 'agrikole' ),
				),
				// Font Icon
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon library', 'agrikole' ),
					'param_name' => 'icon_type',
					'description' => esc_html__( 'Select icon library.', 'agrikole' ),
					'value' => array(
						esc_html__( '', 'agrikole' ) => '',
						esc_html__( 'Elegant Icons', 'agrikole' ) => 'extraicon',
						esc_html__( 'Basic UI Icons', 'agrikole' ) => 'extraicon2',
						esc_html__( 'FontAwesome', 'agrikole' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'agrikole' ) => 'openiconic',
						esc_html__( 'Typicons', 'agrikole' ) => 'typicons',
						esc_html__( 'Entypo', 'agrikole' ) => 'entypo',
						esc_html__( 'Linecons', 'agrikole' ) => 'linecons',
					),
					'group' => esc_html__( 'Icon', 'agrikole' ),
					'dependency' => array( 'element' => 'icon_show', 'value' => array( 'font_icon' ) ),
				),
				array(
				    'type' => 'iconpicker',
				    'heading' => esc_html__( 'Icon', 'agrikole' ),
				    'param_name' => 'icon_extraicon',
				    'settings' => array(
				        'emptyIcon' => true,
				        'type' => 'extraicon',
				        'iconsPerPage' => 200,
				    ),
				    'dependency' => array(
				        'element' => 'icon_type',
				        'value' => 'extraicon',
				    ),
				    'group' => esc_html__( 'Icon', 'agrikole' ),
				),
				array(
				    'type' => 'iconpicker',
				    'heading' => esc_html__( 'Icon', 'agrikole' ),
				    'param_name' => 'icon_extraicon2',
				    'settings' => array(
				        'emptyIcon' => true,
				        'type' => 'extraicon2',
				        'iconsPerPage' => 200,
				    ),
				    'dependency' => array(
				        'element' => 'icon_type',
				        'value' => 'extraicon2',
				    ),
				    'group' => esc_html__( 'Icon', 'agrikole' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'agrikole' ),
					'param_name' => 'icon',
					'settings' => array(
						'emptyIcon' => true,
						'iconsPerPage' => 200,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'fontawesome',
					),
					'group' => esc_html__( 'Icon', 'agrikole' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'agrikole' ),
					'param_name' => 'icon_openiconic',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'openiconic',
						'iconsPerPage' => 200,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'openiconic',
					),
					'group' => esc_html__( 'Icon', 'agrikole' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'agrikole' ),
					'param_name' => 'icon_typicons',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'typicons',
						'iconsPerPage' => 200,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'typicons',
					),
					'group' => esc_html__( 'Icon', 'agrikole' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'agrikole' ),
					'param_name' => 'icon_entypo',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'entypo',
						'iconsPerPage' => 300,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'entypo',
					),
					'group' => esc_html__( 'Icon', 'agrikole' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'agrikole' ),
					'param_name' => 'icon_linecons',
					'settings' => array(
						'emptyIcon' => true,
						'type' => 'linecons',
						'iconsPerPage' => 200,
					),
					'dependency' => array(
						'element' => 'icon_type',
						'value' => 'linecons',
					),
					'group' => esc_html__( 'Icon', 'agrikole' ),
				),
		        array(
					'type' => 'textfield',
					'heading' => esc_html__('Icon: Font Size', 'agrikole'),
					'param_name' => 'icon_font_size',
					'value' => '',
					'group' => esc_html__( 'Icon', 'agrikole' ),
					'dependency' => array( 'element' => 'icon_show', 'value' => array( 'font_icon' ) ),
		        ),
			)
		)
    ));
} );

// Team Carousel
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Team Carousel', 'agrikole'),
	    'description' => esc_html__('Displaying member posts in carousel.', 'agrikole'),
	    'base' => 'team',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'agrikole' ),
				'param_name'  => 'style',
				'value'       => array(
					'Style 1' 	   => 'style-1',
					'Style 2'        => 'style-2',
				),
				'std'		=> 'style-1',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> 'text-center',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Cropping', 'agrikole' ),
				'param_name' => 'image_crop',
				'value'      => array(
					'Full' => 'full',
					'370 x 370' => 'square',
					'370 x 484' => 'rectangle',
					'370 x 400' => 'rectangle2',
					'270 x 354' => 'rectangle1',
				),
				'std'		=> 'full',
			),
            // Query
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number of items', 'agrikole'),
				'param_name' => 'items',
				'value' => '4',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Category Slug (Optional)', 'agrikole'),
				'param_name' => 'cat_slug',
				'value' => '',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Display posts that have this category. Using category-slug.', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing between items', 'agrikole'),
				'param_name' => 'gap',
				'value' => '30',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Auto Scroll?', 'agrikole' ),
				'param_name' => 'auto_scroll',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Query', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Infinity Loop?', 'agrikole' ),
				'param_name' => 'loop',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Duplicate last and first items to get loop illusion.', 'agrikole'),
			),
	        // Controls
			array(
				'type' => 'headings',
				'text' => esc_html__('Bullets', 'agrikole'),
				'param_name' => 'bullets_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Bullets?', 'agrikole' ),
				'param_name' => 'show_bullets',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Space between Bullets & Elements', 'agrikole' ),
				'param_name' => 'bullet_between',
				'value'      => array(
					'50px' => '50',
					'45px' => '45',
					'40px' => '40',
					'35px' => '35',
					'30px' => '30',
					'25px' => '25',
					'20px' => '20',
					'15px' => '15',
					'10px' => '10',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Arrows', 'agrikole'),
				'param_name' => 'arrows_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Arrows?', 'agrikole' ),
				'param_name' => 'show_arrows',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrow Position', 'agrikole' ),
				'param_name' => 'arrow_position',
				'value'      => array(
					'Center' => 'center',
					'Top' => 'top',
				),
				'std'		=> 'center',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-40' => '-40',
					'-35' => '-35',
					'-30' => '-30',
					'-25' => '-25',
					'-20' => '-20',
					'-15' => '-15',
					'-10' => '-10',
					'Center' => 'center',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
				),
				'std'		=> 'center',
				'dependency' => array( 'element' => 'arrow_position', 'value' => 'center' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Vertical', 'agrikole' ),
				'param_name' => 'arrow_offset_v',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-120' => '-120',
					'-110' => '-110',
					'-100' => '-100',
					'-90' => '-90',
					'-80' => '-80',
					'-70' => '-70',
					'-60' => '-60',
					'-50' => '-50',
					'-40' => '-40',
					'-30' => '-30',
					'-20' => '-20',
					'0' => '0',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'80' => '80',
					'90' => '90',
					'100' => '100',
					'110' => '110',
					'120' => '120',
				),
				'std'		=> '0',
				'dependency' => array( 'element' => 'arrow_position', 'value' => 'center' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset_s',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
					'45' => '45',
					'50' => '50',
					'55' => '55',
					'60' => '60',
					'65' => '65',
					'70' => '70',
					'75' => '75',
					'80' => '80',
					'85' => '85',
					'90' => '90',
					'95' => '95',
					'100' => '100',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'arrow_position', 'value' => 'top' ),
			),
			// Columns
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen > 1000px', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen from 600px to 1000px', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen < 600px', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '1c',
			),
			// Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Name', 'agrikole'),
				'param_name' => 'name_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Name Font Family', 'agrikole' ),
				'param_name' => 'name_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Name Font Weight', 'agrikole' ),
				'param_name' => 'name_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Name Color', 'agrikole'),
				'param_name' => 'name_color',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name Font Size', 'agrikole'),
				'param_name' => 'name_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name Line-Height', 'agrikole'),
				'param_name' => 'name_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Position', 'agrikole'),
				'param_name' => 'position_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Position Font Family', 'agrikole' ),
				'param_name' => 'position_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Position Font Weight', 'agrikole' ),
				'param_name' => 'position_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Position Color', 'agrikole'),
				'param_name' => 'position_color',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position Font Size', 'agrikole'),
				'param_name' => 'position_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position Line-Height', 'agrikole'),
				'param_name' => 'position_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Text', 'agrikole'),
				'param_name' => 'text_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Font Family', 'agrikole' ),
				'param_name' => 'text_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Font Weight', 'agrikole' ),
				'param_name' => 'text_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text Color', 'agrikole'),
				'param_name' => 'text_color',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text Font Size', 'agrikole'),
				'param_name' => 'text_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text Line-Height', 'agrikole'),
				'param_name' => 'text_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			// Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name: Top Margin', 'agrikole'),
				'param_name' => 'name_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name: Bottom Margin', 'agrikole'),
				'param_name' => 'name_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position: Top Margin', 'agrikole'),
				'param_name' => 'position_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position: Bottom Margin', 'agrikole'),
				'param_name' => 'position_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text: Top Margin', 'agrikole'),
				'param_name' => 'text_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text: Bottom Margin', 'agrikole'),
				'param_name' => 'text_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	    )
	) );
} );

// Team Grid
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Team Grid', 'agrikole'),
	    'description' => esc_html__('Displaying member posts in grid.', 'agrikole'),
	    'base' => 'teamgrid',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'agrikole' ),
				'param_name'  => 'style',
				'value'       => array(
					'Style 1' 	   => 'style-1',
					'Style 2'        => 'style-2',
				),
				'std'		=> 'style-1',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> 'text-center',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Cropping', 'agrikole' ),
				'param_name' => 'image_crop',
				'value'      => array(
					'Full' => 'full',
					'370 x 370' => 'square',
					'370 x 484' => 'rectangle',
					'370 x 400' => 'rectangle2',
					'270 x 354' => 'rectangle1',
				),
				'std'		=> 'full',
			),
            // Query
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number of items', 'agrikole'),
				'param_name' => 'items',
				'value' => '3',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Category Slug (Optional)', 'agrikole'),
				'param_name' => 'cat_slug',
				'value' => '',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Display posts that have this category. Using category-slug.', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing between items', 'agrikole'),
				'param_name' => 'gapv',
				'value' => '30',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing below items', 'agrikole'),
				'param_name' => 'gaph',
				'value' => '40',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
			// Columns
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Column(s)', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '3c',
			),
			// Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Name', 'agrikole'),
				'param_name' => 'name_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Name Font Family', 'agrikole' ),
				'param_name' => 'name_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Name Font Weight', 'agrikole' ),
				'param_name' => 'name_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Name Color', 'agrikole'),
				'param_name' => 'name_color',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name Font Size', 'agrikole'),
				'param_name' => 'name_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name Line-Height', 'agrikole'),
				'param_name' => 'name_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Position', 'agrikole'),
				'param_name' => 'position_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Position Font Family', 'agrikole' ),
				'param_name' => 'position_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Position Font Weight', 'agrikole' ),
				'param_name' => 'position_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Position Color', 'agrikole'),
				'param_name' => 'position_color',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position Font Size', 'agrikole'),
				'param_name' => 'position_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position Line-Height', 'agrikole'),
				'param_name' => 'position_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Text', 'agrikole'),
				'param_name' => 'text_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Font Family', 'agrikole' ),
				'param_name' => 'text_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Font Weight', 'agrikole' ),
				'param_name' => 'text_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text Color', 'agrikole'),
				'param_name' => 'text_color',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text Font Size', 'agrikole'),
				'param_name' => 'text_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text Line-Height', 'agrikole'),
				'param_name' => 'text_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			// Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name: Top Margin', 'agrikole'),
				'param_name' => 'name_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Name: Bottom Margin', 'agrikole'),
				'param_name' => 'name_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position: Top Margin', 'agrikole'),
				'param_name' => 'position_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Position: Bottom Margin', 'agrikole'),
				'param_name' => 'position_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text: Top Margin', 'agrikole'),
				'param_name' => 'text_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text: Bottom Margin', 'agrikole'),
				'param_name' => 'text_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	    )
	) );
} );

// Action Box
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Action Box', 'agrikole'),
	    'description' => esc_html__('Displaying Action-Box or Promo-Box.', 'agrikole'),
	    'base' => 'actionbox',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Area: Width', 'agrikole'),
				'param_name' => 'content_width',
				'value' => '',
				'description'	=> esc_html__('Default: 70%', 'agrikole'),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Content Area: Alignment', 'agrikole' ),
				'param_name' => 'content_align',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> '',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Area: Width', 'agrikole'),
				'param_name' => 'button_width',
				'value' => '',
				'description'	=> esc_html__('Default: 20%', 'agrikole'),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Area: Alignment', 'agrikole' ),
				'param_name' => 'button_align',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> 'text-right',
			),
            // Content
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_content',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Tag', 'agrikole' ),
				'param_name' => 'heading_tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'		=> 'h2',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Heading Text', 'agrikole'),
				'param_name' => 'heading_text',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Max-Width', 'agrikole'),
				'param_name' => 'heading_width',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__( 'Sub-Heading', 'agrikole' ),
				'param_name' => 'subheading_text',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Sub-Heading Color', 'agrikole'),
				'param_name' => 'subheading_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Sub-Heading Max-Width', 'agrikole'),
				'param_name' => 'subheading_width',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            // Button
	        array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Button Text (Required)', 'agrikole'),
				'param_name' => 'link_text',
				'value' => 'READ MORE',
				'group' => esc_html__( 'Button', 'agrikole' ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Button URL (Required):', 'agrikole'),
				'param_name' => 'link_url',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
            ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open Link in a new Tab', 'agrikole' ),
				'param_name' => 'new_tab',
				'value' => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				'std'		=> 'yes',
				'group' => esc_html__( 'Button', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Size', 'agrikole' ),
				'param_name' => 'button_size',
				'value'      => array(
					'Medium' => 'medium',
					'Small' => 'small',
					'Big' => 'big',
				),
				'std'		=> 'medium',
				'group' => esc_html__( 'Button', 'agrikole' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Rounded', 'agrikole'),
				'param_name' => 'button_rounded',
				'value' => '',
				'description'	=> esc_html__('Ex: 30px', 'agrikole'),
				'group' => esc_html__( 'Button', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Text Color', 'agrikole'),
				'param_name' => 'button_text_color',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Background', 'agrikole'),
				'param_name' => 'button_background',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Border Width', 'agrikole'),
				'param_name' => 'button_border_width',
				'value' => '1px',
				'group' => esc_html__( 'Button', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Border Style', 'agrikole' ),
				'param_name' => 'button_border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'Button', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Border', 'agrikole'),
				'param_name' => 'button_border',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Text: Hover', 'agrikole'),
				'param_name' => 'button_text_hover',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Background: Hover', 'agrikole'),
				'param_name' => 'button_background_hover',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Border: Hover', 'agrikole'),
				'param_name' => 'button_border_hover',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
            ),
            // Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Line-Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Sub-Heading', 'agrikole'),
				'param_name' => 'subheading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Sub-Heading: Font Family', 'agrikole' ),
				'param_name' => 'subheading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Sub-Heading: Font Weight', 'agrikole' ),
				'param_name' => 'subheading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Sub-Heading: Font Size', 'agrikole'),
				'param_name' => 'subheading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Sub-Heading: Line Height', 'agrikole'),
				'param_name' => 'subheading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Button', 'agrikole'),
				'param_name' => 'button_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Font Family', 'agrikole' ),
				'param_name' => 'button_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Font Weight', 'agrikole' ),
				'param_name' => 'button_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Font Size', 'agrikole'),
				'param_name' => 'button_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Line-Height', 'agrikole'),
				'param_name' => 'button_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        // Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Margin', 'agrikole'),
				'param_name' => 'heading_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Margin', 'agrikole'),
				'param_name' => 'button_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	    )
	) );
} );

// Slogan Box
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Slogan Box', 'agrikole'),
	    'description' => esc_html__('Slogan Box.', 'agrikole'),
	    'base' => 'sloganbox',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'agrikole'),
				'param_name' => 'image1',
				'value' => '',
			),
	        // Heading
            array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading',
				'value' => 'Heading Text',
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
            ),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'agrikole'),
				'param_name' => 'image2',
				'value' => '',
			),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			// Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Line-Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	    )
	) );
} );

// Image Box
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Image Box', 'agrikole'),
	    'description' => esc_html__('Displaying image box.', 'agrikole'),
	    'base' => 'imagebox',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
				),
				'std'		=> 'style-1',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> '',
			),
	        // Image
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'agrikole'),
				'param_name' => 'image',
				'value' => '',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Width', 'agrikole'),
				'param_name' => 'image_width',
				'value' => '',
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Rounded', 'agrikole'),
				'param_name' => 'image_rounded',
				'value' => '',
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Padding', 'agrikole'),
				'param_name' => 'content_padding',
				'value' => '45px 50px 43px',
				'description'	=> esc_html__('Top Right Bottom Left.', 'agrikole'),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Content Background', 'agrikole'),
				'param_name' => 'content_bg',
				'value' => '',
            ),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			// Content
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'hading_content',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Tag', 'agrikole' ),
				'param_name' => 'tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'		=> 'h3',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
            array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading',
				'value' => 'Heading Text',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Description', 'agrikole'),
				'param_name' => 'desc_content',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
			array(
				'type' 		=> 'textarea_html',
				'holder' => 'div',
				'heading' 	=> esc_html__('Description', 'agrikole'),
				'param_name' 	=> 'content',
				'value' 		=> '',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Description Color', 'agrikole'),
				'param_name' => 'desc_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
			// Button or Link
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Link or Button?', 'agrikole' ),
				'param_name' => 'show_url',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
				'group' => esc_html__( 'URL', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'url_style',
				'value'      => array(
					'Link' => 'link',
					'Button' => 'button',
					'Arrow' => 'arrow',
					'Image Hover' => 'hover',
				),
				'std'		=> 'link',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Style', 'agrikole' ),
				'param_name' => 'link_style',
				'value'      => array(
					'Style 1' => 'link-style-1',
					'Style 2' => 'link-style-2',
					'Style 3' => 'link-style-3',
				),
				'std'		=> 'link-style-1',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'link' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Color', 'agrikole' ),
				'param_name' => 'link_color',
				'value'      => array(
					'Accent' => 'link-color-accent',
					'Dark' => 'link-color-dark',
					'Green' => 'link-color-green',
				),
				'std'		=> 'link-color-accent',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'link' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text (Required)', 'agrikole'),
				'param_name' => 'link_text',
				'value' => 'READ MORE',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => array('link','button') ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('URL (Required):', 'agrikole'),
				'param_name' => 'link_url',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
            ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open Link in a new Tab', 'agrikole' ),
				'param_name' => 'new_tab',
				'value' => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				'std'		=> 'yes',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Size', 'agrikole' ),
				'param_name' => 'button_size',
				'value'      => array(
					'Medium' => 'medium',
					'Small' => 'small',
					'Big' => 'big',
				),
				'std'		=> 'medium',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Rounded', 'agrikole'),
				'param_name' => 'button_rounded',
				'value' => '',
				'description'	=> esc_html__('Ex: 30px', 'agrikole'),
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Text Color', 'agrikole'),
				'param_name' => 'button_text_color',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Background', 'agrikole'),
				'param_name' => 'button_background',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Border Width', 'agrikole'),
				'param_name' => 'button_border_width',
				'value' => '1px',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Border Style', 'agrikole' ),
				'param_name' => 'button_border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Border Color', 'agrikole'),
				'param_name' => 'button_border',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Text: Hover', 'agrikole'),
				'param_name' => 'button_text_hover',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Background: Hover', 'agrikole'),
				'param_name' => 'button_background_hover',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Border: Hover', 'agrikole'),
				'param_name' => 'button_border_hover',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
			// Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Line-Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Description', 'agrikole'),
				'param_name' => 'desc_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Description Font Family', 'agrikole' ),
				'param_name' => 'desc_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Description Font Weight', 'agrikole' ),
				'param_name' => 'desc_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description Font Size', 'agrikole'),
				'param_name' => 'desc_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description Line-Height', 'agrikole'),
				'param_name' => 'desc_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Button', 'agrikole'),
				'param_name' => 'btn_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Font Family', 'agrikole' ),
				'param_name' => 'button_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Font Weight', 'agrikole' ),
				'param_name' => 'button_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Font Size', 'agrikole'),
				'param_name' => 'button_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        // Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Top Margin', 'agrikole'),
				'param_name' => 'heading_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Bottom Margin', 'agrikole'),
				'param_name' => 'heading_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description: Top Margin', 'agrikole'),
				'param_name' => 'desc_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description: Bottom Margin', 'agrikole'),
				'param_name' => 'desc_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        // Shadow
			array(
				'type' => 'headings',
				'text' => esc_html__('Box Shadow', 'agrikole'),
				'param_name' => 'heading_shadow',
				'group' => esc_html__( 'Shadow', 'agrikole' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Option Shadow', 'agrikole' ),
				'param_name'  => 'inset',
				'value'       => array(
					'Outset'   => '',
					'Inset'   => 'inset',
				),
				'std'		=> '',
				'group' => esc_html__( 'Shadow', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Horizontal (Required)', 'agrikole'),
				'param_name' => 'horizontal',
				'value' => '',
				'group' => esc_html__( 'Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Vertical (Required)', 'agrikole'),
				'param_name' => 'vertical',
				'value' => '',
				'group' => esc_html__( 'Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Blur (Required)', 'agrikole'),
				'param_name' => 'blur',
				'value' => '',
				'group' => esc_html__( 'Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spread (Required)', 'agrikole'),
				'param_name' => 'spread',
				'value' => '',
				'group' => esc_html__( 'Shadow', 'agrikole' ),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Shadow Color (Required)', 'agrikole'),
				'param_name' => 'shadow_color',
				'value' => '',
				'group' => esc_html__( 'Shadow', 'agrikole' ),
            ),
	    )
	) );
} );

// Links
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Links', 'agrikole' ),
        'description' => esc_html__('Displaying a link.', 'agrikole'),
		'base'        => 'advlinks',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
					'Style 3' => 'style-3',
				),
				'std'		=> 'style-1',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__( 'Content (Required)', 'agrikole' ),
				'param_name' => 'content',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Color', 'agrikole' ),
				'param_name' => 'color',
				'value'      => array(
					'Acccent' => 'accent',
					'Dark' => 'dark',
					'Green' => 'green',
				),
				'std'		=> 'dark',
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Link (Required)', 'agrikole'),
				'param_name' => 'link_url',
				'value' => '',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Margin', 'agrikole'),
				'param_name' => 'margin',
				'value' => '',
	        ),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
	        // Typography
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Family', 'agrikole' ),
				'param_name' => 'content_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Weight', 'agrikole' ),
				'param_name' => 'content_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Font Size', 'agrikole'),
				'param_name' => 'content_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
		)
	) );
} );

// List
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'List', 'agrikole' ),
        'description' => esc_html__('Displaying Icon lists with custom icon.', 'agrikole'),
		'base'        => 'advlist',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'agrikole'),
				'param_name' => 'content_background_color',
				'value' => '',
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Style', 'agrikole' ),
				'param_name' => 'content_border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed',
				),
				'std'		=> 'solid',
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color', 'agrikole'),
				'param_name' => 'content_border_color',
				'value' => '',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Border Width', 'agrikole'),
				'param_name' => 'content_border_width',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 0px 0px 1px 0px', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding', 'agrikole'),
				'param_name' => 'content_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 12px 30px 12px 30px', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Bottom Margin', 'agrikole'),
				'param_name' => 'content_bottom_margin',
				'value' => '',
	        ),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			// Icon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon library', 'agrikole' ),
				'param_name' => 'icon_type',
				'description' => esc_html__( 'Select icon library.', 'agrikole' ),
				'value' => array(
					esc_html__( '', 'agrikole' ) => '',
					esc_html__( 'Agrikole Icons', 'agrikole' ) => 'extraicon',
					esc_html__( 'Stroke 7 Icons', 'agrikole' ) => 'extraicon2',
					esc_html__( 'FontAwesome', 'agrikole' ) => 'fontawesome',
					esc_html__( 'Open Iconic', 'agrikole' ) => 'openiconic',
					esc_html__( 'Typicons', 'agrikole' ) => 'typicons',
					esc_html__( 'Entypo', 'agrikole' ) => 'entypo',
					esc_html__( 'Linecons', 'agrikole' ) => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon2',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon2',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon2',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon',
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'fontawesome',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'openiconic',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Style', 'agrikole' ),
				'param_name' => 'icon_style',
				'value'      => array(
					'Simple' => 'simple',
					'Background' => 'background',
				),
				'std'		=> 'simple',
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Background', 'agrikole'),
				'param_name' => 'icon_bg',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array(
					'element' => 'icon_style',
					'value' => 'background',
				),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color', 'agrikole'),
				'param_name' => 'icon_color',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Width', 'agrikole'),
				'param_name' => 'icon_width',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array(
					'element' => 'icon_style',
					'value' => 'background',
				),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Height', 'agrikole'),
				'param_name' => 'icon_height',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array(
					'element' => 'icon_style',
					'value' => 'background',
				),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Rounded', 'agrikole'),
				'param_name' => 'icon_rounded',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array(
					'element' => 'icon_style',
					'value' => 'background',
				),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Font Size', 'agrikole'),
				'param_name' => 'icon_font_size',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Line-Height', 'agrikole'),
				'param_name' => 'icon_line_height',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Position', 'agrikole' ),
				'param_name' => 'icon_position',
				'value'      => array(
					'Middle' => 'icon-middle',
					'Top' => 'icon-top',
				),
				'std'		=> 'icon-middle',
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Icon Top Margin', 'agrikole' ),
				'param_name' => 'icon_top_margin',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			// Content
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__( 'Content', 'agrikole' ),
				'param_name' => 'content',
				'group' => esc_html__( 'Content', 'agrikole' ), 
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Content Color', 'agrikole'),
				'param_name' => 'content_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Left Padding', 'agrikole'),
				'param_name' => 'content_left_padding',
				'value' => '30',
				'group' => esc_html__( 'Content', 'agrikole' ),
				'description'	=> esc_html__('Spacing between the icon and the content', 'agrikole'),
				'dependency' => array( 'element' => 'style', 'value' => 'icon-left' ),
	        ),
	        // Typography
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Content Font Family', 'agrikole' ),
				'param_name' => 'content_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Content Font Weight', 'agrikole' ),
				'param_name' => 'content_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Font Size', 'agrikole'),
				'param_name' => 'content_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Line-Height', 'agrikole'),
				'param_name' => 'content_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
		)
	) );
} );

// Menu List
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Menu List', 'agrikole'),
	    'description' => esc_html__('Menu List.', 'agrikole'),
	    'base' => 'menulist',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'agrikole'),
				'param_name' => 'background',
				'value' => '#f5f5f5',
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color', 'agrikole'),
				'param_name' => 'border_color',
				'value' => '#b2b2b2',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Border Width', 'agrikole'),
				'param_name' => 'border_width',
				'value' => '1px 0px 1px 0px',
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Style', 'agrikole' ),
				'param_name' => 'border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed',
				),
				'std'		=> 'solid',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding', 'agrikole'),
				'param_name' => 'padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Default: 10px 20px 10px 20px', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Bottom Margin', 'agrikole'),
				'param_name' => 'bottom_margin',
				'value' => '10',
	        ),
	        // Content
			array(
				'type' => 'headings',
				'text' => esc_html__('Text', 'agrikole'),
				'param_name' => 'text_content',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Text', 'agrikole'),
				'param_name' => 'text',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Color', 'agrikole'),
				'param_name' => 'text_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Value', 'agrikole'),
				'param_name' => 'value_content',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Value', 'agrikole'),
				'param_name' => 'value',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Color', 'agrikole'),
				'param_name' => 'value_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
			// Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Text', 'agrikole'),
				'param_name' => 'text_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text: Font Family', 'agrikole' ),
				'param_name' => 'text_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text: Font Weight', 'agrikole' ),
				'param_name' => 'text_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text: Font Size', 'agrikole'),
				'param_name' => 'text_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Value', 'agrikole'),
				'param_name' => 'value_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Value: Font Family', 'agrikole' ),
				'param_name' => 'value_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Value: Font Weight', 'agrikole' ),
				'param_name' => 'value_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Value: Font Size', 'agrikole'),
				'param_name' => 'value_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
		)
	) );
} );

// Icon Box
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Icon Box', 'agrikole' ),
        'description' => esc_html__('Displaying Icon Box with custom icon.', 'agrikole'),
		'base'        => 'iconbox',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Icon Top' => 'icon-top',
					'Icon Left' => 'icon-left',
					'Icon Right' => 'icon-right',
					'Icon Left 2' => 'icon-left2',
				),
				'std'		=> 'icon-top',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Alignment', 'agrikole' ),
				'param_name' => 'text_align',
				'value'      => array(
					'Left' => 'align-left',
					'Center' => 'align-center',
					'Right' => 'align-right',
				),
				'std'		=> 'align-left',
				'dependency' => array( 'element' => 'style', 'value' => 'icon-top' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon to Display', 'agrikole' ),
				'param_name' => 'icon_display',
				'value'      => array(
					'Icon Font' => 'icon-font',
					'Icon Image' => 'icon-image',
					'Icon Text' => 'icon-text'
				),
				'std'		=> 'icon-font',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Wrap Padding', 'agrikole'),
				'param_name' => 'wrap_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left.', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Wrap Margin', 'agrikole'),
				'param_name' => 'wrap_margin',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left.', 'agrikole'),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Wrap Background', 'agrikole'),
				'param_name' => 'wrap_background',
				'value' => '',
            ),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Wrap Background Image', 'agrikole'),
				'param_name' => 'wrap_bg_image',
				'value' => '',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Wrap Rounded', 'agrikole'),
				'param_name' => 'wrap_rounded',
				'value' => '',
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Wrap Border Color', 'agrikole'),
				'param_name' => 'wrap_border',
				'value' => '#e7e7e7',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Wrap Border Width', 'agrikole'),
				'param_name' => 'wrap_border_width',
				'value' => '',
				'description'	=> esc_html__('Ex: 1px', 'agrikole'),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Wrap Border Style', 'agrikole' ),
				'param_name' => 'wrap_border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
			),
	        // Image
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'agrikole'),
				'param_name' => 'image',
				'value' => '',
				'group' => esc_html__( 'Image', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-image' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Width', 'agrikole'),
				'param_name' => 'image_width',
				'value' => '',
				'description'	=> esc_html__('Ex: 100px', 'agrikole'),
				'group' => esc_html__( 'Image', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-image' ),
	        ),
	        // Icon Text
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Text', 'agrikole'),
				'param_name' => 'icon_text',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-text' ),
	        ),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			// Icon
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Number?', 'agrikole' ),
				'param_name' => 'show_number',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number', 'agrikole'),
				'param_name' => 'icon_number',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'show_number', 'value' => 'yes' ),
	        ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon library', 'agrikole' ),
				'param_name' => 'icon_type',
				'description' => esc_html__( 'Select icon library.', 'agrikole' ),
				'value' => array(
					esc_html__( '', 'agrikole' ) => '',
					esc_html__( 'Agrikole Icons', 'agrikole' ) => 'extraicon',
					esc_html__( 'Stroke 7 Icons', 'agrikole' ) => 'extraicon2',
					esc_html__( 'Elegant Icons', 'agrikole' ) => 'extraicon3',
					esc_html__( 'FontAwesome', 'agrikole' ) => 'fontawesome',
					esc_html__( 'Open Iconic', 'agrikole' ) => 'openiconic',
					esc_html__( 'Typicons', 'agrikole' ) => 'typicons',
					esc_html__( 'Entypo', 'agrikole' ) => 'entypo',
					esc_html__( 'Linecons', 'agrikole' ) => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-font' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon2',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon2',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon2',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon3',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon3',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon3',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_fontawesome',
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'fontawesome',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'openiconic',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Font Size', 'agrikole'),
				'param_name' => 'icon_font_size',
				'value' => '30px',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Width', 'agrikole'),
				'param_name' => 'icon_width',
				'value' => '60',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Height', 'agrikole'),
				'param_name' => 'icon_height',
				'value' => '60',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Line Height', 'agrikole'),
				'param_name' => 'icon_line_height',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Rounded', 'agrikole'),
				'param_name' => 'icon_rounded',
				'value' => '',
				'description'	=> esc_html__('ex: 10px', 'agrikole'),
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color', 'agrikole'),
				'param_name' => 'icon_color',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Background', 'agrikole'),
				'param_name' => 'icon_background',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Border Color', 'agrikole'),
				'param_name' => 'icon_border',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Border Width', 'agrikole'),
				'param_name' => 'icon_border_width',
				'value' => '',
				'description'	=> esc_html__('Default: 1px', 'agrikole'),
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Border Style', 'agrikole' ),
				'param_name' => 'icon_border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color: Hover', 'agrikole'),
				'param_name' => 'icon_color_hover',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Background: Hover', 'agrikole'),
				'param_name' => 'icon_background_hover',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Border: Hover', 'agrikole'),
				'param_name' => 'icon_border_hover',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
			// Icon Shadow
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Option Icon Shadow', 'agrikole' ),
				'param_name'  => 'icon_inset',
				'value'       => array(
					'Outset'   => '',
					'Inset'   => 'inset',
				),
				'std'		=> '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Horizontal (Required)', 'agrikole'),
				'param_name' => 'icon_horizontal',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Vertical (Required)', 'agrikole'),
				'param_name' => 'icon_vertical',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Blur (Required)', 'agrikole'),
				'param_name' => 'icon_blur',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spread (Required)', 'agrikole'),
				'param_name' => 'icon_spread',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Shadow Color (Required)', 'agrikole'),
				'param_name' => 'icon_shadow_color',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
			// Content
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Tag', 'agrikole' ),
				'param_name' => 'tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'		=> 'h3',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
            array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading URL (Optional):', 'agrikole'),
				'param_name' => 'heading_url',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
			array(
				'type' 		=> 'textarea_html',
				'holder' => 'div',
				'heading' 	=> esc_html__('Description', 'agrikole'),
				'param_name' 	=> 'content',
				'value' 		=> '',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Description Color', 'agrikole'),
				'param_name' => 'desc_color',
				'value' => '',
				'group' => esc_html__( 'Content', 'agrikole' ),
            ),
			// Button or Link
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Link or Button?', 'agrikole' ),
				'param_name' => 'show_url',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
				'group' => esc_html__( 'URL', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'url_style',
				'value'      => array(
					'Link' => 'link',
					'Button' => 'button',
					'Arrow' => 'arrow',
				),
				'std'		=> 'link',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Style', 'agrikole' ),
				'param_name' => 'link_style',
				'value'      => array(
					'Style 1' => 'link-style-1',
					'Style 2' => 'link-style-2',
					'Style 3' => 'link-style-3',
					'Style 4' => 'link-style-4',
				),
				'std'		=> 'link-style-1',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'link' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Color', 'agrikole' ),
				'param_name' => 'link_color',
				'value'      => array(
					'Accent' => 'link-color-accent',
					'Dark' => 'link-color-dark',
					'Light' => 'link-color-light',
					'Blue' => 'link-color-blue',
					'Orange' => 'link-color-orange',
					'Red' => 'link-color-red',
					'Purple' => 'link-color-purple',
					'Picton' => 'link-color-picton'
				),
				'std'		=> 'link-color-accent',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'link' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text (Required)', 'agrikole'),
				'param_name' => 'link_text',
				'value' => 'READ MORE',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => array('link','button') ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('URL (Required):', 'agrikole'),
				'param_name' => 'link_url',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
            ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open Link in a new Tab', 'agrikole' ),
				'param_name' => 'new_tab',
				'value' => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				'std'		=> 'yes',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Size', 'agrikole' ),
				'param_name' => 'button_size',
				'value'      => array(
					'Medium' => 'medium',
					'Small' => 'small',
					'Big' => 'big',
				),
				'std'		=> 'medium',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Rounded', 'agrikole'),
				'param_name' => 'button_rounded',
				'value' => '',
				'description'	=> esc_html__('Ex: 30px', 'agrikole'),
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Text Color', 'agrikole'),
				'param_name' => 'button_text_color',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Background', 'agrikole'),
				'param_name' => 'button_background',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Border Width', 'agrikole'),
				'param_name' => 'button_border_width',
				'value' => '1px',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Border Style', 'agrikole' ),
				'param_name' => 'button_border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Border', 'agrikole'),
				'param_name' => 'button_border',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Text: Hover', 'agrikole'),
				'param_name' => 'button_text_hover',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Background: Hover', 'agrikole'),
				'param_name' => 'button_background_hover',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Border: Hover', 'agrikole'),
				'param_name' => 'button_border_hover',
				'value' => '',
				'group' => esc_html__( 'URL', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
	        // Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Line-Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Description', 'agrikole'),
				'param_name' => 'desc_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Description Font Family', 'agrikole' ),
				'param_name' => 'desc_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Description Font Weight', 'agrikole' ),
				'param_name' => 'desc_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description Font Size', 'agrikole'),
				'param_name' => 'desc_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description Line-Height', 'agrikole'),
				'param_name' => 'desc_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Button', 'agrikole'),
				'param_name' => 'button_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Font Family', 'agrikole' ),
				'param_name' => 'button_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Font Weight', 'agrikole' ),
				'param_name' => 'button_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Font Size', 'agrikole'),
				'param_name' => 'button_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Line-Height', 'agrikole'),
				'param_name' => 'button_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        // Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon: Top Margin', 'agrikole'),
				'param_name' => 'icon_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
				'dependency' => array( 'element' => 'style', 'value' => array( 'icon-left', 'icon-right' ) ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content: Left Padding', 'agrikole'),
				'param_name' => 'content_left_padding',
				'value' => '85px',
				'group' => esc_html__( 'Spacing', 'agrikole' ), 
				'dependency' => array( 'element' => 'style', 'value' => 'icon-left' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content: Right Padding', 'agrikole'),
				'param_name' => 'content_right_padding',
				'value' => '85px',
				'group' => esc_html__( 'Spacing', 'agrikole' ), 
				'dependency' => array( 'element' => 'style', 'value' => 'icon-right' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Left Margin', 'agrikole'),
				'param_name' => 'heading_left_margin',
				'value' => '85px',
				'group' => esc_html__( 'Spacing', 'agrikole' ), 
				'dependency' => array( 'element' => 'style', 'value' => 'icon-left2' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Top Margin', 'agrikole'),
				'param_name' => 'heading_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Bottom Margin', 'agrikole'),
				'param_name' => 'heading_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description: Top Margin', 'agrikole'),
				'param_name' => 'desc_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description: Bottom Margin', 'agrikole'),
				'param_name' => 'desc_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        // Hover
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Hover Style', 'agrikole' ),
				'param_name' => 'hover_style',
				'value'      => array(
					'No Style' => '',
					'Text-Light' => 'hover-style-1',
					'Text-Dark' => 'hover-style-2',
					'Content Scrolling' => 'hover-style-3',
				),
				'std'		=> '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'agrikole'),
				'param_name' => 'bg_color',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
				'dependency' => array( 'element' => 'hover_style', 'value' => array( 'hover-style-1', 'hover-style-2' ) ),
            ),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Background Image', 'agrikole'),
				'param_name' => 'bg_image',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
				'dependency' => array( 'element' => 'hover_style', 'value' => array( 'hover-style-1', 'hover-style-2' ) ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Link Hover', 'agrikole' ),
				'param_name' => 'link_hover_color',
				'value'      => array(
					'Accent' => 'link-hover-accent',
					'Blue' => 'link-hover-blue',
					'Orange' => 'link-hover-orange',
					'Red' => 'link-hover-red',
					'Purple' => 'link-hover-purple',
					'Picton' => 'link-hover-picton'
				),
				'std'		=> 'link-hover-accent',
				'group' => esc_html__( 'Hover', 'agrikole' ),
				'dependency' => array( 'element' => 'hover_style', 'value' => 'hover-style-1' ),
			),
		)
	) );
} );


// Iconbox Group
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_iconboxs extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Iconbox Group', 'agrikole' ),
        'description' => esc_html__('Displaying Iconbox Group', 'agrikole'),
		'base'        => 'iconboxs',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array( 'only' => 'iconbox' ),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'agrikole' ),
				'param_name'  => 'style',
				'value'       => array(
					'Style 1' 	   => 'style-1',
					'Style 2'        => 'style-2',
				),
				'std'		=> 'style-1',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Items', 'agrikole' ),
				'param_name'  => 'items',
				'value'       => array(
					'2' 	   => '2',
					'3'        => '3',
					'4'        => '4',
				),
				'std'		=> '3',
			),
		)
	) );
} );

// Icon List
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Icon List', 'agrikole' ),
        'description' => esc_html__('Displaying Icon Box in group.', 'agrikole'),
		'base'        => 'iconlist',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Style', 'agrikole' ),
				'param_name'  => 'style',
				'value'       => array(
					'Style 1' 	   => 'style-1',
					'Style 2'        => 'style-2',
				),
				'std'		=> 'style-1',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Item Spacing', 'agrikole'),
				'param_name' => 'item_spacing',
				'value' => '',
	        ),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Line?', 'agrikole' ),
				'param_name' => 'show_line',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Line Style', 'agrikole' ),
				'param_name' => 'line_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed',
				),
				'std'		=> 'dashed',
				'dependency' => array( 'element' => 'show_line', 'value' => 'yes' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Line Color', 'agrikole'),
				'param_name' => 'line_color',
				'value' => '',
				'dependency' => array( 'element' => 'show_line', 'value' => 'yes' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Width', 'agrikole'),
				'param_name' => 'line_width',
				'value' => '',
				'dependency' => array( 'element' => 'show_line', 'value' => 'yes' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Offset', 'agrikole'),
				'param_name' => 'line_offset',
				'value' => '',
				'description'	=> esc_html__('Default: 30px', 'agrikole'),
				'dependency' => array( 'element' => 'show_line', 'value' => 'yes' ),
	        ),
            // params group
            array(
				'type' => 'param_group',
				'heading' => 'Icon Box',
				'value' => '',
				'param_name' => 'boxicon',
				'group' => esc_html__( 'Icon Box', 'agrikole' ),
				'params' => array(
		            array(
						'type' => 'textarea',
						'holder' => 'div',
						'heading' => esc_html__('Heading', 'agrikole'),
						'param_name' => 'heading',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Heading Color', 'agrikole'),
						'param_name' => 'heading_color',
						'value' => '',
		            ),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Heading Margin', 'agrikole'),
						'param_name' => 'heading_margin',
						'value' => '',
			        ),
					array(
						'type' => 'textarea',
						'holder' => 'div',
						'heading' => esc_html__( 'Description', 'agrikole' ),
						'param_name' => 'description',
					),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Description Color', 'agrikole'),
						'param_name' => 'desc_color',
						'value' => '',
		            ),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Description Margin', 'agrikole'),
						'param_name' => 'desc_margin',
						'value' => '',
			        ),
					// Icon
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Icon library', 'agrikole' ),
						'param_name' => 'icon_type',
						'description' => esc_html__( 'Select icon library.', 'agrikole' ),
						'value' => array(
							esc_html__( '', 'agrikole' ) => '',
							esc_html__( 'Agrikole Icons', 'agrikole' ) => 'extraicon',
							esc_html__( 'Stroke 7 Icons', 'agrikole' ) => 'extraicon2',
							esc_html__( 'Open Iconic', 'agrikole' ) => 'openiconic',
							esc_html__( 'Typicons', 'agrikole' ) => 'typicons',
							esc_html__( 'Entypo', 'agrikole' ) => 'entypo',
							esc_html__( 'Linecons', 'agrikole' ) => 'linecons',
						),
					),
					array(
					    'type' => 'iconpicker',
					    'heading' => esc_html__( 'Icon', 'agrikole' ),
					    'param_name' => 'icon_extraicon',
					    'settings' => array(
					        'emptyIcon' => true,
					        'type' => 'extraicon',
					        'iconsPerPage' => 200,
					    ),
					    'dependency' => array(
					        'element' => 'icon_type',
					        'value' => 'extraicon',
					    ),
					),
					array(
					    'type' => 'iconpicker',
					    'heading' => esc_html__( 'Icon', 'agrikole' ),
					    'param_name' => 'icon_extraicon2',
					    'settings' => array(
					        'emptyIcon' => true,
					        'type' => 'extraicon2',
					        'iconsPerPage' => 200,
					    ),
					    'dependency' => array(
					        'element' => 'icon_type',
					        'value' => 'extraicon2',
					    ),
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'agrikole' ),
						'param_name' => 'icon_openiconic',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'openiconic',
							'iconsPerPage' => 200,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'openiconic',
						),
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'agrikole' ),
						'param_name' => 'icon_typicons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'typicons',
							'iconsPerPage' => 200,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'typicons',
						),
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'agrikole' ),
						'param_name' => 'icon_entypo',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'entypo',
							'iconsPerPage' => 300,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'entypo',
						),
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'agrikole' ),
						'param_name' => 'icon_linecons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'linecons',
							'iconsPerPage' => 200,
						),
						'dependency' => array(
							'element' => 'icon_type',
							'value' => 'linecons',
						),
					),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Icon Font Size', 'agrikole'),
						'param_name' => 'icon_font_size',
						'value' => '30px',
			        ),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__('Icon Width', 'agrikole'),
						'param_name' => 'icon_width',
						'value' => '60px',
		            ),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__('Icon Height', 'agrikole'),
						'param_name' => 'icon_height',
						'value' => '60px',
		            ),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Icon Line Height', 'agrikole'),
						'param_name' => 'icon_line_height',
						'value' => '',
			        ),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__('Icon Rounded', 'agrikole'),
						'param_name' => 'icon_rounded',
						'value' => '',
						'description'	=> esc_html__('ex: 10px', 'agrikole'),
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Icon Color', 'agrikole'),
						'param_name' => 'icon_color',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Icon Background', 'agrikole'),
						'param_name' => 'icon_background',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Icon Border Color', 'agrikole'),
						'param_name' => 'icon_border',
						'value' => '',
		            ),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Icon Border Width', 'agrikole'),
						'param_name' => 'icon_border_width',
						'value' => '',
						'description'	=> esc_html__('Default: 1px', 'agrikole'),
			        ),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Icon Border Style', 'agrikole' ),
						'param_name' => 'icon_border_style',
						'value'      => array(
							'Solid' => 'solid',
							'Dotted' => 'dotted',
							'Dashed' => 'dashed'
						),
						'std'		=> 'solid',
					),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Icon Color: Hover', 'agrikole'),
						'param_name' => 'icon_color_hover',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Icon Background: Hover', 'agrikole'),
						'param_name' => 'icon_background_hover',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Icon Border: Hover', 'agrikole'),
						'param_name' => 'icon_border_hover',
						'value' => '',
		            ),
				)                
            ),
		)
	) );
} );

// Step Box
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Step Box', 'agrikole' ),
        'description' => esc_html__('Displaying Step Box.', 'agrikole'),
		'base'        => 'stepbox',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
            // params group
            array(
				'type' => 'param_group',
				'heading' => 'Number Box',
				'value' => '',
				'param_name' => 'numberbox',
				'group' => esc_html__( 'Number Box', 'agrikole' ),
				'params' => array(
					// Icon
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Icon library', 'agrikole' ),
						'param_name' => 'icon_type',
						'description' => esc_html__( 'Select icon library.', 'agrikole' ),
						'value' => array(
							esc_html__( '', 'agrikole' ) => '',
							esc_html__( 'Agrikole Icons', 'agrikole' ) => 'extraicon',
							esc_html__( 'Stroke 7 Icons', 'agrikole' ) => 'extraicon2',
						),
					),
					array(
					    'type' => 'iconpicker',
					    'heading' => esc_html__( 'Icon', 'agrikole' ),
					    'param_name' => 'icon_extraicon',
					    'settings' => array(
					        'emptyIcon' => true,
					        'type' => 'extraicon',
					        'iconsPerPage' => 200,
					    ),
					    'dependency' => array(
					        'element' => 'icon_type',
					        'value' => 'extraicon',
					    ),
					),
					array(
					    'type' => 'iconpicker',
					    'heading' => esc_html__( 'Icon', 'agrikole' ),
					    'param_name' => 'icon_extraicon2',
					    'settings' => array(
					        'emptyIcon' => true,
					        'type' => 'extraicon2',
					        'iconsPerPage' => 200,
					    ),
					    'dependency' => array(
					        'element' => 'icon_type',
					        'value' => 'extraicon2',
					    ),
					),


		            array(
						'type' => 'textarea',
						'holder' => 'div',
						'heading' => esc_html__('Heading', 'agrikole'),
						'param_name' => 'heading',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Heading Color', 'agrikole'),
						'param_name' => 'heading_color',
						'value' => '',
		            ),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Heading Margin', 'agrikole'),
						'param_name' => 'heading_margin',
						'value' => '',
			        ),
					array(
						'type' => 'textarea',
						'holder' => 'div',
						'heading' => esc_html__( 'Description', 'agrikole' ),
						'param_name' => 'description',
					),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Description Color', 'agrikole'),
						'param_name' => 'desc_color',
						'value' => '',
		            ),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Description Margin', 'agrikole'),
						'param_name' => 'desc_margin',
						'value' => '',
			        ),
				)                
            ),
		)
	) );
} );

// PriceTable
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Price Table', 'agrikole' ),
        'description' => esc_html__('Displaying a Price Table.', 'agrikole'),
		'base'        => 'pricetable',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> '',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding', 'agrikole'),
				'param_name' => 'padding',
				'value' => '',
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'agrikole'),
				'param_name' => 'bg_color',
				'value' => '',
            ),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Background Image', 'agrikole'),
				'param_name' => 'bg_image',
				'value' => '',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Background Position', 'agrikole' ),
				'param_name'  => 'bg_position',
				'value'       => array(
					'Left Top' => 'lt',
					'Right Top' => 'rt',
					'Center Top' => 'ct',
					'Center Center' => 'cc',
					'Center Bottom'   => 'cb',
					'Left Bottom' => 'lb',
					'Right Bottom'   => 'rb',
				),
				'std'		=> 'lt',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Background Repeat', 'agrikole' ),
				'param_name'  => 'bg_repeat',
				'value'       => array(
					'No Repeat' => 'no-repeat',
					'Repeat'   => 'repeat',
					'Repeat X'   => 'repeat-x',
					'Repeat Y'   => 'repeat-y',
				),
				'std'		=> 'no-repeat',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Background Size', 'agrikole' ),
				'param_name'  => 'bg_size',
				'value'       => array(
					'Auto' 	   => '',
					'Cover'        => 'cover',
				),
				'std'		=> '',
			),
			// Heading
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading',
				'value' => 'Heading Text',
				'group' => esc_html__( 'Heading', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
				'group' => esc_html__( 'Heading', 'agrikole' ),
            ),
			// Price
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Price', 'agrikole'),
				'param_name' => 'price',
				'value' => '199',
				'group' => esc_html__( 'Price', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Price Color', 'agrikole'),
				'param_name' => 'price_color',
				'value' => '',
				'group' => esc_html__( 'Price', 'agrikole' ),
            ),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Currency', 'agrikole' ),
				'param_name' => 'currency',
				'value' => '$',
				'group' => esc_html__( 'Price', 'agrikole' ), 
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Currency Color', 'agrikole'),
				'param_name' => 'currency_color',
				'value' => '',
				'group' => esc_html__( 'Price', 'agrikole' ),
            ),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Unit', 'agrikole' ),
				'param_name' => 'unit',
				'value' => '/MO',
				'group' => esc_html__( 'Price', 'agrikole' ), 
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Unit Color', 'agrikole'),
				'param_name' => 'unit_color',
				'value' => '',
				'group' => esc_html__( 'Price', 'agrikole' ),
            ),
	        // Content
			array(
				'type' 		=> 'textarea_html',
				'holder' => 'div',
				'heading' 	=> esc_html__('Content', 'agrikole'),
				'param_name' 	=> 'content',
				'value' 		=> '',
				'group' => esc_html__( 'Content', 'agrikole' ),
			),
			// Button
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Text (Required)', 'agrikole'),
				'param_name' => 'link_text',
				'value' => 'Sign Up',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('URL (Required):', 'agrikole'),
				'param_name' => 'link_url',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
            ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open Link in a new Tab', 'agrikole' ),
				'param_name' => 'new_tab',
				'value' => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				'std'		=> 'yes',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'show_url', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Size', 'agrikole' ),
				'param_name' => 'button_size',
				'value'      => array(
					'Medium' => 'medium',
					'Small' => 'small',
					'Big' => 'big',
				),
				'std'		=> 'medium',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Rounded', 'agrikole'),
				'param_name' => 'button_rounded',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Text Color', 'agrikole'),
				'param_name' => 'button_text_color',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Background', 'agrikole'),
				'param_name' => 'button_background',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Border Color', 'agrikole'),
				'param_name' => 'button_border',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Border Width', 'agrikole'),
				'param_name' => 'button_border_width',
				'value' => '1px',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Button Border Style', 'agrikole' ),
				'param_name' => 'button_border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Text: Hover', 'agrikole'),
				'param_name' => 'button_text_hover',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Background: Hover', 'agrikole'),
				'param_name' => 'button_background_hover',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Button Border: Hover', 'agrikole'),
				'param_name' => 'button_border_hover',
				'value' => '',
				'group' => esc_html__( 'Button', 'agrikole' ),
				'dependency' => array( 'element' => 'url_style', 'value' => 'button' ),
            ),
	        // Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Line-Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),      
			array(
				'type' => 'headings',
				'text' => esc_html__('Price', 'agrikole'),
				'param_name' => 'price_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Price Font Family', 'agrikole' ),
				'param_name' => 'price_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Price Font Weight', 'agrikole' ),
				'param_name' => 'price_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Price Font Size', 'agrikole'),
				'param_name' => 'price_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Price Line-Height', 'agrikole'),
				'param_name' => 'price_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Unit', 'agrikole'),
				'param_name' => 'unit_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Unit Font Family', 'agrikole' ),
				'param_name' => 'unit_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Unit Font Weight', 'agrikole' ),
				'param_name' => 'unit_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Unit Font Size', 'agrikole'),
				'param_name' => 'unit_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Description Line-Height', 'agrikole'),
				'param_name' => 'unit_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        // Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Margin', 'agrikole'),
				'param_name' => 'heading_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Price Margin', 'agrikole'),
				'param_name' => 'price_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Margin', 'agrikole'),
				'param_name' => 'content_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Button Margin', 'agrikole'),
				'param_name' => 'button_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
		)
	) );
} );

// PriceTable Group 3
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Price Tables with Switcher', 'agrikole' ),
        'description' => esc_html__('Displaying 03 Price Tables with Switcher.', 'agrikole'),
		'base'        => 'pricetables',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Switch Text 1', 'agrikole'),
				'param_name' => 'switch_text_1',
				'value' => '',
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Switch Text 2', 'agrikole'),
				'param_name' => 'switch_text_2',
				'value' => '',
	        ),
            // params group
            array(
				'type' => 'param_group',
				'heading' => 'Price Table Box',
				'value' => '',
				'param_name' => 'pricebox',
				'group' => esc_html__( 'Price Tables', 'agrikole' ),
				'params' => array(
		            array(
						'type' => 'textfield',
						'heading' => esc_html__('Heading', 'agrikole'),
						'param_name' => 'heading',
						'value' => '',
		            ),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__('Price', 'agrikole'),
						'param_name' => 'price',
						'value' => '',
		            ),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__('Currency', 'agrikole'),
						'param_name' => 'currency',
						'value' => '$',
		            ),
					array(
						'type' 		=> 'textarea',
						'heading' 	=> esc_html__('Features', 'agrikole'),
						'param_name' 	=> 'features',
						'value' 		=> '',
					),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Button Content', 'agrikole'),
						'param_name' => 'button_content',
						'value' => '',
			        ),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Button Content Extra', 'agrikole'),
						'param_name' => 'button_content_ex',
						'value' => '',
			        ),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Open Link in a new Tab', 'startflow' ),
						'param_name' => 'new_tab',
						'value' => array(
							'Yes' => 'yes',
							'No' => 'no',
						),
						'std'		=> 'yes',
					),
			        array(
						'type' => 'textfield',
						'heading' => esc_html__('Button Link (URL)', 'agrikole'),
						'param_name' => 'button_url',
						'value' => '',
			        ),
		            array(
						'type' => 'textfield',
						'heading' => esc_html__('Button Rounded', 'agrikole'),
						'param_name' => 'button_rounded',
						'value' => '',
						'description'	=> esc_html__('Ex: 30px', 'agrikole'),
		            ),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__( 'Button Style', 'agrikole' ),
						'param_name' => 'button_style',
						'value'      => array(
							'Background' => 'background',
							'Outline' => 'outline',
						),
						'std'		=> 'background',
					),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Button Text', 'agrikole'),
						'param_name' => 'button_text',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Button Background', 'agrikole'),
						'param_name' => 'button_background',
						'value' => '',
						'dependency' => array( 'element' => 'button_style', 'value' => 'background' ),
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Button Border', 'agrikole'),
						'param_name' => 'button_border',
						'value' => '',
						'dependency' => array( 'element' => 'button_style', 'value' => 'outline' ),
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Button Text: Hover', 'agrikole'),
						'param_name' => 'button_text_hover',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Button Background: Hover', 'agrikole'),
						'param_name' => 'button_background_hover',
						'value' => '',
		            ),
		            array(
						'type' => 'colorpicker',
						'heading' => esc_html__('Button Border: Hover', 'agrikole'),
						'param_name' => 'button_border_hover',
						'value' => '',
						'dependency' => array( 'element' => 'button_style', 'value' => 'outline' ),
		            ),
				)                
            ),
		)
	) );
} );

// Content Box
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_contentbox extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
    vc_map( array(
		'name' => esc_html__('Content Box', 'agrikole'),
		'description' => esc_html__('Content Box.', 'agrikole'),
		'base' => 'contentbox',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array('except' => 'contentbox'),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Background Image', 'agrikole'),
				'param_name' => 'bg_image',
				'value' => '',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Background Position', 'agrikole' ),
				'param_name'  => 'bg_position',
				'value'       => array(
					'Left Top' => 'lt',
					'Right Top' => 'rt',
					'Center Top' => 'ct',
					'Center Center' => 'cc',
					'Center Bottom'   => 'cb',
					'Left Bottom' => 'lb',
					'Right Bottom'   => 'rb',
				),
				'std'		=> 'lt',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Background Repeat', 'agrikole' ),
				'param_name'  => 'bg_repeat',
				'value'       => array(
					'No Repeat' => 'no-repeat',
					'Repeat'   => 'repeat',
					'Repeat X'   => 'repeat-x',
					'Repeat Y'   => 'repeat-y',
				),
				'std'		=> 'no-repeat',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Background Size', 'agrikole' ),
				'param_name'  => 'bg_size',
				'value'       => array(
					'Auto' 	   => '',
					'Cover'        => 'cover',
				),
				'std'		=> '',
			),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Extra Class', 'agrikole' ),
				'param_name'  => 'class',
				'description' => esc_html__( 'Addition class name to refer to it in your css file.', 'agrikole' )
			),
            // Spacing
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => 'left',
					'Center' => 'center',
					'Right' => 'right',
				),
				'std'		=> 'left',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Width', 'agrikole'),
				'param_name' => 'd_width',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
				'description'	=> esc_html__('Ex: 600px', 'agrikole'),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Height', 'agrikole'),
				'param_name' => 'd_height',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
				'description'	=> esc_html__('Ex: 400px', 'agrikole'),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding', 'agrikole'),
				'param_name' => 'padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. You can use % or px value.', 'agrikole'),
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding on mobile', 'agrikole'),
				'param_name' => 'mobile_padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. You can use % or px value.', 'agrikole'),
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Margin', 'agrikole'),
				'param_name' => 'margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
				'description'	=> esc_html__('Top Right Bottom Left. You can use % or px value.', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Margin on mobile', 'agrikole'),
				'param_name' => 'mobile_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ), 
				'description'	=> esc_html__('Top Right Bottom Left. You can use % or px value.', 'agrikole'),
	        ),
            // Design
			array(
				'type' => 'headings',
				'text' => esc_html__('Background', 'agrikole'),
				'param_name' => 'heading_background',
				'group' => esc_html__( 'Design', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'agrikole'),
				'param_name' => 'background_color',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Border', 'agrikole'),
				'param_name' => 'heading_border',
				'group' => esc_html__( 'Design', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color', 'agrikole'),
				'param_name' => 'border_color',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Border Width', 'agrikole'),
				'param_name' => 'border_width',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 0px 0px 1px 0px', 'agrikole'),
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Style', 'agrikole' ),
				'param_name' => 'border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'Design', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Rounded', 'agrikole'),
				'param_name' => 'heading_rounded',
				'group' => esc_html__( 'Design', 'agrikole' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Rounded', 'agrikole'),
				'param_name' => 'rounded',
				'value' => '',
				'description'	=> esc_html__('Ex: 6px', 'agrikole'),
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Box Shadow', 'agrikole'),
				'param_name' => 'heading_shadow',
				'group' => esc_html__( 'Design', 'agrikole' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Option Shadow', 'agrikole' ),
				'param_name'  => 'inset',
				'value'       => array(
					'Outset'   => '',
					'Inset'   => 'inset',
				),
				'std'		=> '',
				'group' => esc_html__( 'Design', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Horizontal (Required)', 'agrikole'),
				'param_name' => 'horizontal',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Vertical (Required)', 'agrikole'),
				'param_name' => 'vertical',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Blur (Required)', 'agrikole'),
				'param_name' => 'blur',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spread (Required)', 'agrikole'),
				'param_name' => 'spread',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Shadow Color (Required)', 'agrikole'),
				'param_name' => 'shadow_color',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
	        // Hover
			array(
				'type' => 'headings',
				'text' => esc_html__('Background', 'agrikole'),
				'param_name' => 'heading_background_hover',
				'group' => esc_html__( 'Hover', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'agrikole'),
				'param_name' => 'background_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Border', 'agrikole'),
				'param_name' => 'heading_border_hover',
				'group' => esc_html__( 'Hover', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color', 'agrikole'),
				'param_name' => 'border_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Border Width', 'agrikole'),
				'param_name' => 'border_width_hover',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 0px 0px 1px 0px', 'agrikole'),
				'group' => esc_html__( 'Hover', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Style', 'agrikole' ),
				'param_name' => 'border_style_hover',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'Hover', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Rounded', 'agrikole'),
				'param_name' => 'heading_rounded_hover',
				'group' => esc_html__( 'Hover', 'agrikole' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Rounded', 'agrikole'),
				'param_name' => 'rounded_hover',
				'value' => '',
				'description'	=> esc_html__('Ex: 6px', 'agrikole'),
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Box Shadow', 'agrikole'),
				'param_name' => 'heading_shadow_hover',
				'group' => esc_html__( 'Hover', 'agrikole' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Option Shadow', 'agrikole' ),
				'param_name'  => 'inset_hover',
				'value'       => array(
					'Outset'   => '',
					'Inset'   => 'inset',
				),
				'std'		=> '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Horizontal (Required)', 'agrikole'),
				'param_name' => 'horizontal_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Vertical (Required)', 'agrikole'),
				'param_name' => 'vertical_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Blur (Required)', 'agrikole'),
				'param_name' => 'blur_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spread (Required)', 'agrikole'),
				'param_name' => 'spread_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Shadow Color (Required)', 'agrikole'),
				'param_name' => 'shadow_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Transforms', 'agrikole'),
				'param_name' => 'heading_transforms',
				'group' => esc_html__( 'Hover', 'agrikole' ),
			),
			array(
				'type' => 'number',
				'heading' => esc_html__('Translate X', 'agrikole'),
				'param_name' => 'translatex',
				'value' => 0,
				'suffix' => 'px',
				'group' => esc_html__( 'Hover', 'agrikole' ),
		  	),
			array(
				'type' => 'number',
				'heading' => esc_html__('Translate Y', 'agrikole'),
				'param_name' => 'translatey',
				'value' => 0,
				'suffix' => 'px',
				'group' => esc_html__( 'Hover', 'agrikole' ),
		  	),
        )
    ) );
} );

// Advanced Text
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Advanced Text', 'agrikole' ),
        'description' => esc_html__('Displaying a text with some styles.', 'agrikole'),
		'base'        => 'advtext',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
				),
				'std'		=> '',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Tag', 'agrikole' ),
				'param_name' => 'tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
					'DIV' => 'div'
				),
				'std'		=> 'h2',
			),
			array(
				'type' 		=> 'textarea_html',
				'holder' => 'div',
				'heading' 	=> esc_html__('Content', 'agrikole'),
				'param_name' 	=> 'content',
				'value' 		=> '',
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Color', 'agrikole'),
				'param_name' => 'color',
				'value' => '',
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Max-Width', 'agrikole'),
				'param_name' => 'max_width',
				'value' => '',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Bottom Margin', 'agrikole'),
				'param_name' => 'bottom_margin',
				'value' => '',
	        ),
            // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
	        // Typography
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Family', 'agrikole' ),
				'param_name' => 'font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Weight', 'agrikole' ),
				'param_name' => 'font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Font Size', 'agrikole'),
				'param_name' => 'font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Height', 'agrikole'),
				'param_name' => 'line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
		)
	) );
} );

// Single Heading
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Single Heading', 'agrikole' ),
        'description' => esc_html__('Displaying a single heading with some styles.', 'agrikole'),
		'base'        => 'singleheading',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
				),
				'std'		=> '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__( 'Heading Text', 'agrikole' ),
				'param_name' => 'heading',
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Bottom Margin', 'agrikole'),
				'param_name' => 'heading_bottom_margin',
				'value' => '',
	        ),
            // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Width', 'agrikole'),
				'param_name' => 'line_width',
				'value' => '40',
				'group' => esc_html__( 'Line', 'agrikole' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Height', 'agrikole'),
				'param_name' => 'line_height',
				'value' => '2',
				'group' => esc_html__( 'Line', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Line Color', 'agrikole'),
				'param_name' => 'line_color',
				'value' => '#eddd5e',
				'group' => esc_html__( 'Line', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing Between', 'agrikole'),
				'param_name' => 'heading_padding',
				'value' => '',
				'group' => esc_html__( 'Line', 'agrikole' ),
				'description'	=> esc_html__('Spacing between the line and the text. Ex: 50px.', 'agrikole'),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Offset Top', 'agrikole'),
				'param_name' => 'line_top',
				'value' => '',
				'group' => esc_html__( 'Line', 'agrikole' ),
				'description'	=> esc_html__('Ex: 5px.', 'agrikole'),
            ),
	        // Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading: Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading: Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Letter Spacing', 'agrikole'),
				'param_name' => 'heading_letter_spacing',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
		)
	) );
} );

// Headings
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Headings', 'agrikole' ),
        'description' => esc_html__('Displaying awesome heading styles.', 'agrikole'),
		'base'        => 'headings',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Right' => 'text-right',
					'Center' => 'text-center',
				),
				'std'		=> 'text-center',
			),
			// Pre-Heading
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__( 'Pre-Heading', 'agrikole' ),
				'param_name' => 'preheading',
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Pre-Heading Color', 'agrikole'),
				'param_name' => 'preheading_color',
				'value' => '',
            ),
            // Heading
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'heading' => esc_html__( 'Heading Text', 'agrikole' ),
				'param_name' => 'heading',
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Max-Width', 'agrikole'),
				'param_name' => 'heading_width',
				'value' => '',
            ),
            // Sub Heading
			array(
				'type' 		=> 'textarea_html',
				'holder' => 'div',
				'heading' 	=> esc_html__('Sub-Heading', 'agrikole'),
				'param_name' 	=> 'content',
				'value' 		=> '',
			),
            // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Separator', 'agrikole' ),
				'param_name' => 'separator',
				'value'      => array(
					'No Separator' => '',
					'Line' => 'line',
					'Image' => 'image',
				),
				'std'		=> '',
				'group' => esc_html__( 'Separator', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Separator Position', 'agrikole' ),
				'param_name' => 'sep_position',
				'value'      => array(
					'Top' => 'top',
					'Between Heading & Sub-Heading' => 'between',
					'Bottom' => 'bottom',
					'Left' => 'left',
				),
				'std'		=> 'between',
				'group' => esc_html__( 'Separator', 'agrikole' ),
				'dependency' => array( 'element' => 'separator', 'value' => array( 'line', 'image' ) ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Width', 'agrikole'),
				'param_name' => 'line_width',
				'value' => '70',
				'group' => esc_html__( 'Separator', 'agrikole' ),
				'dependency' => array( 'element' => 'separator', 'value' => 'line' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Height', 'agrikole'),
				'param_name' => 'line_height',
				'value' => '2',
				'group' => esc_html__( 'Separator', 'agrikole' ),
				'dependency' => array( 'element' => 'separator', 'value' => 'line' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Separator Margin', 'agrikole'),
				'param_name' => 'sep_margin',
				'value' => '',
				'group' => esc_html__( 'Separator', 'agrikole' ),
				'dependency' => array( 'element' => 'separator', 'value' => array( 'line', 'image' ) ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Line: Right Margin', 'agrikole'),
				'param_name' => 'line_right_margin',
				'value' => '20',
				'group' => esc_html__( 'Separator', 'agrikole' ),
				'dependency' => array( 'element' => 'sep_position', 'value' => 'left' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Line Color', 'agrikole'),
				'param_name' => 'line_color',
				'value' => '#eddd5e',
				'group' => esc_html__( 'Separator', 'agrikole' ),
				'dependency' => array( 'element' => 'separator', 'value' => 'line' ),
            ),
	        // Image
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'agrikole'),
				'param_name' => 'image',
				'value' => '',
				'group' => esc_html__( 'Separator', 'agrikole' ),
				'dependency' => array( 'element' => 'separator', 'value' => 'image' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Width (Optional)', 'agrikole'),
				'param_name' => 'image_width',
				'value' => '',
				'group' => esc_html__( 'Separator', 'agrikole' ),
				'dependency' => array( 'element' => 'separator', 'value' => 'image' ),
	        ),
	        // Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Tag', 'agrikole' ),
				'param_name' => 'tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'		=> 'h2',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading: Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading: Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Font Size on Mobile', 'agrikole'),
				'param_name' => 'heading_font_size_mobile',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Line Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Letter Spacing', 'agrikole'),
				'param_name' => 'heading_letter_spacing',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Pre-Heading', 'agrikole'),
				'param_name' => 'preheading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Pre-Heading: Font Family', 'agrikole' ),
				'param_name' => 'preheading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Pre-Heading: Font Weight', 'agrikole' ),
				'param_name' => 'preheading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Pre-Heading: Font Size', 'agrikole'),
				'param_name' => 'preheading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Pre-Heading: Line Height', 'agrikole'),
				'param_name' => 'preheading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Pre-Heading: Letter Spacing', 'agrikole'),
				'param_name' => 'preheading_letter_spacing',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        // Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Top Margin', 'agrikole'),
				'param_name' => 'heading_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Bottom Margin', 'agrikole'),
				'param_name' => 'heading_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
		)
	) );
} );

// Animation Block
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_animationblock extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
    vc_map( array(
		'name' => esc_html__('Animation Block', 'agrikole'),
		'description' => esc_html__('Apply animations anywhere.', 'agrikole'),
		'base' => 'animationblock',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array('except' => 'animationblock'),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
         )
    ) );
} );

// Counter
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Counter', 'agrikole' ),
        'description' => esc_html__('Displaying a counter.', 'agrikole'),
		'base'        => 'counter',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2'
				),
				'std'		=> 'style-1',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> '',
				'dependency' => array( 'element' => 'style', 'value' => array('style-1')  ),
			),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			// Icon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon library', 'agrikole' ),
				'param_name' => 'icon_type',
				'description' => esc_html__( 'Select icon library.', 'agrikole' ),
				'value' => array(
					esc_html__( '', 'agrikole' ) => '',
					esc_html__( 'Agrikole Icons', 'agrikole' ) => 'extraicon',
					esc_html__( 'Stroke 7 Icons', 'agrikole' ) => 'extraicon2',
					esc_html__( 'Elegant Icons', 'agrikole' ) => 'extraicon3',
					esc_html__( 'FontAwesome', 'agrikole' ) => 'fontawesome',
					esc_html__( 'Open Iconic', 'agrikole' ) => 'openiconic',
					esc_html__( 'Typicons', 'agrikole' ) => 'typicons',
					esc_html__( 'Entypo', 'agrikole' ) => 'entypo',
					esc_html__( 'Linecons', 'agrikole' ) => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-font' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon2',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon2',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon2',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon3',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon3',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon3',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_fontawesome',
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'fontawesome',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'openiconic',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Font Size', 'agrikole'),
				'param_name' => 'icon_font_size',
				'value' => '30px',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Width', 'agrikole'),
				'param_name' => 'icon_width',
				'value' => '60',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Height', 'agrikole'),
				'param_name' => 'icon_height',
				'value' => '60',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Line Height', 'agrikole'),
				'param_name' => 'icon_line_height',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Rounded', 'agrikole'),
				'param_name' => 'icon_rounded',
				'value' => '',
				'description'	=> esc_html__('ex: 10px', 'agrikole'),
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color', 'agrikole'),
				'param_name' => 'icon_color',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Background', 'agrikole'),
				'param_name' => 'icon_background',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Border Color', 'agrikole'),
				'param_name' => 'icon_border',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Border Width', 'agrikole'),
				'param_name' => 'icon_border_width',
				'value' => '',
				'description'	=> esc_html__('Default: 1px', 'agrikole'),
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Border Style', 'agrikole' ),
				'param_name' => 'icon_border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color: Hover', 'agrikole'),
				'param_name' => 'icon_color_hover',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Background: Hover', 'agrikole'),
				'param_name' => 'icon_background_hover',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Border: Hover', 'agrikole'),
				'param_name' => 'icon_border_hover',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => array('icon-font','icon-text') ),
            ),
			// Number
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Number Tag', 'agrikole' ),
				'param_name' => 'number_tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
					'div' => 'div',
				),
				'std'		=> 'h3',
				'group' => esc_html__( 'Number', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Number Show', 'agrikole' ),
				'param_name' => 'decimals',
				'value'      => array(
					'Normal' => '0',
					'Decimal' => '1',
				),
				'std'		=> '0',
				'group' => esc_html__( 'Number', 'agrikole' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Number', 'agrikole' ),
				'param_name' => 'number',
				'group' => esc_html__( 'Number', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Number Color', 'agrikole'),
				'param_name' => 'number_color',
				'value' => '',
				'group' => esc_html__( 'Number', 'agrikole' ),
            ),
			array(
				'type' => 'number',
				'heading' => esc_html__('Rolling Time', 'agrikole'),
				'param_name' => 'time',
				'value' => 5000,
				'suffix' => 'ms',
				'group' => esc_html__( 'Number', 'agrikole' ),
		  	),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Prefix (Optional)', 'agrikole' ),
				'param_name' => 'number_prefix',
				'group' => esc_html__( 'Number', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Prefix Color', 'agrikole'),
				'param_name' => 'prefix_color',
				'value' => '',
				'group' => esc_html__( 'Number', 'agrikole' ),
            ),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Suffix (Optional)', 'agrikole' ),
				'param_name' => 'number_suffix',
				'group' => esc_html__( 'Number', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Suffix Color', 'agrikole'),
				'param_name' => 'suffix_color',
				'value' => '',
				'group' => esc_html__( 'Number', 'agrikole' ),
            ),
		  	// Heading
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading Tag', 'agrikole' ),
				'param_name' => 'heading_tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
					'div' => 'div',
				),
				'std'		=> 'div',
				'group' => esc_html__( 'Heading', 'agrikole' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Heading', 'agrikole' ),
				'param_name' => 'heading',
				'group' => esc_html__( 'Heading', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Heading Color', 'agrikole'),
				'param_name' => 'heading_color',
				'value' => '',
				'group' => esc_html__( 'Heading', 'agrikole' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading Max-Width', 'agrikole'),
				'param_name' => 'heading_max_width',
				'value' => '',
				'group' => esc_html__( 'Heading', 'agrikole' ),
            ),
	        // Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Number Settings', 'agrikole'),
				'param_name' => 'number_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
				'class' => '',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Number: Font Family', 'agrikole' ),
				'param_name' => 'number_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Number: Font Weight', 'agrikole' ),
				'param_name' => 'number_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number: Font Size', 'agrikole'),
				'param_name' => 'number_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number: Font Size on Mobile', 'agrikole'),
				'param_name' => 'number_font_size_mobile',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number: Line Height', 'agrikole'),
				'param_name' => 'number_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number: Letter Spacing', 'agrikole'),
				'param_name' => 'number_letter_spacing',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type' => 'headings',
				'text' => esc_html__('Heading Settings', 'agrikole'),
				'param_name' => 'heading_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
				'class' => '',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading: Font Family', 'agrikole' ),
				'param_name' => 'heading_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Heading: Font Weight', 'agrikole' ),
				'param_name' => 'heading_font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Font Size', 'agrikole'),
				'param_name' => 'heading_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Line Height', 'agrikole'),
				'param_name' => 'heading_line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Letter Spacing', 'agrikole'),
				'param_name' => 'heading_letter_spacing',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        // Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Content Left Padding', 'agrikole'),
				'param_name' => 'content_left_padding',
				'value' => '100',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
				'description'	=> esc_html__('Spacing between the icon and the content', 'agrikole'),
				'dependency' => array( 'element' => 'style', 'value' => 'style-2' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon: Top Margin', 'agrikole'),
				'param_name' => 'icon_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number: Top Margin', 'agrikole'),
				'param_name' => 'number_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number: Bottom Margin', 'agrikole'),
				'param_name' => 'number_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Top Margin', 'agrikole'),
				'param_name' => 'heading_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Heading: Bottom Margin', 'agrikole'),
				'param_name' => 'heading_bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
		)
	) );
} );

// Video Icon
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Video Icon', 'agrikole' ),
        'description' => esc_html__('Displaying Icon with custom video popup.', 'agrikole'),
		'base'        => 'videoicon',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => 'text-left',
					'Right' => 'text-right',
					'Center' => 'text-center',
				),
				'std'		=> 'text-center',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'White' => 'white',
					'Accent' => 'accent',
					'Green' => 'green',  //0575e6
				),
				'std'		=> 'accent',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Size', 'agrikole' ),
				'param_name' => 'size',
				'value'      => array(
					'Big' => 'big',
					'Small' => 'small',
				),
				'std'		=> 'big',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Link Youtube/Vimeo (URL)', 'agrikole'),
				'param_name' => 'video_url',
				'value' => '',
	        ),
            // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
		)
	) );
} );

// Simple Image
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Simple Image', 'agrikole' ),
        'description' => esc_html__('Displaying a simple image with animation.', 'agrikole'),
		'base'        => 'simpleimage',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'agrikole'),
				'param_name' => 'image',
				'value' => '',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Image Stretch?', 'agrikole' ),
				'param_name' => 'img_stretch',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
            // Effect
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Effect', 'agrikole' ),
				'param_name' => 'effect',
				'value'      => array(
					'No Effect' => 'simple',
					'Reveal' => 'reveal',
					'Background' => 'background',
				),
				'std'		=> 'simple',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Reveal Direction', 'agrikole' ),
				'param_name' => 'reveal_dir',
				'value'      => array(
					'Left - Right' => 'lr',
					'Right - Left' => 'rl',
				),
				'std'		=> 'lr',
				'dependency' => array( 'element' => 'effect', 'value' => 'reveal' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Background Position', 'agrikole' ),
				'param_name' => 'bg_pos',
				'value'      => array(
					'Top' => 'top',
					'Right' => 'right',
					'Bottom' => 'bottom',
					'Left' => 'left',
				),
				'std'		=> 'top',
				'dependency' => array( 'element' => 'effect', 'value' => 'background' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Width (Optional)', 'agrikole'),
				'param_name' => 'image_width',
				'value' => '',
				'dependency' => array( 'element' => 'effect', 'value' => 'simple' ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Rounded', 'agrikole'),
				'param_name' => 'rounded',
				'value' => '',
				'description'	=> esc_html__('ex: 10px', 'agrikole'),
				'dependency' => array( 'element' => 'effect', 'value' => array('simple','reveal') ),
            ),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Center Alignment', 'agrikole' ),
				'param_name' => 'center_align',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
				'dependency' => array( 'element' => 'effect', 'value' => 'simple' ),
			),
	        // Hyperlink
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Link (URL):', 'agrikole'),
				'param_name' => 'url',
				'value' => '',
            ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open Link in a new Tab', 'agrikole' ),
				'param_name' => 'new_tab',
				'value' => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				'std'		=> 'yes',
			),
            // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			// Box Shadow
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Option Shadow', 'agrikole' ),
				'param_name'  => 'inset',
				'value'       => array(
					'Outset'   => '',
					'Inset'   => 'inset',
				),
				'std'		=> '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
				'dependency' => array( 'element' => 'effect', 'value' => array('simple','reveal') ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Horizontal (Required)', 'agrikole'),
				'param_name' => 'horizontal',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
				'dependency' => array( 'element' => 'effect', 'value' => array('simple','reveal') ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Vertical (Required)', 'agrikole'),
				'param_name' => 'vertical',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
				'dependency' => array( 'element' => 'effect', 'value' => array('simple','reveal') ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Blur (Required)', 'agrikole'),
				'param_name' => 'blur',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
				'dependency' => array( 'element' => 'effect', 'value' => array('simple','reveal') ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spread (Required)', 'agrikole'),
				'param_name' => 'spread',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
				'dependency' => array( 'element' => 'effect', 'value' => array('simple','reveal') ),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Shadow Color (Required)', 'agrikole'),
				'param_name' => 'shadow_color',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
				'dependency' => array( 'element' => 'effect', 'value' => array('simple','reveal') ),
            ),
			// Video Icon
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'icon_style',
				'value'      => array(
					'White' => 'white',
					'Accent' => 'accent',
					'Blue' => 'blue',  //0575e6
					'Orange' => 'orange', //f7b446
					'Red' => 'red',  //ff3366
					'Purple' => 'purple', //7540ee
					'Picton' => 'picton', //3fb6dc
				),
				'std'		=> 'white',
				'group' => esc_html__( 'Video Icon', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Size', 'agrikole' ),
				'param_name' => 'icon_size',
				'value'      => array(
					'Big' => 'big',
					'Small' => 'small',
				),
				'std'		=> 'big',
				'group' => esc_html__( 'Video Icon', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Link Youtube/Vimeo (URL)', 'agrikole'),
				'param_name' => 'video_url',
				'value' => '',
				'group' => esc_html__( 'Video Icon', 'agrikole' ),
	        ),
			// Stretch
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Stretch', 'agrikole' ),
				'param_name' => 'stretch',
				'value'      => array(
					'No Stretch' => '',
					'Stretch To Right' => 'stretch_right',
					'Stretch To Left' => 'stretch_left',
					'Stretch on Mobile' => 'stretch_mobi',
				),
				'std'		=> '',
				'group' => esc_html__( 'Stretch', 'agrikole' ),
				'dependency' => array( 'element' => 'effect', 'value' => 'reveal' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Offset Left', 'agrikole'),
				'param_name' => 'offset_left',
				'value' => '-22vw',
				'group' => esc_html__( 'Stretch', 'agrikole' ),
				'dependency' => array( 'element' => 'stretch', 'value' => 'stretch_left' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Offset Right', 'agrikole'),
				'param_name' => 'offset_right',
				'value' => '-22vw',
				'group' => esc_html__( 'Stretch', 'agrikole' ),
				'dependency' => array( 'element' => 'stretch', 'value' => 'stretch_right' ),
	        ),
		)
	) );
} );

// Parallax Image Box
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_parallaxbox extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Parallax Image Box', 'agrikole' ),
        'description' => esc_html__('Parallax Box', 'agrikole'),
		'base'        => 'parallaxbox',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array( 'only' => 'parallaxitem' ),
		'controls' => 'full',
		'show_settings_on_create' => false,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView'
	) );
} );

// Parallax Box Item
add_action( 'vc_before_init', function() {
	vc_map( array(
	'name'        => esc_html__( 'Item', 'agrikole' ),
    'description' => esc_html__('Item for Parallax Image Box', 'agrikole'),
		'base'        => 'parallaxitem',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'as_child'    => array( 'only' => 'parallaxbox' ),
		'params'      => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Image', 'agrikole'),
				'param_name' => 'image',
				'value' => '',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Width', 'agrikole'),
				'param_name' => 'image_width',
				'value' => '',
				'description'	=> esc_html__('You can use % or px value. Ex: 50%.', 'agrikole'),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Rounded', 'agrikole'),
				'param_name' => 'image_rounded',
				'value' => '',
				'description'	=> esc_html__('Ex: 5px', 'agrikole'),
            ),
	        array(
	            'type' => 'textfield',
	            'heading' => esc_html__('Parallax X', 'agrikole'),
	            'param_name' => 'parallax_x',
	            'description'   => esc_html__('X axis translation.', 'agrikole'),
	        ),
	        array(
	            'type' => 'textfield',
	            'heading' => esc_html__('Parallax Y', 'agrikole'),
	            'param_name' => 'parallax_y',
	            'description'   => esc_html__('Y axis translation.', 'agrikole'),
	        ),
	        array(
	            'type' => 'textfield',
	            'heading' => esc_html__('Smoothness', 'agrikole'),
	            'param_name' => 'smoothness',
	            'value' => '30',
	            'description'   => esc_html__('Slowdown the animation.', 'agrikole'),
	        ),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Left', 'agrikole'),
				'param_name' => 'left',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Right', 'agrikole'),
				'param_name' => 'right',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__('Top', 'agrikole'),
				'param_name' => 'top',
				'value' => '',
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Option Shadow', 'agrikole' ),
				'param_name'  => 'inset',
				'value'       => array(
					'Outset'   => '',
					'Inset'   => 'inset',
				),
				'std'		=> '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Horizontal (Required)', 'agrikole'),
				'param_name' => 'horizontal',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Vertical (Required)', 'agrikole'),
				'param_name' => 'vertical',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Blur (Required)', 'agrikole'),
				'param_name' => 'blur',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spread (Required)', 'agrikole'),
				'param_name' => 'spread',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Shadow Color (Required)', 'agrikole'),
				'param_name' => 'shadow_color',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
            ),
		)
	) );
} );

// Icons
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Icons', 'agrikole' ),
        'description' => esc_html__('Displaying Icon lists with custom icon.', 'agrikole'),
		'base'        => 'icons',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
			// Icon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon library', 'agrikole' ),
				'param_name' => 'icon_type',
				'description' => esc_html__( 'Select icon library.', 'agrikole' ),
				'value' => array(
					esc_html__( '', 'agrikole' ) => '',
					esc_html__( 'Agrikole Icons', 'agrikole' ) => 'extraicon',
					esc_html__( 'Stroke 7 Icons', 'agrikole' ) => 'extraicon2',
					esc_html__( 'FontAwesome', 'agrikole' ) => 'fontawesome',
					esc_html__( 'Open Iconic', 'agrikole' ) => 'openiconic',
					esc_html__( 'Typicons', 'agrikole' ) => 'typicons',
					esc_html__( 'Entypo', 'agrikole' ) => 'entypo',
					esc_html__( 'Linecons', 'agrikole' ) => 'linecons',
				),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon',
			    ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon2',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon2',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon2',
			    ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_fontawesome',
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'fontawesome',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'openiconic',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Font Size', 'agrikole'),
				'param_name' => 'font_size',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Width', 'agrikole'),
				'param_name' => 'width',
				'value' => '60',
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Height', 'agrikole'),
				'param_name' => 'height',
				'value' => '60',
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Line Height', 'agrikole'),
				'param_name' => 'line_height',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Rounded', 'agrikole'),
				'param_name' => 'rounded',
				'value' => '',
				'description'	=> esc_html__('ex: 10px', 'agrikole'),
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Color', 'agrikole'),
				'param_name' => 'color',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'agrikole'),
				'param_name' => 'background_color',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color', 'agrikole'),
				'param_name' => 'border_color',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Border Width', 'agrikole'),
				'param_name' => 'border_width',
				'value' => '',
				'description'	=> esc_html__('Default: 1px', 'agrikole'),
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Style', 'agrikole' ),
				'param_name' => 'border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
				'group' => esc_html__( 'Design', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Margin', 'agrikole'),
				'param_name' => 'margin',
				'value' => '',
				'group' => esc_html__( 'Design', 'agrikole' ),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Color: Hover', 'agrikole'),
				'param_name' => 'color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color: Hover', 'agrikole'),
				'param_name' => 'background_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color: Hover', 'agrikole'),
				'param_name' => 'border_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
	        // Hyperlink
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Link (URL):', 'agrikole'),
				'param_name' => 'link_url',
				'value' => '',
				'group' => esc_html__( 'Hyperlink', 'agrikole' ),
            ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open Link in a new Tab', 'agrikole' ),
				'param_name' => 'new_tab',
				'group' => esc_html__( 'Hyperlink', 'agrikole' ),
				'value' => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				'std'		=> 'yes',
			),
		)
	) );
} );

// Divider
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Divider', 'agrikole'),
        'description' => esc_html__('Displaying lines separator.', 'agrikole'),
        'base' => 'divider',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => 'divider-left',
					'Center' => 'divider-center',
					'Right' => 'divider-right',
				),
				'std'		=> 'divider-center',
				'dependency' => array( 'element' => 'icon_display', 'value' => 'no-icon' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Line Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed',
					'Double' => 'double',
				),
				'std'		=> 'solid',
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Line: Width', 'agrikole'),
				'param_name' => 'width',
				'value' => '',
				'description' => esc_html__( 'Default: 100%.', 'agrikole' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Line: Height', 'agrikole'),
				'param_name' => 'height',
				'value' => '',
				'description'	=> esc_html__('Default: 1px', 'agrikole'),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Line: Color', 'agrikole'),
				'param_name' => 'color',
				'value' => '',
            ),
			// Icon
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon to Display', 'agrikole' ),
				'param_name' => 'icon_display',
				'value'      => array(
					'No Icon' => 'no-icon',
					'Icon Font' => 'icon-font',
				),
				'std'		=> 'no-icon',
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon library', 'agrikole' ),
				'param_name' => 'icon_type',
				'description' => esc_html__( 'Select icon library.', 'agrikole' ),
				'value' => array(
					esc_html__( '', 'agrikole' ) => '',
					esc_html__( 'Agrikole Icons', 'agrikole' ) => 'extraicon',
					esc_html__( 'Stroke 7 Icons', 'agrikole' ) => 'extraicon2',
					esc_html__( 'Open Iconic', 'agrikole' ) => 'openiconic',
					esc_html__( 'Typicons', 'agrikole' ) => 'typicons',
					esc_html__( 'Entypo', 'agrikole' ) => 'entypo',
					esc_html__( 'Linecons', 'agrikole' ) => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-font' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon2',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon2',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon2',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'openiconic',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon: Color', 'agrikole'),
				'param_name' => 'icon_color',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-font' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon: Font Size', 'agrikole'),
				'param_name' => 'icon_font_size',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-font' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon: Padding', 'agrikole'),
				'param_name' => 'icon_padding',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'description'	=> esc_html__('Top Right Bottom Left. Default: 0px 12px 0px 12px', 'agrikole'),
				'dependency' => array( 'element' => 'icon_display', 'value' => 'icon-font' ),
	        ),
	        // Spacing
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon: Top Margin', 'agrikole'),
				'param_name' => 'icon_top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Line: Top Margin', 'agrikole'),
				'param_name' => 'top_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Line: Bottom Margin', 'agrikole'),
				'param_name' => 'bottom_margin',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
	        ),
        )
    ) );
} );

// Alignment Box
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_alignbox extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Alignment Box', 'agrikole' ),
        'description' => esc_html__('Align elements.', 'agrikole'),
		'base'        => 'alignbox',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array('except' => 'alignbox'),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => 'left',
					'Right' => 'right',
					'Center' => 'center',
				),
				'std'		=> 'center',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment on Mobile', 'agrikole' ),
				'param_name' => 'alignment_mobi',
				'value'      => array(
					'Left' => 'left',
					'Right' => 'right',
					'Center' => 'center',
				),
				'std'		=> 'center',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Hide on Mobile?', 'agrikole' ),
				'param_name' => 'mobi_hide',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
		)
	) );
} );

// Grid Box
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_gridbox extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
    vc_map( array(
		'name' => esc_html__('Grid Box', 'agrikole'),
		'description' => esc_html__('Grid Box.', 'agrikole'),
		'base' => 'gridbox',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array('except' => 'gridbox'),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Grid', 'agrikole' ),
				'param_name' => 'grid',
				'value'      => array(
					'Grid 4' => '4',
					'Grid 3' => '3',
					'Grid 2' => '2',
				),
				'std'		=> '3',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Border Type?', 'agrikole' ),
				'param_name' => 'border_type',
				'value' => array(
					'Separator' => 'separator',
					'Wrap' => 'wrap',
					'No Border' => 'no',
				),
				'std'		=> 'separator',
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Border Color', 'agrikole' ),
				'param_name' => 'border_color',
				'value' => array(
					'Light' => 'light',
					'Dark' => 'dark',
				),
				'std'		=> 'light',
				'dependency' => array( 'element' => 'border_type', 'value' => array('separator', 'wrap') ),
			),
			array(
				'type'       => 'dropdown',
				'heading' => esc_html__('Spacing between items', 'agrikole'),
				'param_name' => 'gapv',
				'value'      => array(
					'0' => '0',
					'5' => '5',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
					'45' => '45',
					'50' => '50',
					'55' => '55',
					'60' => '60',
				),
				'std'		=> '30',
				'dependency' => array( 'element' => 'border_type', 'value' => 'no' ),
			),
			array(
				'type'       => 'dropdown',
				'heading' => esc_html__('Spacing below items', 'agrikole'),
				'param_name' => 'gaph',
				'value'      => array(
					'0' => '0',
					'5' => '5',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
					'45' => '45',
					'50' => '50',
					'60' => '60',
				),
				'std'		=> '15',
				'dependency' => array( 'element' => 'border_type', 'value' => 'no' ),
			),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
        )
    ) );
} );

// Buttons
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Buttons', 'agrikole'),
        'description' => esc_html__('Advanced Buttons.', 'agrikole'),
        'base' => 'buttons',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
            array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__('Text', 'agrikole'),
				'param_name' => 'text',
				'value' => 'Button Text',
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Size', 'agrikole' ),
				'param_name' => 'size',
				'value'      => array(
					'Medium' => 'medium',
					'Small' => 'small',
					'Big' => 'big',
				),
				'std'		=> 'medium',
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text Color', 'agrikole'),
				'param_name' => 'text_color',
				'value' => '',
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color', 'agrikole'),
				'param_name' => 'background_color',
				'value' => '',
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color', 'agrikole'),
				'param_name' => 'border_color',
				'value' => '',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Border Width', 'agrikole'),
				'param_name' => 'border_width',
				'value' => '1px',
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Border Style', 'agrikole' ),
				'param_name' => 'border_style',
				'value'      => array(
					'Solid' => 'solid',
					'Dotted' => 'dotted',
					'Dashed' => 'dashed'
				),
				'std'		=> 'solid',
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Rounded', 'agrikole'),
				'param_name' => 'rounded',
				'value' => '',
				'description'	=> esc_html__('ex: 10px', 'agrikole'),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Padding', 'agrikole'),
				'param_name' => 'padding',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left. Ex: 13px 40px 13px 40px', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Margin', 'agrikole'),
				'param_name' => 'margin',
				'value' => '',
				'description'	=> esc_html__('Top Right Bottom Left.', 'agrikole'),
	        ),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Full-width Button?', 'agrikole' ),
				'param_name' => 'full_width',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
	        // Animation
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Enable Animation?', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation_effect',
				'value'      => array(
					'Fade In Up' => 'fadeInUp',
					'Fade In Down' => 'fadeInDown',
					'Fade In' => 'fadeIn',
					'Fade In Left' => 'fadeInLeft',
					'Fade In Right' => 'fadeInRight',
				),
				'std'		=> 'fadeInUp',
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Duration', 'agrikole'),
				'param_name' => 'animation_duration',
				'value' => '0.75s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Animation Delay', 'agrikole'),
				'param_name' => 'animation_delay',
				'value' => '0.3s',
				'description'	=> esc_html__('Ex: 0.1s, 0.15s', 'agrikole'),
				'dependency' => array( 'element' => 'animation', 'value' => 'yes' ),
            ),
			// Hover
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text Color: Hover', 'agrikole'),
				'param_name' => 'text_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Background Color: Hover', 'agrikole'),
				'param_name' => 'background_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Border Color: Hover', 'agrikole'),
				'param_name' => 'border_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color: Hover', 'agrikole'),
				'param_name' => 'icon_color_hover',
				'value' => '',
				'group' => esc_html__( 'Hover', 'agrikole' ),
            ),
			// Icon
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Style', 'agrikole' ),
				'param_name' => 'icon_style',
				'value'      => array(
					'No Icon' => 'no_icon',
					'Icon Style 1' => 'icon_style_1',
					'Icon Style 2' => 'icon_style_2',
					'Custom Icon' => 'custom',
				),
				'std'		=> 'no_icon',
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Icon library', 'agrikole' ),
				'param_name' => 'icon_type',
				'description' => esc_html__( 'Select icon library.', 'agrikole' ),
				'value' => array(
					esc_html__( '', 'agrikole' ) => '',
					esc_html__( 'Agrikole Icons', 'agrikole' ) => 'extraicon',
					esc_html__( 'Stroke 7 Icons', 'agrikole' ) => 'extraicon2',
					esc_html__( 'FontAwesome', 'agrikole' ) => 'fontawesome',
					esc_html__( 'Open Iconic', 'agrikole' ) => 'openiconic',
					esc_html__( 'Typicons', 'agrikole' ) => 'typicons',
					esc_html__( 'Entypo', 'agrikole' ) => 'entypo',
					esc_html__( 'Linecons', 'agrikole' ) => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_style', 'value' => 'custom' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
			    'type' => 'iconpicker',
			    'heading' => esc_html__( 'Icon', 'agrikole' ),
			    'param_name' => 'icon_extraicon2',
			    'settings' => array(
			        'emptyIcon' => true,
			        'type' => 'extraicon2',
			        'iconsPerPage' => 200,
			    ),
			    'dependency' => array(
			        'element' => 'icon_type',
			        'value' => 'extraicon2',
			    ),
			    'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon',
				'settings' => array(
					'emptyIcon' => true,
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'fontawesome',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_openiconic',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'openiconic',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'openiconic',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_typicons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'typicons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'typicons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_entypo',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'entypo',
					'iconsPerPage' => 300,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'entypo',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => esc_html__( 'Icon', 'agrikole' ),
				'param_name' => 'icon_linecons',
				'settings' => array(
					'emptyIcon' => true,
					'type' => 'linecons',
					'iconsPerPage' => 200,
				),
				'dependency' => array(
					'element' => 'icon_type',
					'value' => 'linecons',
				),
				'group' => esc_html__( 'Icon', 'agrikole' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Icon Color', 'agrikole'),
				'param_name' => 'icon_color',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_style', 'value' => 'custom' ),
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Font Size', 'agrikole'),
				'param_name' => 'icon_font_size',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_style', 'value' => 'custom' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon Position', 'agrikole' ),
				'param_name' => 'icon_position',
				'value'      => array(
					'Icon Left' => 'icon-left',
					'Icon Right' => 'icon-right',
				),
				'std'		=> 'icon-right',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'dependency' => array( 'element' => 'icon_style', 'value' => 'custom' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon: Right Padding', 'agrikole'),
				'param_name' => 'icon_right_padding',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'description'	=> esc_html__('Spacing between the icon and the text. Ex: 40px.', 'agrikole'),
				'dependency' => array( 'element' => 'icon_position', 'value' => 'icon-left' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Icon Left Padding', 'agrikole'),
				'param_name' => 'icon_left_padding',
				'value' => '',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'description'	=> esc_html__('Spacing between the icon and the text. Ex: 40px.', 'agrikole'),
				'dependency' => array( 'element' => 'icon_position', 'value' => 'icon-right' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Icon: Offset', 'agrikole' ),
				'param_name' => 'icon_offset',
				'value'      => array(
					'-15px' => '-15',
					'-14px' => '-14',
					'-13px' => '-13',
					'-12px' => '-12',
					'-11px' => '-11',
					'-10px' => '-10',
					'-9px' => '-9',
					'-8px' => '-8',
					'-7px' => '-7',
					'-6px' => '-6',
					'-5px' => '-5',
					'-4px' => '-4',
					'-3px' => '-3',
					'-2px' => '-2',
					'-1px' => '-1',
					'0px' => '0',
					'1px' => '1',
					'2px' => '2',
					'3px' => '3',
					'4px' => '4',
					'5px' => '5',
					'6px' => '6',
					'7px' => '7',
					'8px' => '8',
					'9px' => '9',
					'10px' => '10',
					'11px' => '11',
					'12px' => '12',
					'13px' => '13',
					'14px' => '14',
					'15px' => '15',
				),
				'std'		=> '0',
				'group' => esc_html__( 'Icon', 'agrikole' ),
				'description'	=> esc_html__('Use this to change the distance middle the icon and top of button.', 'agrikole'),
				'dependency' => array( 'element' => 'icon_style', 'value' => 'custom' ),
			),
	        // Hyperlink
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Link (URL):', 'agrikole'),
				'param_name' => 'link_url',
				'value' => '',
				'group' => esc_html__( 'Hyperlink', 'agrikole' ),
            ),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Open Link in a new Tab', 'agrikole' ),
				'param_name' => 'new_tab',
				'group' => esc_html__( 'Hyperlink', 'agrikole' ),
				'value' => array(
					'Yes' => 'yes',
					'No' => 'no',
				),
				'std'		=> 'yes',
			),
			// Box Shadow
			array(
				'type' => 'headings',
				'text' => esc_html__('Box Shadow', 'agrikole'),
				'param_name' => 'heading_shadow',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Option Shadow', 'agrikole' ),
				'param_name'  => 'inset',
				'value'       => array(
					'Outset'   => '',
					'Inset'   => 'inset',
				),
				'std'		=> '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Horizontal (Required)', 'agrikole'),
				'param_name' => 'horizontal',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Vertical (Required)', 'agrikole'),
				'param_name' => 'vertical',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Blur (Required)', 'agrikole'),
				'param_name' => 'blur',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spread (Required)', 'agrikole'),
				'param_name' => 'spread',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
	        ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Shadow Color (Required)', 'agrikole'),
				'param_name' => 'shadow_color',
				'value' => '',
				'group' => esc_html__( 'Box Shadow', 'agrikole' ),
            ),
	        // Typography
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Family', 'agrikole' ),
				'param_name' => 'font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Weight', 'agrikole' ),
				'param_name' => 'font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Font Size', 'agrikole'),
				'param_name' => 'font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Line-Height', 'agrikole'),
				'param_name' => 'line_height',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
        )
    ) );
} );

// Hero Section
add_action( 'vc_before_init', function() {
    class WPBakeryShortCode_hero extends WPBakeryShortCodesContainer {}
} );
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Hero Section', 'agrikole'),
        'description' => esc_html__('Hero Section.', 'agrikole'),
        'base' => 'hero',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
		'as_parent' => array('except' => 'hero'),
		'controls' => 'full',
		'show_settings_on_create' => true,
		'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'js_view' => 'VcColumnView',
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Hero Height', 'agrikole' ),
				'param_name' => 'hero_height',
				'value'      => array(
					'Full Screen' => 'full-height',
					'Custom Height' => 'custom-height',
				),
				'std'		=> 'full-height',
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Hero Custom Height', 'agrikole'),
				'param_name' => 'hero_custom_height',
				'value' => '',
				'description'	=> esc_html__('Ex: 600px.', 'agrikole'),
				'dependency' => array( 'element' => 'hero_height', 'value' => 'custom-height' ),
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Showcase', 'agrikole' ),
				'param_name' => 'showcase',
				'value'      => array(
					'Background Slideshow' => 'slideshow',
					'Background Video' => 'video',
				),
				'std'		=> 'slideshow',
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__('Background Images', 'agrikole'),
				'param_name' => 'images',
				'value' => '',
				'description' => esc_html__('Choose multi-images for background slideshow.', 'agrikole'),
				'dependency' => array( 'element' => 'showcase', 'value' => 'slideshow' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Effects', 'agrikole' ),
				'param_name' => 'effect',
				'value'      => array(
					'fade' => 'fade',
					'fade2' => 'fade2',
					'slideLeft' => 'slideLeft',
					'slideLeft2' => 'slideLeft2',
					'slideRight' => 'slideRight',
					'slideRight2' => 'slideRight2',
					'slideUp' => 'slideUp',
					'slideDown' => 'slideDown',
					'slideDown2' => 'slideDown2',
					'zoomIn' => 'zoomIn',
					'zoomIn2' => 'zoomIn2',
					'zoomOut' => 'zoomOut',
					'zoomOut2' => 'zoomOut2',
					'swirlLeft' => 'swirlLeft',
					'swirlLeft2' => 'swirlLeft2',
					'swirlRight' => 'swirlRight',
					'swirlRight2' => 'swirlRight2',
					'burn' => 'burn',
					'burn2' => 'burn2',
					'blur' => 'blur',
					'blur2' => 'blur2',
					'flash' => 'flash',
					'flash2' => 'flash2'
				),
				'std'		=> 'fade',
				'dependency' => array( 'element' => 'showcase', 'value' => 'slideshow' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Youtube link (URL)', 'agrikole'),
				'param_name' => 'video_link',
				'value' => '',
				'description' => esc_html__('Youtube link or ID. Ex: https://www.youtube.com/watch?v=vQqZIFCab9o', 'agrikole'),
				'dependency' => array( 'element' => 'showcase', 'value' => 'video' ),
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Pattern Overlay', 'agrikole' ),
				'param_name' => 'pattern_overlay',
				'value'      => array(
					'No Parttern' => '',
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
					'Style 3' => 'style-3',
					'Style 4' => 'style-4',
					'Style 5' => 'style-5',
					'Style 6' => 'style-6',
					'Style 7' => 'style-7',
					'Style 8' => 'style-8',
					'Style 9' => 'style-9',
				),
				'std'		=> 'style-1',
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Color Overlay', 'agrikole'),
				'param_name' => 'color_overlay',
				'value' => '',
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Content Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => 'text-left',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> 'text-center',
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Content: Top Margin', 'agrikole'),
				'param_name' => 'content_top',
				'value' => '',
				'description'	=> esc_html__('Ex: 50px. In case you want to set a spacing above the content area.', 'agrikole'),
            ),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Content area into Grid?', 'agrikole' ),
				'param_name' => 'grid',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			// Arrow
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show arrow?', 'agrikole' ),
				'param_name' => 'scroll',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
				'group' => esc_html__( 'Arrow', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrow Style', 'agrikole' ),
				'param_name' => 'arrow_style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
				),
				'std'		=> 'style-1',
				'group' => esc_html__( 'Arrow', 'agrikole' ),
				'dependency' => array( 'element' => 'scroll', 'value' => 'yes' ),
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Scroll to Row (ID)', 'agrikole'),
				'param_name' => 'scroll_id',
				'value' => '',
				'description' => esc_html__('Enter the anchor ID you assigned to the element.', 'agrikole'),
				'group' => esc_html__( 'Arrow', 'agrikole' ),
				'dependency' => array( 'element' => 'scroll', 'value' => 'yes' ),
            ),
        )
    ) );
} );

// Images Grid
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name' => esc_html__( 'Images Grid', 'agrikole' ),
		'description' => esc_html__('Displaying images masonry or mosaic grid.', 'agrikole'),
		'base' => 'imagesgrid',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Layout', 'agrikole' ),
				'param_name' => 'mode',
				'value'      => array(
					'Masonry' => 'grid',
					'Mosaic' => 'mosaic',
				),
				'std'		=> 'grid',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Cropping', 'agrikole' ),
				'param_name' => 'image_crop',
				'value'      => array(
					'Full' => 'full',
					'640 x 640' => 'std1',
					'640 x 430' => 'std2',
					'370 x 370' => 'square',
					'370 x 484' => 'rectangle',
					'370 x 400' => 'rectangle2',
					'465 x 603' => 'rectangle3'	
				),
				'std'		=> 'full',
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__('Images', 'agrikole'),
				'param_name' => 'images',
				'value' => '',
				'description' => esc_html__('Choose multi-images for Images Grid.', 'agrikole')
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Image Rounded', 'agrikole'),
				'param_name' => 'rounded',
				'value' => '',
				'description'	=> esc_html__('ex: 10px', 'agrikole'),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing between items', 'agrikole'),
				'param_name' => 'gapv',
				'value' => '0',
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing below items', 'agrikole'),
				'param_name' => 'gaph',
				'value' => '0',
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'If Wrap > 1100px.', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Column Options', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
					'7 Columns' => '7c',
				),
				'std'		=> '4c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'If Wrap from 800px to 1099px.', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Column Options', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'If Wrap from 550px to 799px.', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Column Options', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'If Wrap < 549px.', 'agrikole' ),
				'param_name' => 'column4',
				'group'      => esc_html__( 'Column Options', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '1c',
			),
		)
	) );
} );

// Images Carousel
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name' => esc_html__( 'Images Carousel', 'agrikole' ),
		'description' => esc_html__('Displaying images in carousel.', 'agrikole'),
		'base' => 'imagescarousel',
		'weight'	=>	180,
		'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Image Cropping', 'agrikole' ),
				'param_name' => 'image_crop',
				'value'      => array(
					'Full' => 'full',
					'640 x 640' => 'std1',
					'640 x 430' => 'std2',
					'370 x 370' => 'square',
					'370 x 480' => 'rectangle',
					'370 x 400' => 'rectangle2',
					'370 x 310' => 'rectangle3'
				),
				'std'		=> 'full',
			),
			array(
				'type' => 'attach_images',
				'heading' => esc_html__('Images', 'agrikole'),
				'param_name' => 'images',
				'value' => '',
				'description' => esc_html__('Choose multi-images for Images Grid.', 'agrikole')
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Border?', 'agrikole' ),
				'param_name' => 'show_borders',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Auto Scroll?', 'agrikole' ),
				'param_name' => 'auto_scroll',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Query', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Infinity Loop?', 'agrikole' ),
				'param_name' => 'loop',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Duplicate last and first items to get loop illusion.', 'agrikole'),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Item: Spacing Between', 'agrikole'),
				'param_name' => 'gap',
				'value' => '30',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
	        // Controls
			array(
				'type' => 'headings',
				'text' => esc_html__('Arrows', 'agrikole'),
				'param_name' => 'arrows_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Arrows?', 'agrikole' ),
				'param_name' => 'show_arrows',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrow Position', 'agrikole' ),
				'param_name' => 'arrow_position',
				'value'      => array(
					'Center' => 'center',
					'Bottom' => 'bottom',
				),
				'std'		=> 'center',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			// Column
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen > 1000px', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
					'7 Columns' => '7c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen from 600px to 1000px', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen < 600px', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '1c',
			),
		)
	) );
} );

// Scroll Target
add_action( 'vc_before_init', function() {
	vc_map( array(
		'name'        => esc_html__( 'Scroll to ID Target', 'agrikole' ),
        'description' => esc_html__('Displaying a arrow for scrolling down when clicked.', 'agrikole'),
		'base'        => 'scrolltarget',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
		'params'      => array(
            array(
				'type' => 'textfield',
				'heading' => esc_html__('ID Target', 'agrikole'),
				'param_name' => 'id_target',
				'value' => '',
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Color', 'agrikole'),
				'param_name' => 'color',
				'value' => '',
            ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Size', 'agrikole'),
				'param_name' => 'size',
				'value' => '',
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> 'text-center',
			),
		)
	) );
} );

// Special Text
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Special Text', 'agrikole'),
        'description' => esc_html__('Awesome Texts.', 'agrikole'),
        'base' => 'specialtext',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => 'text-left',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> 'text-left',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Tag', 'agrikole' ),
				'param_name' => 'tag',
				'value'      => array(
					'Div' => 'div',
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'		=> 'div',
			),
			array(
				'type' => 'textfield',
				'holder' => 'span',
				'heading' => esc_html__( 'Text 1 (Optional)', 'agrikole' ),
				'param_name' => 'text1',
			),
			array(
				'type' => 'textfield',
				'holder' => 'span',
				'heading' => esc_html__( 'Text 2 (Optional)', 'agrikole' ),
				'param_name' => 'text2',
			),
			array(
				'type' => 'textfield',
				'holder' => 'span',
				'heading' => esc_html__( 'Text 3 (Optional)', 'agrikole' ),
				'param_name' => 'text3',
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text 1 Color', 'agrikole'),
				'param_name' => 'color1',
				'value' => '',
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text 2 Color', 'agrikole'),
				'param_name' => 'color2',
				'value' => '',
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text 3 Color', 'agrikole'),
				'param_name' => 'color3',
				'value' => '',
            ),
			// Typography
			array(
				'type' => 'headings',
				'text' => esc_html__('Text 1', 'agrikole'),
				'param_name' => 'text1_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 1: Font Family', 'agrikole' ),
				'param_name' => 'text1_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 1: Font Weight', 'agrikole' ),
				'param_name' => 'text1_font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text 1: Font Size', 'agrikole'),
				'param_name' => 'text1_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 1: Font Style', 'agrikole' ),
				'param_name' => 'text1_font_style',
				'value'      => array(
					'Normal' => '',
					'Italic' => 'italic',
				),
				'std'		=> '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Text 2', 'agrikole'),
				'param_name' => 'text2_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 2: Font Family', 'agrikole' ),
				'param_name' => 'text2_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 2: Font Weight', 'agrikole' ),
				'param_name' => 'text2_font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text 2: Font Size', 'agrikole'),
				'param_name' => 'text2_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 2: Font Style', 'agrikole' ),
				'param_name' => 'text2_font_style',
				'value'      => array(
					'Normal' => '',
					'Italic' => 'italic',
				),
				'std'		=> '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Text 3', 'agrikole'),
				'param_name' => 'text3_typograpy',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 3: Font Family', 'agrikole' ),
				'param_name' => 'text3_font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 3: Font Weight', 'agrikole' ),
				'param_name' => 'text3_font_weight',
				'value'      => array(
					'Default' => 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Text 3: Font Size', 'agrikole'),
				'param_name' => 'text3_font_size',
				'value' => '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text 3: Font Style', 'agrikole' ),
				'param_name' => 'text3_font_style',
				'value'      => array(
					'Normal' => '',
					'Italic' => 'italic',
				),
				'std'		=> '',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			// Spacing
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Text 1: Right Padding', 'agrikole'),
				'param_name' => 'text1_right_padding',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
            ),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Text 2: Right Padding', 'agrikole'),
				'param_name' => 'text2_right_padding',
				'value' => '',
				'group' => esc_html__( 'Spacing', 'agrikole' ),
            ),
        )
    ) );
} );

// Fancy Text
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Fancy Text', 'agrikole'),
        'description' => esc_html__('Awesome Animation Text.', 'agrikole'),
        'base' => 'fancytext',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Text Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
					'Right' => 'text-right',
				),
				'std'		=> 'text-center',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Animation', 'agrikole' ),
				'param_name' => 'animation',
				'value'      => array(
					'Scrolling' => 'scroll',
					'Typing' => 'typed',
				),
				'std'		=> 'scroll',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Text 1 (Optional)', 'agrikole' ),
				'param_name' => 'text1',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Text 2 (Optional)', 'agrikole' ),
				'param_name' => 'text2',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Text 3 (Optional)', 'agrikole' ),
				'param_name' => 'text3',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Text 4 (Optional)', 'agrikole' ),
				'param_name' => 'text4',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Text 5 (Optional)', 'agrikole' ),
				'param_name' => 'text5',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Prefix Text (Optional)', 'agrikole' ),
				'param_name' => 'prefix_text',
				'group' => esc_html__( 'Prefix & Suffix', 'agrikole' ),
				'dependency' => array( 'element' => 'animation', 'value' => 'typed' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Suffix Text (Optional)', 'agrikole' ),
				'param_name' => 'suffix_text',
				'group' => esc_html__( 'Prefix & Suffix', 'agrikole' ),
				'dependency' => array( 'element' => 'animation', 'value' => 'typed' ),
			),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Text Color', 'agrikole'),
				'param_name' => 'text_color',
				'value' => '',
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Prefix Text Color', 'agrikole'),
				'param_name' => 'prefix_color',
				'value' => '',
				'group' => esc_html__( 'Prefix & Suffix', 'agrikole' ),
				'dependency' => array( 'element' => 'animation', 'value' => 'typed' ),
            ),
            array(
				'type' => 'colorpicker',
				'heading' => esc_html__('Suffix Text Color', 'agrikole'),
				'param_name' => 'suffix_color',
				'value' => '',
				'group' => esc_html__( 'Prefix & Suffix', 'agrikole' ),
				'dependency' => array( 'element' => 'animation', 'value' => 'typed' ),
            ),
	        // Typography
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Tag', 'agrikole' ),
				'param_name' => 'tag',
				'value'      => array(
					'H1' => 'h1',
					'H2' => 'h2',
					'H3' => 'h3',
					'H4' => 'h4',
					'H5' => 'h5',
					'H6' => 'h6',
				),
				'std'		=> 'h2',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Family', 'agrikole' ),
				'param_name' => 'font_family',
				'value'      =>  agrikole_plugin_google_font(),
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Font Weight', 'agrikole' ),
				'param_name' => 'font_weight',
				'value'      => array(
					'Default'		=> 'Default',
					'300' => '300',
					'400' => '400',
					'500' => '500',
					'600' => '600',
					'700' => '700',
					'800' => '800',
					'900' => '900',
				),
				'std'		=> 'Default',
				'group' => esc_html__( 'Typography', 'agrikole' ),
			),
			array(
				'type' => 'number',
				'heading' => esc_html__( 'Font Size: Max', 'agrikole' ),
				'param_name' => 'font_max',
				'value' => 70,
				'suffix' => 'px',
				'group' => esc_html__( 'Typography', 'agrikole' ),
				'description'	=> esc_html__('Important! This size only appear exactly on the full-width grid, 65px max-size on the 1170 grid and 32px max-size on the 570px grid.', 'agrikole'),
		  	),
		  	array(
				'type' => 'number',
				'heading' => esc_html__( 'Font Size: Min', 'agrikole' ),
				'param_name' => 'font_min',
				'value' => 22,
				'suffix' => 'px',
				'group' => esc_html__( 'Typography', 'agrikole' ),
		  	),
        )
    ) );
} );

// Partner Carousel
add_action( 'vc_before_init', function() {
	vc_map( array(
	    'name' => esc_html__('Partner Carousel', 'agrikole'),
	    'description' => esc_html__('Displaying partner posts in carousel.', 'agrikole'),
	    'base' => 'partners',
		'weight'	=>	180,
	    'icon' => plugins_url('assets/icon.png', __FILE__),
	    'category' => esc_html__('WPRT VC Addons', 'agrikole'),
	    'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
					'Style 3' => 'style-3',
				),
				'std'		=> 'style-1',
			),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Spacing between items', 'agrikole'),
				'param_name' => 'gap',
				'value' => '10',
	        ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Auto Scroll?', 'agrikole' ),
				'param_name' => 'auto_scroll',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Infinity Loop?', 'agrikole' ),
				'param_name' => 'loop',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'description'	=> esc_html__('Duplicate last and first items to get loop illusion.', 'agrikole'),
			),
			// Query
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number of items', 'agrikole'),
				'param_name' => 'items',
				'value' => '5',
				'group' => esc_html__( 'Query', 'agrikole' ),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Category Slug', 'agrikole'),
				'param_name' => 'cat_slug',
				'value' => '',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Only show posts from specific category-slug (optional).', 'agrikole'),
	        ),
	        // Controls
			array(
				'type' => 'headings',
				'text' => esc_html__('Bullets', 'agrikole'),
				'param_name' => 'bullets_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Bullets?', 'agrikole' ),
				'param_name' => 'show_bullets',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Space between Bullets & Images', 'agrikole' ),
				'param_name' => 'bullet_between',
				'value'      => array(
					'50px' => '50',
					'45px' => '45',
					'40px' => '40',
					'35px' => '35',
					'30px' => '30',
					'25px' => '25',
					'20px' => '20',
					'15px' => '15',
					'10px' => '10',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Bullets Show', 'agrikole' ),
				'param_name' => 'bullet_show',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'Square' => 'bullet-square',
					'Circle' => 'bullet-circle',
				),
				'std'		=> 'bullet-square',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Arrows', 'agrikole'),
				'param_name' => 'arrows_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Arrows?', 'agrikole' ),
				'param_name' => 'show_arrows',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-40' => '-40',
					'-35' => '-35',
					'-30' => '-30',
					'-25' => '-25',
					'-20' => '-20',
					'-15' => '-15',
					'-10' => '-10',
					'Center' => 'center',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
				),
				'std'		=> 'center',
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Vertical', 'agrikole' ),
				'param_name' => 'arrow_offset_v',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-120' => '-120',
					'-110' => '-110',
					'-100' => '-100',
					'-90' => '-90',
					'-80' => '-80',
					'-70' => '-70',
					'-60' => '-60',
					'-50' => '-50',
					'-40' => '-40',
					'-30' => '-30',
					'-20' => '-20',
					'0' => '0',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'80' => '80',
					'90' => '90',
					'100' => '100',
					'110' => '110',
					'120' => '120',
				),
				'std'		=> '0',
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen > 1000px', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
					'7 Columns' => '7c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen from 600px to 1000px', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen < 600px', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '1c',
			),
	    )
	) );
} );

// Share Icons
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Share Socials', 'agrikole'),
        'description' => esc_html__('Share Socials.', 'agrikole'),
        'base' => 'shareicons',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value' => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
				),
				'std'		=> 'style-1',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Facebook?', 'agrikole' ),
				'param_name' => 'facebook',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Twitter?', 'agrikole' ),
				'param_name' => 'twitter',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Pinterest?', 'agrikole' ),
				'param_name' => 'pinterest',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Linkedin?', 'agrikole' ),
				'param_name' => 'linkedin',
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
        )
    ) );
} );

// Subscribe Form
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Subscribe Form', 'agrikole'),
        'description' => esc_html__('Displaying mailchimp newsletter form.', 'agrikole'),
        'base' => 'subscribe',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'agrikole' ),
				'param_name' => 'style',
				'value'      => array(
					'Style 1' => 'style-1',
					'Style 2' => 'style-2',
				),
				'std'		=> 'style-1',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Alignment', 'agrikole' ),
				'param_name' => 'alignment',
				'value'      => array(
					'Left' => '',
					'Center' => 'text-center',
				),
				'std'		=> '',
			),
            array(
				'type' => 'textfield',
				'heading' => esc_html__('Max-Width', 'agrikole'),
				'param_name' => 'width',
				'value' => '',
            ),
        )
    ) );
} );

// Products Carousel
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('Products Carousel', 'agrikole'),
        'description' => esc_html__('Displaying products in carousel.', 'agrikole'),
        'base' => 'dproducts',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
	        // Query
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Number', 'agrikole'),
				'param_name' => 'number',
				'value' => '4',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('The number of campaigns to show.', 'agrikole'),
	        ),
	        array(
				'type' => 'textfield',
				'heading' => esc_html__('Item: Space Between', 'agrikole'),
				'param_name' => 'gap',
				'value' => '30',
				'group' => esc_html__( 'Query', 'agrikole' ),
				'description'	=> esc_html__('Important! Include the blur distance of the shadow.', 'agrikole'),
	        ),
	        // Controls
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Item: Auto Scroll?', 'agrikole' ),
				'param_name' => 'auto_scroll',
				'value'      => array(
					'No' => 'false',
					'Yes' => 'true',
				),
				'std'		=> 'false',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Bullets', 'agrikole'),
				'param_name' => 'bullets_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Bullets?', 'agrikole' ),
				'param_name' => 'show_bullets',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Space between Bullets & Images', 'agrikole' ),
				'param_name' => 'bullet_between',
				'value'      => array(
					'50px' => '50',
					'45px' => '45',
					'40px' => '40',
					'35px' => '35',
					'30px' => '30',
					'25px' => '25',
					'20px' => '20',
					'15px' => '15',
					'10px' => '10',
				),
				'std'		=> '50',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Bullets Show', 'agrikole' ),
				'param_name' => 'bullet_show',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'Square' => 'bullet-square',
					'Circle' => 'bullet-circle',
				),
				'std'		=> 'bullet-square',
				'dependency' => array( 'element' => 'show_bullets', 'value' => 'yes' ),
			),
			array(
				'type' => 'headings',
				'text' => esc_html__('Arrows', 'agrikole'),
				'param_name' => 'arrows_heading',
				'group' => esc_html__( 'Controls', 'agrikole' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Arrows?', 'agrikole' ),
				'param_name' => 'show_arrows',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array( esc_html__( 'Yes, please.', 'agrikole' ) => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Horizontal', 'agrikole' ),
				'param_name' => 'arrow_offset',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-40' => '-40',
					'-35' => '-35',
					'-30' => '-30',
					'-25' => '-25',
					'-20' => '-20',
					'-15' => '-15',
					'-10' => '-10',
					'Center' => 'center',
					'10' => '10',
					'15' => '15',
					'20' => '20',
					'25' => '25',
					'30' => '30',
					'35' => '35',
					'40' => '40',
				),
				'std'		=> 'center',
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Arrows Offset: Vertical', 'agrikole' ),
				'param_name' => 'arrow_offset_v',
				'group' => esc_html__( 'Controls', 'agrikole' ),
				'value'      => array(
					'-120' => '-120',
					'-110' => '-110',
					'-100' => '-100',
					'-90' => '-90',
					'-80' => '-80',
					'-70' => '-70',
					'-60' => '-60',
					'-50' => '-50',
					'-40' => '-40',
					'-30' => '-30',
					'-20' => '-20',
					'0' => '0',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50',
					'60' => '60',
					'70' => '70',
					'80' => '80',
					'90' => '90',
					'100' => '100',
					'110' => '110',
					'120' => '120',
				),
				'std'		=> '0',
				'dependency' => array( 'element' => 'show_arrows', 'value' => 'yes' ),
			),
			// Columns
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen > 1000px.', 'agrikole' ),
				'param_name' => 'column',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
					'6 Columns' => '6c',
					'7 Columns' => '7c',
				),
				'std'		=> '3c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen from 600px to 1000px.', 'agrikole' ),
				'param_name' => 'column2',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
					'5 Columns' => '5c',
				),
				'std'		=> '2c',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Screen < 600px.', 'agrikole' ),
				'param_name' => 'column3',
				'group'      => esc_html__( 'Columns', 'agrikole' ),
				'value'      => array(
					'1 Column' => '1c',
					'2 Columns' => '2c',
					'3 Columns' => '3c',
					'4 Columns' => '4c',
				),
				'std'		=> '1c',
			),
        )
    ) );
} );

// Countdown
add_action( 'vc_before_init', function() {
    vc_map( array(
        'name' => esc_html__('CountDown', 'agrikole'),
        'description' => esc_html__('Displaying Countdown Timer.', 'agrikole'),
        'base' => 'countdown',
		'weight'	=>	180,
        'icon' => plugins_url('assets/icon.png', __FILE__),
        'category' => esc_html__('WPRT VC Addons', 'agrikole'),
        'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'heading' => esc_html__( 'Time', 'agrikole' ),
				'param_name' => 'time',
				'value' => 'December 30, 2020 8:30:00'
			),
        )
    ) );
} );