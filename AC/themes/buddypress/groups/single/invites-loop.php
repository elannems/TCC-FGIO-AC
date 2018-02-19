<?php

/**
 * BuddyPress - Group Invites Loop
 */

?>
<div class="left-menu col-xs-4">
    
    <div id="message" class="info alert alert-info">
        <p><?php _e( 'AVISO: É necessário acionar o botão "Enviar Convites" para efetivar o envio dos convites.', 'cne-ac' ); ?></p>
    </div>

    <div id="invite-list">

        <ul>
            <?php bp_new_group_invite_friend_list(); ?>
        </ul>

        <?php wp_nonce_field( 'groups_invite_uninvite_user', '_wpnonce_invite_uninvite_user' ); ?>

    </div> <!-- #invite-list -->

</div> <!-- .left-menu -->

<div class="main-column col-xs-8">

    <?php do_action( 'bp_before_group_send_invites_list' ); ?>

    <?php if ( bp_group_has_invites( bp_ajax_querystring( 'invite' ) . '&per_page=5' ) ) : ?>

        <div id="pag-top" class="pagination">

            <div class="pag-count" id="group-invite-count-top">

                <?php bp_group_invite_pagination_count(); ?>

            </div>

            <div class="pagination-links" id="group-invite-pag-top">

                <?php bp_group_invite_pagination_links(); ?>

            </div>

        </div> <!-- #pag-top -->

        <ul id="friend-list" class="item-list">

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
                            <?php do_action( 'bp_group_send_invites_item' ); ?>
                        </div> <!-- .item -->

                        <div class="action col-xs-5">
                            <a class="button remove" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php _e( 'Remove Invite', 'buddypress' ); ?></a>

                            <?php do_action( 'bp_group_send_invites_item_action' ); ?>
                        </div> <!-- .action -->

                    </div> <!-- .row -->
                </li>

            <?php endwhile; ?>

        </ul> <!-- #friend-list -->

        <div id="pag-bottom" class="pagination">

            <div class="pagination-links" id="group-invite-pag-bottom">

                <?php bp_group_invite_pagination_links(); ?>

            </div>

        </div> <!-- #pag-bottom -->

    <?php else : ?>

        <div id="message" class="info alert alert-info">
            <p><?php _e( 'Selecione seus amigos que deseja convidar para o grupo.', 'cne-ac' ); ?></p>
        </div>

    <?php endif; ?>

    <?php

    /**
     * Fires after the display of the group send invites list.
     *
     * @since 1.1.0
     */
    do_action( 'bp_after_group_send_invites_list' ); ?>

</div> <!-- .main-column -->
