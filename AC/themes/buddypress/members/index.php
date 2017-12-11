<?php
/**
 * BuddyPress - Users
 *
 * @package cne-ac
 * 
 */

do_action( 'bp_before_directory_members_page' ); ?>

<div id="buddypress">
    
    <div class="row">
        <div id="template-notices" class="col-xs-12" role="alert" aria-atomic="true">
            <?php do_action( 'template_notices' ); ?>
        </div>
    </div>

    <?php

    do_action( 'bp_before_directory_members' ); ?>

    <?php

    do_action( 'bp_before_directory_members_content' ); ?>

    <?php bp_get_template_part( 'common/search/dir-search-form' ); ?>


    <?php

    do_action( 'bp_before_directory_members_tabs' ); ?>

    <form action="" method="post" id="members-directory-form" class="dir-form">

        <div class="item-list-tabs" id="cne-filter-buttons" aria-label="<?php esc_attr_e( 'Members directory main navigation', 'buddypress' ); ?>" role="navigation">
            <ul>
                
                <li class="selected" id="members-all"><a href="<?php bp_members_directory_permalink(); ?>"><?php printf( __( 'Todos os usuários %s', 'buddypress' ), '<span>' . bp_get_total_member_count() . '</span>' ); ?></a></li>

                <?php if ( is_user_logged_in() && bp_is_active( 'friends' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
                    <li id="members-personal"><a href="<?php echo esc_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/' ); ?>"><?php printf( __( 'My Friends %s', 'buddypress' ), '<span>' . bp_get_total_friend_count( bp_loggedin_user_id() ) . '</span>' ); ?></a></li>
                <?php endif; ?>

                <?php

                do_action( 'bp_members_directory_member_types' ); ?>

            </ul>
        </div><!-- .item-list-tabs -->

            <div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e( 'Members directory secondary navigation', 'buddypress' ); ?>" role="navigation">
                <div class="form-inline">
                    <div class="form-group">
                        <ul>
                            <?php do_action( 'bp_members_directory_member_sub_types' ); ?>

                            <li id="members-order-select" class="last filter">
                                <label for="members-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
                                <select id="members-order-by" class="form-control">
                                    <option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
                                    <option value="newest"><?php _e( 'Newest Registered', 'buddypress' ); ?></option>

                                    <?php if ( bp_is_active( 'xprofile' ) ) : ?>
                                            <option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>
                                    <?php endif; ?>

                                    <?php do_action( 'bp_members_directory_order_options' ); ?>
                                </select>
                            </li>
                        </ul>
                    </div><!-- .form-group -->
                </div><!-- .form-inline -->
            </div><!-- .item-list-tabs -->

            <h2 class="bp-screen-reader-text sr-only"><?php _e( 'Diretório de Usuários', 'cne-ac' ); ?></h2>

            <div id="members-dir-list" class="members dir-list">
                    <?php bp_get_template_part( 'members/members-loop' ); ?>
            </div><!-- #members-dir-list -->

            <?php do_action( 'bp_directory_members_content' ); ?>

            <?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ); ?>

            <?php do_action( 'bp_after_directory_members_content' ); ?>

    </form><!-- #members-directory-form -->

    <?php do_action( 'bp_after_directory_members' ); ?>

</div><!-- #buddypress -->

<?php do_action( 'bp_after_directory_members_page' );
