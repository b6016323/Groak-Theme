<?php
/**
 * Functions for listings management
 *
 * @package groak_dev
 */

function gr_list_by()
{
    //role
    $foundusers = get_users('role=business');
    foreach($foundusers as $user)
    {
        //echo "<span>".esc_html($user->username)."</span>";
        echo "triggered";
    }
}
add_shortcode('groak_get_users','gr_list_by');