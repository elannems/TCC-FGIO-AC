<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>
<div class="cne-bbpress-content">
    <div class="cne-thumbnails row">
    	<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
            
            <div class="col-xs-4">
                <div class="thumbnail cne-thumbnail">
                    <div class="cne-thumbnail-image">
                        <a href="<?php bbp_forum_permalink(); ?>"><?php cne_ac_card_image(); ?></a>
                    </div> <!-- cne-thumbnail-image -->

                    <div class="caption cne-thumbnail-caption">
                        <div class="cne-thumbnail-top">
                            <?php do_action( 'bbp_theme_before_forum_title' ); ?>
                            <h2><a href="<?php bbp_forum_permalink(); ?>"><?php empty( bbp_get_forum_title() ) ? _e( 'Sem título','cne-ac' ) : bbp_forum_title(); ?></a></h2>
                            <?php do_action( 'bbp_theme_after_forum_title' ); ?>
                            
                        </div> <!-- cne-thumbnail-top -->
                        <div class="cne-thumbnail-middle">
                            <?php do_action( 'bbp_theme_before_forum_description' ); ?>
                            <?php echo empty( get_the_excerpt() ) ? __( 'Sem descrição','cne-ac' ) : get_the_excerpt(); ?>
                            <?php do_action( 'bbp_theme_after_forum_description' ); ?>
                        </div> <!-- cne-thumbnail-middle -->
                        
                        <div class="cne-thumbnail-bottom"> 
                            <div class="col-xs-12">
                                <?php printf( _n( '%1$d Tópico', '%1$d Tópicos', bbp_get_forum_topic_count(), 'cne-ac' ), bbp_get_forum_topic_count()) ?>
                            </div>
                        </div> <!-- cne-thumbnail-bottom -->
                    </div> <!-- cne-thumbnail-caption -->
                </div> <!-- cne-thumbnail -->
            </div> <!-- col -->
        <?php endwhile; ?>
    </div> <!-- cne-thumbnails -->
</div>

<?php do_action( 'bbp_template_after_forums_loop' ); ?>
