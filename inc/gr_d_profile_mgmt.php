<?php
/**
 * Functions for profile management
 *
 * @package groak_dev
 */
function gr_d_rewrite_tag()
{
    //used in profile pages
    add_rewrite_tag('%business%','([^/]+)','business=');
    add_rewrite_tag('%gr_action%','([^/]+)','gr_action=');
    add_rewrite_tag('%gr_users%','([^/]+)','gr_users=');
}
add_action('init','gr_d_rewrite_tag');
function gr_d_rewrite_rule()
{
    //used in profile pages
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
    $args[] = "gr_users";
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
            $content .= gr_get_food_menu($bID);
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
function gr_get_food_menu($bID)
{
    $upload_directory = wp_upload_dir();
    $b = get_user_by('id',$bID);
    $menu_location = $upload_directory['basedir']."/".$b->user_login."/menu.pdf";
    $menu_url = $upload_directory['baseurl']."/".$b->user_login."/menu.pdf";
    $content = "<div class='groak_business_profile_food_menu'>";
    if(file_exists($menu_location))
    {
        $content .= do_shortcode("[pdf-embedder url=$menu_url]");
    }
    else
    {
        $content .= "<h2>Food Menu Coming Soon</h2>";
    }
    $content .= "</div>";
    return $content;
}
function gr_get_contact_details($bID)
{
    $business = get_user_by('id',$bID);
    $businessmeta = get_user_meta($bID);
    if($businessmeta['business_name'][0] != "" | $businessmeta['business_postcode'][0] != "")
    {
        $content = '<div class="groak_business_profile_address">'.$businessmeta['business_name'][0].',<br>'.$businessmeta['business_address'][0].',<br><span class="groak_postcode">'.$businessmeta['business_postcode'][0].'</span>,<br>'.$businessmeta['business_country'][0].'</div>';
        $content .= '<div class="groak_business_profile_contact"><a href="tel:'.$businessmeta['business_number'][0].'">'.$businessmeta['business_number'][0].'</a></div>';
    }
    return $content;
}

//Thank you https://www.iptanus.com/custom-upload-path-for-wordpress-file-upload-plugin/
if (!function_exists('wfu_before_file_upload_handler')) {
    function wfu_before_file_upload_handler($file_path, $file_unique_id) {
      //get the current user
      $user = wp_get_current_user();
      if ( $user->ID != 0 ) {
        //extract filename from $file_path
        $filename = wfu_basename($file_path);
        //get upload dir structure
        $upload_dir = wp_upload_dir();
        //construct new upload dir from upload base dir and the username of the current user
        $new_file_dir = $upload_dir['basedir'].'/'.$user->user_login;
        //create the new file dir, if it is does not exist
        if ( !is_dir($new_file_dir) ) mkdir($new_file_dir, 0777, true);
        //return the new file path
        return $new_file_dir.'/menu.pdf';
      }
    }
    add_filter('wfu_before_file_upload', 'wfu_before_file_upload_handler', 10, 2);
}