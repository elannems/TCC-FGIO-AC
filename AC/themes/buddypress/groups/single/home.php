<?php
/**
 * BuddyPress - Groups Home
 *
 * @package cne-ac
 * 
 */

?>
<div id="buddypress">

    <?php if ( bp_has_groups() ) : 
        
        while ( bp_groups() ) : bp_the_group(); ?>

        <?php

        do_action( 'bp_before_group_home_content' ); ?>

        <div id="item-header" role="complementary">

        <?php

            bp_get_template_part( 'groups/single/group-header' );

        ?>

        </div><!-- #item-header -->

        <div id="item-content" class="row">
            
            <div id="item-nav" class="col-xs-3">
                    <div class="item-list-tabs no-ajax" id="object-nav" aria-label="<?php esc_attr_e( 'Group primary navigation', 'buddypress' ); ?>" role="navigation">
                        <ul class="nav">

                            <?php bp_get_options_nav(); ?>

                            <?php do_action( 'bp_group_options_nav' ); ?>

                        </ul>
                    </div>
            </div><!-- #item-nav -->
            

            <div id="item-body" class="col-xs-9">

                <?php

                do_action( 'bp_before_group_body' );

                if ( bp_is_group_home() ) :

                    if ( bp_group_is_visible() ) {

                        cne_ac_groups_front_template_part();

                    } else {

                        do_action( 'bp_before_group_status_message' ); ?>

                        <div id="message" class="info alert alert-info">
                            <p><?php bp_group_status_message(); ?></p>
                        </div>

                        <?php do_action( 'bp_after_group_status_message' );

                    }

                else :

                    if ( bp_is_group_admin_page() ) : 
                        bp_get_template_part( 'groups/single/admin' );
                    elseif ( bp_is_group_members() ) : 
                        cne_ac_groups_members_template_part();
                    elseif ( bp_is_group_invites() ) : 
                        bp_get_template_part( 'groups/single/send-invites' );
                    elseif ( bp_is_group_membership_request() ) : 
                        bp_get_template_part( 'groups/single/request-membership' );                                
                    else : 
                        bp_get_template_part( 'groups/single/plugins' );
                    endif;

                endif;


                do_action( 'bp_after_group_body' ); ?>

            </div><!-- #item-body -->
            
            </div>

            <?php do_action( 'bp_after_group_home_content' ); ?>

	<?php 
        
        endwhile; 
        
    endif; 
    
    ?>

</div><!-- #buddypress -->
