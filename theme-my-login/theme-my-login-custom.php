<?php
function tml_registration_errors($errors)
{
    if(empty($_POST['your_name']))
    {
        $errors->add( 'empty_first_name', '<strong>ERROR</strong>: Please enter your first name.' );
    }
    if(empty($_POST['user_email']))
    {
        $errors->add( 'empty_email', '<strong>ERROR</strong>: Please enter an email.' );
    }
    if(empty($_POST['user_login']))
    {
        $errors->add( 'empty_login', '<strong>ERROR</strong>: Please enter a username.' );
    }
    if(empty($_POST['business_name']))
    {
        $errors->add( 'empty_business_name', '<strong>ERROR</strong>: Please enter your business name.' );
    }
    if(empty($_POST['business_address']))
    {
       $errors->add( 'empty_business_address', '<strong>ERROR</strong>: Please enter the address.' );
    }
    if(empty($_POST['business_postcode']))
    {
        $errors->add( 'empty_business_postcode', '<strong>ERROR</strong>: Please enter the business postcode.' );
    }
    if(empty($_POST['business_city']))
    {
        $errors->add( 'empty_city', '<strong>ERROR</strong>: Please enter the businesses city.' );
    }
    if(empty($_POST['business_country']))
    {
        $errors->add( 'empty_country', '<strong>ERROR</strong>: Please enter the businesses country.' );
    }
    if(empty($_POST['business_number']))
    {
        $errors->add( 'empty_number', '<strong>ERROR</strong>: Please enter a contact number.' );
    }
	return $errors;
}
add_filter('registration_errors','tml_registration_errors');


function tml_business_registration($userid)
{
    if(!empty($_POST['your_name']))
    {
        update_user_meta($userid,'your_name',$_POST['your_name']);
    }
    if(!empty($_POST['user_email']))
    {
        update_user_meta($userid,'user_email',$_POST['user_email']);
    }
    if(!empty($_POST['user_login']))
    {
        update_user_meta($userid,'user_login',$_POST['user_login']);
    }
    if(!empty($_POST['business_name']))
    {
        update_user_meta($userid,'business_name',$_POST['business_name']);
    }
    if(!empty($_POST['business_address']))
    {
        update_user_meta($userid,'business_address',$_POST['business_address']);
    }
    if(!empty($_POST['business_address2']))
    {
        update_user_meta($userid,'business_address2',$_POST['business_address2']);
    }
    if(!empty($_POST['business_postcode']))
    {
        update_user_meta($userid,'business_postcode',$_POST['business_postcode']);
    }
    if(!empty($_POST['business_city']))
    {
        update_user_meta($userid,'business_city',$_POST['business_city']);
    }
    if(!empty($_POST['business_country']))
    {
        update_user_meta($userid,'business_country',$_POST['business_country']);
    }
    if(!empty($_POST['business_number']))
    {
        update_user_meta($userid,'business_number',$_POST['business_number']);
    }
}
add_action('user_register','tml_business_registration');
?>