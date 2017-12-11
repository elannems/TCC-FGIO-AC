<?php
/**
 * BuddyPress - Groups Send Invites
 *
 * @package cne-ac
 * 
 */

do_action( 'bp_before_group_send_invites_content' ); ?>

<?php

if ( bp_get_new_group_invite_friend_list() ) : ?>

    <h2 class="bp-screen-reader-text cne-title"><?php _e( 'Send invites', 'buddypress' ); ?></h2>

    <form action="<?php bp_group_send_invite_form_action(); ?>" method="post" id="send-invite-form" class="standard-form">

        <div class="invite row" aria-live="polite" aria-atomic="false" aria-relevant="all">
                <?php bp_get_template_part( 'groups/single/invites-loop' ); ?>
        </div>

        <div class="submit">
            <input type="submit" name="submit" id="submit" class="btn btn-default" value="<?php esc_attr_e( 'Send Invites', 'buddypress' ); ?>" />
        </div>

            <?php wp_nonce_field( 'groups_send_invites', '_wpnonce_send_invites' ); ?>

            <input type="hidden" name="group_id" id="group_id" value="<?php bp_group_id(); ?>" />

	</form><!-- #send-invite-form -->

<?php

elseif ( !bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

    <div id="message" class="info alert alert-info">
        <p class="notice"><?php _e( 'Group invitations can only be extended to friends.', 'buddypress' ); ?></p>
        <p class="message-body"><?php _e( "Once you've made some friendships, you'll be able to invite those members to this group.", 'buddypress' ); ?></p>
    </div>

<?php

else : ?>

    <div id="message" class="info alert alert-info">
        <p class="notice"><?php _e( 'All of your friends already belong to this group.', 'buddypress' ); ?></p>
    </div>

<?php endif; ?>

<?php do_action( 'bp_after_group_send_invites_content' ); ?>
