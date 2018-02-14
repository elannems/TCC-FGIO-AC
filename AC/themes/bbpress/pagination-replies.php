<?php

/**
 * bbPress - Pagination for pages of replies (when viewing a topic)
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="bbp-pagination">
    <?php if ( bbp_is_single_user_replies() ) : ?>

        <div class="bbp-pagination-links">

            <?php bbp_topic_pagination_links(); ?>

        </div> <!-- .bbp-pagination-links -->

    <?php else : ?>

        <div class="cne-load-more text-center">

            <a class="btn btn-default" id="cne-btn-load-more" href="#" role="button">Mais comentários</a>

        </div> <!-- .cne-load-more -->

    <?php endif; ?>
    
</div> <!-- .bbp-pagination -->

<?php do_action( 'bbp_template_after_pagination_loop' );
