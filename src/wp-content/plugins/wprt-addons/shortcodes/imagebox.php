<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$css = $data = $image_css = $heading_css = $desc_css = $link_cls = $link_css = $button_cls = $button_css = $inner_css = $thumb_css = $content_css = $content_cls = $image_html = $hover_html = $heading_html = $desc_html = $url_html = $button_data = '';

extract( shortcode_atts( array(
    'style' => 'style-1',
    'animation' => '',
    'animation_effect' => 'fadeInUp',
    'animation_duration' => '0.75s',
    'animation_delay' => '0.3s',
    'alignment' => '',
    'image'    => '',
    'image_rounded' => '',
    'image_width' => '',
    'show_icon' => '',
    'content_padding' => '45px 50px 43px',
    'content_bg' => '',
    'tag' => 'h3',
    'heading' => 'Heading Text',
    'heading_color' => '',
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
    'heading_top_margin' => '',
    'heading_bottom_margin' => '',
    'desc_top_margin' => '',
    'desc_bottom_margin' => '',
    'inset' => '',
    'horizontal' => '',
    'vertical' => '',
    'blur' => '',
    'spread' => '',
    'shadow_color' => ''
), $atts ) );
$content = wpb_js_remove_wpautop($content, true);

$heading_line_height = intval( $heading_line_height );
$desc_line_height = intval( $desc_line_height );
$heading_font_size = intval( $heading_font_size );
$desc_font_size = intval( $desc_font_size );
$button_font_size = intval( $button_font_size );
$button_rounded = intval( $button_rounded );
$heading_top_margin = intval( $heading_top_margin );
$heading_bottom_margin = intval( $heading_bottom_margin );
$desc_top_margin = intval( $desc_top_margin );
$desc_bottom_margin = intval( $desc_bottom_margin );

$cls = $style .' '. $alignment;
$new_tab = $new_tab == 'yes' ? '_blank' : '_self'; 

if ( $heading_font_weight != 'Default' ) $heading_css .= 'font-weight:'. $heading_font_weight .';';
if ( $heading_font_size ) $heading_css .= 'font-size:'. $heading_font_size .'px;';
if ( $heading_color ) $heading_css .= 'color:'. $heading_color .';';
if ( $heading_line_height ) $heading_css .= 'line-height:'. $heading_line_height .'px;';
if ( $heading_top_margin ) $heading_css .= 'margin-top:'. $heading_top_margin .'px;';
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
if ( $button_border_width ) $button_css .= 'border-width:'. $button_border_width .';';

if ( $button_font_family != 'Default' ) {
    agrikole_enqueue_google_font( $button_font_family );
    $button_css .= 'font-family:'. $button_font_family .';';
}

if ( $url_style == 'hover' && $link_url ) {
    $cls .= ' image-hover';
    $hover_html .= sprintf(
        '<div class="hover-image">
        <a target="%2$s" class="arrow" href="%1$s">
            <span class="core-icon-next"></span>
        </a>
        </div>',
        esc_attr( $link_url ),
        $new_tab
    );
}

if ( $image ) {
    if ( $image_rounded ) {
        $thumb_css .= 'border-radius:'. intval( $image_rounded ) .'px; overflow:hidden;';
    }
    if ( $image_width ) {
        $thumb_css .= 'width:'. intval( $image_width ) .'px;';
        if ( $alignment == 'text-center' ) $thumb_css .= 'margin: 0 auto;';
    }
    $image_html .= sprintf(
        '<div class="thumb" style="%2$s">%3$s %1$s</div>',
        wp_get_attachment_image( $image, 'full' ),
        $thumb_css,
        $hover_html
    );
}

if ( $heading )
    $heading_html .= sprintf(
    '<%3$s class="title" style="%2$s">
        %1$s
    </%3$s>',
    $heading,
    $heading_css,
    $tag
    );

if ( $content ) 
    $desc_html .= sprintf(
    '<div class="desc" style="%2$s">%1$s</div>',
    $content,
    $desc_css
);

if ( $url_style == 'link' && $link_url ) {
    $link_cls .= $link_style;

    if ( $link_color == '#eddd5e' ) { $link_cls .= ' accent';
    } else { $link_cls .= ' '. substr( $link_color, 11 ); }

    $url_html .= sprintf(
        '<div class="url-wrap">
            <a href="%2$s" target="%3$s" class="agrikole-links %5$s" style="%4$s">
                <span class="text">%1$s</span>
            </a>
        </div>',
        esc_html( $link_text ),
        esc_attr( $link_url ),
        $new_tab,
        $link_css,
        $link_cls
    );
}

if ( $url_style == 'arrow' && $link_url ) {
    $url_html .= sprintf(
        '<div class="url-wrap">
        <a target="%2$s" class="arrow" href="%1$s">
            <span class="core-icon-next"></span>
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

    $url_html .= sprintf(
        '<div class="url-wrap">
            <a target="%5$s" class="agrikole-button %3$s" href="%2$s" style="%4$s" %6$s>%1$s</a>
        </div>',
        esc_html( $link_text ),
        esc_attr( $link_url ),
        $button_cls,
        $button_css,
        $new_tab,
        $button_data
    );
}

if ( $animation ) {
    $cls .= ' wow '. $animation_effect;
    $data .= ' data-wow-duration="'. $animation_duration .'" data-wow-delay="'. $animation_delay .'"';
}

if ( $content_padding ) $content_css .= ' padding:'. $content_padding .';';
if ( $content_bg ) $content_css .= ' background-color:'. $content_bg .';';

if ( $horizontal && $vertical && $blur && $spread && $shadow_color )
    $css .= ' box-shadow:'. $inset .' '. $horizontal .' '. $vertical .' '. $blur .' '. $spread .' '. $shadow_color;

if ( $style == 'style-1' )
printf(
    '<div class="agrikole-image-box clearfix %6$s" style="%7$s" %8$s>
        <div class="item">
            <div class="inner">
                %1$s
                <div class="text-wrap %9$s" style="%5$s">
                    %2$s %3$s %4$s
                </div>
            </div>
        </div>
    </div>', 
    $image_html,
    $heading_html,
    $desc_html,
    $url_html,
    $content_css,
    $cls,
    $css,
    $data,
    $content_cls
);

if ( $style == 'style-2' )
printf(
    '<div class="agrikole-image-box clearfix %6$s" style="%7$s" %8$s>
        <div class="item">
            <div class="inner">
                <div class="text-wrap %9$s" style="%5$s">
                    %2$s %3$s %4$s
                </div>
                %1$s
            </div>
        </div>
    </div>', 
    $image_html,
    $heading_html,
    $desc_html,
    $url_html,
    $content_css,
    $cls,
    $css,
    $data,
    $content_cls
);