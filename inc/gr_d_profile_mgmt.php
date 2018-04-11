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
    add_rewrite_tag('%gr_tags%','([^/]+)','gr_tags=');
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
    $args[] = "gr_tags";
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
    $url = home_url($wp->request)."/list-users?gr_tags=";
    $content = '<div class="groak_business_profile_tags">';
    $business_tags = $businessmeta['business_tags'][0];
    $tags = explode(",",$business_tags);
    foreach($tags as $tag)
    {
        $tag = trim($tag);
        if(!$tag == "")
        {
            $content .= "<span class='gr_business_tag'><a href='$url$tag'>$tag</a></span>";
        }
    }
    
    $content .= '</div>';
    $content .= '<div class="groak_business_profile_about">'.$businessmeta['description'][0].'</div>';
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

function gr_get_comments()
{
    $businessid = get_query_var('business');
    $args = array(
        'meta_query'    =>  array(
            'key'   => 'business_comment',
            'value' => $businessid
        )
    );
    $comment_query = new WP_comment_query;
    $reviews = $comment_query->query($args);
    $review_contents = array();
    foreach($reviews as $review)
    {
        $review_split = explode(",",$review->comment_content);
        foreach($review_split as $rev)
        {
            $rev = trim($rev);
            if(array_key_exists($rev,$review_contents) && $rev != "")
            {
                $review_contents[$rev] += 1;
            }
            else
            {
                if($rev != "")
                {
                    $review_contents[$rev] = 1;
                }
            }
        }
    }
    $content = "<div class='reviews_block'>";
    
    //http://php.net/manual/en/function.key.php    I messed up the structure nof the array so i have to use this, i just want to finish this
    while($rev = current($review_contents))
    {
        $content .= "<div class='review_block'><span class='numOf'>".$rev."</span><span class='theReview'>".key($review_contents)."</span></div>";
        next($review_contents);
    }
    $content .= "</div>";
    return $content;
}

function gr_comment_section()
{
    $businessid = get_query_var('business');
    $reviews = array(
        "The food is great",
        "Excellent service",
        "A hidden gem"
    );
    $new_comment_field = "<p class='comment-form-comment'>";
    $new_comment_field .= "<input type='hidden' name='bid' value='$businessid'>";
    $new_comment_field .= "<input type='hidden' name='comment' value='".time()."'>";
    foreach($reviews as $review)
    {
        $new_comment_field .= "<input type='checkbox' value='$review' name='comments[]' id='$review'><label for='$review'>$review</label><br>";
    }
    $new_comment_field .= "</p>";
    
    $new_logged_in_as = "";
    $new_title_reply = "Leave a review";
    
    $new_defaults = array(
        'comment_field' => $new_comment_field,
        'logged_in_as' => $new_logged_in_as,
        'title_reply' => $new_title_reply,
        'label_submit' => "Leave a review"
    );
    comment_form($new_defaults);
}
function gr_fix_comment_content($commentdata)
{
    $comment_content = "";
    foreach($_POST['comments'] as $review)
    {
        $comment_content .= $review.",";
    }
    $commentdata['comment_content'] = $comment_content;
    return $commentdata;
}
add_filter('preprocess_comment','gr_fix_comment_content');

function gr_custom_comment_meta($comment_id)
{
    add_comment_meta($comment_id, 'business_comment',$_POST['bid']);
}
add_action('comment_post','gr_custom_comment_meta');

function gr_comment_redirect_fix($location)
{
    return $_SERVER["HTTP_REFERER"];
}
add_filter('comment_post_redirect','gr_comment_redirect_fix');
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