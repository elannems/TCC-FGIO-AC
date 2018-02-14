<?php

/**
 * bbPress - Search Loop: Single Topic
 */

?>

<div class="cne-bbp-topic-search row">
    
    <div class="cne-bbp-search-result col-xs-6">

        <?php do_action( 'bbp_theme_before_topic_title' ); ?>

        <strong><?php _e( 'Topic: ', 'bbpress' ); ?>
            <a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
            <?php _e( 'em ', 'cne-ac' ); ?>
            <a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"><?php bbp_forum_title( bbp_get_topic_forum_id() ); ?></a>
        </strong>

        <?php do_action( 'bbp_theme_after_topic_title' ); ?>

    </div><!-- .cne-bbp-search-result -->

    <div class="cne-bbp-search-author col-xs-3">
        
        <div class="bbp-topic-author">

            <?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

            <?php bbp_topic_author_link( array( 'type' => 'name' ) ); ?>

            <?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

	</div><!-- .bbp-topic-author -->

    </div><!-- .cne-bbp-search-author -->

    <div class="cne-bbp-search-post-date col-xs-3">

        <?php bbp_topic_post_date( bbp_get_topic_id() ); ?>

    </div><!-- .cne-bbp-search-post-date -->

</div><!-- .cne-bbp-topic-search -->
