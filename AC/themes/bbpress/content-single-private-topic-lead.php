<?php
/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */
?>

<?php do_action('bbp_template_before_lead_topic'); ?>

<div id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-lead-topic">
    
    <div class="cne-bbp-topic-header">
        <?php do_action('cne_ac_bbp_theme_before_lead_topic_header'); ?>
        <table class="table-condensed">
            <tbody>
                <tr>
                    <th><?php _e('Usuário:', 'cne-ac'); ?></th>
                    <td colspan="3"><?php bbp_topic_author_link( array( 'size' => '14', 'type' => 'name' ) ) ?></td>
                </tr>
                <tr>
                    <th><?php _e('Criado em:', 'cne-ac'); ?></th>
                    <td><?php  the_date() ?></td>
                    <th><?php _e('Atualizado em:', 'cne-ac'); ?></th>
                    <td><?php  the_modified_date() ?></td>
                </tr>
                <tr>
                    <th><?php _e('Categoria:', 'cne-ac'); ?></th>
                    <td colspan="3"><?php bbp_forum_title() ?></td>
                </tr>
                <tr>
                    <th><?php _e('Objetivo:', 'cne-ac'); ?></th>
                    <td colspan="3"><?php echo get_post_meta(bbp_get_topic_id(), 'cne_bbp_topic_objective', true); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Autor Original:', 'cne-ac'); ?></th>
                    <td colspan="3"><?php echo get_post_meta(bbp_get_topic_id(), 'cne_bbp_topic_author', true); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Descrição:', 'cne-ac'); ?></th>
                    <td colspan="3"><?php echo get_post_meta(bbp_get_topic_id(), 'cne_bbp_topic_desc', true); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Tags:', 'cne-ac'); ?></th>
                    <td colspan="3"><?php echo cne_ac_custom_bbp_topic_tag_list(); ?></td>
                </tr>
            </tbody>
        </table>
        <?php do_action('cne_bbp_theme_after_lead_topic_header'); ?>            
    </div>

    <div class="cne-bbp-topic-body">

        <!--<div class="bbp-topic-header">

                <div class="bbp-meta">

                        <span class="bbp-topic-post-date"><?php bbp_topic_post_date(); ?></span>

                        <a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>

<?php do_action('bbp_theme_before_topic_admin_links'); ?>

        <?php bbp_topic_admin_links(); ?>

        <?php do_action('bbp_theme_after_topic_admin_links'); ?>

                </div>--><!-- .bbp-meta -->

        <!--</div>--><!-- .bbp-topic-header -->

        <div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>


            <div class="cne-bbp-topic-content">

<?php do_action('bbp_theme_before_topic_content'); ?>

                <?php bbp_topic_content(); ?>

                <?php do_action('bbp_theme_after_topic_content'); ?>

            </div><!-- .bbp-topic-content -->

        </div><!-- #post-<?php bbp_topic_id(); ?> -->



    </div><!-- .bbp-body -->

    <div class="cne-bbp-topic-footer col-xs-12">
        <div class="row">
            <div class="col-xs-3 cne-favorite">
                <?php bbp_topic_favorite_link(); ?>
            </div>
            <div class="col-xs-6 col-xs-offset-3 cne-share">
                <?php cne_ac_get_topic_share_link(); ?>
            </div>
        </div>
    </div>

</div><!-- #bbp-topic-<?php bbp_topic_id(); ?>-lead -->

<?php do_action('bbp_template_after_lead_topic'); ?>
