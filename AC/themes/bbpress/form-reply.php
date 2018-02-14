<?php

/**
 * bbPress - New/Edit Reply
 */

?>

<?php if ( bbp_is_reply_edit() ) : ?>

    <div id="bbpress-forums">

<?php endif; ?>

<?php if ( bbp_current_user_can_access_create_reply_form() ) : ?>

    <div id="new-reply-<?php bbp_topic_id(); ?>" class="bbp-reply-form">

        <form id="new-post" name="new-post" method="post" action="<?php the_permalink(); ?>">

            <?php do_action( 'bbp_theme_before_reply_form' ); ?>

            <fieldset class="bbp-form">
                <legend><?php _e( 'Comentar', 'cne-ac' ); ?></legend>

                <?php do_action( 'bbp_theme_before_reply_form_notices' ); ?>

                <?php do_action( 'bbp_template_notices' ); ?>

                <div>

                    <?php do_action( 'bbp_theme_before_reply_form_content' ); ?>

                    <?php bbp_the_content( array( 'context' => 'reply', 'textarea_rows' => 2, 'quicktags' => false ) ); ?>

                    <?php do_action( 'bbp_theme_after_reply_form_content' ); ?>

                    <?php if ( bbp_allow_revisions() && bbp_is_reply_edit() ) : ?>

                        <?php do_action( 'bbp_theme_before_reply_form_revisions' ); ?>

                        <fieldset class="bbp-form">
                            <legend>
                                <input name="bbp_log_reply_edit" id="bbp_log_reply_edit" type="checkbox" value="1" <?php bbp_form_reply_log_edit(); ?> tabindex="<?php bbp_tab_index(); ?>" />
                                <label for="bbp_log_reply_edit"><?php _e( 'Keep a log of this edit:', 'bbpress' ); ?></label><br />
                            </legend>

                            <div>
                                <label for="bbp_reply_edit_reason"><?php printf( __( 'Optional reason for editing:', 'bbpress' ), bbp_get_current_user_name() ); ?></label><br />
                                <input type="text" value="<?php bbp_form_reply_edit_reason(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_reply_edit_reason" id="bbp_reply_edit_reason" />
                            </div>
                        </fieldset> <!-- .bbp-form -->

                        <?php do_action( 'bbp_theme_after_reply_form_revisions' ); ?>

                    <?php endif; ?>

                    <?php do_action( 'bbp_theme_before_reply_form_submit_wrapper' ); ?>

                    <div class="bbp-submit-wrapper">

                        <?php do_action( 'bbp_theme_before_reply_form_submit_button' ); ?>

                        <?php bbp_cancel_reply_to_link(); ?>

                        <button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_reply_submit" name="bbp_reply_submit" class="btn btn-default btn-xs button submit"><?php _e( 'Submit', 'bbpress' ); ?></button>

                        <?php do_action( 'bbp_theme_after_reply_form_submit_button' ); ?>

                    </div> <!-- .bbp-submit-wrapper -->

                    <?php do_action( 'bbp_theme_after_reply_form_submit_wrapper' ); ?>

                </div>

                <?php bbp_reply_form_fields(); ?>

                <?php do_action( 'bbp_theme_after_reply_form' ); ?>

            </fieldset> <!-- .bbp-form -->

        </form>
    </div> <!-- .bbp-reply-form -->

<?php elseif ( bbp_is_topic_closed() ) : ?>

    <div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
        <div class="alert alert-info">
            <p><?php printf( __( 'O tópico &#8216;%s&#8217; está fechado para novos comentários.', 'cne-ac' ), bbp_get_topic_title() ); ?></p>
        </div>
    </div>

<?php else : ?>

    <div id="no-reply-<?php bbp_topic_id(); ?>" class="bbp-no-reply">
        <div class="alert alert-warning">
            <p><?php is_user_logged_in() ? _e( 'Você não pode comentar neste tópico.', 'cne-ac' ) : _e( 'Você precisa entra na sua conta para comentar nos tópicos.', 'cne-ac' ); ?></p>
        </div>
    </div>

<?php endif; ?>

<?php if ( bbp_is_reply_edit() ) : ?>

    </div> <!-- #bbpress-forums -->

<?php endif; ?>
