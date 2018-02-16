<?php
/**
 * Functions for profile management
 *
 * @package groak_dev
 */

function gr_d_rewrite_tag()
{
    add_rewrite_tag('%business%','([^/]+)','business=');
}
add_action('init','gr_d_rewrite_tag');

function gr_d_rewrite_rule()
{
    add_rewrite_rule('b/([^/]*)/?','index.php?pagename=profile-page&business=$matches[1]','top');
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
    return $args;
}
add_filter('query_vars','gr_d_filter_try');