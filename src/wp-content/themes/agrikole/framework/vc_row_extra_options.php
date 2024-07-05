<?php
if ( function_exists('vc_add_param') ) {
    vc_add_param(
        'vc_column_inner',
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Half Background?', 'agrikole' ),
            'param_name' => 'halfbg',
            'value' => array(
                esc_html__( 'Disable', 'agrikole' ) => '',
                esc_html__( 'Background Color', 'agrikole' ) => 'color',
            ),
            'description' => esc_html__( 'Put a background left or right side of row', 'agrikole' ),
        )
    );
    vc_add_param(
        'vc_column_inner',
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Background Color', 'agrikole' ),
            'param_name' => 'halfbg_color',
            'value' => '',
            'dependency' => array(
                'element' => 'halfbg',
                'value' => array( 'color' ),
            ),
        )
    );
    vc_add_param(
        'vc_column_inner',
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Background Position', 'agrikole' ),
            'param_name' => 'halfbg_position',
            'value' => array(
                esc_html__( 'Left', 'agrikole' ) => 'left',
                esc_html__( 'Right', 'agrikole' ) => 'right',                
            ),
            'dependency' => array(
                'element' => 'halfbg',
                'value' => array( 'color', 'image' ),
            ),
        )
    );
    vc_add_param(
        'vc_column_inner',
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Background Rounded', 'agrikole' ),
            'param_name' => 'halfbg_rounded',
            'dependency' => array(
                'element' => 'halfbg',
                'value' => array( 'color', 'image' ),
            ),
            'description' => esc_html__( 'Top Right Bottom Left.', 'agrikole' ),
        )
    );
} 