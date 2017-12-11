<?php

get_header();

$template = cnew_get_template_loader();

?>

<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

        <?php
        
        while ( have_posts() ) : the_post();

                $template->get_template_part( 'content', 'single-workshop' );
                
        endwhile;
        
        ?>

        </div><!-- .site-content -->
</div><!-- .content-area -->

<?php 

get_footer(); 
