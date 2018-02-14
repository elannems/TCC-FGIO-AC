<?php

/**
 * bbPress - Replies Loop: Single Reply
 */

?>

<tbody>
    
    <tr>
        <td class="text-left"> <?php cne_ac_card_user_topic_image( bbp_get_reply_topic_id() ); ?> </td>
        <td class="text-left">
            <div>
                <?php $topic_title = bbp_get_topic_title( bbp_get_reply_topic_id() ); ?>
                <?php echo bbp_is_topic_trash( bbp_get_reply_topic_id() ) ? $topic_title : '<a class="bbp-topic-permalink" href="' . bbp_get_topic_permalink( bbp_get_reply_topic_id() ).'">'.$topic_title .'</a>'; ?>
            </div>
        </td>

        <td class="text-left"><?php bbp_reply_content(); ?></td>
        <td class="text-left"><?php bbp_reply_post_date(); ?></td>
        <?php if( cne_ac_current_user_can_edit_delete() ) : ?>
            <td>
                <?php echo cne_ac_bbp_get_reply_trash_link(); ?>
            </td>
        <?php endif; ?>
    </tr>

</tbody>

