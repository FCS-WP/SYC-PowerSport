<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = $css = $data = $heading_css = $heading_cls = $desc_css = $link_html = $url_wrap_css = $link_cls = $link_css = $button_css = $button_cls = $button_data = '';
$content_html = $text_css = $inner_css = $icon_offset = $icon = $icon_css = $icon_cls = $icon_html = $icon_data = $hover_html = $hover_css = $image_css = '';

extract( shortcode_atts( array(
	'style' => 'icon-top',
	'text_align' => 'align-left',
	'icon_display' => 'icon-font',
	'wrap_background' => '',
	'wrap_bg_image' => '',
	'wrap_padding' => '',
	'wrap_margin' => '',
	'wrap_rounded' => '',
	'wrap_border' => '#e7e7e7',
	'wrap_border_width' => '',
	'wrap_border_style' => 'solid',
	'animation' => '',
	'animation_effect' => 'fadeInUp',
	'animation_duration' => '0.75s',
	'animation_delay' => '0.3s',
	'image' => '',
	'image_width' => '',
	'show_number' => '',
	'icon_number' => '',
	'icon_text' => '',
	'icon_showcase' => 'simple',
	'icon_type' => '',
	'icon_font_size' => '30px',
	'icon_color' => '',
	'icon_width' => '60',
	'icon_height' => '60',
	'icon_line_height' => '',
	'icon_rounded' => '',
	'icon_color' => '',
	'icon_background' => '',
	'icon_border' => '',
	'icon_border_width' => '',
	'icon_border_style' => 'solid',
	'icon_color_hover' => '',
	'icon_background_hover' => '',
	'icon_border_hover' => '',
	'tag' => 'h3',
	'heading' => '',
	'heading_url' => '',
	'heading_color' => '',
	'description' => '',
	'desc_color' => '',
	'show_url' => '',
	'url_style' => 'link',
	'link_style' => 'link-style-1',
	'link_color' => 'link-color-accent',
	'link_text' => 'READ MORE',
	'link_url' => '',
	'new_tab' => 'yes',
	'button_size' => 'medium',
	'button_rounded' => '',
	'button_text_color' => '',
	'button_background' => '',
    'button_border_width' => '1px',
    'button_border_style' => 'solid',
	'button_border' => '',
	'button_text_hover' => '',
	'button_background_hover' => '',
	'button_border_hover' => '',
	'heading_font_family' => 'Default',
	'heading_font_weight' => 'Default',
	'heading_font_size' => '',
	'heading_line_height' => '',
	'desc_font_family' => 'Default',
	'desc_font_weight' => 'Default',
	'desc_font_size' => '',
	'desc_line_height' => '',
	'button_font_family' => 'Default',
	'button_font_weight' => 'Default',
	'button_font_size' => '',
	'icon_top_margin' => '',
	'content_left_padding' => '85px',
	'content_right_padding' => '85px',
	'heading_left_margin' => '85px',
	'heading_top_margin' => '',
	'heading_bottom_margin' => '',
	'desc_top_margin' => '',
	'desc_bottom_margin' => '',
	'hover_style' => '',
	'bg_color' => '',
	'bg_image' => '',
	'icon_inset' => '',
	'icon_horizontal' => '',
	'icon_vertical' => '',
	'icon_blur' => '',
	'icon_spread' => '',
	'icon_shadow_color' => '',
	'link_hover_color' => 'link-hover-accent'
), $atts ) );
$content = wpb_js_remove_wpautop( $content, true );

$image_width = intval( $image_width );
$icon_font_size = intval( $icon_font_size );
$icon_line_height = intval( $icon_line_height );
$icon_rounded = intval( $icon_rounded );
$icon_width = intval( $icon_width );
$icon_height = intval( $icon_height );
$icon_border_width = intval( $icon_border_width );

$icon_top_margin = intval( $icon_top_margin );
$content_left_padding = intval( $content_left_padding );
$content_right_padding = intval( $content_right_padding );
$heading_left_margin = intval( $heading_left_margin );
$heading_top_margin = intval( $heading_top_margin );
$heading_bottom_margin = intval( $heading_bottom_margin );
$desc_top_margin = intval( $desc_top_margin );
$desc_bottom_margin = intval( $desc_bottom_margin );

$heading_font_size = intval( $heading_font_size );
$heading_line_height = intval( $heading_line_height );
$desc_font_size = intval( $desc_font_size );
$desc_line_height = intval( $desc_line_height );
$button_font_size = intval( $button_font_size );
$button_rounded = intval( $button_rounded );

$wrap_rounded = intval( $wrap_rounded );
$wrap_border_width = intval( $wrap_border_width );

$cls = $style .' '. $text_align .' '. $hover_style .' '. $link_hover_color;
$cls .= ( $icon_showcase != 'simple' ) ? ' has-width' : ' simple';

if ( $wrap_background ) $css .= 'background-color:'. $wrap_background .';';
if ( $wrap_bg_image ) $css .= 'background-image:url('. wp_get_attachment_image_src( $wrap_bg_image, 'full' )[0] .');background-size:cover;';
if ( $wrap_padding ) $css .= 'padding:'. $wrap_padding .';';
if ( $wrap_margin ) $css .= 'margin:'. $wrap_margin .';';
if ( $wrap_rounded ) $css .= 'border-radius:'. $wrap_rounded .'px;';
if ( $wrap_border_width ) $css .= 'border:'. $wrap_border_width .'px '. $wrap_border_style .' '. $wrap_border .';';

if ( $style == 'icon-left2' )
	$heading_css .= 'margin-left:'. $heading_left_margin .'px;';

if ( $content_left_padding && $style == 'icon-left' ) 
	$heading_css = $desc_css = $url_wrap_css = 'padding-left:'. $content_left_padding .'px;';

if ( $content_right_padding && $style == 'icon-right' )
	$heading_css = $desc_css = $url_wrap_css = 'padding-right:'. $content_right_padding .'px;';

if ( $heading_font_weight != 'Default' ) $heading_css .= 'font-weight:'. $heading_font_weight .';';
if ( $heading_color ) $heading_css .= 'color:'. $heading_color .';';
if ( $heading_color == '#ffffff' ) $heading_cls .= ' white';
if ( $heading_font_size ) $heading_css .= 'font-size:'. $heading_font_size .'px;';
if ( $heading_line_height ) $heading_css .= 'line-height:'. $heading_line_height .'px;';

if ( $heading_top_margin ) {
	if ( $style == 'icon-left' || $style == 'icon-right' ) {
		$heading_css .= 'padding-top:'. $heading_top_margin .'px;';
	} else { $heading_css .= 'margin-top:'. $heading_top_margin .'px;'; }
}

if ( $heading_bottom_margin ) $heading_css .= 'margin-bottom:'. $heading_bottom_margin .'px;';
if ( $heading_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $heading_font_family );
	$heading_css .= 'font-family:'. $heading_font_family .';';
}

if ( $desc_font_weight != 'Default' ) $desc_css .= 'font-weight:'. $desc_font_weight .';';
if ( $desc_color ) $desc_css .= 'color:'. $desc_color .';';
if ( $desc_font_size ) $desc_css .= 'font-size:'. $desc_font_size .'px;';
if ( $desc_line_height ) $desc_css .= 'line-height:'. $desc_line_height .'px;';
if ( $desc_top_margin ) $desc_css .= 'margin-top:'. $desc_top_margin .'px;';
if ( $desc_bottom_margin ) $desc_css .= 'margin-bottom:'. $desc_bottom_margin .'px;';
if ( $desc_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $desc_font_family );
	$desc_css .= 'font-family:'. $desc_font_family .';';
}

if ( $button_font_weight != 'Default' ) $button_css .= 'font-weight:'. $button_font_weight .';';
if ( $button_font_size ) $button_css .= 'font-size:'. $button_font_size .'px;';
if ( $button_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $button_font_family );
	$button_css .= 'font-family:'. $button_font_family .';';
}

if ( $icon_display == 'icon-font' || $icon_display == 'icon-text' ) {
	$icon_inner = $icon_number_html = '';

	if ( $icon_type && $icon_display == 'icon-font' ) {
		if ( isset( $atts["icon_{$icon_type}"] ) )
			$icon = $atts["icon_{$icon_type}"];
		vc_icon_element_fonts_enqueue( $icon_type );

		$icon_inner = '<i class="'. $icon .'"></i>';
	}

	if ( $icon_display == 'icon-text' ) {
		$icon_inner = $icon_text;
	}

	$irand = rand();
	$icon_cls = 'icon-'. $irand .' '. $icon_display;

	if ( $icon_font_size ) $icon_css .= 'font-size:'. $icon_font_size .'px;';
	if ( $icon_width ) $icon_css .= 'width:'. $icon_width .'px;';
	if ( $icon_height ) $icon_css .= 'height:'. $icon_height .'px;';
	if ( $icon_border_style ) $icon_css .= 'border-style:'. $icon_border_style .';';
	if ( $icon_border_width ) $icon_css .= 'border-width:'. $icon_border_width .'px;';
	if ( $icon_rounded ) $icon_css .= 'border-radius:'. $icon_rounded .'px;';
	if ( $icon_line_height ) $icon_css .= 'line-height:'. $icon_line_height .'px;';
	if ( $icon_top_margin && $style == 'icon-left' ) $icon_css .= 'margin-top:'. $icon_top_margin .'px;';

	if ( $icon_horizontal && $icon_vertical && $icon_blur && $icon_spread && $icon_shadow_color )
	    $icon_css .= ' box-shadow:'. $icon_inset .' '. $icon_horizontal .' '. $icon_vertical .' '. $icon_blur .' '. $icon_spread .' '. $icon_shadow_color;

	if ( $icon_color == '#eddd5e' ) {
		$icon_cls .= ' accent';
	} else {
		$icon_cls .= ' custom';
		$icon_data .= ' data-icon="'. $icon_color .'"';
	}

	if ( $icon_background == '#eddd5e' ) {
		$icon_cls .= ' accent-bg';
	} else {
		$icon_cls .= ' custom';
		$icon_data .= ' data-background="'. $icon_background .'"';
	}
	
	if ( $icon_border ) $icon_data .= ' data-border="'. $icon_border .'"';

	if ( $icon_color_hover ) $icon_data .= ' data-icon-hover="'. $icon_color_hover .'"';
	if ( $icon_background_hover ) $icon_data .= ' data-background-hover="'. $icon_background_hover .'"';
	if ( $icon_border_hover ) $icon_data .= ' data-border-hover="'. $icon_border_hover .'"';

	if ( $show_number ) $icon_number_html = sprintf( '<span class="icon-number">%1$s</span>', $icon_number );

	if ( $icon || $icon_text )
	$icon_html = sprintf(
		'<div class="agrikole-icon %3$s" %4$s>
			<span class="icon" style="%2$s">%1$s</span>%5$s
		</div>',
		$icon_inner,
		$icon_css,
		$icon_cls,
		$icon_data,
		$icon_number_html
	);
	
} else {
	if ( $image_width )
		$image_css = 'width:'. $image_width .'px;';

	if ( $image )
		$icon_html = sprintf(
			'<div class="image-wrap" style="%2$s">
				<img alt="image" src="%1$s">
			</div>',
			wp_get_attachment_image_src( $image, 'full' )[0],
			$image_css
		);
}

$new_tab = $new_tab == 'yes' ? '_blank' : '_self'; 
		
if ( $heading )
	if ( $heading_url ) {
		$content_html .= sprintf(
		'<%4$s class="heading %5$s" style="%2$s">
			<a href="%3$s">
				<span>%1$s</span>
			</a>
		</%4$s>',
		$heading,
		$heading_css,
	    esc_attr( $heading_url ),
		$tag,
		$heading_cls
		);
	} else {
		$content_html .= sprintf(
		'<%3$s class="heading %4$s" style="%2$s">
			<span>%1$s</span>
		</%3$s>',
		$heading,
		$heading_css,
		$tag,
		$heading_cls
		);
	}


if ( $content ) $content_html .= sprintf(
	'<div class="desc" style="%2$s">%1$s</div>',
	$content,
	$desc_css
);

if ( $url_style == 'link' && $link_url ) {
	$link_cls .= $link_style;

	if ( $link_color == '#eddd5e' ) { $link_cls .= ' accent';
	} else { $link_cls .= ' '. substr( $link_color, 11 ); }


	$link_html = sprintf(
		'<div class="url-wrap" style="%6$s">
			<a target="%3$s" class="agrikole-links %5$s" href="%2$s" style="%4$s">
				<span class="text">%1$s</span>
			</a>
		</div>',
		esc_html( $link_text ),
		esc_attr( $link_url ),
		$new_tab,
        $link_css,
        $link_cls,
		$url_wrap_css
	);
}

if ( $url_style == 'arrow' && $link_url ) {
	$link_html = sprintf(
		'<div class="url-wrap text-right">
		<a target="%2$s" class="agrikole-arrow" href="%1$s">
			<span class="core-icon-arrow-right"></span>
		</a>
		</div>',
		esc_attr( $link_url ),
		$new_tab
	);
}

if ( $url_style == 'button' && $link_url ) {
	$rand = rand();
	$button_cls = $button_size;
	$button_cls = 'big btn-'. $rand;

	if ( $button_rounded ) $button_css .= 'border-radius:'. $button_rounded .'px;';
	if ( $button_border_width ) $button_css .= 'border-width:'. $button_border_width .';';

    if ( $button_background == '#eddd5e' ) {
        $button_cls .= ' accent';
    } else {
        $button_cls .= ' custom';
        $button_data .= ' data-background="'. $button_background .'"';
    }

	if ( $button_text_color == '#eddd5e' ) {
		$button_cls .= ' text-accent';
	} else {
		$button_cls .= ' custom';
		$button_data .= ' data-text="'. $button_text_color .'"';
	}

    if ( $button_border_width ) {
        $button_cls .= ' outline '. $button_border_style;
        if ( $button_border == '#eddd5e' ) {
            $button_cls .= ' outline-accent';
        } else {
            $button_cls .= ' custom';
            $button_data .= ' data-border="'. $button_border .'"';
        }
    }	

	if ( $button_text_hover ) $button_data .= ' data-text-hover="'. $button_text_hover .'"';
	if ( $button_background_hover ) $button_data .= ' data-background-hover="'. $button_background_hover .'"';
	if ( $button_border_hover ) $button_data .= ' data-border-hover="'. $button_border_hover .'"';

	$link_html = sprintf(
		'<div class="url-wrap" style="%6$s">
			<a target="%5$s" class="agrikole-button %3$s" href="%2$s" style="%4$s" %7$s>%1$s</a>
		</div>',
		esc_html( $link_text ),
		esc_attr( $link_url ),
		$button_cls,
		$button_css,
		$new_tab,
		$url_wrap_css,
		$button_data
	);
}

if ( $animation ) {
	$cls .= ' wow '. $animation_effect;
	$data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

if ( $hover_style != '' ) {
	if ( $wrap_rounded ) $hover_css .= 'border-radius:'. $wrap_rounded .'px;';
	if ( $bg_color ) $hover_css .= 'background-color:'. $bg_color .';';
	if ( $bg_image ) $hover_css .= 'background-image:url('. wp_get_attachment_image_src( $bg_image, 'full' )[0] .');';
	$hover_html = '<div class="hover" style="'. $hover_css .'"></div>';
}

printf( '<div class="agrikole-icon-box clearfix %1$s" style="%2$s" %5$s>%6$s<div class="wrap-inner" style="position: relative;">%3$s <div class="content-wrap">%4$s</div></div>%7$s</div>',
	$cls,
	$css,
	$icon_html,
	$content_html,
	$data,
	$hover_html,
	$link_html
);
