<?php

/**
 * bbPress - Archive Reply Content Part
 */

?>

<?php do_action( 'cne_ac_bbp_template_before_content_replies' ); ?>

<div class="row">
    <div class="cne-bbp-replies col-xs-6">
        <div class="panel panel-default cne-panel">

            <div class="panel-heading cne-panel-heading">
                <h1><?php printf( _n( 'Comentário (%1$d)', 'Comentários (%1$d)', bbp_get_topic_reply_count(), 'cne-ac' ), bbp_get_topic_reply_count()) ?></h1>
            </div> <!-- .cne-panel-heading -->

            <div class="panel-body cne-panel-body">

                <?php bbp_get_template_part( 'form', 'reply' ); ?>

                <?php if ( bbp_has_replies() ) : ?>

                        <?php bbp_get_template_part( 'loop', 'replies' ); ?>

                        <?php bbp_get_template_part( 'pagination', 'replies' ); ?>

                <?php endif; ?>

            </div> <!-- .cne-panel-body -->
        </div> <!-- .cne-panel -->
    </div> <!-- .cne-bbp-replies -->

    <div class="cne-bbp-information col-xs-6">
        <div class="panel panel-default cne-panel">
            <div class="panel-heading cne-panel-heading">
                <h1><?php _e( 'Os comentários <span class="cne-required">NÃO</span> devem', 'cne-ac' ); ?></h1>
            </div> <!-- .cne-panel-heading -->

            <div class="panel-body cne-panel-body">
                <?php cne_ac_rules_list(); ?>
                <div class="cne-rules-report">
                    <h2><?php _e('Caso encontre algum comentário que não respeite essas regras, denuncie acionando o link <i class="cne-btn-circle cne-alert fa fa-bullhorn" aria-hidden="true"></i> do respectivo comentário.', 'cne-ac'); ?></h2>
                </div> <!-- .cne-rules-report -->
            </div> <!-- .cne-panel-body -->
        </div> <!-- .cne-panel -->
    </div> <!-- .cne-bbp-information -->
</div> <!-- .row -->

<?php do_action( 'cne_ac_bbp_template_after_content_replies' ); ?>