<?php
/*
* Template Name: Groak Business Profile Page
* gr_d_profile_mgmt has the functions for this page.  It may be neater that way
*/
get_header();

//$google_api_key = get_option('groak_google_maps_api');
$businessid = get_query_var('business');

$business = get_user_by('id',$businessid);
$businessmeta = get_user_meta($businessid);


?>
<div class="groak_business_profile">
    <h1><?php echo $businessmeta['business_name'][0]; ?></h1>
    <?php echo gr_get_profile_menu($businessid);?>
    <?php echo gr_get_profile_content($businessid);?>
    <?php echo gr_get_comments();?>
    <?php echo gr_comment_section();?>
</div>
<?php
get_footer();