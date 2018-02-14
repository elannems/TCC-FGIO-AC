<?php

/**
 * bbPress - Search Loop: Single Reply
 */

?>

<div class="cne-bbp-reply-search row">
    
    <div class="cne-bbp-search-result col-xs-6">

        <strong><?php _e( 'Comentário no tópico ', 'cne-ac' ); ?>
        <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>:</strong>
        
        <?php do_action( 'bbp_theme_before_reply_content' ); ?>

        <?php echo bbp_get_reply_content(); ?>

        <?php do_action( 'bbp_theme_after_reply_content' ); ?>
        
    </div><!-- .cne-bbp-search-result -->

    <div class="cne-bbp-search-author col-xs-3">
        <div class="bbp-topic-author">
            
            <?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

            <?php bbp_reply_author_link( array( 'size' => '14', 'type' => 'name' ) ); ?>

            <?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	</div><!-- .bbp-topic-author -->
    </div><!-- .cne-bbp-search-author -->

    <div class="cne-bbp-search-post-date col-xs-3">

        <?php bbp_reply_post_date(); ?>

    </div><!-- .cne-bbp-search-post-date -->

</div><!-- .cne-bbp-reply-search -->

