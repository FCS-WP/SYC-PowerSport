<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$html = $sub_html = $cls = $css = $heading_wrap_css = $heading_css = $subheading_wrap_cls = $subheading_css = $url_wrap_css = '';
$button_cls = $button_css = $button_data = '';

extract( shortcode_atts( array(
	'content_width' => '',
	'button_width' => '',
	'heading_text' => '',
	'heading_color' => '',
	'heading_width' => '',
	'subheading_text' => '',
	'subheading_color' => '',
	'subheading_width' => '',
	'content_align' => '',
	'button_align' => '',
	'heading_tag' => 'h2',
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
	'subheading_font_family' => 'Default',
	'subheading_font_weight' => 'Default',
	'subheading_font_size' => '',
	'subheading_line_height' => '',
	'button_font_family' => 'Default',
	'button_font_weight' => 'Default',
	'button_font_size' => '',
	'heading_margin' => '',
	'button_margin' => '',
), $atts ) );

$rand = rand();
$heading_line_height = intval( $heading_line_height );
$heading_font_size = intval( $heading_font_size );

$subheading_line_height = intval( $subheading_line_height );
$subheading_font_size = intval( $subheading_font_size );

$heading_width = intval( $heading_width );
$subheading_width = intval( $subheading_width );
$button_font_size = intval( $button_font_size );
$button_rounded = intval( $button_rounded );

if ( $subheading_font_weight != 'Default' ) $subheading_css .= 'font-weight:'. $subheading_font_weight .';';
if ( $subheading_color ) $subheading_css .= 'color:'. $subheading_color .';';
if ( $subheading_font_size ) $subheading_css .= 'font-size:'. $subheading_font_size .'px;';
if ( $subheading_line_height ) $subheading_css .= 'line-height:'. $subheading_line_height .'px;';
if ( $subheading_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $subheading_font_family );
	$subheading_css .= 'font-family:'. $subheading_font_family .';';
}

if ( $subheading_width ) {
	$subheading_css .= 'max-width:'. $subheading_width .'px;';
	if ( $content_align == 'text-center' ) $subheading_css .= 'margin-left: auto; margin-right: auto;';
}

$sub_html .= sprintf('
	<div class="subheading-wrap %1$s">
		<div style="%2$s">
			%3$s
		</div>
	</div>',
	$subheading_wrap_cls,
	$subheading_css,
	$subheading_text
);

if ( $heading_font_weight != 'Default' ) $heading_css .= 'font-weight:'. $heading_font_weight .';';
if ( $heading_color ) $heading_css .= 'color:'. $heading_color .';';
if ( $heading_font_size ) $heading_css .= 'font-size:'. $heading_font_size .'px;';
if ( $heading_line_height ) $heading_css .= 'line-height:'. $heading_line_height .'px;';
if ( $heading_margin ) $heading_css .= 'margin:'. $heading_margin .';';
if ( $heading_font_family != 'Default' ) {
	agrikole_enqueue_google_font( $heading_font_family );
	$heading_css .= 'font-family:'. $heading_font_family .';';
}

if ( $heading_width ) {
	$heading_css .= 'max-width:'. $heading_width .'px;';
	if ( $content_align == 'text-center' ) $heading_css .= 'margin-left: auto; margin-right: auto;';
}

if ( $content_width ) $heading_wrap_css .= 'width:'. $content_width .';';

$html .= sprintf('
	<div class="heading-wrap" style="%1$s">
		<%4$s class="heading" style="%2$s">
			%3$s
		</%4$s>
		%5$s
	</div>',
	$heading_wrap_css,
	$heading_css,
	$heading_text,
	$heading_tag,
	$sub_html	
);

if ( $link_text && $link_url ) {
	$btnrand = rand();
	$button_cls = $button_size .' btn-'. $btnrand;

	if ( $button_width ) $url_wrap_css .= 'width:'. $button_width .';';
	if ( $button_margin ) $url_wrap_css .= 'padding:'. $button_margin .';';
	if ( $button_rounded ) $button_css .= 'border-radius:'. $button_rounded .'px;';
	if ( $button_border_width ) $button_css .= 'border-width:'. $button_border_width .';';
	if ( $button_text_color ) $button_data .= ' data-text="'. $button_text_color .'"';

    if ( $button_background == '#eddd5e' ) {
        $button_cls .= ' accent';
    } else {
        $button_cls .= ' custom';
        $button_data .= ' data-background="'. $button_background .'"';
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

	$html .= sprintf(
		'<div class="url-wrap" style="%6$s">
			<a target="%5$s" class="agrikole-button %3$s" href="%2$s" style="%4$s" %7$s><span>%1$s</span></a>
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

printf(
	'<div class="agrikole-action-box %3$s" style="%2$s">
		<div class="inner">%s</div>
	</div>',
	$html,
	$css,
	$cls
);