<?php

/**
 * BuddyPress - Groups
 */

do_action('bp_before_directory_groups_page');
?>

<div id="buddypress">

    <?php do_action('bp_before_directory_groups'); ?>

    <?php do_action('bp_before_directory_groups_content'); ?>

    <?php bp_get_template_part('common/search/dir-search-form'); ?>

    <form action="" method="post" id="groups-directory-form" class="dir-form">

        <div id="template-notices" role="alert" aria-atomic="true">
            
            <?php do_action('template_notices'); ?>

        </div> <!-- #template-notices -->

        <div class="item-list-tabs" id="cne-filter-buttons" aria-label="<?php esc_attr_e('Groups directory main navigation', 'buddypress'); ?>">
            <ul>
                <li class="selected" id="groups-all"><a class="btn btn-default" href="<?php bp_groups_directory_permalink(); ?>"><?php printf(__('All Groups %s', 'buddypress'), '<span>' . bp_get_total_group_count() . '</span>'); ?></a></li>

                <?php if (is_user_logged_in() && bp_get_total_group_count_for_user(bp_loggedin_user_id())) : ?>
                    <li id="groups-personal"><a class="btn btn-default" href="<?php echo bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/'; ?>"><?php printf(__('My Groups %s', 'buddypress'), '<span>' . bp_get_total_group_count_for_user(bp_loggedin_user_id()) . '</span>'); ?></a></li>
                <?php endif; ?>

                <?php do_action('bp_groups_directory_group_filter'); ?>

            </ul>
        </div> <!-- .item-list-tabs -->

        <div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e('Groups directory secondary navigation', 'buddypress'); ?>" role="navigation">
            <div class="form-inline">
                <div class="form-group">
                    <ul>
                        <?php do_action('bp_groups_directory_group_types'); ?>

                        <li id="groups-order-select" class="last filter">

                            <label for="groups-order-by"><?php _e('Order By:', 'buddypress'); ?></label>

                            <select id="groups-order-by" class="form-control">
                                <option value="active"><?php _e('Last Active', 'buddypress'); ?></option>
                                <option value="popular"><?php _e('Most Members', 'buddypress'); ?></option>
                                <option value="newest"><?php _e('Newly Created', 'buddypress'); ?></option>
                                <option value="alphabetical"><?php _e('Alphabetical', 'buddypress'); ?></option>

                                <?php do_action('bp_groups_directory_order_options'); ?>
                            </select>
                        </li> <!-- #groups-order-select -->
                    </ul>
                </div> <!-- .form-group -->
            </div> <!-- .form-inline -->
        </div> <!-- .item-list-tabs -->
        
        <h2 class="bp-screen-reader-text sr-only"><?php _e( 'Groups directory', 'buddypress' ); ?></h2>

        <div id="groups-dir-list" class="groups dir-list">
            <?php bp_get_template_part('groups/groups-loop'); ?>
        </div><!-- #groups-dir-list -->

        <?php do_action('bp_directory_groups_content'); ?>

        <?php wp_nonce_field('directory_groups', '_wpnonce-groups-filter'); ?>

        <?php do_action('bp_after_directory_groups_content'); ?>

    </form> <!-- #groups-directory-form -->

    <?php do_action('bp_after_directory_groups'); ?>

</div> <!-- #buddypress -->

<?php do_action('bp_after_directory_groups_page');
    