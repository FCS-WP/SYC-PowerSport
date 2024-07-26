<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/*
 * Define Variables
 */
if (!defined('THEME_DIR'))
    define('THEME_DIR', get_template_directory());
if (!defined('THEME_URL'))
    define('THEME_URL', get_template_directory_uri());


/*
 * Include framework files
 */
foreach (glob(THEME_DIR.'-child' . "/includes/*.php") as $file_name) {
    require_once ( $file_name );
}

function myContentFooter() {
    ?>
    <div class="ppocta-ft-fix">
        <a id="whatsappButton" href="#" target="_blank"><span>Whatsapp: +65 89012**</span></a>
    </div>
    <?php
}
add_action( 'wp_footer', 'myContentFooter' );