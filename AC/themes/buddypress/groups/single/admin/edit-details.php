<?php

/**
 * BuddyPress - Groups Admin - Edit Details
 */

?>

<h2 class="cne-title"><?php _e( 'Detalhes do grupo', 'cne-ac' ); ?></h2>

<?php do_action( 'bp_before_group_details_admin' ); ?>

<div class="form-group">
    <label for="group-name"><?php _e( 'Nome do Grupo (obrigatório)', 'cne-ac' ); ?></label>
    <input type="text" name="group-name" id="group-name" value="<?php bp_group_name(); ?>" aria-required="true" class="form-control" />
</div>

<div class="form-group">
    <label for="group-desc"><?php _e( 'Descrição do Grupo (obrigatório)', 'cne-ac' ); ?></label>
    <textarea name="group-desc" id="group-desc" aria-required="true" class="form-control" rows="5"><?php bp_group_description_editable(); ?></textarea>
</div>

<?php do_action( 'groups_custom_group_fields_editable' ); ?>

<?php do_action( 'bp_after_group_details_admin' ); ?>

<input type="submit" value="<?php esc_attr_e( 'Salvar Alterações', 'cne-ac' ); ?>" id="save" name="save" class="btn btn-success pull-right" />

<?php wp_nonce_field( 'groups_edit_group_details' ); ?>
