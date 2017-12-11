<?php

get_header(); 

$template = cnew_get_template_loader();

?>

<div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <div class="wrap">
                        <?php
                                post_type_archive_title( '<h1 class="entry-title">', '</h1>' );
                        ?>
                    </div>
                </header><!-- .entry-header -->
                <div class="cnew-content">
                    <?php
                    $template->get_template_part( 'content', 'archive-workshop' );
                    ?>
                </div>
            </article>
        </div><!-- .site-content -->
</div><!-- .content-area -->

<?php 

get_footer(); 
