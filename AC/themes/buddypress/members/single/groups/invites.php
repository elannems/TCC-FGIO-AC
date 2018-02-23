<?php

/**
 * BuddyPress - Members Single Group Invites
 */

do_action( 'bp_before_group_invites_content' ); ?>

<?php if ( bp_has_groups( 'type=invites&user_id=' . bp_loggedin_user_id() ) ) : ?>

    <h2 class="cne-title"><?php _e( 'Convites recebidos', 'cne-ac' ); ?></h2>

    <ul id="group-list" class="invites item-list">

        <?php while ( bp_groups() ) : bp_the_group(); ?>

            <li>
                <div class="cne-bp-group row">
                    <div class="col-xs-8">
                        <div class="item-avatar pull-left">
                            <a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=thumb&width=50&height=50' ); ?></a>
                        </div>
                        <div class="item-title pull-left">
                            <h2><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></h2>
                        </div>
                    </div><!-- .col -->

                    <?php do_action( 'bp_group_invites_item' ); ?>

                    <div class="action col-xs-4">
                        <a class="btn btn-default accept" href="<?php bp_group_accept_invite_link(); ?>"><?php _e( 'Aceitar', 'cne-ac' ); ?></a> &nbsp;
                        <a class="btn btn-default reject confirm" href="<?php bp_group_reject_invite_link(); ?>"><?php _e( 'Recusar', 'cne-ac' ); ?></a>

                        <?php do_action( 'bp_group_invites_item_action' ); ?>

                    </div> <!-- .col -->
                </div> <!-- .row -->

                <div class="row">
                    <div class="col-xs-12">
                        <div class="item-desc" style="margin-top: 5px;"><?php bp_group_description_excerpt(); ?></div>
                    </div>
                </div> <!-- .row -->
            </li>

        <?php endwhile; ?>
    </ul> <!-- .invites -->

<?php else: ?>

    <div id="message" class="alert alert-info">
        <p><?php _e( 'Você não possui convites para grupos.', 'cne-ac' ); ?></p>
    </div>

<?php endif;?>

<?php do_action( 'bp_after_group_invites_content' ); ?>
