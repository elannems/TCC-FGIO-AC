<?php

/**
 * bbPress - Pagination for pages of replies (when viewing a topic)
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="bbp-pagination header">
    
    <div class="bbp-pagination-count">

        <?php bbp_topic_pagination_count(); ?>

    </div> <!-- .bbp-pagination-count -->

    <div class="bbp-pagination-links">

        <?php bbp_topic_pagination_links(); ?>

    </div> <!-- .bbp-pagination-links -->
    
</div> <!-- .bbp-pagination header -->


<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
