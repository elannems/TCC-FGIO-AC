<?php

/**
 * BuddyPress - Groups Admin - Group Settings
 */

?>

<h2 class="cne-title"><?php _e( 'Configurações do grupo', 'cne-ac' ); ?></h2>

<?php do_action( 'bp_before_group_settings_admin' ); ?>

<fieldset class="group-create-invitations">

    <legend><?php _e( 'Enviar convites', 'cne-ac' ); ?></legend>

    <p><?php _e( 'Quem pode convidar outras pessoas para o grupo?', 'cne-ac' ); ?></p>

    <div class="radio">
        <label for="group-invite-status-members"><input type="radio" name="group-invite-status" id="group-invite-status-members" value="members"<?php bp_group_show_invite_status_setting( 'members' ); ?> /> <?php _e( 'Todos os usuários do grupo', 'cne-ac' ); ?></label>
    </div>
    <div class="radio">
        <label for="group-invite-status-mods"><input type="radio" name="group-invite-status" id="group-invite-status-mods" value="mods"<?php bp_group_show_invite_status_setting( 'mods' ); ?> /> <?php _e( 'Somente os administradores e moderadores do grupo', 'cne-ac' ); ?></label>
    </div>
    <div class="radio">
        <label for="group-invite-status-admins"><input type="radio" name="group-invite-status" id="group-invite-status-admins" value="admins"<?php bp_group_show_invite_status_setting( 'admins' ); ?> /> <?php _e( 'Somente os administradores do grupo', 'cne-ac' ); ?></label>
    </div>

</fieldset> <!-- .group-create-invitations -->

<?php do_action( 'bp_after_group_settings_admin' ); ?>

<p><input type="submit" value="<?php esc_attr_e( 'Salvar Alterações', 'cne-ac' ); ?>" id="save" name="save" class="btn btn-success pull-right" /></p>
<?php wp_nonce_field( 'groups_edit_group_settings' ); ?>
