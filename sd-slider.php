<?php
/**
 * Plugin Name: SD Slider
 * Plugin URI: https://wordpress.org/sd-slider
 * Description: my ddescription
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
            }

            public static function uninstall(){
                    // empty we dont have anything to delete here
            }
     }
 }

 if(class_exists ('SD_Slider')){ //checks if the class exists then moves and uses it 
    register_activation_hook(__FILE__,array('SD_SLIDER','activate')); //
    register_deactivation_hook(__FILE__,array('SD_SLIDER','deactivate'));
    register_uninstall_hook(__FILE__,array('SD_SLIDER','uninstall'));

    $mv_slider= new SD_Slider();

 }