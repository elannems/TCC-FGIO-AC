<?php
/**
 * Template Name: Modelo AC
 * 
 * Template para o conteudo do ambiente colaborativo
 *
 * @author Elanne M de Souza
 * @version 1.0
 */
get_header(); 
?>

<div class="cne-ac container">
    <div id="primary" class="content-area row">
        <div id="content" class="site-content col-xs-12" role="main">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part('content', 'cne-ac'); ?>
            <?php endwhile; ?>

        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .container -->

<?php get_footer();