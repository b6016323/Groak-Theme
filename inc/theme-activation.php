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
        ),
		array(
			'name'		=> 'Wordpress File Upload',
			'slug'		=> 'wordpress-theme-upload',
			'required'	=> true,
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
    //We want to create multiple pages, so lets start with an array
    $required_pages = array();
    
    //creating the pages
    $required_pages[] = array(
        //array for the post for WP
        'post_details'=>array(
        'post_type' => 'page',
        'post_title' => 'Profile Page',
        'post_status' => 'publish'),
        //item for page template
        'page_template'=> 'template_parts/gr_d_profile.php'
    );
    $required_pages[] = array(
        'post_details'=> array(
        'post_type' => 'page',
        'post_title' => 'Home Page',
        'post_status' => 'publish',
        'post_content' => groak__default_homepage()),
        'page_template' => 'page-no-title.php'
    );
    $required_pages[] = array(
        'post_details'=> array(
        'post_type' => 'page',
        'post_title' => 'About',
        'post_status' => 'publish'),
        'page_template' => ''
        );
    $required_pages[] = array(
        'post_details'=> array(
        'post_type' => 'page',
        'post_title' => 'Privacy Policy',
        'post_status' => 'publish'),
        'page_template' => ''
        );
    //Now check if the pages exist, if they dont then we create them
    
    foreach($required_pages as $required_page)
    {
        if(!isset(get_page_by_title($required_page['post_details']['post_title'])->ID))
        {
            $created_page = wp_insert_post($required_page['post_details']);
            update_post_meta($created_page,'_wp_page_template',$required_page['page_template']);
            if($required_page['post_details']['post_title'] == 'Home Page')
            {
                //update_option('page_on_front',$created_page);
                update_option('show_on_front','page');
            }
        }
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
    $page_content = '[gr_menu menu="testing"]';
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