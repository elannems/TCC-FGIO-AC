<?php

/**
 * BBPress - User Topics Loop
 *
 * @package cne-ac
 * 
 */

?>

<?php do_action( 'bbp_template_before_topics_loop' ); ?>

<div id="bbp-forum-<?php bbp_forum_id(); ?> bbp-topics">
    
        <?php bbp_get_template_part( 'pagination', 'header-topics' ); ?>
    
    <div class="cne-topics">
        <!-- http://bootsnipp.com/snippets/mp16M -->
        <div class="table-responsive">
        <div class="cne-table-container">
			<div class="cne-table-body">
				<table class="table">
					<thead>
						<tr>
                                                        <th>Imagem</th>
							<th>Título</th>
							<th><i class="fa fa-heart" aria-hidden="true"></i></th>
							<th><i class="fa fa-comment" aria-hidden="true"></i></th>
							<th>Criado em</th>
							<?php if( cne_ac_current_user_can_edit_delete() ) : ?>
                                                            <th>Ações</th>
                                                        <?php endif; ?>
						</tr>
					</thead>

            <?php while ( bbp_topics() ) : bbp_the_topic(); ?>
                                        
                                        <?php bbp_get_template_part( 'loop', 'user-single-topic' ); ?>

            <?php endwhile; ?>
				</table>
			</div>
			
		</div>
	<div class="clearfix"></div>
</div>
    </div>
    <div class="bbp-after-topics">
        <?php bbp_get_template_part( 'pagination', 'footer-topics' ); ?>
    </div>
</div><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->

<?php do_action( 'bbp_template_after_topics_loop' ); ?>
