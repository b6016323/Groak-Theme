<?php
/**
 * groak_dev theme activation functions and requirements
 *
 *
 * @package groak_dev
 */

function groak__register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(


		// Require the user registration plugin
		array(
			'name'      => 'Theme My Login',
			'slug'      => 'theme-my-login',
			'required'  => true,
		),
        array(
            'name'      => 'GeoIP Detection',
            'slug'      => 'geoip-detect',
            'required'  => true,
        )

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'groak',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'groak' ),
			'menu_title'                      => __( 'Install Plugins', 'groak' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'groak' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'groak' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'groak' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'groak'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'groak'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'groak'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'groak'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'groak'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'groak'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'groak'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'groak'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'groak'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'groak' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'groak' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'groak' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'groak' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'groak' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'groak' ),
			'dismiss'                         => __( 'Dismiss this notice', 'groak' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'groak' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'groak' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}
function groak__create_required_pages()
{
    //the theme requires a page called profile-page, heere we will check the page exists and if not, create it
     $required_page_exists = get_page_by_title('Profile Page');
        
        $required_page = array(
            'post_type' => 'page',
            'post_title' => 'Profile Page',
            'post_status' => 'publish'
        );
        $required_page_template = 'template-parts/gr_d_profile.php';
        
        if(!isset($required_page_exists->ID))
        {
            $created_page = wp_insert_post($required_page);
            update_post_meta($created_page,'_wp_page_template',$required_page_template);        
        }
    $required_page_exists = get_page_by_title('Home Page');
    $required_page = array(
        'post_type' => 'page',
        'post_title' => 'Home Page',
        'post_status' => 'publish',
        'post_content' => groak__default_homepage()
    );
    $required_page_template = 'template-parts/content-no-title.php';
    if(!isset($required_page_exists->ID))
    {
        $created_page = wp_insert_post($required_page);
        update_post_meta($created_page,'_wp_page_template',$required_page_template); 
    }
}
function groak__set_defaults()
{
    //Dont allow comments by default
    update_option('default_comment_status','closed');
    $homepage = get_page_by_title('Home Page');
    update_option('page_on_front',$homepage->ID);
    update_option('show_on_front','page');
    
}
add_action('after_switch_theme','groak__set_defaults');

function groak__default_homepage()
{
    $page_content = "<ul>";
    $page_content .= "<li><a href='register'>Register</a></li>";
    $page_content .= "<li><a href='login'>Log in</a></li>";
    $page_content .= "<li><a href=''>View Resturaunts</a></li>";
    $page_content .= "</ul>";
    return $page_content;
}

function groak__user_roles()
{
    //Create a new user role
    $result = add_role(
    'business',
    __('Business'),
    array(
        'read' => true,
        'edit_posts' => true,
        'create_posts' => true,
        'publish_posts' => true,
        'install_plugins' => false,
        'edit_themes' => false,
        'update_plugin' => false,
        'update_core' => false
    ));
}
add_action('after_switch_theme','groak__user_roles');
?>