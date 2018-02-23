<?php

/**
 * BuddyPress - Perfil: Alterar Avatar do Usuario
 */

?>

<h2 class="cne-title"><?php _e( 'Alterar avatar', 'cne-ac' ); ?></h2>

<?php

do_action( 'bp_before_profile_avatar_upload_content' ); ?>

<div class="alert alert-info" role="alert">
    <p><?php _e( 'O avatar é visível para todos, por isto solicitamos que não utilize uma foto sua ou de outras pessoas.', 'cne-ac' ); ?></p>
</div>

<form action="" method="post" id="avatar-upload-form" class="standard-form" enctype="multipart/form-data">

    <?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>

        <?php wp_nonce_field( 'bp_avatar_upload' ); ?>

        <p id="avatar-upload">
            <label for="file" class="bp-screen-reader-text">
                <?php _e( 'Selecione uma imagem', 'cne-ac' ); ?>
            </label>
            <input type="file" name="file" id="file" />
            <input type="submit" name="upload" id="upload" value="<?php esc_attr_e( 'Enviar imagem', 'cne-ac' ); ?>" />
            <input type="hidden" name="action" id="action" value="bp_avatar_upload" />
        </p>

        <?php if ( bp_get_user_has_avatar() ) : ?>
            <p><?php _e( "Se você quer excluir o avatar atual e não deseja enviar um novo, por favor, use a aba \"Excluir\".", 'cne-ac' ); ?></p>
            <p><a class="btn btn-default" href="<?php bp_avatar_delete_link(); ?>"><?php _e( 'Excluir meu avatar', 'cne-ac' ); ?></a></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

        <h5><?php _e( 'Recortar imagem', 'cne-ac' ); ?></h5>

        <img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e( 'Imagem atual', 'cne-ac' ); ?>" />

        <div id="avatar-crop-pane">
            <img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e( 'Imagem recortada', 'cne-ac' ); ?>" />
        </div>

        <input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" class="btn btn-default" value="<?php esc_attr_e( 'Recortar imagem', 'cne-ac' ); ?>" />

        <input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />

        <?php wp_nonce_field( 'bp_avatar_cropstore' ); ?>

    <?php endif; ?>

</form>

<?php bp_avatar_get_templates(); ?>

<?php do_action( 'bp_after_profile_avatar_upload_content' ); ?>
