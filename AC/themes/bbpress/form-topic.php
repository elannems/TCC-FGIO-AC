<?php

/**
 * bbPress - New/Edit Topic
 */

?>

<div id="bbpress-forums">
    
    <?php if (bbp_current_user_can_access_create_topic_form()) : ?>

        <?php if ( cne_ac_is_secao_privado( bbp_get_topic_forum_id() ) ) : ?>
            <?php bbp_get_template_part( 'form', 'private-topic' ); ?>
        <?php else : ?>
            <?php bbp_get_template_part( 'form', 'public-topic' ); ?>
        <?php endif; ?>

    <?php else : ?>

        <div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
            <div class="alert alert-warning">
                <p><?php is_user_logged_in() ? _e('Você não pode criar tópicos neste espaço.', 'cne-ac') : _e('Você precisa entrar na sua conta para criar novos tópicos.', 'cne-ac'); ?></p>
            </div>
        </div>

    <?php endif; ?>

</div> <!-- #bbpress-forums -->
