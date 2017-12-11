<?php

/**
 * Pagination for pages of replies (when viewing a topic)
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="bbp-pagination">
        <?php if ( bbp_is_single_user_replies() ) : ?>
    
            <div class="bbp-pagination-links">

                    <?php bbp_topic_pagination_links(); ?>
                    
            </div>
    
        <?php else : ?>
    
            <div class="cne-load-more text-center">
                
                <a class="btn btn-default" id="cne-btn-load-more" href="#" role="button">Mais comentários</a>
                
            </div>
    
        <?php endif; ?>
    
</div>

<?php do_action( 'bbp_template_after_pagination_loop' );
