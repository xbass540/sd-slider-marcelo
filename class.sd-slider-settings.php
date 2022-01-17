<?php

if (!class_exists('SD_Slider_Settings')) {
    class SD_Slider_Settings
    {

        public static $options;

        public function __construct()
        {
            self::$options = get_option('sd_slider_options');
            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init()
        {

            //register settings 
            register_setting('sd_slider_group', 'sd_slider_options', array($this, 'sd_slider_validate'));

            //add a section
            add_settings_section(
                'sd_slider_main_section', //id of the section
                esc_html__('How does it work?', 'sd-slider'), //section title
                null, //call back function that displays some html if we like currently set to null
                'sd_slider_page1' //the page where the settings page appears
            );
            //add a field
            add_settings_field(
                'sd_slider_shortcode',
                esc_html__('Shortcode', 'sd-slider'),
                array($this, 'sd_slider_shortcode_callback'),
                'sd_slider_page1',
                'sd_slider_main_section'
            );
        }



        //create a callback function that displays something in the field area
        public function sd_slider_shortcode_callback()
        {
?>
            <span><?php esc_html_e('Use the shortcode [sd_slider] to display the slider in any page/post/widget', 'sd-slider'); ?></span>
<?php
        }
        ////////closing 
    }
}
