<?php

/**
 * User Favorites
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

	<?php do_action( 'bbp_template_before_user_favorites' ); ?>

	<div id="bbp-user-favorites" class="bbp-user-favorites">
		<h2 class="entry-title cne-title"><?php _e( 'Meus tópicos favoritos', 'cne-ac' ); ?></h2>
		<div class="bbp-user-section">

			<?php if ( bbp_get_user_favorites() ) : ?>

				<?php bbp_get_template_part( 'loop', 'topics' ); ?>

			<?php else : ?>
                            <div class="alert alert-info">
				<p><?php bbp_is_user_home() ? _e( 'Você ainda não marcou nenhum tópico como favorito.', 'cne-ac' ) : _e( 'Este usuário ainda não possui tópicos favoritos.', 'cne-ac' ); ?></p>
                            </div>
			<?php endif; ?>

		</div>
	</div><!-- #bbp-user-favorites -->

	<?php do_action( 'bbp_template_after_user_favorites' ); ?>
