<?php

/**
 * BuddyPress - Groups Header
 */

do_action( 'bp_before_group_header' );

?>

<div class="row">
    <?php $col_xs = 10; ?>
    <?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
        <div id="item-header-avatar" class="col-xs-3">
            <?php $col_xs = 7; ?>
            <a href="<?php echo esc_url( bp_get_group_permalink() ); ?>" title="<?php echo esc_attr( bp_get_group_name() ); ?>">

                <?php bp_group_avatar(); ?>

            </a>
        </div> <!-- #item-header-avatar -->
    <?php endif; ?>
        
    <div id="item-header-content" class="col-xs-<?php echo $col_xs; ?>">
            
        <div id="item-meta">

            <?php bp_group_type_list(); ?>

            <div id="item-buttons">

                <?php do_action( 'bp_group_header_actions' ); ?>

            </div> <!-- #item-buttons -->

            <?php do_action( 'bp_group_header_meta' ); ?>
                
            <div class="item-desc">
                <?php bp_group_description(); ?>
            </div> <!-- .item-desc -->

	</div> <!-- #item-meta -->
        
        <?php do_action( 'bp_before_group_header_meta' ); ?>

    </div> <!-- #item-header-content -->
        
    <div id="item-actions" class="col-xs-2">

        <?php if ( bp_group_is_visible() ) : ?>

            <p><?php _e( 'Group Admins', 'buddypress' ); ?></p>

            <?php bp_group_list_admins();

            do_action( 'bp_after_group_menu_admins' );

            if ( bp_group_has_moderators() ) :

                do_action( 'bp_before_group_menu_mods' ); ?>

                <p><?php _e( 'Group Mods' , 'buddypress' ); ?></p>

                <?php 

                bp_group_list_mods();

                do_action( 'bp_after_group_menu_mods' );

            endif;

        endif; ?>

    </div><!-- #item-actions -->

</div> <!-- .row -->

<div class="row">
    
    <?php do_action( 'bp_after_group_header' );  ?>

    <div id="template-notices" class="col-xs-12" role="alert" aria-atomic="true">
        <?php do_action( 'template_notices' ); ?>
    </div> <!-- .col -->
    
</div> <!-- .row -->

