<?php
if ( function_exists('vc_add_param') ) {
    vc_add_param(
        'vc_row',
        array(
            "type" => "dropdown",
            "heading" => esc_html__('Content Position: Middle', 'agrikole'),
            "param_name" => "row_content_position",
            'value' => array(
                'Default' => 'Default',
                'Top' => 'top',
                'Middle' => 'middle',
                'Bottom' => 'bottom'
            ),   
        ) 
    );
    vc_add_param(
        'vc_row',
        array(
            "type" => "dropdown",
            "heading" => esc_html__('Equal Height', 'agrikole'),
            "param_name" => "row_equal_height",
            "value" => array(   
                esc_html__('No', 'agrikole') => 'no',  
                esc_html__('Yes', 'agrikole') => 'yes',                                                                                
            ),     
        ) 
    );    
    vc_add_param(
        'vc_row',
        array(
            "type" => "dropdown",
            "heading" => esc_html__('Fullwidth', 'agrikole'),
            "param_name" => "fullwidth",
            "value" => array(   
                esc_html__('No', 'agrikole') => 'no',  
                esc_html__('Yes', 'agrikole') => 'yes',                                                                                
            ),
            "description" => esc_html__("Select 'Yes' to stretch row and content", 'agrikole' ),      
        ) 
    );
    vc_add_param(
        'vc_row',
        array(
            "type" => "dropdown",
            "heading" => esc_html__('Spacing Between Columns', 'agrikole'),
            "param_name" => "column_spacing",
            'value' => array(
                esc_html__( 'Default', 'agrikole' ) => '30',
                '0px' => '0px',
                '1px' => '1',
                '5px' => '5',
                '10px' => '10',
                '20px' => '20',
                '30px' => '30',
                '40px' => '40',
                '50px' => '50',
                '60px' => '60',
                '70px' => '70',
                '80px' => '80',
                '90px' => '90',
                '100px' => '100',
            ),     
        ) 
    );
    // Add new Param in Row Inner
    vc_add_param(
        'vc_row_inner',
        array(
            "type" => "dropdown",
            "heading" => esc_html__('Spacing Between Columns', 'agrikole'),
            "param_name" => "column_inner_spacing",
            'value' => array(
                esc_html__( 'Default', 'agrikole' ) => '30',
                '0px' => '0px',
                '1px' => '1',
                '5px' => '5',
                '10px' => '10',
                '20px' => '20',
                '30px' => '30',
                '40px' => '40',
                '50px' => '50',
                '60px' => '60',
                '70px' => '70',
                '80px' => '80',
                '90px' => '90',
            ),     
        ) 
    );
    vc_add_param(
        'vc_row_inner',
        array(
            "type" => "textfield",
            "heading" => esc_html__('Padding Wrapper', 'agrikole'),
            "param_name" => "column_inner_padding",
            'value' => '',     
        )
    );
    vc_add_param(
        'vc_row_inner',
        array(
            "type" => "textfield",
            "heading" => esc_html__('Mobile Padding Wrapper', 'agrikole'),
            "param_name" => "column_inner_mobipadding",
            'value' => '',     
        )
    );
}

if ( function_exists('vc_remove_param') ) {
    vc_remove_param( "vc_row", "full_width" );
    vc_remove_param( "vc_row", "content_placement" );
    vc_remove_param( "vc_row", "equal_height" );
    vc_remove_param( "vc_row", "full_height" );
    vc_remove_param( "vc_row", "video_bg" );
    vc_remove_param( "vc_row", "video_bg_parallax" );
    vc_remove_param( "vc_row", "video_bg_url" );
    vc_remove_param( "vc_row", "parallax_speed_video" );
    vc_remove_param( "vc_row", "columns_placement" );
    vc_remove_param( "vc_row", "gap" );
    vc_remove_param( 'vc_row_inner', 'gap' );
    vc_remove_param( 'vc_row_inner', 'equal_height' );
    vc_remove_param( 'vc_row_inner', 'content_placement' );
    vc_remove_param( "vc_column", "css_animation" );
    vc_remove_param( "vc_column", "video_bg" );
    vc_remove_param( "vc_column", "video_bg_parallax" );
    vc_remove_param( "vc_column", "video_bg_url" );
}    