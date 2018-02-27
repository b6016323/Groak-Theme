<?php
/**
 * Functions for profile management
 *
 * @package groak_dev
 */
function gr_d_rewrite_tag()
{
    add_rewrite_tag('%business%','([^/]+)','business=');
    add_rewrite_tag('%gr_action%','([^/]+)','gr_action=');
}
add_action('init','gr_d_rewrite_tag');
function gr_d_rewrite_rule()
{
	//regex testing https://regex101.com/r/pEwAKt/1
    add_rewrite_rule('b/([^/]*)/?$','index.php?pagename=profile-page&business=$matches[1]','top');
    add_rewrite_rule('b/([^/]*)/viewmenu/?$','index.php?pagename=profile-page&business=$matches[1]&gr_action=menu','top');
    add_rewrite_rule('b/([^/]*)/contact/?$','index.php?pagename=profile-page&business=$matches[1]&gr_action=contact','top');
    flush_rewrite_rules();
}
add_action('init','gr_d_rewrite_rule');
function gr_d_flush_rules()
{
    flush_rewrite_rules();
}
add_action('after_switch_theme','gr_d_flush_rules');
function gr_d_filter_try($args)
{
    $args[] = "business";
    $args[] = "gr_action";
    return $args;
}
add_filter('query_vars','gr_d_filter_try');

//Functions for profile page
function gr_get_profile_menu($bID)
{
    $url = home_url($wp->request)."/b/".$bID;
    //start the ocntent we will return, which is our nav menu
    $content = "<div class='groak_business_profile_nav'><ul>";
    //get the gr_action value, or home if nothing else
    $action = get_query_var('gr_action', 'home');
    //Start adding the relevant content to the returning content
    switch($action)
    {
        case "home":
            $content .= '<li><a href="'.$url.'/viewmenu">menu</a></li>';
            $content .= '<li><a href="'.$url.'/contact">contact</a></li>';
            break;
        case "menu":
            $content .= '<li><a href="'.$url.'/">home</a></li>';
            $content .= '<li><a href="'.$url.'/contact">contact</a></li>';
            break;
        case "contact":
            $content .= '<li><a href="'.$url.'/">home</a></li>';
            $content .= '<li><a href="'.$url.'/viewmenu">menu</a></li>';
            break;
        default:
            $content .= '<li><a href="'.$url.'/viewmenu">menu</a></li>';
            $content .= '<li><a href="'.$url.'/contact">contact</a></li>';
            break;
    }    
    $content .= "</ul></div>";
    return $content;
}

function gr_get_profile_content($bID)
{
    $action = get_query_var('gr_action', 'home');
    
    $content = "<div class='gr_profile_content'>";
    switch($action)
    {
        case "home":
        case "":
            $content .= gr_get_profile_information($bID);
            $content .= gr_get_profile_events();
            $content .= gr_get_profile_reviews();
            $content .= gr_get_profile_map($bID);
            break;
        case "menu":
            $content .= gr_get_food_menu();
            break;
        case "contact":
            $content .= gr_get_contact_details($bID);
            $content .= gr_get_profile_map($bID);
            break;
        default:
            break;
    }
    $content .= "</div>";
    return $content;
}
function gr_get_profile_information($bID)
{
    $business = get_user_by('id',$bID);
    $businessmeta = get_user_meta($bID);
    $content = '<div class="groak_business_profile_about">'.$businessmeta['description'][0].'</div>';
    return $content;
}
function gr_get_profile_events()
{
    $content = "<h2>Events Coming Soon</h2>";
    return $content;
}
function gr_get_profile_reviews()
{
    $content = "<h2>Reviews Coming Soon</h2>";
    return $content;
}
function gr_get_profile_map($bID)
{
    $content = '<div class="groak_business_profile_map">';
    $google_api_key = get_option('groak_google_maps_api');
    $business = get_user_by('id',$bID);
    $businessmeta = get_user_meta($bID);
    if($businessmeta['business_name'][0] != "" | $businessmeta['business_postcode'][0] != "")
    {
        $business_address = $businessmeta['business_name'][0].",".$businessmeta['business_address'][0].",".$businessmeta['business_postcode'][0].",".$businessmeta['business_country'][0];
        $business_address = str_replace(' ','%20',$business_address);
        $map_url = "https://www.google.com/maps/embed/v1/search?key=".$google_api_key."&q=".$business_address;
        $content .= '<iframe width="600" height="450" frameborder="0" style="border:0" src="'.$map_url.'" allowfullscreen></iframe>';
    }
    $content .= '</div>';
    return $content;
}
function gr_get_food_menu()
{
    $content = "<div class='gorak_business_profile_food_menu'>";
    $content .= "<h2>Food Menu Coming Soon";
    $content .= "</div>";
    return $content;
}
function gr_get_contact_details($bID)
{
    $business = get_user_by('id',$bID);
    $businessmeta = get_user_meta($bID);
    if($businessmeta['business_name'][0] != "" | $businessmeta['business_postcode'][0] != "")
    {
        $content = '<div class="groak_business_profile_address">'.$businessmeta['business_name'][0].',<br>'.$businessmeta['business_address'][0].',<br>'.$businessmeta['business_postcode'][0].',<br>'.$businessmeta['business_country'][0].'</div>';
        $content .= '<div class="groak_business_profile_contact"><a href="tel:'.$businessmeta['business_number'][0].'">'.$businessmeta['business_number'][0].'</a></div>';
    }
    return $content;
}