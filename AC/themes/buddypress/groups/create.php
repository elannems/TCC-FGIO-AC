<?php

/**
 * BuddyPress - Groups Create
 */

do_action( 'bp_before_create_group_page' ); ?>

<div id="buddypress">

    <?php do_action( 'bp_before_create_group_content_template' ); ?>

    <form action="<?php bp_group_creation_form_action(); ?>" method="post" id="create-group-form" class="standard-form" enctype="multipart/form-data">

        <?php do_action( 'bp_before_create_group' ); ?>
        <div class="row">
            <div class="item-list-tabs no-ajax col-xs-12" id="group-create-tabs">
                <ul class="nav nav-pills">

                    <?php bp_group_creation_tabs(); ?>

                </ul>
            </div>
        </div> <!-- .row -->

        <div id="template-notices" role="alert" aria-atomic="true">
            <?php do_action( 'template_notices' ); ?>
        </div> <!-- #template-notices -->

        <div class="item-body" id="group-create-body">

            <?php /* Group creation step 1: Basic group details */ ?>
            <?php if ( bp_is_group_creation_step( 'group-details' ) ) : ?>

                <h2 class="cne-title"><?php _e( 'Group Details', 'buddypress' ); ?></h2>

                <?php

                do_action( 'bp_before_group_details_creation_step' ); ?>

                <div class="form-group">
                    <label for="group-name"><?php _e( 'Nome do Grupo (obrigatório)', 'cne-ac' ); ?></label>
                    <input type="text" name="group-name" id="group-name" class="form-control" aria-required="true" value="<?php bp_new_group_name(); ?>" />
                </div> <!-- .form-group -->

                <div class="form-group">
                    <label for="group-desc"><?php _e( 'Descrição do Grupo (obrigatório)', 'cne-ac' ); ?></label>
                    <textarea name="group-desc" id="group-desc" class="form-control" rows="5" aria-required="true"><?php bp_new_group_description(); ?></textarea>
                </div> <!-- .form-group -->

                <?php

                do_action( 'bp_after_group_details_creation_step' );
                do_action( 'groups_custom_group_fields_editable' ); // @Deprecated

                wp_nonce_field( 'groups_create_save_group-details' ); 

                ?>

            <?php endif; ?>

            <?php /* Group creation step 2: Group settings */ ?>
            <?php if ( bp_is_group_creation_step( 'group-settings' ) ) : ?>

                <h2 class="cne-title"><?php _e( 'Configurações do Grupo', 'cne-ac' ); ?></h2>

                <?php do_action( 'bp_before_group_settings_creation_step' ); ?>

                <fieldset class="group-create-invitations">

                    <legend><?php _e( 'Enviar convites', 'buddypress' ); ?></legend>

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

                </fieldset>

                <?php do_action( 'bp_after_group_settings_creation_step' ); ?>

                <?php wp_nonce_field( 'groups_create_save_group-settings' ); ?>

            <?php endif; ?>

            <?php /* Group creation step 3: Avatar Uploads */ ?>
            <?php if ( bp_is_group_creation_step( 'group-avatar' ) ) : ?>

                <h2 class="cne-title"><?php _e( 'Group Avatar', 'buddypress' ); ?></h2>

                <?php do_action( 'bp_before_group_avatar_creation_step' ); ?>

                <?php if ( 'upload-image' == bp_get_avatar_admin_step() ) : ?>
                    <div class="row">
                        <div class="col-md-2">
                                <?php bp_new_group_avatar(); ?>
                        </div> <!-- .col -->
                        <div class="col-md-10">
                            <div class="alert alert-info">
                                <p><?php _e( "Upload an image to use as a profile photo for this group. The image will be shown on the main group page, and in search results.", 'buddypress' ); ?></p>
                            </div>
                        </div> <!-- .col -->
                    </div> <!-- .row -->
                    <div class="main-column">
                            <p>
                                <label for="file" class="sr-only"><?php _e( 'Select an image', 'buddypress' ); ?></label>
                                <input type="file" name="file" id="file" />
                                <input type="submit" name="upload" id="upload" value="<?php esc_attr_e( 'Upload Image', 'buddypress' ); ?>" />
                                <input type="hidden" name="action" id="action" value="bp_avatar_upload" />
                            </p>

                            <div class="alert alert-info">
                                <p><?php _e( 'Para pular este passo, clique no botão "Salvar e Continuar".', 'cne-ac' ); ?></p>
                            </div>
                    </div><!-- .main-column -->

                        <?php bp_avatar_get_templates(); ?>

                <?php endif; ?>

                <?php if ( 'crop-image' == bp_get_avatar_admin_step() ) : ?>

                    <h4><?php _e( 'Recortar imagem', 'cne-ac' ); ?></h4>

                    <img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e( 'Imagem atual', 'cne-ac' ); ?>" />

                    <div id="avatar-crop-pane">
                        <img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e( 'Imagem recortada', 'cne-ac' ); ?>" />
                    </div>

                    <input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e( 'Recortar imagem', 'cne-ac' ); ?>" />

                    <input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
                    <input type="hidden" name="upload" id="upload" />
                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />

                <?php endif; ?>

                <?php do_action( 'bp_after_group_avatar_creation_step' ); ?>

                <?php wp_nonce_field( 'groups_create_save_group-avatar' ); ?>

            <?php endif; ?>

            <?php /* Group creation step 5: Invite friends to group */ ?>
            <?php if ( bp_is_group_creation_step( 'group-invites' ) ) : ?>

                <h2 class="cne-title"><?php _e( 'Enviar convites', 'buddypress' ); ?></h2>

                <?php do_action( 'bp_before_group_invites_creation_step' ); ?>

                <?php if ( bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
                    <div class="row-fluid">
                        <div id="message" class="info alert alert-info">
                            <p><?php _e('Selecione seus amigos que deseja convidar para o grupo.', 'cne-ac' ); ?></p>
                        </div>
                    </div> <!-- .row-fluid -->
                    <div class="row">
                        <div class="left-menu col-xs-4">

                            <div id="invite-list">
                                <ul>
                                    <?php bp_new_group_invite_friend_list(); ?>
                                </ul>

                                <?php wp_nonce_field( 'groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ); ?>
                            </div>

                        </div> <!-- .left-menu -->

                        <div class="main-column col-xs-8">

                            <?php /* The ID 'friend-list' is important for AJAX support. */ ?>
                            <ul id="friend-list" class="item-list">

                                <?php if ( bp_group_has_invites() ) : ?>

                                    <?php while ( bp_group_invites() ) : bp_group_the_invite(); ?>

                                        <li id="<?php bp_group_invite_item_id(); ?>">
                                            <div class="row">
                                                <div class="item col-xs-7">
                                                    <div class="item-title">
                                                        <h2><?php bp_group_invite_user_link(); ?></h2>
                                                    </div>
                                                    <div class="item-meta">
                                                        <span class="activity"><?php bp_group_invite_user_last_active(); ?></span>
                                                    </div>
                                                    <div class="action col-xs-5">
                                                        <a class="remove" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php _e( 'Remove Invite', 'buddypress' ); ?></a>
                                                    </div>
                                                </div> <!-- .col -->
                                            </div> <!-- .row -->
                                        </li>

                                    <?php endwhile; ?>

                                    <?php wp_nonce_field( 'groups_send_invites', '_wpnonce_send_invites' ); ?>

                                <?php endif; ?>

                            </ul>

                        </div><!-- .main-column -->
                    </div> <!-- .row -->

                <?php else : ?>

                    <div id="message" class="info alert alert-info">
                        <p><?php _e( 'Os convites de grupo só podem ser estendidos para amigos.', 'cne-ac' ); ?></p><p><?php _e( 'Depois de ter feito algumas amizades, você vai ser capaz de convidar esses membros para o grupo.', 'cne-ac' ); ?></p>
                    </div>

                <?php endif; ?>

            <?php wp_nonce_field( 'groups_create_save_group-invites' ); ?>

            <?php do_action( 'bp_after_group_invites_creation_step' ); ?>

            <?php endif; ?>

            <?php do_action( 'groups_custom_create_steps' ); ?>

            <?php do_action( 'bp_before_group_creation_step_buttons' ); ?>

            <?php if ( 'crop-image' != bp_get_avatar_admin_step() ) : ?>

                <div class="submit" id="previous-next">

                    <?php /* Previous Button */ ?>
                    <?php if ( !bp_is_first_group_creation_step() ) : ?>

                        <input type="button" value="<?php esc_attr_e( 'Voltar', 'cne-ac' ); ?>" id="group-creation-previous" class="btn btn-warning pull-left" name="previous" onclick="location.href='<?php bp_group_creation_previous_link(); ?>'" />

                    <?php endif; ?>

                    <?php /* Next Button */ ?>
                    <?php if ( !bp_is_last_group_creation_step() && !bp_is_first_group_creation_step() ) : ?>

                        <input type="submit" value="<?php esc_attr_e( 'Salvar e Continuar', 'cne-ac' ); ?>" id="group-creation-next" class="btn btn-success pull-right" name="save" />

                    <?php endif;?>

                    <?php /* Create Button */ ?>
                    <?php if ( bp_is_first_group_creation_step() ) : ?>

                        <input type="submit" value="<?php esc_attr_e( 'Criar Grupo e Continuar', 'cne-ac' ); ?>" id="group-creation-create" class="btn btn-success pull-right" name="save" />

                    <?php endif; ?>

                    <?php /* Finish Button */ ?>
                    <?php if ( bp_is_last_group_creation_step() ) : ?>

                        <input type="submit" value="<?php esc_attr_e( 'Finalizar', 'cne-ac' ); ?>" id="group-creation-finish" class="btn btn-success pull-right" name="save" />

                    <?php endif; ?>
                </div>

            <?php endif;?>

            <?php do_action( 'bp_after_group_creation_step_buttons' ); ?>

            <?php /* Don't leave out this hidden field */ ?>
            <input type="hidden" name="group_id" id="group_id" value="<?php bp_new_group_id(); ?>" />

            <?php do_action( 'bp_directory_groups_content' ); ?>

        </div><!-- .item-body -->

        <?php do_action( 'bp_after_create_group' ); ?>

    </form>

    <?php do_action( 'bp_after_create_group_content_template' ); ?>

</div>

<?php do_action( 'bp_after_create_group_page' ); ?>
