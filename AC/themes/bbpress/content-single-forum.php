<?php

/**
 * bbPress: Conteudo Forum
 */

?>

<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<?php do_action( 'bbp_template_before_single_forum' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php if ( bbp_has_forums() ) : ?>

			<?php bbp_get_template_part( 'loop', 'forums' ); ?>

		<?php endif; ?>

		<?php if ( !bbp_is_forum_category() && bbp_has_topics() ) : ?>
    
                    <?php if ( bbp_allow_search() ) : ?>

                                <div class="bbp-search-form">

                                        <?php bbp_get_template_part( 'form', 'search' ); ?>

                                </div>

                    <?php endif; ?>
    
                    <?php if( $form_topic_page_link = cne_ac_get_form_topic_page_link(bbp_get_forum_id()) ) : ?>
                        <div class="cne-bbp-before-content">

                            <a class="btn btn-default pull-right" href="<?php echo esc_url( $form_topic_page_link ) ?>" role="button"><i class="fa fa-plus"></i> <?php _e( 'Novo tópico', 'cne-ac' ) ?></a>

                        </div>
                    <?php endif; ?>

                    <?php bbp_get_template_part( 'loop',       'topics'    ); ?>

		<?php elseif ( !bbp_is_forum_category() ) : ?>

			<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

			<?php bbp_get_template_part( 'form',       'topic'     ); ?>

		<?php endif; ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_single_forum' ); ?>

</div>
