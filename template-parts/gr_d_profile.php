<?php
/*
* Template Name: Groak Business Profile Page
*/
get_header();

$businessid = get_query_var('business');
$business = get_user_by('id',$businessid);
$businessmeta = get_user_meta($businessid);

$business_address = $businessmeta['business_name'][0].",".$businessmeta['business_address'][0].",".$businessmeta['business_postcode'][0].",".$businessmeta['business_country'][0];
echo $business_address;
$business_address = str_replace(' ','%20',$business_address);
echo $business_address;
$map_url = "https://www.google.com/maps/embed/v1/search?key=AIzaSyCNDrILVNLzWGASvtl8TzfVs-YW0p94Zn4&q=".$business_address;
/*
echo "<pre>";
print_r($business);
echo "</pre>";

echo "<pre>";
print_r($businessmeta);
echo "</pre>";
*/
?>
<div class="groak_business_profile">
    <h2><?php echo $businessmeta['business_name'][0]; ?></h2>
    <div class="groak_business_profile_nav">
        <ul>
            <li><a href="menu">Menu</a></li>
            <li><a href="contact">Contact</a></li>
        </ul>
    </div>
    <div class="groak_business_profile_about"><?php echo $businessmeta['description'][0];?></div>
    <div class="groak_business_profile_map">
        <iframe width="600" height="450" frameborder="0" style="border:0" src="<?php echo $map_url;?>" allowfullscreen></iframe>
    </div>
</div>
<?php
get_footer();