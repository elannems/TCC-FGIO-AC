<?php

/**
 * bbPress - New Topics Loop
 */

?>

<div id="bbpress-forums">

    <?php do_action('bbp_template_before_topics_index'); ?>

    <?php $meta_key = 'cne_ac_secao_tipo'; ?>
    
    <?php foreach (cne_ac_get_list_meta_values($meta_key) as $meta_value) : ?>
    
        <?php if (bbp_has_forums(array('meta_key' => $meta_key, 'meta_value' => $meta_value))) : ?>

            <?php $list_forums_id = cne_ac_get_list_post_ids($meta_key, $meta_value, bbp_get_forum_post_type()); ?>

            <?php if (bbp_has_topics(array('post_parent__in' => $list_forums_id, 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => 9, 'show_stickies' => false, 'max_num_pages' => 1))) : ?>

                <div class="panel panel-default cne-panel">
                    <div class="panel-heading cne-panel-heading">
                        <?php do_action('bbp_theme_before_forum_title'); ?>
                        <h1><?php $meta_value == 'publico' ? _e('Veja o que outros fizeram', 'cne-ac') : _e('Últimas atividades adicionadas'); ?></h1>
                        <?php do_action('bbp_theme_after_forum_title'); ?>
                    </div> <!-- .cne-panel-heading -->
                    <div class="panel-body cne-panel-body">
                        <div class="cne-carousel">

                            <?php while (bbp_topics()) : bbp_the_topic(); ?>

                                <div class="col-xs-4">
                                    <div class="thumbnail cne-thumbnail">

                                        <div class="cne-thumbnail-image">
                                            <?php cne_ac_card_image(); ?>
                                        </div> <!-- cne-thumbnail-image -->

                                        <div class="caption cne-thumbnail-caption">

                                            <div class="cne-thumbnail-top">
                                                <h2><a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a></h2>
                                            </div> <!-- .cne-thumbnail-top -->

                                            <div class="cne-thumbnail-middle">
                                                <span class="cne-bbp-topic-forum"> <a class="bbp-topic-permalink" href="<?php bbp_forum_permalink(bbp_get_topic_forum_id()); ?>"> <?php bbp_topic_forum_title(); ?> </a></span>     
                                                <span class="bbp-topic-started-by"><?php printf(__('Criado por: %1$s', 'cne-ac'), bbp_get_topic_author_link(array('size' => '14', 'type' => 'name'))); ?></span>                                                                                     
                                            </div> <!-- .cne-thumbnail-middle -->
                                        
                                        </div> <!-- .cne-thumbnail-caption -->
                                    </div> <!-- .cne-thumbnail -->
                                </div> <!-- .col -->

                            <?php endwhile; ?>

                        </div> <!-- .cne-carousel -->
                    </div> <!-- .cne-panel-body -->
                </div> <!-- .cne-panel -->
                
            <?php endif; ?>

        <?php else : ?>

            <?php bbp_get_template_part('feedback', 'no-topics'); ?>

        <?php endif; ?>
                
    <?php endforeach; ?>

    <?php do_action('bbp_template_after_topics_index'); ?>

</div> <!-- #bbpress-forums -->
