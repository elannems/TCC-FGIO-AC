<?php

/**
 * bbPress - Topics Loop
 */

?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>

<div class="cne-bbpress-content">
    <div id="bbp-forum-<?php bbp_forum_id(); ?> bbp-topics">

        <?php bbp_get_template_part( 'pagination', 'header-topics' ); ?>

        <div class="cne-topics">
            <div class="cne-thumbnails row">

                <?php while ( bbp_topics() ) : bbp_the_topic(); ?>

                    <?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

                <?php endwhile; ?>

            </div> <!-- .row -->
        </div> <!-- .cne-topics -->
        
        <div class="bbp-after-topics">
            <?php bbp_get_template_part( 'pagination', 'footer-topics' ); ?>
        </div> <!-- .bbp-after-topics -->
        
    </div> <!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
</div> <!-- .cne-bbpress-content -->

<?php do_action( 'bbp_template_after_topics_loop' ); ?>
