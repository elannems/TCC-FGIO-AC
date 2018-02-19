<?php

/**
 * BuddyPress - Members Activate
 */

?>

<div id="buddypress">

    <?php do_action( 'bp_before_activation_page' ); ?>

    <div class="page" id="activate-page">

        <div id="template-notices" role="alert" aria-atomic="true">
            <?php do_action( 'template_notices' ); ?>
        </div>

        <?php do_action( 'bp_before_activate_content' ); ?>

        <?php if ( bp_account_was_activated() ) : ?>

            <p><?php printf( __( 'Sua conta foi ativada com sucesso! Agora você pode <a href="%s">entrar</a> utilizando o nome de usuário e senha informados no cadastro.', 'cne-ac' ), get_site_url() . '/entrar' ); ?></p>

       <?php else : ?>

            <p><?php _e( 'Chave de ativação inválida.', 'cne-ac' ); ?></p>

            <form action="" method="get" class="standard-form" id="activation-form">
                <div class="form-group">
                    <label for="key"><?php _e( 'Insira uma chave de ativação:', 'cne-ac' ); ?></label>
                    <input type="text" name="key" id="key" value="" class="form-control" />

                    <div class="submit" style="margin-top: 10px;">
                        <input type="submit" name="submit" value="<?php esc_attr_e( 'Ativar', 'cne-ac' ); ?>" class="btn btn-default pull-right" />
                    </div>
                </div> <!-- .form-group -->
            </form> <!-- .standard-form -->

        <?php endif; ?>

        <?php do_action( 'bp_after_activate_content' ); ?>

    </div> <!-- .page -->

    <?php do_action( 'bp_after_activation_page' ); ?>

</div> <!-- #buddypress -->
