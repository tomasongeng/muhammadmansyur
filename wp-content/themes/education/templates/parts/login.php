<?php $social_login = do_shortcode(themerex_get_theme_option('social_login', '')); ?>
<div id="popup_login" class="popup_wrap popup_login bg_tint_light<?php if (empty($social_login)) echo ' popup_half'; ?>">
	<a href="#" class="popup_close"></a>
	<div class="form_wrap">
		<div<?php if (!empty($social_login)) echo ' class="form_left"'; ?>>
			<form action="<?php echo wp_login_url(); ?>" method="post" name="login_form" class="popup_form login_form">
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr(home_url()); ?>">
				<div class="popup_form_field login_field iconed_field icon-user-2"><input type="text" id="log" name="log" value="" placeholder="<?php _e('Login or Email', 'education'); ?>"></div>
				<div class="popup_form_field password_field iconed_field icon-lock-1"><input type="password" id="password" name="pwd" value="" placeholder="<?php _e('Password', 'education'); ?>"></div>
				<div class="popup_form_field remember_field">
					<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="forgot_password"><?php _e('Forgot password?', 'education'); ?></a>
					<input type="checkbox" value="forever" id="rememberme" name="rememberme">
					<label for="rememberme"><?php _e('Remember me', 'education'); ?></label>
				</div>
                <?php
                $trx_addons_privacy = trx_addons_get_privacy_text();
                if (!empty($trx_addons_privacy)) {
                    ?><div class="trx_addons_popup_form_field trx_addons_popup_form_field_agree">
                    <input type="checkbox" value="1" id="i_agree_privacy_policy_registration" name="i_agree_privacy_policy"><label for="i_agree_privacy_policy_registration"> <?php echo wp_kses_post($trx_addons_privacy); ?></label>
                    </div><?php
                }
                ?>
				<div class="popup_form_field submit_field"><input type="submit" class="submit_button" value="<?php _e('Login', 'education'); ?>"<?php
                        if ( !empty($trx_addons_privacy) ) {
                        ?> disabled="disabled"<?php
                                }?>></div>
				<div class="result message_block"></div>
			</form>
		</div>
		<?php if (!empty($social_login))  { ?>
			<div class="form_right">
				<div class="login_socials_title"><?php _e('You can login using your social profile', 'education'); ?></div>
				<div class="login_socials_list">
					<?php echo trim($social_login); ?>
				</div>
				<div class="login_socials_problem"><a href="#"><?php _e('Problem with login?', 'education'); ?></a></div>
			</div>
		<?php } ?>
	</div>	<!-- /.login_wrap -->
</div>		<!-- /.popup_login -->
