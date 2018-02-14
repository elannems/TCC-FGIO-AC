<?php

/**
 * bbPress - Replies Loop
 */

?>
                                        
<?php do_action( 'bbp_template_before_replies_loop' ); ?>

<div id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">   
    <div class="cne-replies clearfix">
        <div class="table-responsive">
            <div class="cne-table-container">
                <div class="cne-table-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Tópico</th>
                                <th>Comentário</th>
                                <th>Criado em</th>
                                <?php if( cne_ac_current_user_can_edit_delete() ) : ?>
                                    <th>Ações</th>
                                <?php endif; ?>
                            </tr>
                        </thead>


                        <?php while ( bbp_replies() ) : bbp_the_reply(); ?>

                            <?php bbp_get_template_part( 'loop', 'user-single-reply' ); ?>

                        <?php endwhile; ?>

                    </table>
                </div> <!-- .cne-table-body -->
            </div> <!-- .cne-table-container -->
        </div> <!-- .table-responsive -->
    </div> <!-- .cne-replies -->
</div> <!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' ); ?>
