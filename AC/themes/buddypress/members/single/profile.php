<?php

/**
 * BuddyPress - Users Profile
 */

?>

<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'buddypress' ); ?>" role="navigation">
    <ul class="nav">
        <?php bp_get_options_nav(); ?>
    </ul> <!-- .nav -->
</div> <!-- .item-list-tabs -->

<?php do_action( 'bp_before_profile_content' ); ?>

<div class="profile">
    
    <?php switch ( bp_current_action() ) :

        // Edit
        case 'edit'   :
            bp_get_template_part( 'members/single/profile/edit' );
            break;

        // Change Avatar
        case 'change-avatar' :
            bp_get_template_part( 'members/single/profile/change-avatar' );
            break;

        case 'general' :
            bp_get_template_part( 'members/single/profile/general' );
            break;

        case 'delete-account' :
            bp_get_template_part( 'members/single/profile/delete-account' );
            break;

        // Compose
        case 'public' :
            bp_get_template_part( 'members/single/profile/profile-loop' );


        // Any other
        default :
            bp_get_template_part( 'members/single/plugins' );
            break;
    endswitch; ?>
    
</div> <!-- .profile -->

<?php do_action( 'bp_after_profile_content' ); ?>
