<?php

if(!class_exists('SD_Slider_Post_Type')){// we get the option to overwrite the class if it doesn't exist
    class SD_Slider_Post_Type{
            function __construct()
            {
                add_action('init', array($this, 'create_post_type') );
                add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );//adds metabox in slider page
                add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );//saves post to DB
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
                        //'register_meta_box_cb'  =>  array( $this, 'add_meta_boxes' ) // alternative way to reate metaboxes
                    )
                );
            }
//adds metaboxes in slider edit page
            public function add_meta_boxes(){
                add_meta_box(
                    'sd_slider_meta_box',//CSS ID
                    esc_html__( 'Link Options', 'sd-slider' ),//Title
                    array( $this, 'add_inner_meta_boxes' ),
                    'sd-slider',
                    'normal', //where in the edit page it is displayed normal is under the content
                    'high'
                );
            }
//Inserts the HTML of the metaboxes fields
    public function add_inner_meta_boxes($post){
        require_once( SD_SLIDER_PATH . 'assets/views/sd-slider_metabox.php' );//calls the HTML file
    }
//Saves the data to the DB and sanitize
public function save_post( $post_id ){
    if( isset( $_POST['sd_slider_nonce'] ) ){
        if( ! wp_verify_nonce( $_POST['sd_slider_nonce'], 'sd_slider_nonce' ) ){
            return;
        }
    }

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return;
    }

    if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'sd-slider' ){
        if( ! current_user_can( 'edit_page', $post_id ) ){
            return;
        }elseif( ! current_user_can( 'edit_post', $post_id ) ){
            return;
        }
    }

    if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ){
        $old_link_text = get_post_meta( $post_id, 'sd_slider_link_text', true );
        $new_link_text = $_POST['sd_slider_link_text'];
        $old_link_url = get_post_meta( $post_id, 'sd_slider_link_url', true );
        $new_link_url = $_POST['sd_slider_link_url'];

        if( empty( $new_link_text )){ // checks if the fields are empty
            update_post_meta( $post_id, 'sd_slider_link_text', esc_html__( 'Add some text', 'sd-slider' ) );
        }else{
            update_post_meta( $post_id, 'sd_slider_link_text', sanitize_text_field( $new_link_text ), $old_link_text );//text field sanitizing
        }

        if( empty( $new_link_url )){ // checks if the fields are empty
            update_post_meta( $post_id, 'sd_slider_link_url', '#' );
        }else{
            update_post_meta( $post_id, 'sd_slider_link_url', sanitize_text_field( $new_link_url ), $old_link_url ); // sanitize url
        }
        
        
    }
}
//end of initial brackets
    }
}