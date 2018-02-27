<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package groak_dev
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function gr_d__body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'gr_d__body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function gr_d__pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'gr_d__pingback_header' );
/**
* Sort the custom logo for the theme
*/
function groak_theme_logo()
{
    if(!has_custom_logo())
    {
    //check if user has set a different location
	$user_location = geoip_detect2_get_info_from_current_ip();
	$country = $user_location->country->name;
	$country_for_image = str_replace(" ","",$country);
    if($country_for_image = "" | empty($country_for_image))
    {
        $country_for_image = "Default";
    }
	$logo_src = get_template_directory_uri()."/inc/images/gr_".$country_for_image.".png";
    }
    else
    {
        $logo_id = get_theme_mod('custom_logo');
        $logo_src = wp_get_attachment_image_src($logo_id,'full')[0];
    }
    $return_content = "<a href=".esc_url( home_url( '/' ) )." rel='home'><img class='site-logo' src='".$logo_src."'></a>";
    return $return_content;
}
add_filter('get_custom_logo','groak_theme_logo');