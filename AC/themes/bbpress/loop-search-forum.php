<?php

/**
 * bbPress - Search Loop: Single Forum
 */

?>

<div class="cne-bbp-forum-search row">

    <div class="cne-bbp-search-result col-xs-6">

        <?php do_action( 'bbp_theme_before_forum_title' ); ?>
        
        <strong><?php _e( 'Área de Conteúdo: ', 'cne-ac' ); ?><a href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></strong>

        <?php do_action( 'bbp_theme_after_forum_title' ); ?>

    </div><!-- .cne-bbp-search-result -->

    <div class="cne-bbp-search-author col-xs-3">


    </div><!-- .cne-bbp-search-author -->

    <div class="cne-bbp-search-post-date col-xs-3">


    </div><!-- .cne-bbp-search-post-date -->

</div><!-- .cne-bbp-forum-search -->

