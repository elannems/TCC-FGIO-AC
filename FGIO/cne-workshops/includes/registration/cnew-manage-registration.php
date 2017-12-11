<?php

if ( !defined( 'ABSPATH' ) ) exit;

function cnew_ativa_inscricao( $key ) {
    $data = array( 'class' => 'cnew-error', 'msg' => 'Ocorreu um problema ao confirmar sua inscrição.' );
    $inscricao = new CNEW_Registration();
    $resultado = $inscricao->cnew_confirma_inscricao( $key );
    
    if( $resultado ) {
        $data = array( 'class' => 'cnew-success', 'msg'=>__( 'E-mail confirmado com sucesso!', 'cnew' ) );
    }
    
    return $data;
}

/*
 * Baseado em <https://code.tutsplus.com/tutorials/wordpress-error-handling-with-wp_error-class-ii--cms-21142>
 */
function cnew_page_registration( $template, $workshop ) {
    
    $vagas = get_post_meta( $workshop->ID, 'cnew_vacancies');
    if( !empty($vagas) && $vagas[0] ) {
        if( $vagas[0] <= CNEW_Registration::cnew_get_total_reg_workshop( $workshop->ID ) ) {
            $data = array( 'class' => 'cnew-warning', 'msg' => 'Caro inscrito, comunicamos que já recebemos mais inscrições que o número de vagas disponíveis para essa oficina. Contudo, você ainda pode se inscrever pois caso ocorra alguma desistência sua inscrição pode ser selecionada.' );

            ob_start();
            $template->set_template_data( $data )->get_template_part( 'feedback', 'message' );
            $vagas_preenchidas = ob_get_clean();
            
            $data['vagas_preenchidas'] = $vagas_preenchidas;
        }
    }

    if ( isset( $_POST['registration_submit'] ) && cnew_verify_nonce_request( 'cnew_new_registration' ) ) {
        
        $name           = sanitize_text_field( cnew_get_registration_name_value() );
        $date_birth     = sanitize_text_field( cnew_get_registration_date_birth_value() );
        $gender         = cnew_get_registration_gender_value();
        $email          = sanitize_email( cnew_get_registration_email_value() );
        $parent_name    = sanitize_text_field( cnew_get_registration_parent_name_value() );
        $parent_phone   = sanitize_text_field( cnew_get_registration_parent_phone_value() );
        
        $has_error = cnew_validate_form($name, $date_birth, $gender, $email, $parent_name, $parent_phone, $workshop->ID);
        
        $registration_success = false;
        
        if ( $has_error ) {
            
            global $form_error;
            
            $list_error = '<ul>';
            foreach ( $form_error->get_error_messages() as $error ) {
                $list_error .= '<li>' . $error . '</li>';
            }
            $list_error .= '</ul>';
            
            $data = array( 'class' => 'cnew-error', 'msg' => $list_error );
            
            ob_start();
            $template->set_template_data( $data )->get_template_part( 'feedback', 'message' );
            $output_error = ob_get_clean();
            
            $data['title'] = $workshop->post_title;
            $data['error'] = $output_error;
            $template->set_template_data( $data )->get_template_part( 'form', 'registration' );
            
        } else {
        
        $new_register = new CNEW_Registration;

        $registration_success = $new_register->cnew_add( $name, $date_birth, $gender, $email, $parent_name, $parent_phone, $workshop);

            if( $registration_success ) {
                $data = array( 'class' => 'cnew-success', 'msg'=>__( 'Solicitação de inscrição enviada com sucesso, mas ainda não acabou! Enviamos uma confirmação de e-mail para o e-mail informado no formulário de inscrição. Confirme seu e-mail para finalizar a solicitação de inscrição.', 'cnew' ) );
                $template->set_template_data( $data )->get_template_part( 'feedback', 'message' );
            } else {
                $data = array( 'class' => 'cnew-error', 'msg' => 'Ocorreu um problema ao enviar sua inscrição. Por favor, tente novamente.' );

                ob_start();
                $template->set_template_data( $data )->get_template_part( 'feedback', 'message' );
                $output_error = ob_get_clean();

                $data['title'] = $workshop->post_title;
                $data['error'] = $output_error;
                $template->set_template_data( $data )->get_template_part( 'form', 'registration' );
            }
        
        }

    } else {

        $data['title'] = $workshop->post_title;
        $template->set_template_data( $data )->get_template_part( 'form', 'registration' );
    
    }
    
}

function cnew_validate_form( $name, $date_birth, $gender, $email, $parent_name, $parent_phone, $workshop_id ) {
    
    global $form_error;
     
    $form_error = new WP_Error;
     
    if ( empty( $name ) || empty( $date_birth ) || empty( $gender ) || empty( cnew_get_registration_email_value() ) || empty( $parent_name ) || empty( $parent_phone ) ) :
        $form_error->add( 'required', __( 'Algum campo obrigatório não foi preenchido. Por favor, revise o formulário.', 'cnew' ) );
    endif;
    
    if( ( strlen( $name ) > 255 ) || ( strlen( $email ) > 255 ) || ( strlen( $parent_name ) > 255 ) ) :
        $form_error->add( 'maxlength', __( 'Algum campo excede 255 caracteres. Por favor, revise o formulário.', 'cnew' ) );
    endif;
    
    if( !preg_match( "/^[\'a-zA-ZÀ-ú ]*$/",$name ) || !preg_match( "/^[a-zA-ZÀ-ú ]*$/",$parent_name ) ) :
        $form_error->add( 'invalid_name', __( 'O nome informado é inválido. Por favor, revise os campos "Nome Completo", pois estes só permitem letras e espaço em branco.', 'cnew' ) );
    endif;
    
    if( $gender != 'male' && $gender != 'female' ) :
        $form_error->add( 'invalid_gender', __( 'O sexo informado é inválido. Por favor, selecione uma das opções do campo.', 'cnew' ) );
    endif;
    
    if ( !preg_match( '/^(((0[1-9]|1[0-2])\/((19|[2-9]\d)\d{2})))$/', $date_birth ) ) :
        $form_error->add( 'invalid_date', __( 'A data de nascimento inserida é inválida. Por favor, verifique se a data informada respeita o formato mês/ano.', 'cnew' ) );
    else :
        $parts_date = explode( '/', $date_birth );
        if( $parts_date[1] >= date( 'Y' )  ) :
            $form_error->add( 'invalid_date', __( 'O ano de nascimento inserido é inválido. Por favor, verifique se o ano informado é menor que o ano corrente.', 'cnew' ) );
        endif;
    endif;
    
    if( ! is_email( $email ) ) :
        $form_error->add( 'invalid_email', __( 'O e-mail informado é inválido. Por favor, verifique o formato do e-mail inserido.', 'cnew' ) );
    else :
        if( cnew_email_has_registration( $email, $workshop_id ) ) {
            $form_error->add( 'email_exists', __( 'O e-mail informado já está inscrito nesta oficina.', 'cnew' ) );
        }
    endif;
    
    $phone_number = preg_replace("/\D/","",$parent_phone);
    if( strlen( $phone_number ) != 10 && strlen( $phone_number ) != 11 ) :
            $form_error->add( 'invalid_phone', __( 'O número de telefone inserido é inválido. Por favor, informe um telefone com 10 ou 11 dígitos.', 'cnew' ) );
    endif;
    
    $has_error = false;
    if( is_wp_error( $form_error) && !empty( $form_error->get_error_messages() ) )
        $has_error = true;
    
    return $has_error;
 
}          

