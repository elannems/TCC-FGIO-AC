<?php

function cnew_registration_custom_metabox_callback( $post ) {
    
    wp_nonce_field( 'cnew_registration_metabox_save', 'cnew_registration_metabox_nonce' );
    
    $values = CNEW_Registration::cnew_get_by_post_id( $post->ID );
    
    $value_name = isset( $values->name ) ? esc_attr( $values->name ) : '';
    
    $value_date_birth = isset( $values->date_birth ) ? converter_date_birth_to_mb( esc_attr( $values->date_birth ) ) : '';
    
    $value_gender = isset( $values->gender ) ? esc_attr( $values->gender ) : '';
    
    $value_parent_name = isset( $values->parent_name ) ? esc_attr( $values->parent_name ) : '';
    
    $value_parent_phone = isset( $values->parent_phone ) ? esc_attr( $values->parent_phone ) : '';
    
    $value_email = isset( $values->email ) ? esc_attr( $values->email ) : '';
    
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-reg-name" class="cnew-metabox-label">';
                _e('Nome Completo do Participante', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-reg-name" name="cnew_reg_name" class="cnew-metabox-input" value="'.$value_name.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-reg-date-birth" class="cnew-metabox-label">';
                _e('Mês e Ano de Nascimento do Participante', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-reg-date-birth" name="cnew_reg_date_birth" class="cnew-metabox-input" value="'.$value_date_birth.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">';
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-reg-gender" class="cnew-metabox-label">';
                        _e('Sexo', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">';
            echo '<input type="radio" name="cnew_reg_gender" id="cnew-reg-gender" value="male" ' . checked( $value_gender, 'male', false ) .'>';
                _e( 'Masculino', 'cnew' );
            echo '<input type="radio" name="cnew_reg_gender" id="cnew-reg-gender" value="female" ' . checked( $value_gender, 'female', false ) . '>';
                _e( 'Feminino', 'cnew' );
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-reg-parent-name" class="cnew-metabox-label">';
                _e('Nome Completo do Responsável', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-reg-parent-name" name="cnew_reg_parent_name" class="cnew-metabox-input" value="'.$value_parent_name.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-reg-parent-phone" class="cnew-metabox-label">';
                _e('Telefone do Responsável', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-reg-parent-phone" name="cnew_reg_parent_phone" class="cnew-metabox-input" value="'.$value_parent_phone.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-reg-email" class="cnew-metabox-label">';
                _e('E-mail do Responsável', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-reg-email" name="cnew_reg_email" class="cnew-metabox-input" value="'.$value_email.'" />';
        echo '</div>';
    echo '</div>';
    
}

function cnew_workshop_custom_metabox_callback( $post ) {
    
    wp_nonce_field( 'cnew_workshop_metabox_save', 'cnew_workshop_metabox_nonce' );
    
    $values = get_post_custom( $post->ID );
    
    $value_content = isset( $values['cnew_content'] ) ? esc_attr( $values['cnew_content'][0] ) : '';
    
    $value_objective = isset( $values['cnew_objective'] ) ? esc_attr( $values['cnew_objective'][0] ) : '';
    
    $value_target_audience = isset( $values['cnew_target_audience'] ) ? esc_attr( $values['cnew_target_audience'][0] ) : '';
    
    $value_requirements = isset( $values['cnew_requirements'] ) ? esc_attr( $values['cnew_requirements'][0] ) : '';
    
    $value_vacancies = isset( $values['cnew_vacancies'] ) ? esc_attr( $values['cnew_vacancies'][0] ) : '';
    
    $value_start_date = isset( $values['cnew_start_date'] ) ? converter_date_to_mb( esc_attr( $values['cnew_start_date'][0] ) ) : '';
    
    $value_end_date = isset( $values['cnew_end_date'] ) ? converter_date_to_mb( esc_attr( $values['cnew_end_date'][0] ) ) : '';
    
    $value_date_event = isset( $values['cnew_date_event'] ) ? esc_attr( $values['cnew_date_event'][0] ) : '';
    
    $value_events_place = isset( $values['cnew_events_place'] ) ? esc_attr( $values['cnew_events_place'][0] ) : '';
    
    $value_contact = isset( $values['cnew_contact'] ) ? esc_attr( $values['cnew_contact'][0] ) : '';
    
    $value_more_info = isset( $values['cnew_more_info'] ) ? esc_attr( $values['cnew_more_info'][0] ) : '';
    
    //$value_form_type = isset( $values['cnew_form_type'] ) ? esc_attr( $values['cnew_form_type'][0] ) : '';
    
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-content" class="cnew-metabox-label">';
                _e('Conteúdo', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<textarea  id="cnew-content" name="cnew_content" class="cnew-metabox-input" rows="4">'.$value_content.'</textarea>';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-objective" class="cnew-metabox-label">';
                _e('Objetivo', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-objective" name="cnew_objective" class="cnew-metabox-input" value="'.$value_objective.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-requirements" class="cnew-metabox-label">';
                _e('Requisitos', 'cnew' );
            echo '</label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<textarea  id="cnew-requirements" name="cnew_requirements" class="cnew-metabox-input" rows="4">'.$value_requirements.'</textarea>';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-target-audience" class="cnew-metabox-label">';
                _e('Público Alvo', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-target-audience" name="cnew_target_audience" class="cnew-metabox-input" value="'.$value_target_audience.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-start-date" class="cnew-metabox-label">';
                _e('Data de Início das Inscrições', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-start-date" name="cnew_start_date" class="cnew-metabox-input" value="'.$value_start_date.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-end-date" class="cnew-metabox-label">';
                _e('Data de Encerramento das Inscrições', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-end-date" name="cnew_end_date" class="cnew-metabox-input" value="'.$value_end_date.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-date-event" class="cnew-metabox-label">';
                _e('Data do Evento', 'cnew' );
            echo '<span class="cnew-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-date-event" name="cnew_date_event" class="cnew-metabox-input" value="'.$value_date_event.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-events-place" class="cnew-metabox-label">';
                _e('Local do Evento', 'cnew' );
            echo '</label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-events-place" name="cnew_events_place" class="cnew-metabox-input" value="'.$value_events_place.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-vacancies" class="cnew-metabox-label">';
                _e('Número de Vagas', 'cnew' );
            echo '</label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="number"  id="cnew-vacancies" name="cnew_vacancies" class="cnew-metabox-input" value="'.$value_vacancies.'" min="0" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-contact" class="cnew-metabox-label">';
                _e('Contato para Informações', 'cnew' );
            echo '</label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<input type="text"  id="cnew-contact" name="cnew_contact" class="cnew-metabox-input" value="'.$value_contact.'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cnew-metabox-div">'; 
        echo '<div class="cnew-metabox-div-label">'; 
            echo '<label for="cnew-more-info" class="cnew-metabox-label">';
                _e('Informações Adicionais', 'cnew' );
            echo '</label> ';
        echo '</div>';
        echo '<div class="cnew-metabox-div-input">'; 
            echo '<textarea  id="cnew-mote-info" name="cnew_more_info" class="cnew-metabox-input" rows="4">'.$value_more_info.'</textarea>';
        echo '</div>';
    echo '</div>';
   
}

function converter_date_to_mb( $date ) {
    $date_db = DateTime::createFromFormat('Y-m-d', $date);
    return $date_db ? $date_db->format('d/m/Y') : $date_db;
}

function converter_date_birth_to_mb( $date ) {
    $date_db = DateTime::createFromFormat('Y-m-d', $date);
    return $date_db ? $date_db->format('m/Y') : $date_db;
}
