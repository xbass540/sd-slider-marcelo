<div class="wrap">
    <!-- always open settings page like this -->
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <!--     //assigns the nav-tab-active class to the active Tab  -->

    <?php
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'main_options';
    ?>

    <!-- tabs  -->
    <h2 class="nav-tab-wrapper">
        <a href="?page=sd_slider_admin&tab=main_options" class="nav-tab <?php echo $active_tab == 'main_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Main Options', 'sd-slider'); ?></a>
        <a href="?page=sd_slider_admin&tab=additional_options" class="nav-tab <?php echo $active_tab == 'additional_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Additional Options', 'sd-slider'); ?></a>
    </h2>


    <!-- splits the ontent into 2 tabs with an if conditional statement -->
    <form action="options.php" method="post">
        <?php
        if ($active_tab == 'main_options') {
            settings_fields('sd_slider_group');
            do_settings_sections('sd_slider_page1');
        } else {
            settings_fields('sd_slider_group');
            do_settings_sections('sd_slider_page2');
        }
        submit_button(esc_html__('Save Settings', 'sd-slider'));
        ?>
    </form>