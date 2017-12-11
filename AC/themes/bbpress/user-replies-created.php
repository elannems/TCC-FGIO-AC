<?php

/**
 * User Replies Created
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_user_replies' ); ?>

	<div id="bbp-user-replies-created" class="bbp-user-replies-created">
		<h2 class="entry-title cne-title"><?php _e( 'Meus comentários', 'cne-ac' ); ?></h2>
		<div class="bbp-user-section">

			<?php if ( bbp_get_user_replies_created() ) : ?>

				<?php bbp_get_template_part( 'pagination', 'header-user-replies' ); ?>

				<?php bbp_get_template_part( 'loop',       'user-replies' ); ?>

				<?php bbp_get_template_part( 'pagination', 'footer-user-replies' ); ?>

			<?php else : ?>
                    <div class="alert alert-info" role="alert">
                        <p><?php bbp_is_user_home() ? _e( 'Você não comentou em nenhum tópico ainda.', 'cne-ac' ) : _e( 'Este usuário não comentou em nenhum tópico.', 'cne-ac' ); ?></p>
                    </div>
			<?php endif; ?>

		</div>
	</div><!-- #bbp-user-replies-created -->

	<?php do_action( 'bbp_template_after_user_replies' ); ?>
