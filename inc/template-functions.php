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
    //setting the logo based on location
    //first check if there is a custom logo set, we dont want to override the custom logo, it may be done on purpose
    if(!has_custom_logo())
    {
		
        //Custom logo not set, we get the location, country and then assign it to an image.  EG: gr_France.png.  All images will need to be done for that format.  There may be a better way of doing this
        //We do need to check if the user is looking at a different location and change the logo based on that.
        //These if/else statements just return a home link with an image inside.
	$user_location = geoip_detect2_get_info_from_current_ip();
	$country = $user_location->country->name;
	$country_for_image = str_replace(" ","",$country);
    if($country_for_image == "" | empty($country_for_image))
    {
        $country_for_image = "Default";
    }
	//NEEDS TIDYING UP but it checks if the file exists,if not just show the default
		if(!file_exists($logo_src))
		{
			$logo_src = get_template_directory_uri()."/inc/images/gr_Default.png";
		}
		else
		{
			$logo_src = get_template_directory_uri()."/inc/images/gr_".$country_for_image.".png";
		}
    }
    else
    {
        //we have a cusotm logo so just assign the image src to what is needed.  Probably dont need to do this but i can come back to it, better safe than... i'll never come back to it. it works
        $logo_id = get_theme_mod('custom_logo');
        $logo_src = wp_get_attachment_image_src($logo_id,'full')[0];
    }
    $return_content = "<a href=".esc_url( home_url( '/' ) )." rel='home'><img class='site-logo' src='".$logo_src."'></a>";
    //return the content to wherever it was called from
    return $return_content;
}
add_filter('get_custom_logo','groak_theme_logo');