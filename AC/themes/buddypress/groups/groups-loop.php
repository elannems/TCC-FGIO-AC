<?php

/**
 * BuddyPress - Groups Loop
 */

?>

<?php

do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
    <p class="current-group-type"><?php bp_current_group_directory_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) . '&per_page=5' ) ) : ?>

    <div id="pag-top" class="pagination">

        <div class="pag-count" id="group-dir-count-top">

            <?php bp_groups_pagination_count(); ?>

        </div>

        <div class="pagination-links" id="group-dir-pag-top">

            <?php bp_groups_pagination_links(); ?>

        </div>

    </div> <!-- .pagination -->

    <?php do_action( 'bp_before_directory_groups_list' ); ?>

    <ul id="groups-list" class="item-list" aria-live="assertive" aria-atomic="true" aria-relevant="all">

        <?php while ( bp_groups() ) : bp_the_group(); ?>
            <li <?php bp_group_class(); ?>>
                <div class="cne-bp-group row">
                    <div class="col-xs-8">
                        <div class="item-avatar pull-left">
                            <a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=thumb&width=50&height=50' ); ?></a>
                        </div> <!-- .item-avatar -->

                        <div class="item pull-left">
                            <div class="item-title"><h2><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></h2></div>
                            <div class="item-meta"><?php _e('Membros: ', 'cne-ac') . bp_group_total_members(); ?></div>
                            <div class="item-meta"><span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => true ) ) ); ?>"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span></div>

                            <?php do_action( 'bp_directory_groups_item' ); ?>

                        </div> <!-- .item -->
                    </div> <!-- .col -->

                    <div class="action col-xs-4">

                        <?php do_action( 'bp_directory_groups_actions' ); ?>

                    </div> <!-- .action -->

                </div> <!-- .row -->
                        
                <div class="row">
                    <div class="col-xs-12">
                        <div class="item-desc"><?php bp_group_description_excerpt(); ?></div>
                    </div>
                </div> <!-- .row -->
                        
                <div class="clear"></div>
                
            </li>
            
	<?php endwhile; ?>

    </ul> <!-- #groups-list -->

    <?php do_action( 'bp_after_directory_groups_list' ); ?>

    <div id="pag-bottom" class="pagination">

        <div class="pagination-links" id="group-dir-pag-bottom">

            <?php bp_groups_pagination_links(); ?>

        </div>

    </div> <!-- .pagination -->

<?php else: ?>

    <div id="message" class="info alert alert-info">
            <p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
    </div>

<?php endif; ?>

<?php do_action( 'bp_after_groups_loop' ); ?>
