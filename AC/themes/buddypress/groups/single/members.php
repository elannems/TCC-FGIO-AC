<?php

/**
 * BuddyPress - Groups Members
 */

?>

<?php if ( bp_group_has_members( bp_ajax_querystring( 'group_members' ) . '&per_page=5' ) ) : ?>

    <?php do_action( 'bp_before_group_members_content' ); ?>

    <div id="pag-top" class="pagination">

        <div class="pag-count" id="member-count-top">

            <?php bp_members_pagination_count(); ?>

        </div>

        <div class="pagination-links" id="member-pag-top">

            <?php bp_members_pagination_links(); ?>

        </div>

    </div> <!-- #pag-top -->

    <?php do_action( 'bp_before_group_members_list' ); ?>

    <ul id="member-list" class="item-list">

        <?php while ( bp_group_members() ) : bp_group_the_member(); ?>
        
            <li>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="item-avatar pull-left">
                            <a href="<?php bp_group_member_domain(); ?>"><?php bp_group_member_avatar_mini(); ?></a>
                        </div> <!-- .item-avatar -->

                        <div class="item pull-left">
                            <div class="item-title">
                                <h2><?php bp_group_member_link(); ?></h2>
                            </div>
                            <div class="item-meta">
                                <span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_member_joined_since( array( 'relative' => false ) ) ); ?>"><?php bp_group_member_joined_since(); ?></span>
                            </div>
                        </div> <!-- .item -->
                    </div> <!-- .col -->
		
                    <?php do_action( 'bp_group_members_list_item' ); ?>

                    <?php if ( bp_is_active( 'friends' ) ) : ?>

                        <div class="action col-xs-4">

                            <?php bp_add_friend_button( bp_get_group_member_id(), bp_get_group_member_is_friend() ); ?>

                            <?php do_action( 'bp_group_members_list_item_action' ); ?>

                        </div> <!-- .action -->

                    <?php endif; ?>
                </div> <!-- .row -->
            </li>

        <?php endwhile; ?>

    </ul> <!-- .item-list -->

    <?php do_action( 'bp_after_group_members_list' ); ?>

    <div id="pag-bottom" class="pagination">

        <div class="pagination-links" id="member-pag-bottom">

            <?php bp_members_pagination_links(); ?>

        </div>

    </div> <!-- #pag-bottom -->

    <?php do_action( 'bp_after_group_members_content' ); ?>

<?php else: ?>

    <div id="message" class="info alert alert-info">
            <p><?php _e( 'No members were found.', 'buddypress' ); ?></p>
    </div>

<?php endif; ?>
