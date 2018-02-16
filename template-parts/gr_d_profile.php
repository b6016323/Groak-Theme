<?php
/*
* Template Name: Groak Business Profile Page
*/
get_header();

$businessid = get_query_var('business');

?>
<div class="groak_business_profile">
    <h2><?php echo $businessid; ?></h2>
</div>
<?php
get_footer();