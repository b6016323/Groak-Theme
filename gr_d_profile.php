<?php
/*
* Template Name: Groak Business Profile Page
*/
get_header();

$google_api_key = 'AIzaSyApisp5iQGZipP4Vb8kqppYahjW8Tp9RRs';

$businessid = get_query_var('business');
$sub_section = get_page_uri();

$business = get_user_by('id',$businessid);
$businessmeta = get_user_meta($businessid);

$business_address = $businessmeta['business_name'][0].",".$businessmeta['business_address'][0].",".$businessmeta['business_postcode'][0].",".$businessmeta['business_country'][0];
$business_address = str_replace(' ','%20',$business_address);
$map_url = "https://www.google.com/maps/embed/v1/search?key=".$google_api_key."&q=".$business_address;

$curr_url = home_url($wp->request);
if($sub_section == "menu")
{
	
}

if($sub_section == "contact")
{
	echo "conatct";
}

?>
<div class="groak_business_profile">
    <h2><?php echo $businessmeta['business_name'][0]; ?></h2>
    <div class="groak_business_profile_nav">
        <ul>
            <li><a href="<?php echo $curr_url?>/menu">Menu</a></li>
            <li><a href="<?php echo $curr_url?>/contact">Contact</a></li>
        </ul>
    </div>
    <div class="groak_business_profile_about"><?php echo $businessmeta['description'][0];?></div>
<?php
if($sub_section == "contact")
{
	?>
	<div class="groak_business_profile_address"><?php echo $businessmeta['business_name'][0].",<br>".$businessmeta['business_address'][0].",<br>".$businessmeta['business_postcode'][0].",<br>".$businessmeta['business_country'][0];?></div>
	<div class="groak_business_profile_contact"><?php echo $businessmeta['business_number'];?></div>
	<?php
}
?>
    <div class="groak_business_profile_map">
        <iframe width="600" height="450" frameborder="0" style="border:0" src="<?php echo $map_url;?>" allowfullscreen></iframe>
    </div>
</div>
<?php
get_footer();