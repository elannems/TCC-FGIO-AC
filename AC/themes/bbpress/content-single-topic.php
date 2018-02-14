<?php

/**
 * bbPress - Single Topic Content Part
 */

?>

<div id="bbpress-forums">
    <div class="cne-bbp-before-content">
	<?php cne_ac_button_topic_parent(); ?>
    </div>

    <?php do_action( 'bbp_template_before_single_topic' ); ?>
        
    <!-- Verifica se e necessario o usuario estar autenticado -->
    <?php if ( post_password_required() ) : ?>

        <?php bbp_get_template_part( 'form', 'protected' ); ?>

    <?php else : ?>

        <?php if ( bbp_show_lead_topic() ) : ?>
            <!-- Verifica se forum e do tipo privado -->
            <?php if ( cne_ac_is_secao_privado() ) : ?>
                <?php bbp_get_template_part( 'content', 'single-private-topic-lead' ); ?>
            <?php else : ?>
                <?php bbp_get_template_part( 'content', 'single-public-topic-lead' ); ?>
            <?php endif; ?>

        <?php endif; ?>

        <?php bbp_get_template_part( 'content', 'replies' ); ?>

    <?php endif; ?>

    <?php do_action( 'bbp_template_after_single_topic' ); ?>

</div> <!-- #bbpress-forums -->
