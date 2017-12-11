<?php

/**
 * Search Loop
 *
 * @package bbPress
 * @subpackage Theme
*/

?>

<?php do_action( 'bbp_template_before_search_results_loop' ); ?>

<div id="bbp-search-results" class="forums bbp-search-results">

	<div class="cne-bbp-header row">

		
		<div class="cne-bbp-search-result col-xs-6">

			<?php _e( 'Resultado', 'cne-ac' ); ?>

		</div><!-- .cne-bbp-search-result -->
                
                <div class="cne-bbp-search-author col-xs-3">

			<?php _e( 'Autor', 'cne-ac' ); ?>

		</div><!-- .cne-ac-bbp-search-author -->
                
                <div class="cne-bbp-search-post-date col-xs-3">

			<?php _e( 'Criado em', 'cne-ac' ); ?>

		</div><!-- .cne-ac-bbp-search-post-date -->
                

	</div><!-- .cne-bbp-header -->

	<div class="cne-bbp-body">

		<?php while ( bbp_search_results() ) : bbp_the_search_result(); ?>

			<?php bbp_get_template_part( 'loop', 'search-' . get_post_type() ); ?>

		<?php endwhile; ?>

	</div><!-- .cne-bbp-body -->

</div><!-- #bbp-search-results -->

<?php do_action( 'bbp_template_after_search_results_loop' ); ?>