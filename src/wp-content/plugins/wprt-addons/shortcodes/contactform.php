<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = '';

extract( shortcode_atts( array(
	'form_id' => '',
	'background' => '',
	'button' => 'green'
), $atts ) );

$cls .= ' bg-'. $background .' btn-'. $button;

echo '<div class="agrikole-cf7 '. $cls .'">';
echo do_shortcode( '[contact-form-7 id="'. $form_id .'"]' );
echo '</div>';
