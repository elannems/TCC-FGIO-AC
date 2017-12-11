<?php ?>

<div class="cnew-before-form">
    <?php if( isset( $data ) ) : ?> 
        <div class="cnew-workshop-title">
            <h1><?php echo $data->title; ?></h1>
        </div>
        <?php if( isset( $data->vagas_preenchidas ) ) : ?>
            <?php echo $data->vagas_preenchidas ?>
        <?php endif; ?>
        <?php if( isset( $data->error ) ) : ?>
            <?php echo $data->error ?>
        <?php endif; ?>
    <?php endif ?>
</div>

<div class="cnew-form">
    
    <form action="" name="cnew_registration_form" id="cnew-registration-form" class="cnew-registration-form" method="post">
        
        <fieldset>
            <legend>Informações do Participante</legend>
            <div class="cnew-form-group">
                <label for="cnew-reg-name"><?php _e( 'Nome Completo', 'cnew' ); ?><span class="cnew-required"> *</span></label>
                <input type="text" id="cnew-reg-name" class="cnew-input-text" name="cnew_reg_name" value="<?php cnew_registration_name_value(); ?>" />
            </div>

            <div class="cnew-form-group">
                <label for="cnew-reg-date-birth"><?php _e( 'Mês e Ano de Nascimento (mês/ano)', 'cnew' ); ?><span class="cnew-required"> *</span></label>
                <input type="text" id="cnew-reg-date-birth" class="cnew-input-text" name="cnew_reg_date_birth" value="<?php cnew_registration_date_birth_value(); ?>" />
            </div>

            <div class="cnew-form-group">
                    <label for="cnew-reg-gender"><?php _e( 'Sexo', 'cnew' ); ?><span class="cnew-required"> *</span></label>
                    <div class="cnew-form-radio">
                        <input type="radio" name="cnew_reg_gender" id="cnew-reg-gender" value="male" <?php cnew_registration_gender_checked( 'male' ); ?>> Masculino
                        <input type="radio" name="cnew_reg_gender" id="cnew-reg-gender" value="female" <?php cnew_registration_gender_checked( 'female' ); ?>> Feminino
                    </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Informações do Responsável</legend>
            <div class="cnew-form-group">
                <label for="cnew-reg-parent-name"><?php _e( 'Nome Completo', 'cnew' ); ?><span class="cnew-required"> *</span></label>
                <input type="text" id="cnew-reg-parent-name" class="cnew-input-text" name="cnew_reg_parent_name" value="<?php cnew_registration_parent_name_value(); ?>" />
            </div>
            
            <div class="cnew-form-group">
                <label for="cnew-reg-parent-phone"><?php _e( 'Telefone', 'cnew' ); ?><span class="cnew-required"> *</span></label>
                <input type="text" id="cnew-reg-parent-phone" class="cnew-input-text" name="cnew_reg_parent_phone" value="<?php cnew_registration_parent_phone_value(); ?>" />
            </div>

            <div class="cnew-form-group">
                <label for="cnew-reg-email"><?php _e( 'E-mail', 'cnew' ); ?><span class="cnew-required"> *</span></label>
                <input type="email" id="cnew-reg-email" class="cnew-input-text" name="cnew_reg_email" value="<?php cnew_registration_email_value(); ?>"  />
            </div>
        </fieldset>

        <input type="submit" name="registration_submit" id="registration-submit" value="<?php esc_attr_e( 'Enviar Inscrição', 'cnew' ); ?>" />
        
        <?php wp_nonce_field( 'cnew_new_registration' ); ?>

    </form>
    
</div>
