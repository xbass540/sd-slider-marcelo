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

            //add 1st section
            add_settings_section(
                'sd_slider_main_section', //id of the section
                esc_html__('How does it work?', 'sd-slider'), //section title
                null, //call back function that displays some html if we like currently set to null
                'sd_slider_page1' //the page where the settings page appears
            );
            //add 1st field it just displays some text
            add_settings_field(
                'sd_slider_shortcode',
                esc_html__('Shortcode', 'sd-slider'),
                array($this, 'sd_slider_shortcode_callback'),
                'sd_slider_page1',
                'sd_slider_main_section'
            );

            //add 2nd section
            add_settings_section(
                'sd_slider_second_section', //id of the section
                esc_html__('Other Options', 'sd-slider'), //section title
                null, //call back function that displays some html if we like currently set to null
                'sd_slider_page2' //the page where the settings page appears
            );

            //add 2nd field input textfield
            add_settings_field(
                'sd_slider_title',
                esc_html__('Slider Title', 'sd-slider'),
                array($this, 'sd_slider_title_callback'),
                'sd_slider_page2',
                'sd_slider_second_section',
                array(
                    'label_for' => 'sd_slider_title' // the id of the field)
                )
            );

            //add 3rd field checkbox
            add_settings_field(
                'sd_slider_bullets',
                esc_html__('Display Bullets', 'sd-slider'),
                array($this, 'sd_slider_bullets_callback'),
                'sd_slider_page2',
                'sd_slider_second_section',
                array(
                    'label_for' => 'sd_slider_bullets'// the id of the field)
                )
                );

            //add 4th field styles dropdown
            add_settings_field(
                'sd_slider_style',
                esc_html__('Slider Style', 'sd-slider'),
                array($this, 'sd_slider_style_callback'),
                'sd_slider_page2',
                'sd_slider_second_section',
                array( //6th parameter passes arguments to callback function    
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'sd_slider_style'// the id of the field
                )

            );
            //////
        }



        //create a callback function that displays something in the field area
        public function sd_slider_shortcode_callback()
        {
?>
            <span><?php esc_html_e('Use the shortcode [sd_slider] to display the slider in any page/post/widget', 'sd-slider'); ?></span>
        <?php
        }

        //create the callback function for the input field of the 2nd section

        public function sd_slider_title_callback($args)
        {
        ?>
            <input type="text" name="sd_slider_options[sd_slider_title]" id="sd_slider_title" value="<?php echo isset(self::$options['sd_slider_title']) ? esc_attr(self::$options['sd_slider_title']) : ''; ?>">
        <?php
        }

        //create the callback for the bullets 
        public function sd_slider_bullets_callback($args)
        {
        ?>
            <input type="checkbox" name="sd_slider_options[sd_slider_bullets]" id="sd_slider_bullets" value="1" <?php
          if (isset(self::$options['sd_slider_bullets'])) {
 checked("1", self::$options['sd_slider_bullets'], true); //checks if the box is checked
  }
 ?> />
            <label for="sd_slider_bullets"><?php esc_html_e('Whether to display bullets or not', 'sd-slider'); ?></label>

        <?php
        }

        //callback function for styles
        public function sd_slider_style_callback($args)
        {
        ?>
            <select 
            id="sd_slider_style" 
            name="sd_slider_options[sd_slider_style]">
                <?php
                foreach ($args['items'] as $item) :
                ?>
                    <option value="<?php echo esc_attr($item); ?>" <?php
                  isset(self::$options['sd_slider_style']) ? selected($item, self::$options['sd_slider_style'], true) : '';
                   ?>>
                        <?php echo esc_html(ucfirst($item)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
<?php
        }

        ///validate function for the input fields in the settings page
        public function sd_slider_validate($input)
        {
            $new_input = array();
            foreach ($input as $key => $value) {
                switch ($key) {
                    case 'sd_slider_title':
                        if (empty($value)) {
                            add_settings_error('sd_slider_options', 'sd_slider_message', esc_html__('The title field can not be left empty', 'sd-slider'), 'error');
                            $value = esc_html__('Please, type some text', 'sd-slider');
                        }
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                    default:
                        $new_input[$key] = sanitize_text_field($value);
                        break;
                }
            }
            return $new_input;
        }

        ////////closing 
    }
}
