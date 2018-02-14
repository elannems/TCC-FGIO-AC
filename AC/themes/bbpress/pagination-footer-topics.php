<?php

/**
 * bbPress - Pagination for pages of topics (when viewing a forum)
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="bbp-pagination footer">
    
    <div class="bbp-pagination-links">

        <?php bbp_forum_pagination_links(); ?>

    </div> <!-- .bbp-pagination-links -->
    
</div> <!-- .bbp-pagination footer -->

<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
