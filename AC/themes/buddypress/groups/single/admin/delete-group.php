<?php

/**
 * BuddyPress - Groups Admin - Delete Group
 */

?>

<h2 class="cne-title"><?php _e( 'Excluir grupo', 'cne-ac' ); ?></h2>

<?php do_action( 'bp_before_group_delete_admin' ); ?>

<div id="message" class="alert alert-info">
    <p><?php _e( 'CUIDADO: Ao excluir um grupo não é possível reverter esta ação.', 'cne-ac' ); ?></p>
</div>

<div class="checkbox">
    <label for="delete-group-understand"><input type="checkbox" name="delete-group-understand" id="delete-group-understand" value="1" onclick="if(this.checked) { document.getElementById('delete-group-button').disabled = ''; } else { document.getElementById('delete-group-button').disabled = 'disabled'; }" /> <?php _e( 'Eu quero excluir este grupo.', 'cne-ac' ); ?></label>
</div>

<?php do_action( 'bp_after_group_delete_admin' ); ?>

<div class="submit">
    <input type="submit" disabled="disabled" value="<?php esc_attr_e( 'Excluir Grupo', 'cne-ac' ); ?>" id="delete-group-button" name="delete-group-button" class="btn btn-danger pull-right" />
</div>

<?php wp_nonce_field( 'groups_delete_group' ); ?>
