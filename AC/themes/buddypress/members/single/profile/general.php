<?php
/**
 * BuddyPress - Perfil: Configurar Conta do Usuario
 */

do_action( 'bp_before_member_settings_template' ); ?>

<h2 class="cne-title"><?php _e( 'Configurar conta', 'cne-ac' ); ?></h2>

<form action="<?php echo bp_displayed_user_domain() . bp_get_profile_slug() . '/general'; ?>" method="post" class="standard-form" id="settings-form">

    <?php if ( !is_super_admin() ) : ?>
            <div class="form-group">
                <label for="pwd"><?php _e( 'Senha atual <span>(obrigatório para alterar a senha)</span>', 'cne-ac' ); ?></label>
                <input type="password" name="pwd" id="pwd" size="16" value="" class="settings-input small form-control" required <?php bp_form_field_attributes( 'password' ); ?>/>
            </div>
    <?php endif; ?>

    <div class="form-group">
	<label for="pass1"><?php _e( 'Nova senha <span>(obrigatório)</span>', 'cne-ac' ); ?></label>
        <input type="password" name="pass1" id="pass1" size="16" value="" class="settings-input small password-entry form-control" required <?php bp_form_field_attributes( 'password' ); ?>/>
        <div id="pass-strength-result"></div>
    </div>
    <div class="form-group">
        <label for="pass2"><?php _e( 'Repetir nova senha <span>(obrigatório)</span>', 'cne-ac' );?></label>
	<input type="password" name="pass2" id="pass2" size="16" value="" class="settings-input small password-entry-confirm form-control" required <?php bp_form_field_attributes( 'password' ); ?>/>
    </div>
	<?php do_action( 'bp_core_general_settings_before_submit' ); ?>

	<div class="submit">
            <input type="submit" name="submit" value="<?php esc_attr_e( 'Salvar Alterações', 'cne-ac' ); ?>" id="submit" class="auto btn btn-success pull-right" />
	</div>

	<?php do_action( 'bp_core_general_settings_after_submit' ); ?>

	<?php wp_nonce_field( 'cne_ac_bp_profile_general' ); ?>

</form>

<?php

do_action( 'bp_after_member_settings_template' );
