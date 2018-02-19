<?php

/**
 * BuddyPress - Groups Admin - Group Avatar
 */

?>

<h2 class="cne-title"><?php _e( 'Avatar do grupo', 'cne-ac' ); ?></h2>

<?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>
    <div class="alert alert-info">
	<p><?php _e("Envie uma imagem para usar como foto de perfil deste grupo. A imagem será mostrada na página principal do grupo e em resultados de pesquisa.", 'cne-ac' ); ?></p>
    </div>
    <p>
        <label for="file" class="bp-screen-reader-text"><?php _e( 'Selecione uma imagem', 'cne-ac' ); ?></label>
        <input type="file" name="file" id="file" />
        <input type="submit" name="upload" id="upload" value="<?php esc_attr_e( 'Enviar imagem', 'cne-ac' ); ?>" />
        <input type="hidden" name="action" id="action" value="bp_avatar_upload" />
    </p>

    <?php if ( bp_get_group_has_avatar() ) : ?>

        <p><?php _e( "Se você quer excluir a foto do perfil existente sem enviar uma nova, por favor, use a aba de exclusão.", 'cne-ac' ); ?></p>

        <?php bp_button( array( 'id' => 'delete_group_avatar', 'component' => 'groups', 'wrapper_id' => 'delete-group-avatar-button', 'link_class' => 'edit', 'link_href' => bp_get_group_avatar_delete_link(), 'link_text' => __( 'Excluir avatar do grupo', 'cne-ac' ) ) ); ?>

    <?php endif; ?>

    <?php bp_avatar_get_templates(); ?>

    <?php wp_nonce_field( 'bp_avatar_upload' ); ?>

<?php endif; ?>

<?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

    <h4><?php _e( 'Recortar imagem', 'cne-ac' ); ?></h4>

    <img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e( 'Imagem atual', 'cne-ac' ); ?>" />

    <div id="avatar-crop-pane">
        <img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e( 'Imagem recortada', 'cne-ac' ); ?>" />
    </div>

    <input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e( 'Recortar imagem', 'cne-ac' ); ?>" />

    <input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
    <input type="hidden" id="x" name="x" />
    <input type="hidden" id="y" name="y" />
    <input type="hidden" id="w" name="w" />
    <input type="hidden" id="h" name="h" />

    <?php wp_nonce_field( 'bp_avatar_cropstore' ); ?>

<?php endif; ?>
