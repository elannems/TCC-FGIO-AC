<?php
/**
 * BuddyPress - Members Register
 *
 * @package cne-ac
 * 
 */

?>
<style type="text/css">
    #basic-details-section{
        display:none;
    }
</style>
<div id="buddypress">

	<?php do_action( 'bp_before_register_page' ); ?>

	<div class="page row" id="register-page">
            
            <div class="col-xs-offset-2 col-xs-8 col-xs-offset-2">

		<form action="" name="signup_form" id="signup_form" class="standard-form" method="post" enctype="multipart/form-data">

		<?php if ( 'registration-disabled' == bp_get_current_signup_step() ) : ?>

			<div id="template-notices" role="alert" aria-atomic="true" class="alert-danger">
				<?php do_action( 'template_notices' ); ?>

			</div>

			<?php do_action( 'bp_before_registration_disabled' ); ?>

				<p><?php _e( 'User registration is currently not allowed.', 'buddypress' ); ?></p>

			<?php do_action( 'bp_after_registration_disabled' ); ?>
		<?php endif; ?>

		<?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

			<div id="template-notices" role="alert" aria-atomic="true" class="alert-danger">
				<?php do_action( 'template_notices' ); ?>
			</div>
                        <div class="alert alert-info" role="alert">
                            <p><?php _e( 'É fácil se cadastrar. Basta preencher os campos abaixo e nós vamos criar uma conta para você em segundos.', 'cne-ac' ); ?></p>
                           
                        </div>
			<?php do_action( 'bp_before_account_details_fields' ); ?>

                            <?php /***** Informacoes do Perfil ******/ ?>

			<?php if ( bp_is_active( 'xprofile' ) ) : ?>

				<?php do_action( 'bp_before_signup_profile_fields' ); ?>

				<div class="register-section" id="profile-details-section">
                                        <fieldset>
					<legend><?php _e( 'Informações do Perfil', 'cne-ac' ); ?></legend>

					<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<div<?php bp_field_css_class( array( 'editfield' ) ); ?>>

							<?php
							$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
                                                        if( $field_type->name === 'Seletor de data') :
                                                            echo '<div class="form-inline">';
                                                        endif;
                                                            echo '<div class="form-group">';
                                                                $field_type->edit_field_html( array( 'class' => 'form-control', 'required' => 'required' ) );
                                                                do_action( 'bp_custom_profile_edit_fields_pre_visibility' );


                                                                do_action( 'bp_custom_profile_edit_fields' ); ?>
                                                                
                                                                <?php if( !empty( bp_the_profile_field_description() ) ) : ?>
                                                                    <p class="description"><?php bp_the_profile_field_description(); ?></p>
                                                                <?php endif;
                                                        echo '</div>'; 
                                                       if( $field_type->name === 'Seletor de data') :
                                                           echo '</div>';
                                                       endif; ?>

						</div>

					<?php endwhile; ?>

					<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

					<?php endwhile; endif; endif; ?>

					<?php do_action( 'bp_signup_profile_fields' ); ?>
                                        
                                        </fieldset>
                                    
                                        <div class="cne-bbp-information">
                                            <div class="panel panel-default cne-panel">

                                                <div class="panel-heading cne-panel-heading">
                                                    <h1><?php _e( 'Sobre as informações solicitadas', 'cne-ac' ); ?></h1>
                                                </div> <!-- cne-panel-heading -->

                                                <div class="panel-body cne-panel-body">
                                                    <ul>
                                                        <li><span style="font-size: 16px;">Nome de exibição: </span><span style="font-weight: 400;">é o nome que será exibido quando você fizer uma publicação, por isto recomendamos não utilizar seu nome verdadeiro;</span></li>
                                                        <li><span style="font-size: 16px;">Data de nascimento: </span><span style="font-weight: 400;">essa informação é utilizada para levantar o perfil das pessoas que utilizam o sistema. Essa informação não é visível publicamente e nem será divulgada a terceiros.</span></li>
                                                    </ul>
                                                </div> <!-- cne-panel-body -->

                                            </div> <!-- cne-panel -->
                                        </div> <!-- cne-bbp--information -->
                                    
                                    <div class="submit"><a class="btn btn-default cne-next-step pull-right"><?php _e('Próximo', 'cne-ac'); ?></a></div>

				</div><!-- #profile-details-section -->

				<?php do_action( 'bp_after_signup_profile_fields' ); ?>

			<?php endif; ?>

				<?php /***** Informacoes da Conta ******/ ?>
                                
                            <div class="register-section" id="basic-details-section">

                            <fieldset>
					<legend><?php _e( 'Informações da Conta', 'cne-ac' ); ?></legend>
                                
                                <div class="form-group">
                                    <label for="signup_username"><?php _e( 'Username', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                                    <?php do_action( 'bp_signup_username_errors' ); ?>
                                    <input type="text" name="signup_username" id="signup_username" class="form-control" value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes( 'username' ); ?> required="required"/>
                                    <?php _e('A informação deste campo será visível a todos os usuários, então solicitamos que não utilize seu nome verdadeiro para sua segurança.', 'cne-ac'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="signup_email" id="cne-label-signup-email"><?php _e( 'Email Address', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                                    <?php do_action( 'bp_signup_email_errors' ); ?>
                                    <input type="email" name="signup_email" id="signup_email" class="form-control" value="<?php bp_signup_email_value(); ?>" <?php bp_form_field_attributes( 'email' ); ?> required="required"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="signup_password"><?php _e( 'Choose a Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                                    <?php do_action( 'bp_signup_password_errors' ); ?>
                                    <input type="password" name="signup_password" id="signup_password" value="" class="password-entry form-control" <?php bp_form_field_attributes( 'password' ); ?> required="required"/>
                                    <div id="pass-strength-result"></div>
                                </div>
                                <div class="form-group">
				<label for="signup_password_confirm"><?php _e( 'Confirm Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
				<?php do_action( 'bp_signup_password_confirm_errors' ); ?>
				<input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" class="password-entry-confirm form-control" <?php bp_form_field_attributes( 'password' ); ?> required="required"/>
                                </div>
				
                                <?php do_action( 'bp_account_details_fields' ); ?>
                                
                            </fieldset>
                                
                            <div class="cne-bbp-information">
                                <div class="panel panel-default cne-panel">

                                    <div class="panel-heading cne-panel-heading">
                                        <h1><?php _e( 'Sobre as informações solicitadas', 'cne-ac' ); ?></h1>
                                    </div> <!-- cne-panel-heading -->

                                    <div class="panel-body cne-panel-body">
                                        <div class="cne-rules-list">
                                            <ul>
                                                <li><span style="font-size: 16px;">Nome de usuário: </span><span style="font-weight: 400;">é o nome que você utilizará para acessar sua conta (em conjunto com a senha). Essa informação é visível publicamente, por isto recomendamos não utilizar seu nome verdadeiro.</span></li>
                                                <li><span style="font-size: 16px;">E-mail: </span><span style="font-weight: 400;">essa informação é necessária para que seja enviado o e-mail de ativação da sua conta e também para recuperar sua conta. Essa informação não é visível publicamente e nem será divulgada a terceiros.</span></li>
                                                <li><span style="font-size: 16px;">Senha: </span><span style="font-weight: 400;"> informação necessária para acessar sua conta (em conjunto com o nome de usuário). Essa informação não é visível publicamente e nem será divulgada a terceiros.</span></li>
                                            </ul>
                                        </div>
                                        <div class="cne-rules-report">
                                            <h2><?php _e('Para sua segurança, pedimos que não informe nenhuma informação pessoal para outros usuários. Caso você encontre algum usuário solicitando informações pessoais, por favor denuncie acionando o link <i class="cne-btn-circle cne-alert fa fa-bullhorn" aria-hidden="true"></i> presente nos tópicos e comentários.', 'cne-ac'); ?></h2>
                                        </div> <!-- cne-rules-report -->
                                    </div> <!-- cne-panel-body -->

                                </div> <!-- cne-panel -->
                            </div> <!-- cne-bbp--information -->
                            
                            <div class="cne-bbp-information">
                                <div class="panel panel-default cne-panel">
                                    <div class="panel-heading cne-panel-heading">
                                        <h1><?php _e( 'Os tópicos e comentários <span class="cne-required">NÃO</span> devem', 'cne-ac' ); ?></h1>
                                    </div> <!-- cne-panel-heading -->

                                    <div class="panel-body cne-panel-body">
                                        <?php cne_ac_rules_list(); ?>
                                        <div class="cne-rules-report">
                                            <h2><?php _e('Caso encontre algum tópico ou comentário que não respeite essas regras, denuncie acionando o link <i class="cne-btn-circle cne-alert fa fa-bullhorn" aria-hidden="true"></i> presente nos tópicos e comentários.', 'cne-ac'); ?></h2>
                                        </div> <!-- cne-rules-report -->
                                    </div> <!-- cne-panel-body -->
                                </div> <!-- cne-panel -->
                            </div> <!-- cne-bbp--information -->
                                
                                <?php do_action( 'bp_before_registration_submit_buttons' ); ?>

                                <div class="submit">
                                        <input type="submit" name="signup_submit" id="signup_submit" class="btn btn-success pull-right" value="<?php esc_attr_e( 'Enviar', 'cne-ac' ); ?>" />
                                </div>

                                <?php do_action( 'bp_after_registration_submit_buttons' ); ?>

                                <?php wp_nonce_field( 'bp_new_signup' ); ?>
			</div> <!-- #basic-details-section -->

			<?php do_action( 'bp_after_account_details_fields' ); ?>

			
			

		<?php endif; ?>

		<?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php	do_action( 'template_notices' ); ?>

			</div>

			<?php	do_action( 'bp_before_registration_confirmed' ); ?>

			<div id="template-notices" class="alert alert-success" role="alert" aria-atomic="true">
                            <p><?php _e( 'Sua conta foi criada com sucesso! Contudo, para começar a compartilhar e interagir com os outros usuários, é necessário ativar a conta através do e-mail que enviamos para o endereço de e-mail informado no cadastro.', 'cne-ac' ); ?></p>
			</div>

			<?php do_action( 'bp_after_registration_confirmed' ); ?>

		<?php endif; ?>

		<?php do_action( 'bp_custom_signup_steps' ); ?>

		</form>
                
            </div> <!-- .col -->

	</div> <!-- .row -->

	<?php do_action( 'bp_after_register_page' ); ?>

</div><!-- #buddypress -->
