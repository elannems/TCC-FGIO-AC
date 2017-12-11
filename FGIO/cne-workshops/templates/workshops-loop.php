<?php

$template = cnew_get_template_loader();
$paged = 1;
if( isset($data) ) {
    
    $workshops = $data->workshops;
    $paged = $data->paged;
} else {
    $workshops = cnew_open_workshops();
}

echo '<div class ="cnew-workshops-loop">';
if( $workshops->have_posts() ) :
    
    while ( $workshops->have_posts() ) : 
        $workshops->the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="wrap">
                <header class="cnew-entry-header">
                    <?php
                            the_title( sprintf( '<h1 class="cnew-entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
                    ?>

                <div class="cnew-entry-meta">
                    <span class="cnew-date"><i class="fa fa-calendar"></i> <?php the_time('j \d\e F \d\e Y') ?></span>
                </div><!-- .cnew-entry-meta -->

                </header><!-- .cnew-entry-header -->
            
                <div class="cnew-entry-summary">
                    <?php

                            the_excerpt();

                            echo '<div class="cnew-readmore">
                                    <a href="' . esc_url( get_permalink() ) . '">' . __( 'Saiba mais', 'cnew' ) . '</a>
                            </div>';
                    ?>
                </div><!-- .cnew-entry-summary -->
            </div><!-- .wrap -->
        </article><!-- post -->
            <?php
        
    endwhile;
    
    $paginate_links = cnew_pagination($workshops->max_num_pages, $paged);
    
    if($paginate_links) :
        echo '<div class="cnew-paginate">';
            echo $paginate_links;
        echo '</div>';
    endif;
    
    cnew_reset_postdata();
        
else :
    $data = array( 'class' => 'cnew-error', 'msg' => __( 'Nenhuma oficina encontrada.', 'cnew' ) );
    $template->set_template_data( $data )->get_template_part( 'feedback', 'message' );

endif;

echo '</div>';
