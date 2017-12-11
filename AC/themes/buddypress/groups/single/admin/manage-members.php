<?php
/**
 * BuddyPress - Groups Admin - Manage Members
 *
 * @package cne-ac
 * 
 */

?>

<h2 class="cne-title"><?php _e( 'Administrar membros', 'cne-ac' ); ?></h2>

<?php do_action( 'bp_before_group_manage_members_admin' ); ?>

<div aria-live="polite" aria-relevant="all" aria-atomic="true">

	<div class="bp-widget group-members-list group-admins-list">
            <fieldset>
		<legend class="section-header"><?php _e( 'Administradores', 'cne-ac' ); ?></legend>

		<?php if ( bp_group_has_members( array( 'per_page' => 5, 'group_role' => array( 'admin' ), 'page_arg' => 'mlpage-admin' ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="admins-list" class="item-list">
				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
					<li>
                                            <div class="row">
                                                <div class="col-xs-6">
						<div class="item-avatar pull-left">
							<?php bp_group_member_avatar_thumb(); ?>
						</div>

						<div class="item pull-left">
							<div class="item-title">
								<?php bp_group_member_link(); ?>
							</div>
							<div class="joined item-meta">
								<?php bp_group_member_joined_since(); ?>
							</div>
							<?php do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>
						</div>
                                                </div>
						<div class="action col-xs-6">
							<?php if ( count( bp_group_admin_ids( false, 'array' ) ) > 1 ) : ?>
								<a class="button confirm admin-demote-to-member" href="<?php bp_group_member_demote_link(); ?>"><?php _e( 'Rebaixar a membro', 'cne-ac' ); ?></a>
							<?php endif; ?>

							<?php do_action( 'bp_group_manage_members_admin_actions', 'admins-list' ); ?>
						</div>
                                            </div>
					</li>
				<?php endwhile; ?>
			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

		<div id="message" class="alert alert-info">
			<p><?php _e( 'Não foi encontrado nenhum administrador.', 'cne-ac' ); ?></p>
		</div>

		<?php endif; ?>
            </fieldset>
	</div>

	<div class="bp-widget group-members-list group-mods-list">
            <fieldset>
		<legend class="section-header"><?php _e( 'Moderadores', 'cne-ac' ); ?></legend>

		<?php if ( bp_group_has_members( array( 'per_page' => 5, 'group_role' => array( 'mod' ), 'page_arg' => 'mlpage-mod' ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="mods-list" class="item-list">

				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>
					<li>
                                            <div class="row">
                                                <div class="col-xs-6">
						<div class="item-avatar pull-left">
							<?php bp_group_member_avatar_thumb(); ?>
						</div>

						<div class="item pull-left">
							<div class="item-title">
								<?php bp_group_member_link(); ?>
							</div>
							<div class="joined item-meta">
								<?php bp_group_member_joined_since(); ?>
							</div>
							<?php do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>
						</div>
                                                    
                                                </div>

						<div class="action col-xs-6">
							<a href="<?php bp_group_member_promote_admin_link(); ?>" class="button confirm mod-promote-to-admin"><?php _e( 'Promote to Admin', 'buddypress' ); ?></a>
							<a class="button confirm mod-demote-to-member" href="<?php bp_group_member_demote_link(); ?>"><?php _e( 'Rebaixar a membro', 'cne-ac' ); ?></a>

							<?php do_action( 'bp_group_manage_members_admin_actions', 'mods-list' ); ?>

						</div>
                                            </div>
					</li>
				<?php endwhile; ?>

			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

			<div id="message" class="alert alert-info">
				<p><?php _e( 'Não foi encontrado nenhum moderador.', 'cne-ac' ); ?></p>
			</div>

		<?php endif; ?>
                
            </fieldset>
	</div>

	<div class="bp-widget group-members-list">
            <fieldset>
		<legend class="section-header"><?php _e( "Membros", 'cne-ac' ); ?></legend>

		<?php if ( bp_group_has_members( array( 'per_page' => 5, 'exclude_banned' => 0 ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="members-list" class="item-list" aria-live="assertive" aria-relevant="all">
				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

					<li class="<?php bp_group_member_css_class(); ?>">
                                            <div class="row">
                                                <div class="col-xs-12">
						<div class="item-avatar pull-left">
							<?php bp_group_member_avatar_thumb(); ?>
						</div>

						<div class="item pull-left">
							<div class="item-title">
								<?php bp_group_member_link(); ?>
								<?php
								if ( bp_get_group_member_is_banned() ) {
									echo ' <span class="banned">';
									_e( '(banned)', 'buddypress' );
									echo '</span>';
								} ?>
							</div>
							<div class="joined item-meta">
								<?php bp_group_member_joined_since(); ?>
							</div>
							<?php do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>
                                                </div>
						</div>
                                            </div>
                                            <div class="row">
						<div class="action col-xs-12">
							<?php if ( bp_get_group_member_is_banned() ) : ?>

								<a href="<?php bp_group_member_unban_link(); ?>" class="button confirm member-unban" title="<?php esc_attr_e( 'Remover banimento', 'cne-ac' ); ?>"><?php _e( 'Remover banimento', 'cne-ac' ); ?></a>

							<?php else : ?>

								<a href="<?php bp_group_member_ban_link(); ?>" class="button confirm member-ban"><?php _e( 'Banir do grupo', 'cne-ac' ); ?></a>
								<a href="<?php bp_group_member_promote_mod_link(); ?>" class="button confirm member-promote-to-mod"><?php _e( 'Promover a moderador', 'cne-ac' ); ?></a>
								<a href="<?php bp_group_member_promote_admin_link(); ?>" class="button confirm member-promote-to-admin"><?php _e( 'Promover a administrador', 'cne-ac' ); ?></a>

							<?php endif; ?>

							<a href="<?php bp_group_member_remove_link(); ?>" class="button confirm"><?php _e( 'Remover do grupo', 'cne-ac' ); ?></a>

							<?php do_action( 'bp_group_manage_members_admin_actions', 'members-list' ); ?>
						</div>
                                            </div>
					</li>

				<?php endwhile; ?>
			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

			<div id="message" class="alert alert-info">
				<p><?php _e( 'Não foi encontrado nenhum membro.', 'cne-ac' ); ?></p>
			</div>

		<?php endif; ?>
	</div>

</div>

<?php do_action( 'bp_after_group_manage_members_admin' ); ?>
