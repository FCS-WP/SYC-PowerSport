<?php
/**
 * Bottom Bar
 *
 * @package agrikole
 * @version 3.6.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Exit if disabled via Customizer
if ( ! agrikole_get_mod( 'bottom_bar', true ) ) return false;

// Default
$copyright = esc_html( 'Agrikole - Creative Multipurpose WordPress Theme.', 'agrikole' );
if ( agrikole_get_mod( 'bottom_copyright' ) )
    $copyright = agrikole_get_mod( 'bottom_copyright' );

$css = agrikole_element_bg_css('bottom_background_img');
$bottom_style = agrikole_get_mod( 'bottom_bar_style', 'style-1' );

if ( is_page() && $bottom_bg = agrikole_metabox('bottom_bg') )
    $css .= 'background-color:'. $bottom_bg .';';
?>

<div id="bottom" class="<?php echo agrikole_element_classes( 'bottom_bar_style' ); ?>" style="<?php echo esc_attr( $css ); ?>">
    <div class="agrikole-container">
        <div class="bottom-bar-inner-wrap">
            <div class="bottom-bar-copyright clearfix">
                <?php
                if ( $copyright ) : ?>
                    <div id="copyright">
                        <?php printf( '%s', do_shortcode( $copyright ) ); ?>
                    </div>
                <?php endif; ?>

                <?php
                if ( 'style-2' == $bottom_style ) 
                    get_template_part( 'templates/bottom-nav' );
                ?>
            </div><!-- /.bottom-bar-copyright -->
        </div>
    </div>
</div><!-- /#bottom -->