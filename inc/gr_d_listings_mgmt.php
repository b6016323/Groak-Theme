<?php
/**
 * Functions for listings management
 *
 * @package groak_dev
 */

function groak_list_by()
{
    $search_query = get_query_var('gr_users','');
    $search_tags = get_query_var('gr_tags','');
    $content .= "<div class='groak_user_list'>";
    if(!$search_query && !$search_tags)
    {
        $found_users = get_users('role=Business');
    }
    else
    {
        if($search_tags == "")
        {
            $searching_for = array(
            'role' => 'business',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                'key' => 'business_name',
                'value' => $search_query,
                'compare' => 'LIKE')));
        }
        else
        {
            $searching_for = array(
            'role' => 'business',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                'key' => 'business_name',
                'value' => $search_query,
                'compare' => 'LIKE'),
                array(
                'key' => 'business_tags',
                'value' => $search_tags,
                'compare' => 'LIKE'
                    )
                )
            );
        }
        
        $the_search_query = new wp_user_query($searching_for);
        $found_users = $the_search_query->get_results();
    }
    if(empty($found_users))
    {
        echo "<div class='groak_user_list_item'><span>There are no matches to your search</span></div>";
    }
    else
    {
        foreach($found_users as $user)
        {
            $user_meta = get_user_meta($user->ID);
            $content .= gr_user_wrapper(array('ID'=>$user->ID,'user_meta'=>$user_meta));
        }
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
    $r_content .= "<span>";
    
    $business_tags = $usermeta['business_tags'][0];
    $tags = explode(",",$business_tags);
    $counter = count($tags);
    $counter = 0;
    foreach($tags as $tag)
    {
        $tag = trim($tag);
        if(!$tag == "")
        {
            $counter++;
            if($counter <= 2)
            {
                $r_content .= "<span class='gr_business_tag'>$tag</span>";
            }
        }
    }
   
    $r_content .= "</span>";
    $r_content .= "<span>Rating To Come</span>";
    $r_content .= "</div>";
    
    return $r_content;
}

function gr_user_search_form()
{
    $url = get_permalink();
    $content = "<div class='groak_search_users'>";
    $content .= "<form role='search' method='get' class='searchform' action='$url'>";
    $content .= "<div><label for='s'>Search Businesses:</label>";
    $content .= "Name: <input type='text' value='' name='gr_users' id='gr_users'>";
    $content .= "Tag: <input type='text' value='' name='gr_tags' id='gr_tag'>";
    $content .= "<input type='submit' id='searchsubmit' value='Search' />";
    $content .= "</div>";
    $content .= "</form>";
    $content .= "</div>";
    echo $content;
}
add_shortcode('groak_user_search','gr_user_search_form');