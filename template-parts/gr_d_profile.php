
<?php
/*
* Template Name: Groak Business Profile Page
*/
get_header();
do_shortcode('geoip_detect2 property="country"');
$google_api_key = get_option('groak_google_maps_api');
$businessid = get_query_var('business');

$business = get_user_by('id',$businessid);
$businessmeta = get_user_meta($businessid);

//Check if the user has selected to view the menu
$view_menu_option = get_query_var('viewmenu',false);
if($view_menu_option)
{
    //test if this user has a menu
    echo "show menu";
}

//Check if business address is empty
// we need a name and post code minimum (i think) to search googles maps, so we check for a business name and postcode
$do_address = true;
if($businessmeta['business_name'][0] == "" | $businessmeta['business_postcode'][0] == "")
{
    $do_address = false;
}

$business_address = $businessmeta['business_name'][0].",".$businessmeta['business_address'][0].",".$businessmeta['business_postcode'][0].",".$businessmeta['business_country'][0];
$business_address = str_replace(' ','%20',$business_address);
$map_url = "https://www.google.com/maps/embed/v1/search?key=".$google_api_key."&q=".$business_address;
$curr_url = home_url($wp->request);

?>
<div class="groak_business_profile">
    <h2><?php echo $businessmeta['business_name'][0]; ?></h2>
    <div class="groak_business_profile_nav">
        <ul>
            <li><a href="#menu">Menu</a></li><!--Test if this user has a menu-->
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
    <div class="groak_business_profile_about"><?php echo $businessmeta['description'][0];?></div>
    <?php
    if($do_address)
    {
        ?>
    <div class="groak_business_profile_address"><?php echo $businessmeta['business_name'][0].",<br>".$businessmeta['business_address'][0].",<br>".$businessmeta['business_postcode'][0].",<br>".$businessmeta['business_country'][0];?></div>
    <?php
    }
        ?>
	
	<div class="groak_business_profile_contact"><?php echo $businessmeta['business_number'][0];?></div>
    <?php
    if($do_address)
    {
        ?>
    <div class="groak_business_profile_map">
        <iframe width="600" height="450" frameborder="0" style="border:0" src="<?php echo $map_url;?>" allowfullscreen></iframe>
    </div>
    <?php
    }
        ?>
</div>
<?php
get_footer();