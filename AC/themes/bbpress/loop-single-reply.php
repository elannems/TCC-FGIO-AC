<?php

/**
 * bbPress - Replies Loop: Single Reply
 */

?>

<div <?php bbp_reply_class(); ?>>    
    <div class="cne-bbp-reply-author pull-left">

        <?php do_action( 'bbp_theme_before_reply_author_details' ); ?>
        <?php bbp_reply_author_link( array( 'size' => 40, 'type' => 'avatar' ) ); ?>
        <?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

    </div> <!-- .cne-bbp-reply-author -->

    <div class="cne-bbp-reply-content" style=" margin-left: 50px;">
        
        <div class="cne-bbp-heading">
            
            <div class="cne-reply-top">
                <?php bbp_reply_author_link( array( 'type' => 'name' ) ); ?>

                <span class="cne-reply-links pull-right">
                    <?php cne_ac_get_reply_alert_link(); ?>
                </span>
            </div> <!-- .cne-reply-top -->
            
            <div class="cne-reply-bottom">
                <span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>
            </div> <!-- .cne-reply-bottom -->
            
        </div> <!-- .cne-bbp-heading -->


        <?php do_action( 'bbp_theme_before_reply_content' ); ?>

        <?php bbp_reply_content(); ?>

        <?php do_action( 'bbp_theme_after_reply_content' ); ?>

    </div> <!-- .cne-bbp-reply-content -->

</div> <!-- .reply -->
