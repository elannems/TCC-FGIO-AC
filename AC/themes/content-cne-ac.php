<?php
/**
 * Template Content
 *
 * @author Elanne M de Souza
 * @version 1.0
 */
$is_search = bbp_is_search() ? 'search' : '';
?>

<!-- ================== ARTICLE ================== -->
<article id="post-<?php the_ID(); ?>" <?php post_class($is_search); ?>>
    <header class="entry-header">
        <?php if( !is_front_page() ) : ?>
            <?php if( bbp_is_topic_edit() ) : ?>
                <h1 class="entry-title"><?php _e( 'Editar Tópico', 'cne-ac' ); ?></h1>
             <?php else : ?>
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            <?php endif; ?>
        <?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Páginas:', 'cne-ac' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php edit_post_link( __( 'Editar', 'cne-ac' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->
</article>
