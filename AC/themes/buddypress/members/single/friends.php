<?php
/**
 * BuddyPress - Users Friends
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'buddypress' ); ?>" role="navigation">
    <ul class="nav">
        <?php if ( bp_is_my_profile() ) bp_get_options_nav(); ?>
    </ul>
</div>

<?php
switch ( bp_current_action() ) :

	case 'my-friends' :

		do_action( 'bp_before_member_friends_content' ); ?>

		<?php if ( is_user_logged_in() ) : ?>

			<h2 class="cne-title"><?php _e( 'Meus amigos', 'cne-ac' ); ?></h2>
                    
                        <div class="cne-bp-order-by">
                            <div class="form-inline">
                                <div class="form-group">
                                    <ul>
                                        <li id="members-order-select" class="last filter">
                                            <label for="members-friends"><?php _e( 'Order By:', 'buddypress' ); ?></label>
                                            <select id="members-friends" class="form-control">
                                                <option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
                                                <option value="newest"><?php _e( 'Newest Registered', 'buddypress' ); ?></option>
                                                <option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>

                                                    <?php do_action( 'bp_member_friends_order_options' ); ?>
                                            </select>
                                        </li>
                                    </ul>
                                </div><!-- .form-group -->
                            </div><!-- .form-inline -->
                        </div><!-- .cne-bp-order-by -->
                        
		<?php else : ?>
			<h2 class="cne-title"><?php _e( 'Amigos', 'cne-ac' ); ?></h2>
		<?php endif ?>

		<div class="members friends">

			<?php bp_get_template_part( 'members/members-loop' ) ?>

		</div><!-- .members.friends -->

		<?php

		do_action( 'bp_after_member_friends_content' );
		
                break;

	case 'requests' :
		bp_get_template_part( 'members/single/friends/requests' );
		break;

	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
