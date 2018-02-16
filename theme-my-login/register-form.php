<?php
/*
Custom theme template
*/
?>
<div class="tml tml-register" id="theme-my-login<?php $template->the_instance(); ?>">
	<?php $template->the_errors(); ?>
	<form name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register', 'login_post' ); ?>" method="post">
        <p class="tml-user-yourname-wrap">
			<label for="user_yourname<?php $template->the_instance(); ?>"><?php _e( 'Your Name', 'theme-my-login' ); ?></label>
			<input type="text" name="your_name" id="your_name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'your_name' ); ?>" size="20" />
		</p>
        <p class="tml-user-email-wrap">
			<label for="user_email<?php $template->the_instance(); ?>"><?php _e( 'E-mail', 'theme-my-login' ); ?></label>
			<input type="text" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" />
		</p>        
		<?php if ( 'email' != $theme_my_login->get_option( 'login_type' ) ) : ?>
		<p class="tml-user-login-wrap">
			<label for="user_login<?php $template->the_instance(); ?>"><?php _e( 'Username', 'theme-my-login' ); ?></label>
			<input type="text" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
		</p>
		<?php endif; ?>
		<?php do_action( 'register_form' ); ?>

		<p class="tml-registration-confirmation" id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'Registration confirmation will be e-mailed to you.', 'theme-my-login' ) ); ?></p>

        <p class="tml-business-name-wrap">
			<label for="business_name<?php $template->the_instance(); ?>"><?php _e( 'Business Name', 'theme-my-login' ); ?></label>
			<input type="text" name="business_name" id="business_name<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'business_name' ); ?>" size="20" />
		</p>
        <p class="tml-business-address-wrap">
			<label for="business_address<?php $template->the_instance(); ?>"><?php _e( 'Business Address Line 1', 'theme-my-login' ); ?></label>
			<input type="text" name="business_address" id="business_address<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'business_address' ); ?>" size="20" />
		</p>
        <p class="tml-business-address-wrap2">
			<label for="business_address2<?php $template->the_instance(); ?>"><?php _e( 'Business Address Line 2', 'theme-my-login' ); ?></label>
			<input type="text" name="business_address2" id="business_address2<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'business_address2' ); ?>" size="20" />
		</p>
        <p class="tml-business-postcode">
			<label for="business_postcode<?php $template->the_instance(); ?>"><?php _e( 'Business Postcode', 'theme-my-login' ); ?></label>
			<input type="text" name="business_postcode" id="business_postcode<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'business_postcode' ); ?>" size="20" />
		</p>
        <p class="tml-business-city">
			<label for="business_city<?php $template->the_instance(); ?>"><?php _e( 'Business City', 'theme-my-login' ); ?></label>
			<input type="text" name="business_city" id="business_city<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'business_city' ); ?>" size="20" />
		</p>
        <p class="tml-business-country">
			<label for="business_country<?php $template->the_instance(); ?>"><?php _e( 'Business Country', 'theme-my-login' ); ?></label>
			<input type="text" name="business_country" id="business_country<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'business_country' ); ?>" size="20" />
		</p>
        <p class="tml-business-number">
			<label for="business_number<?php $template->the_instance(); ?>"><?php _e( 'Contact Number', 'theme-my-login' ); ?></label>
			<input type="text" name="business_number" id="business_number<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'business_number' ); ?>" size="20" />
		</p>
        
		<p class="tml-submit-wrap">
			<input type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>" value="<?php esc_attr_e( 'Register', 'theme-my-login' ); ?>" />
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="register" />
		</p>
        
	</form>
	<?php $template->the_action_links( array( 'register' => false ) ); ?>
</div>
