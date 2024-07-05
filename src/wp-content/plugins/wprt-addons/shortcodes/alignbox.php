<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cls = '';

extract( shortcode_atts( array(
    'alignment' => 'center',
    'alignment_mobi' => 'center',
    'mobi_hide' => '',
), $atts ) );

if ( $alignment_mobi == 'center' ) $cls = ' mobi-align-center';
if ( $alignment_mobi == 'left' ) $cls = ' mobi-align-left';
if ( $alignment_mobi == 'right' ) $cls = ' mobi-align-right';

$cls .= ' align-'. $alignment;
if ( $mobi_hide ) $cls .= ' hide-on-mobile';

printf(
	'<div class="agrikole-align-box %2$s">%1$s</div>',
	do_shortcode( $content ),
	$cls
);