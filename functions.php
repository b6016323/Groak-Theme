<?php
/**
 * groak_dev functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package groak_dev
 */

if ( ! function_exists( 'gr_d__setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function gr_d__setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on groak_dev, use a find and replace
		 * to change 'gr_d_' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'gr_d_', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'gr_d_' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'gr_d__custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 50,
			'flex-width'  => true,
			'flex-height' => true,
		) );
        
        /**
        *
        *   START RYAN CUSTOM CODE AND ADDITIONS
        *
        **/
        require_once get_template_directory().'/inc/theme-activation.php';
        require_once get_template_directory().'/inc/class-tgm-plugin-activation.php';
        require_once get_template_directory().'/inc/gr_d_profile_mgmt.php';
        require_once get_template_directory().'/inc/gr_d_listings_mgmt.php';
        require_once get_template_directory().'/theme-my-login/theme-my-login-custom.php';
        add_action( 'tgmpa_register', 'groak__register_required_plugins' );
        
        
        // create a profile-page if it doesnt exist
        //the theme requires a page called profile-page, heere we will check the page exists and if not, create it
        add_action( 'tgmpa_register', 'groak__create_required_pages');

        if(is_admin())
        {
            //get the admin page
            require_once(get_template_directory().'/inc/admin/gr_admin.php');
            groak_admin();
        }
        
        
        /*
        *  END RYAN CUSTOM CODE
        */
	}
endif;
add_action( 'after_setup_theme', 'gr_d__setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gr_d__content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gr_d__content_width', 640 );
}
add_action( 'after_setup_theme', 'gr_d__content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function gr_d__widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'gr_d_' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'gr_d_' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'gr_d__widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gr_d__scripts() {
	wp_enqueue_style( 'gr_d_-style', get_stylesheet_uri() );

	wp_enqueue_script( 'gr_d_-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'gr_d_-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gr_d__scripts' );


function gr_d__set_default_menus()
{
    //lets register some menus
    register_nav_menus(array(
            'Home_Menu'=>__('Home Menu')
    ));
}
add_action('after_setup_theme','gr_d__set_default_menus');

function gr_d__menu_options()
{
    //set the menu items
    
}
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



//shortcode for menus in pages
function gr_d_shortcode_menu($args)
{
    wp_nav_menu( array(
					'menu'        => $args['menu']
    ));
}
add_shortcode('gr_menu','gr_d_shortcode_menu');
