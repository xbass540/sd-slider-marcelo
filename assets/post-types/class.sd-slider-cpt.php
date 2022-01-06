<?php

if(!class_exists('SD_Slider_Post_Type')){// we get the option to overwrite the class if it doesn't exist
    class SD_Slider_Post_Type{
            function __construct()
            {
                add_action('init', array($this, 'create_post_type') );
            }

            public function create_post_type(){//this is the callback function of the hook function= method 
            
                register_post_type(
                    'sd-slider',
                    array(
                        'label' => esc_html__( 'Slider', 'sd-slider' ),
                        'description'   => esc_html__( 'Sliders', 'sd-slider' ),
                        'labels' => array(
                            'name'  => esc_html__( 'Sliders', 'sd-slider' ),
                            'singular_name' => esc_html__( 'Slider', 'sd-slider' ),
                        ),
                        'public'    => true,
                        'supports'  => array( 'title', 'editor', 'thumbnail' ),
                        'hierarchical'  => false,
                        'show_ui'   => true,
                        'show_in_menu'  => true,
                        'menu_position' => 10,
                        'show_in_admin_bar' => true,
                        'show_in_nav_menus' => true,
                        'can_export'    => true,
                        'has_archive'   => true,
                        'exclude_from_search'   => false,
                        'publicly_queryable'    => true,
                        'show_in_rest'  => true,
                        'menu_icon' => 'dashicons-slides',
                        //'register_meta_box_cb'  =>  array( $this, 'add_meta_boxes' )
                    )
                );
            }
    }
}