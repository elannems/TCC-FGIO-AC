<?php

/**
 * bbPress - Pagination for pages of topics (when viewing a forum)
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="bbp-pagination header">
    
    <div class="bbp-pagination-count">

        <?php bbp_forum_pagination_count(); ?>

    </div> <!-- .bbp-pagination-count -->

    <div class="bbp-pagination-links">

        <?php bbp_forum_pagination_links(); ?>

    </div> <!-- .bbp-pagination-links -->
    
</div> <!-- .bbp-pagination header -->

<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
