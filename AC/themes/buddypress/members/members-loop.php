<?php

/**
 * BuddyPress - Members Loop
 */

do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
    <p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) . '&per_page=5' ) ) : ?>

    <div id="pag-top" class="pagination">

        <div class="pag-count" id="member-dir-count-top">

                <?php bp_members_pagination_count(); ?>

        </div>

        <div class="pagination-links" id="member-dir-pag-top">

                <?php bp_members_pagination_links(); ?>

        </div>

    </div> <!-- #pag-top -->

    <?php do_action( 'bp_before_directory_members_list' ); ?>

    <ul id="members-list" class="item-list" aria-live="assertive" aria-relevant="all">

        <?php while ( bp_members() ) : bp_the_member(); ?>

            <li <?php bp_member_class(); ?>>
                <div class="row">
                    <div class="col-xs-7">
                        <div class="item-avatar pull-left">
                            <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
                        </div> <!-- .item-avatar -->

                        <div class="item pull-left">
                            <div class="item-title">
                                <h2><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></h2>
                            </div>
                            <div class="item-meta">
                                <span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_member_last_active( array( 'relative' => true ) ) ); ?>"><?php bp_member_last_active(); ?></span>
                            </div>
                            <div class="item-meta">
                                <?php printf( __( 'Amigos: %s', 'cne-ac' ), '<span>' . cne_ac_get_total_user_friends() . '</span>' ); ?>
                            </div>
                            <?php do_action( 'bp_directory_members_item' ); ?>
                        </div> <!-- .item -->
                    </div> <!-- .col -->

                    <div class="action col-xs-5">

                        <?php do_action( 'bp_directory_members_actions' ); ?>

                    </div>

                    <div class="clear"></div>

                </div> <!-- .row -->
            </li>

        <?php endwhile; ?>

    </ul> <!-- .item-list -->

    <?php do_action( 'bp_after_directory_members_list' ); ?>

    <?php bp_member_hidden_fields(); ?>

    <div id="pag-bottom" class="pagination">

        <div class="pagination-links" id="member-dir-pag-bottom">

            <?php bp_members_pagination_links(); ?>

        </div>

    </div> <!-- #pag-bottom -->

<?php else: ?>

    <div id="message" class="info alert alert-info">
        <p><?php _e( "Nenhum usuário encontrado.", 'cne-ac' ); ?></p>
    </div>

<?php endif; ?>

<?php do_action( 'bp_after_members_loop' ); ?>
