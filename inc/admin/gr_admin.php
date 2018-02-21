<?php

function groak_admin()
{
    if(is_admin())
    {
        add_action('admin_menu','groak_admin_menu');
        add_action('admin_init', 'groak_admin_register_settings');
    }
}

function groak_admin_menu()
{
    add_menu_page('Groak Admin','Theme Admin', 'manage_options','Groak_Admin','groak_admin_page');
    //add_action('admin_init', 'groak_admin_update');
}

function groak_admin_page()
{
    ?>
    <h1>Groak Admin Page</h1>

    <form action="options.php" method="post">
        <?php settings_fields('groak_admin_settings');?>
        <?php do_settings_sections('groak_admin_settings');?>
        <label>Google Maps API </label><input type="text" name="groak_google_maps_api" value="<?php echo get_option('groak_google_maps_api');?>">
        <?php submit_button();?>
    </form>
    <?php
}

function groak_admin_register_settings()
{
    register_setting('groak_admin_settings','groak_google_maps_api');
}

function groak_admin_update()
{
    //register_setting('groak_admin_settings','groak_google_maps_api');
}