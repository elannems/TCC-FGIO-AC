<?php

/**
 * bbPress - Topics Loop: Single Topic
 */

?>

<div class="col-xs-4">
    <div class="thumbnail cne-thumbnail">
        
        <div class="cne-thumbnail-image">
            <?php cne_ac_card_image(); ?>
        </div> <!-- .cne-thumbnail-image -->

        <div class="caption cne-thumbnail-caption">
            
            <div class="cne-thumbnail-top">
                <?php do_action( 'bbp_theme_before_topic_title' ); ?>
                <h2><a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php echo !empty( bbp_get_topic_title() ) ?  bbp_topic_title() : __( 'Sem Título', 'cne-ac' ) ?></a></h2>
                <?php do_action( 'bbp_theme_after_topic_title' ); ?>
            </div> <!-- .cne-thumbnail-top -->
            
            <div class="cne-thumbnail-middle">
                <?php do_action( 'bbp_theme_before_topic_meta' ); ?>

                <p class="bbp-topic-meta">

                    <?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

                    <span class="bbp-topic-started-by"><?php printf( __( 'Criado por: %1$s', 'cne-ac' ), bbp_get_topic_author_link( array( 'size' => '14', 'type' => 'name' ) ) ); ?></span>

                    <?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

                </p> <!-- .bbp-topic-meta -->

                <?php do_action( 'bbp_theme_after_topic_meta' ); ?>

                <?php do_action( 'bbp_theme_before_forum_description' ); ?>
                <?php echo get_post_meta( bbp_get_topic_id(), 'cne_bbp_topic_desc', true); ?>
                <?php do_action( 'bbp_theme_after_forum_description' ); ?>
                
            </div> <!-- .cne-thumbnail-middle -->
            
            <div class="cne-thumbnail-bottom"> 
                <div class="col-xs-6"><i class="fa fa-heart" aria-hidden="true"></i> <?php cne_ac_bbp_topic_like_count() ?></div>
                <div class="col-xs-6"><i class="fa fa-comment" aria-hidden="true"></i> <?php bbp_topic_reply_count() ?></div>
            </div> <!-- .cne-thumbnail-bottom -->
        
        </div> <!-- .cne-thumbnail-caption -->
    
    </div> <!-- .cne-thumbnail -->

</div> <!-- .col -->

