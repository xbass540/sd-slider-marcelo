<?php
/**
 * Plugin Name: SD Slider
 * Plugin URI: https://wordpress.org/sd-slider
 * Description: Solomon Designs modular responsive Slider Plugin
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Kostas Mavrokefalos
 * Author URI: https://solomondesigns.co.uk
 * License: GPL v2 or later
 * 
 */

//prevent access directly 

 if(! defined ('ABSPATH')){
     exit;
 }

 if(!class_exists ('SD_Slider')){ //checks if the class doesn't exist then moves and uses it 
     class SD_Slider{
            function __construct()//the constructor is the first item to be executed 
            {
                $this->define_constants(); // i call the method define_constant 

                require_once( SD_SLIDER_PATH . 'assets/post-types/class.sd-slider-cpt.php' );// intatiate the slider class = bring it to life
                
                add_action( 'admin_menu', array( $this, 'add_menu' ) );//creates a higher level menu in admin area

                $SD_Slider_Post_Type = new SD_Slider_Post_Type();
            }



            public function define_constants(){
               define ('SD_SLIDER_PATH',plugin_dir_path( __FILE__)) ; //define a constant variable that contains the plugin dir path
               define ('SD_SLIDER_URL',plugin_dir_url( __FILE__)) ; //define a constant variable that contains the plugin url path
               define ('SD_SLIDER_VERSION','1.0.0') ; //define a constant variable that contains the plugin version
            }

            public static function activate(){
                 
                    update_option('rewrite_rules',''); // deleting values in the fields
            }

            public static function deactivate(){
                   flush_rewrite_rules(); // like saving permalinks .
                   unregister_post_type('sd-slider');
            }

            public static function uninstall(){
                    // empty we dont have anything to delete here
            }

            //add top level menu callback function
   public function add_menu(){
    add_menu_page(
        esc_html__( 'SD Slider Options', 'sd-slider' ),
        'SD Slider',
        'manage_options',
        'sd_slider_admin',
        array( $this, 'sd_slider_settings_page' ),
        'dashicons-images-alt2'
    );

    //add submenu

    add_submenu_page(
        'sd_slider_admin',/// i copy and paste this from the WP backend and this changes where the submenu appears
        esc_html__( 'Manage Slides', 'sd-slider' ),
        esc_html__( 'Manage Slides', 'sd-slider' ),
        'manage_options',
        'edit.php?post_type=sd-slider',
        null,
        null
    );

    add_submenu_page(
        'sd_slider_admin', /// i copy and paste this from the WP backend and this changes where the submenu appears
        esc_html__( 'Add New Slide', 'sd-slider' ),
        esc_html__( 'Add New Slide', 'sd-slider' ),
        'manage_options',
        'post-new.php?post_type=sd-slider',
        null,
        null
    );

}
//menu pages end
public function sd_slider_settings_page(){
            require(SD_SLIDER_PATH . 'views/settings-page.php');
        }
     }
 }

 

 if( class_exists( 'SD_Slider' ) ){
    register_activation_hook( __FILE__, array( 'SD_Slider', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'SD_Slider', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'SD_Slider', 'uninstall' ) );

    $sd_slider = new SD_Slider();
} 