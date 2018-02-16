<?php
/*
* Template Name: Groak Business Profile Page
*/
get_header();

$businessid = get_query_var('business');
$business = get_user_by('id',$businessid);
$businessmeta = get_user_meta($businessid);

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
    <ul><li><a href="menu">Menu</a></li><li><a href="contact">Contact</a></li></ul>
        <div class="groak_business_profile_about"><?php echo $businessmeta['description'][0];?></div>
    </div>
</div>
<?php
get_footer();