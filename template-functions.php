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

function gr_d__location_logo()
{
	//check if user has set a different location
	$user_location = geoip_detect2_get_info_from_current_ip();
	$country = $user_location->country->name;
	$country_for_image = str_replace(" ","",$country);
	$logo_src = get_template_directory()."/inc/images/gr_".$country_for_image.".png";
	echo "<img src='".$logo_src."'>";
}
add_filter('get_custom_logo','gr_d__location_logo');