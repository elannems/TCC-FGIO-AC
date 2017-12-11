<?php

/**
 * User Login Form
 *
 * @package cne-ac
 */

?>

<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form">
    <div class="row">
        <div class="col-xs-offset-2 col-xs-8 col-xs-offset-2">

		<div class="bbp-username form-group">
			<label for="user_login"><?php _e( 'Nome de usuário', 'cne-ac' ); ?>: </label>
			<input type="text" name="log" value="<?php bbp_sanitize_val( 'user_login', 'text' ); ?>" id="user_login" class="form-control" tabindex="<?php bbp_tab_index(); ?>" />
		</div>

		<div class="bbp-password form-group">
			<label for="user_pass"><?php _e( 'Senha', 'cne-ac' ); ?>: </label>
			<input type="password" name="pwd" value="<?php bbp_sanitize_val( 'user_pass', 'password' ); ?>" id="user_pass" class="form-control" tabindex="<?php bbp_tab_index(); ?>" />
		</div>

		<div class="checkbox">
                    <label for="rememberme">
			<input type="checkbox" name="rememberme" value="forever" <?php checked( bbp_get_sanitize_val( 'rememberme', 'checkbox' ) ); ?> id="rememberme" tabindex="<?php bbp_tab_index(); ?>" />
			<?php _e( 'Mantenha-me conectado', 'cne-ac' ); ?>
                    </label>
		</div>

		<?php do_action( 'login_form' ); ?>

		<div>

                <button type="submit" tabindex="<?php bbp_tab_index(); ?>" name="user-submit" class="btn btn-default pull-right user-submit"><?php _e( 'Log In', 'bbpress' ); ?></button>

                <?php bbp_user_login_fields(); ?>

		</div>
        </div>
	</div>
</form>
