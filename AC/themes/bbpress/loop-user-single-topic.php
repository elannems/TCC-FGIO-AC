<?php

/**
 * bbPress - Topics Loop: Single
 */

?>

<tbody>
    
    <tr>
        <td class="text-left"> <?php cne_ac_card_user_topic_image( bbp_get_topic_id() ); ?> </td>
        <td class="text-left">
            <div>
                <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
            </div>
            <div>
                <?php echo get_post_meta( bbp_get_topic_id(), 'cne_bbp_topic_desc', true); ?>
            </div>
        </td>

        <td class="text-left"><?php cne_ac_bbp_topic_like_count() ?></td>
        <td class="text-left"><?php bbp_topic_reply_count() ?></td>
        <td class="text-left"><?php  the_date() ?></td>
        <?php if( cne_ac_current_user_can_edit_delete() ) : ?>
            <td>
                <a class="btn btn-default btn-sm" href="<?php bbp_topic_edit_url(); ?>" title="Editar tópico"><i class="fa fa-fw fa-pencil"></i></a> 
                <?php echo cne_ac_bbp_get_topic_trash_link(); ?>
            </td>
        <?php endif; ?>
    </tr>

</tbody>



