<?php

/**
 * BuddyPress - Avatars main template
 */

do_action( 'bp_attachments_avatar_check_template' );
?>
<div class="bp-avatar-nav"></div>
<div class="bp-avatar"></div>
<div class="bp-avatar-status"></div>

<script type="text/html" id="tmpl-bp-avatar-nav">
    <a href="{{data.href}}" class="bp-avatar-nav-item" data-nav="{{data.id}}">{{data.name}}</a>
</script>

<?php bp_attachments_get_template_part( 'uploader' ); ?>

<?php bp_attachments_get_template_part( 'avatars/crop' ); ?>

<script id="tmpl-bp-avatar-delete" type="text/html">
    <# if ( 'user' === data.object ) { #>
        <p><?php _e( "Você tem certeza que deseja excluir seu avatar?", 'cne-ac' ); ?></p>
        <p><a class="btn btn-default" id="bp-delete-avatar" href="#"><?php esc_html_e( 'Excluir meu avatar', 'buddypress' ); ?></a></p>
    <# } else if ( 'group' === data.object ) { #>
        <p><?php _e( "Você tem certeza que deseja excluir o avatar do grupo?", 'cne-ac' ); ?></p>
        <p><a class="btn btn-default" id="bp-delete-avatar" href="#"><?php esc_html_e( 'Excluir o avatar do grupo', 'cne-ac' ); ?></a></p>
    <# } else { #>
        <?php do_action( 'bp_attachments_avatar_delete_template' ); ?>
    <# } #>
</script>

<?php do_action( 'bp_attachments_avatar_main_template' ); ?>
