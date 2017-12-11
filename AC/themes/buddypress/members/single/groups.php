<?php
/**
 * BuddyPress - Users Groups
 *
 * @package cne-ac
 * @subpackage bp-legacy
 */

?>

<div class="item-list-tabs no-ajax" id="subnav" aria-label="<?php esc_attr_e( 'Member secondary navigation', 'buddypress' ); ?>" role="navigation">
	<ul class="nav">
		<?php if ( bp_is_my_profile() ) bp_get_options_nav(); ?>
	</ul>
</div><!-- .item-list-tabs -->

<?php

switch ( bp_current_action() ) :

	// Home/My Groups
	case 'my-groups' :
            
		do_action( 'bp_before_member_groups_content' ); ?>

		<?php if ( is_user_logged_in() ) : ?>
			<h2 class="cne-title"><?php _e( 'Meus grupos', 'cne-ac' ); ?></h2>

                        <div class="cne-bp-order-by">
                            <div class="form-inline">
                                <div class="form-group">
                                    <ul>
                                        <li id="groups-order-select" class="last filter">

                                                <label for="groups-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
                                                <select id="groups-order-by" class="form-control">
                                                        <option value="active"><?php _e( 'Last Active', 'buddypress' ); ?></option>
                                                        <option value="popular"><?php _e( 'Most Members', 'buddypress' ); ?></option>
                                                        <option value="newest"><?php _e( 'Newly Created', 'buddypress' ); ?></option>
                                                        <option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>

                                                        <?php do_action( 'bp_member_group_order_options' ); ?>

                                                </select>
                                        </li>
                                    </ul>
                                </div><!-- .form-group -->
                            </div><!-- .form-inline -->
                        </div><!-- .cne-bp-order-by -->

		<?php else : ?>
			<h2 class="cne-title"><?php _e( 'Grupos', 'cne-ac' ); ?></h2>
		<?php endif; ?>

		<div class="groups mygroups">

			<?php bp_get_template_part( 'groups/groups-loop' ); ?>

		</div>

		<?php

		do_action( 'bp_after_member_groups_content' );
		break;

	// Group Invitations
	case 'invites' :
		bp_get_template_part( 'members/single/groups/invites' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
