<?php

/**
 * BuddyPress - Perfil: Excluir Conta do Usuario
 */

?>

<h2 class="cne-title"><?php _e( 'Excluir conta', 'cne-ac' ); ?></h2>

<div id="message" class="alert alert-info" role="alert">

    <?php if ( bp_is_my_profile() ) : ?>

        <p><?php _e( 'Ao excluir sua conta, todo o conteúdo que você criou será desvinculado do seu usuário e será atribuído o termo "Anônimo" no autor do conteúdo. CUIDADO: não é possível reverter esta ação.', 'cne-ac' ); ?></p>

    <?php else : ?>

        <p><?php _e( 'Ao excluir uma conta de usuário, todo o conteúdo criado será desvinculado do usuário e será atribuído o termo "Anônimo" no autor do conteúdo. CUIDADO: não é possível reverter esta ação.', 'cne-ac' ); ?></p>

    <?php endif; ?>

</div> <!-- #message -->

<form action="<?php echo bp_displayed_user_domain() . bp_get_profile_slug() . '/delete-account'; ?>" name="account-delete-form" id="account-delete-form" class="standard-form" method="post">

    <?php do_action( 'bp_members_delete_account_before_submit' ); ?>

    <div class="checkbox">
        <label for="delete-account-understand"><input type="checkbox" name="delete-account-understand" id="delete-account-understand" value="1" onclick="if(this.checked) { document.getElementById('delete-account-button').disabled = ''; } else { document.getElementById('delete-account-button').disabled = 'disabled'; }" />
            <?php _e( 'Eu quero excluir esta conta.', 'cne-ac' ); ?>
        </label>
    </div> <!-- .checkbox -->


    <div class="submit">
        <input type="submit" disabled="disabled" value="<?php esc_attr_e( 'Excluir Conta', 'cne-ac' ); ?>" id="delete-account-button" name="delete-account-button" class="btn btn-danger pull-right" />
    </div> <!-- .submit -->

    <?php do_action( 'bp_members_delete_account_after_submit' ); ?>

    <?php wp_nonce_field( 'delete-account' ); ?>

</form>

