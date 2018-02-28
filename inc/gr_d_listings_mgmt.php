<?php
/**
 * Functions for listings management
 *
 * @package groak_dev
 */

function groak_list_by()
{
    $content = "<div class='groak_user_list'>";
    //role
    $found_users = get_users('role=Business');
    foreach($found_users as $user)
    {
        $user_meta = get_user_meta($user->ID);
        $content .= gr_user_wrapper(array('ID'=>$user->ID,'user_meta'=>$user_meta));
    }
    $content .= "</div>";
    echo $content;
}
add_shortcode('groak_get_users','groak_list_by');

function gr_user_wrapper($args)
{
    $usermeta = $args['user_meta'];
    $bID = $args['ID'];
    $url = home_url($wp->request)."/b/".$bID;
    $r_content = "<div class='groak_user_list_item'>";
    $r_content .= "<span><a href='$url'>".$usermeta['business_name'][0]."</a></span>";
    $r_content .= "<span>".$usermeta['business_city'][0]."</span>";
    $r_content .= "<span>Tags To Come</span>";
    $r_content .= "<span>Rating To Come</span>";
    $r_content .= "</div>";
    
    return $r_content;
}