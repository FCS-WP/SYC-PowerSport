<?php

if ( class_exists( 'Deeper_Adv_Tabs' ) ) {
    new Deeper_Adv_Tabs;
}

class Deeper_Adv_Tabs {

    function __construct() {
        add_shortcode( 'deeper_advance_tabs', array( $this, 'deeper_parent_tab_render' ) );
        add_shortcode( 'deeper_advance_tab', array( $this, 'deeper_child_tabs_render' ) );
    }

    function deeper_parent_tab_render( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'style' => 'style-1'
        ), $atts));
        ob_start();
        ?>
     
    	<div class="agrikole-adv-tabs <?php echo esc_attr( $style ); ?>">
            <div class="tab-title">
            </div>
            <div class="tab-content-wrap">
            	<?php do_shortcode( $content ); ?>
            </div>                			
    	</div>

        <?php
        $output = ob_get_clean();
        return $output;
    }

    function deeper_child_tabs_render( $atts, $content = null ) {
        extract(shortcode_atts(array(
            'tab_title' => 'Title',
            'icon_show' => 'font_icon',
            'icon_type' => '',
            'icon' => '',
            'icon_font_size' => '',
            'img_icon' => '',
            'img_icon_hover' => '',
            'img_icon_width' => '',
            'img_icon_height' => ''
        ), $atts));

        $icon_html = $icon_css = '';

        if ( $icon_show == 'font_icon' && $icon_type ) {
            if ( isset( $atts["icon_{$icon_type}"] ) )
                $icon = $atts["icon_{$icon_type}"];
            vc_icon_element_fonts_enqueue( $icon_type );

            if ( $icon_font_size ) $icon_css .= 'font-size:'. intval( $icon_font_size ) .'px;';

            $icon_html = '<span class="icon" style="'. $icon_css .'"><i class="'. $icon .'"></i></span>';
        }

        if ( $icon_show == 'image_icon' ) {
            $origin_img = $hover_img = $img_data = '';

            if ( $img_icon ) {
                $origin_img = wp_get_attachment_image_src( $img_icon, 'full' )[0];
                $img_data .= 'data-origin-src='. $origin_img;
            }

            if ( $img_icon_hover ) {
                $hover_img = wp_get_attachment_image_src( $img_icon_hover, 'full' )[0];
                $img_data .= ' data-hover-src='. $hover_img;
            }

            if ( $origin_img )
                $icon_html = '<img class="image-icon" src="'. $origin_img .'" '. $img_data .' width="'. $img_icon_width .'" height="'. $img_icon_height .'" alt="Image" />';
        }

        ?>
     	    <div class="tab-content">
                <?php echo '<div class="item-title"><a class="anchor-link">'. $icon_html .'<span class="title">'. $tab_title .'</span></a></div>'; ?>
     	    	<?php echo '<div class="item-content">'. do_shortcode( $content ) .'</div>'; ?>
     	    </div>
        <?php
    }
}