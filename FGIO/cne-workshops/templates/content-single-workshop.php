<?php

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <div class="wrap">
        
        <header class="cnew-entry-header">
            
            <?php
            
                the_title( '<h1 class="cnew-entry-title">', '</h1>' );	
                
            ?>

            <div class="cnew-entry-meta">
                <span class="cnew-date"><i class="fa fa-calendar"></i> <?php the_time('j \d\e F \d\e Y') ?></span>
            </div><!-- .cnew-entry-meta -->
            
	</header><!-- .cnew-entry-header -->

	<div class="cnew-entry-content">
            
            <div class="cnew-post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .cnew-post-thumbnail -->
            
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            
            <table class="cnew-table-content">
                <tr>
                    <th><?php _e('Conteúdo:', 'cnew'); ?></th>
                    <td><?php echo nl2br( get_post_meta(get_the_ID(), 'cnew_content', true) ); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Objetivo:', 'cnew'); ?></th>
                    <td><?php echo get_post_meta(get_the_ID(), 'cnew_objective', true); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Requisitos:', 'cnew'); ?></th>
                    <td><?php echo nl2br( get_post_meta(get_the_ID(), 'cnew_requirements', true) ); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Público Alvo:', 'cnew'); ?></th>
                    <td><?php echo get_post_meta(get_the_ID(), 'cnew_target_audience', true); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Período de Inscrição:', 'cnew'); ?></th>
                    <td><?php 
                            $start_date = get_post_meta(get_the_ID(), 'cnew_start_date', true);
                            $end_date = get_post_meta(get_the_ID(), 'cnew_end_date', true);
                            echo cnew_converter_date_to_front($start_date) . __(' até ', 'cnew') .  cnew_converter_date_to_front($end_date); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Data do Evento:', 'cnew'); ?></th>
                    <td><?php echo get_post_meta(get_the_ID(), 'cnew_date_event', true); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Local do Evento:', 'cnew'); ?></th>
                    <td><?php echo get_post_meta(get_the_ID(), 'cnew_events_place', true); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Contato para Informações:', 'cnew'); ?></th>
                    <td><?php echo get_post_meta(get_the_ID(), 'cnew_contact', true); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Informações Adicionais:', 'cnew'); ?></th>
                    <td><?php echo nl2br( get_post_meta(get_the_ID(), 'cnew_more_info', true) ); ?></td>
                </tr>
            </table><!-- .cnew-table-content -->
            
            <?php $registration_page_link = cnew_get_registration_form_page_link( get_the_ID(), $start_date, $end_date ); ?>
            
            <?php if( !empty($registration_page_link) ) : ?>
                <div class="cnew-form">
                    <a href=" <?php echo esc_url( $registration_page_link ) ?>" id="registration-submit"> <?php _e( 'Realizar inscrição', 'cnew' ) ?> </a>
                </div>
            <?php endif; ?> 
          
        </div><!-- .cnew-entry-content -->

        <footer class="entry-footer">
		<?php edit_post_link( __( 'Editar', 'cnew' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
        
    </div>

</article><!-- post- -->
