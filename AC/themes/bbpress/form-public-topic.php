<?php
/**
 * New/Edit Topic
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<?php $forum_id = cne_ac_get_topic_forum_id(); ?>
<fieldset>
    <div id="new-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-form">

    <?php if ( $forum_id ) : ?>
        <form id="new-post" name="new-post" method="post" action="<?php the_permalink(); ?>?forum_id=<?php echo $forum_id ?>" enctype="multipart/form-data">
        <?php do_action('bbp_theme_before_topic_form'); ?>
        <div class="bbp-form">
            <div class="bbp-form-header">
                <legend> <!-- titulo informando se esta criando ou editando um topico -->
                    <?php
                    if (bbp_is_topic_edit()) :
                        printf(__('Editando &ldquo;%s&rdquo;', 'cne-ac'), bbp_get_topic_title());
                    else :
                        bbp_is_single_forum() ? printf(__('Criar Novo Tópico em &ldquo;%s&rdquo;', 'cne-ac'), bbp_get_forum_title()) : _e('Criar Novo Tópico', 'cne-ac');
                    endif;
                    ?>
                </legend>
            </div>
        <div class="bbp-form-body">

<?php do_action('bbp_theme_before_topic_form_notices'); ?>
        <!-- Verifica se acao eh para criar um novo topico, entao verifica se o forum esta fechado para novas postagens -->
<?php if (!bbp_is_topic_edit() && bbp_is_forum_closed()) : ?>

    <div class="bbp-template-notice">
        <p><?php _e('This forum is marked as closed to new topics, however your posting capabilities still allow you to do so.', 'bbpress'); ?></p>
    </div>

<?php endif; ?>

<?php do_action('bbp_template_notices'); ?>

<div>

<?php bbp_get_template_part('form', 'anonymous'); ?>

    <p><span class="cne-required"> * </span>Campo Obrigatório</p>

    <?php do_action('bbp_theme_before_topic_form_title'); ?>

    <div class="form-group">
        <label for="bbp_topic_title"><?php printf(__('Título (Número de caracteres permitidos: %d)', 'bbpress'), bbp_get_title_max_length()); ?><span class="cne-required"> * </span></label>
        <input type="text" id="bbp_topic_title" class="form-control" value="<?php bbp_form_topic_title(); ?>" tabindex="<?php bbp_tab_index(); ?>" name="bbp_topic_title" maxlength="<?php bbp_title_max_length(); ?>" required />
    </div>

    <?php do_action('bbp_theme_after_topic_form_title'); ?>

    <?php do_action('bbp_theme_before_topic_form_content'); ?>
    <div class="form-group">
        <label for="cne_bbp_topic_age"><?php _e('Idade', 'cne-ac'); ?></label>
        <div class="checkbox" style="margin-top: 0;">
            <label><input type="checkbox" value="yes" tabindex="<?php bbp_tab_index(); ?>" name="cne_bbp_topic_age" <?php checked( 'yes', cne_bbp_form_topic_age(), false)?> ><?php _e('Mostrar minha idade atual', 'cne-ac'); ?></label>
        </div>
    </div>
    
   <div class="form-group">
        <label for="cne_bbp_topic_city"><?php _e('Cidade (Número de caracteres permitidos: 100)', 'cne-ac'); ?></label>
        <input type='text' class="form-control" value="<?php cne_bbp_form_topic_city(); ?>" tabindex="<?php bbp_tab_index(); ?>" name='cne_bbp_topic_city' />
   </div>

   <div class="form-group">
        <label for="cne_bbp_topic_author"><?php _e('Autor Original (Número de caracteres permitidos: 100) - Antes de compartilhar o material de outra pessoa, solicite sua autorização!', 'cne-ac'); ?></label>
        <input type='text' class="form-control" value="<?php cne_bbp_form_topic_author(); ?>" tabindex="<?php bbp_tab_index(); ?>" name='cne_bbp_topic_author' />
   </div>

   <div class="form-group">
        <label for="cne_bbp_topic_desc"><?php _e('Breve Descrição (Número de caracteres permitidos: 160)', 'cne-ac'); ?><span class="cne-required"> * </span></label>
        <input type='text' class="form-control" value="<?php cne_bbp_form_topic_desc(); ?>" tabindex="<?php bbp_tab_index(); ?>" name='cne_bbp_topic_desc' maxlength="160" required />
   </div>

    <div class="form-group cne-border">
        <label for="cne_bbp_topic_desc"><?php _e('Conteúdo', 'cne-ac'); ?><span class="cne-required"> * </span></label>
        <?php bbp_the_content(array('context' => 'topic', 'quicktags' => false, 'tinymce' => true, 'teeny' => false)); ?>
     </div>

    <?php do_action('bbp_theme_after_topic_form_content'); ?>

    <?php if (!( bbp_use_wp_editor() || current_user_can('unfiltered_html') )) : ?>

            <p class="form-allowed-tags">
                <label><?php _e('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'bbpress'); ?></label><br />
                <code><?php bbp_allowed_tags(); ?></code>
            </p>

    <?php endif; ?>

    <?php if (bbp_allow_topic_tags() && current_user_can('assign_topic_tags')) : ?>

            <?php do_action('bbp_theme_before_topic_form_tags'); ?>
            
            <div class="form-group">
                <label for="bbp_topic_tags"><?php _e('Tags:', 'bbpress'); ?></label><br />
                <input type="text" value="<?php bbp_form_topic_tags(); ?>" tabindex="<?php bbp_tab_index(); ?>" name="bbp_topic_tags" id="bbp_topic_tags" class="form-control" <?php disabled(bbp_is_topic_spam()); ?> />
            </div>

        <?php do_action('bbp_theme_after_topic_form_tags'); ?>

    <?php endif; ?>

    <div class="form-group cne-border">
        <label for="cne_bbp_topic_image"><?php _e('Selecione uma imagem de destaque', 'cne-ac'); ?></label>
        <input type="file" id="cne_bbp_topic_image" value="<?php cne_bbp_form_topic_image(); ?>" tabindex="<?php bbp_tab_index(); ?>" name="cne_bbp_topic_image">
        <p class="help-block"><?php _e('É recomendado o uso de imagem com a seguinte proporção: 290x200', 'cne-ac'); ?></p>
    </div>


    
<div class="cne-bbp-information">
    <div class="panel panel-default cne-panel">
        
        <div class="panel-heading cne-panel-heading">
            <h1><?php _e( 'O tópico <span class="cne-required">NÃO</span> deve', 'cne-ac' ); ?></h1>
        </div> <!-- cne-panel-heading -->

        <div class="panel-body cne-panel-body">
            <?php cne_ac_rules_list(); ?>
        </div> <!-- cne-panel-body -->
        
    </div> <!-- cne-panel -->
</div> <!-- cne-bbp--information -->

                            <?php do_action('bbp_theme_before_topic_form_submit_wrapper'); ?>

                            <div class="bbp-submit-wrapper">
<?php do_action('bbp_theme_before_topic_form_submit_button'); ?>

                                <button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_topic_submit" name="bbp_topic_submit" class="btn btn-default button submit"><?php _e('Submit', 'bbpress'); ?></button>

<?php do_action('bbp_theme_after_topic_form_submit_button'); ?>

                            </div>

<?php do_action('bbp_theme_after_topic_form_submit_wrapper'); ?>

                        </div>

<?php bbp_topic_form_fields(); ?>

                    </div>

<?php do_action('bbp_theme_after_topic_form'); ?>

            </form>

    </div>
</fieldset>

<?php else : ?>
    <?php bbp_get_template_part( 'feedback' , 'no-forum'); ?>
<?php endif;
