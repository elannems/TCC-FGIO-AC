<?php
/**
 * BuddyPress - Members Friends Requests
 *
 * @package cne-ac
 * 
 */

do_action( 'bp_before_member_friend_requests_content' ); ?>

<?php if ( bp_has_members( 'type=alphabetical&include=' . bp_get_friendship_requests() ) ) : ?>

	<h2 class="cne-title"><?php _e( 'Pedidos de amizade', 'cne-ac' ); ?></h2>

	<div id="pag-top" class="pagination no-ajax">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<ul id="friend-list" class="item-list">
		<?php while ( bp_members() ) : bp_the_member(); ?>

			<li id="friendship-<?php bp_friend_friendship_id(); ?>">
                            <div class="row">
                                <div class="col-xs-8">
				<div class="item-avatar pull-left">
					<a href="<?php bp_member_link(); ?>"><?php bp_member_avatar(); ?></a>
				</div>

				<div class="item pull-left">
					<div class="item-title"><a href="<?php bp_member_link(); ?>"><?php bp_member_name(); ?></a></div>

					<?php do_action( 'bp_friend_requests_item' ); ?>
				</div>
                                </div>
				<div class="action col-xs-4">
					<a class="btn btn-default accept" href="<?php bp_friend_accept_request_link(); ?>"><?php _e( 'Accept', 'buddypress' ); ?></a> &nbsp;
					<a class="btn btn-default reject" href="<?php bp_friend_reject_request_link(); ?>"><?php _e( 'Recusar', 'cne-ac' ); ?></a>

					<?php do_action( 'bp_friend_requests_item_action' ); ?>
				</div>
                            </div>
			</li>

		<?php endwhile; ?>
	</ul>

	<?php do_action( 'bp_friend_requests_content' ); ?>

	<div id="pag-bottom" class="pagination no-ajax">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="alert alert-info">
		<p><?php _e( 'Você não possui pedidos de amizade pendentes.', 'cne-ac' ); ?></p>
	</div>

<?php endif;?>

<?php

/**
 * Fires after the display of member friend requests content.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_friend_requests_content' ); ?>
