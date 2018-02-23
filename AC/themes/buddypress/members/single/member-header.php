<?php

/**
 * BuddyPress - Users Header
 */

?>

<?php do_action( 'bp_before_member_header' ); ?>

<div class="row">
    <div id="item-header-avatar" class="col-xs-3">
        <a href="<?php bp_displayed_user_link(); ?>">

            <?php bp_displayed_user_avatar( 'type=full' ); ?>

        </a>
    </div> <!-- #item-header-avatar -->

    <div id="item-header-content" class="col-xs-9">
        <p class="bbp-user-topic-count"><?php printf( __( 'Tópicos: %s',  'cne-ac' ), bbp_get_user_topic_count_raw() ); ?></p>
        <p class="bbp-user-reply-count"><?php printf( __( 'Comentários: %s', 'cne-ac' ), bbp_get_user_reply_count_raw() ); ?></p>
        <p class="bbp-user-reply-count"><?php printf( __( 'Tópicos Avaliados: %s', 'cne-ac' ), count( bbp_get_user_favorites_topic_ids() ) ); ?></p>
        <p class="cne-bp-user-last-activity">Última Atividade: <span class="activity" data-livestamp="<?php bp_core_iso8601_date( bp_get_user_last_activity( bp_displayed_user_id() ) ); ?>"><?php bp_last_activity( bp_displayed_user_id() ); ?></span></p>

        <?php do_action( 'bp_before_member_header_meta' ); ?>
        <p>
            <div id="item-meta">

                <div id="item-buttons">

                    <?php do_action( 'bp_member_header_actions' ); ?>

                </div> <!-- #item-buttons -->

                <?php do_action( 'bp_profile_header_meta' ); ?>

            </div> <!-- #item-meta -->
        </p>
    </div> <!-- #item-header-content -->
</div> <!-- .row -->

<div class="row">
    <?php do_action( 'bp_after_member_header' ); ?>

    <div id="template-notices" class="col-xs-12" role="alert" aria-atomic="true">
        <?php do_action( 'template_notices' ); ?>
    </div>
</div> <!--.row -->
