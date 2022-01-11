<?php

if(!class_exists('SD_Slider_Post_Type')){// we get the option to overwrite the class if it doesn't exist
    class SD_Slider_Post_Type{
            function __construct()
            {
                add_action('init', array($this, 'create_post_type') );
                add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );//adds metabox in slider page
                add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );//saves post to DB
               add_filter( 'manage_sd-slider_posts_columns', array( $this, 'sd_slider_cpt_columns' ) );//this filter enables us to manipulate the slider posts table in the admin area
               add_action( 'manage_sd-slider_posts_custom_column', array( $this, 'sd_slider_custom_columns'), 10, 2 );//displays the info from the database
               add_filter( 'manage_edit-sd-slider_sortable_columns', array( $this, 'sd_slider_sortable_columns' ) );//make columns sortable
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
                        'show_in_menu'  => false,
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


//create method for filter: manage_sd-slider_posts_columns
public function sd_slider_cpt_columns($columns){
    $columns['sd_slider_link_text'] = esc_html__( 'Link Text', 'sd-slider' );//displays Link text in the sliders table
    $columns['sd_slider_link_url'] = esc_html__( 'Link URL', 'sd-slider' );//displays Url in the sliders table
    return $columns;
}

//create method for action: manage_sd-slider_posts_custom_column. Displays the info from the database to the table
public function sd_slider_custom_columns( $column, $post_id ){
    switch( $column ){
        case 'sd_slider_link_text':
            echo esc_html( get_post_meta( $post_id, 'sd_slider_link_text', true ) );
        break;
        case 'sd_slider_link_url':
            echo esc_url( get_post_meta( $post_id, 'sd_slider_link_url', true ) );
        break;                
    }
}

//make custom columns sortable
public function sd_slider_sortable_columns( $columns ){
    $columns['sd_slider_link_text'] = 'sd_slider_link_text';
    return $columns;
}


/////////
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


    ////////////////////////////////////   validation statements: card closes  //////////////////////////////////

    if( isset( $_POST['sd_slider_nonce'] ) ){ // checks if the value contains anything
        if( ! wp_verify_nonce( $_POST['sd_slider_nonce'], 'sd_slider_nonce' ) ){// checks if the nonce value is the one expected or not
            return;
        }
    }

    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){//checks about saving to avoids losing data
        return;
    }

    if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'sd-slider' ){//checks if we are on the correct screen for the correct post type
        if( ! current_user_can( 'edit_page', $post_id ) ){
            return;
        }elseif( ! current_user_can( 'edit_post', $post_id ) ){
            return;
        }
    }

    //////////////////////////////////// end of validation statements ////////////////////////////////////////////////////////

    if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ){
        //the 1st button link text
        $old_link_text = get_post_meta( $post_id, 'sd_slider_link_text', true );
        $new_link_text = $_POST['sd_slider_link_text'];

        //the 1st button link url
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

        //the 2nd button 
                //the 1st button link text
                $old_link_text_b = get_post_meta( $post_id, 'sd_slider_link_text_b', true );
                $new_link_text_b = $_POST['sd_slider_link_text_b'];
        
                //the 1st button link url
                $old_link_url_b = get_post_meta( $post_id, 'sd_slider_link_url_b', true );
                $new_link_url_b = $_POST['sd_slider_link_url_b'];
        
                if( empty( $new_link_text_b )){ // checks if the fields are empty
                    update_post_meta( $post_id, 'sd_slider_link_text_b', esc_html__( 'Add some text', 'sd-slider' ) );
                }else{
                    update_post_meta( $post_id, 'sd_slider_link_text', sanitize_text_field( $new_link_text_b ), $old_link_text_b );//text field sanitizing
                }
        
                if( empty( $new_link_url_b )){ // checks if the fields are empty
                    update_post_meta( $post_id, 'sd_slider_link_url', '#' );
                }else{
                    update_post_meta( $post_id, 'sd_slider_link_url', sanitize_text_field( $new_link_url_b ), $old_link_url_b ); // sanitize url
                }

        
    }
}
//end of initial brackets
    }
}