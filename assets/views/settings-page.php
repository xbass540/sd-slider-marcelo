<div class="wrap">
    <!-- always open settings page like this -->
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <form action="options.php" method="post">
        <?php
      
            settings_fields('sd_slider_group');
            do_settings_sections('sd_slider_page1');
        submit_button(esc_html__('Save Settings', 'sd-slider'));
        ?>
    </form