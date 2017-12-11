<?php

function cnew_email_resend( $registration ) {
    $result = false;
    
    if( !empty( $registration ) && !empty($registration->confirmation_key) ) :
            
        $tokens = cnew_get_tokens( array( '{{link_ativacao}}' => 'cnew_get_activate_url' ) );

        $args['replace_pairs'] = cnew_replace_tokens_value( $registration, $tokens );
        $args['subject'] = cnew_get_email_subject_resend();
        $args['header'] = cnew_get_email_header();
        $args['content'] = cnew_get_email_content_resend();
        $args['footer'] = cnew_get_email_footer();

        $result = cnew_send_email( $registration->email, $args );
            
    endif;
    
    return $result;

}

function cnew_email_accepted( $registration ) {
     $result = false;
    
    if( !empty( $registration ) ) :
            
        $tokens = cnew_get_tokens();

        $args['replace_pairs'] = cnew_replace_tokens_value( $registration, $tokens );
        $args['subject'] = cnew_get_email_subject_accepted();
        $args['header'] = cnew_get_email_header();
        $args['content'] = cnew_get_email_content_accepted();
        $args['footer'] = cnew_get_email_footer();

        $result = cnew_send_email( $registration->email, $args );
            
    endif;
    
    return $result;
}

function cnew_email_declined( $registration ) {
     $result = false;
    
    if( !empty( $registration ) ) :
            
        $tokens = cnew_get_tokens();

        $args['replace_pairs'] = cnew_replace_tokens_value( $registration, $tokens );
        $args['subject'] = cnew_get_email_subject_declined();
        $args['header'] = cnew_get_email_header();
        $args['content'] = cnew_get_email_content_declined();
        $args['footer'] = cnew_get_email_footer();

        $result = cnew_send_email( $registration->email, $args );
            
    endif;
    
    return $result;
}

function cnew_email_cancel( $registration ) {
    $result = false;
    
    if( !empty( $registration ) ) :
            
        $tokens = cnew_get_tokens();

        $args['replace_pairs'] = cnew_replace_tokens_value( $registration, $tokens );
        $args['subject'] = cnew_get_email_subject_cancel();
        $args['header'] = cnew_get_email_header();
        $args['content'] = cnew_get_email_content_cancel();
        $args['footer'] = cnew_get_email_footer();

        $result = cnew_send_email( $registration->email, $args );

    endif;
        
    return $result;
}

function cnew_email_create_user( $registration, $key ) {
    
    $tokens = cnew_get_tokens( array( '{{nome_usuario_email}}' => 'cnew_get_user_name_email', '{{senha_usuario}}' => 'cnew_get_password' ) );
    
    $tokens_value = cnew_replace_tokens_value( $registration, $tokens );
    $new_token = array( '{{link_ativacao_conta}}' => esc_url( trailingslashit( bp_get_activation_page() ) . "{$key}/" ) );//bp_get_activation_page retorna pag de ativacao do buddypress
                        
    $args['replace_pairs'] = array_merge($tokens_value, $new_token);
    $args['subject'] = cnew_get_email_subject_create_user();
    $args['header'] = cnew_get_email_header();
    $args['content'] = cnew_get_email_content_create_user();
    $args['footer'] = cnew_get_email_footer();

    return cnew_send_email( $registration->email, $args );
}

function cnew_get_tokens( $add_tokens = array() ) {
    $tokens = array( 
                '{{nome_completo}}' => 'cnew_get_name',
                '{{nome_usuario}}' => 'cnew_get_user_name',
                '{{email}}' => 'cnew_get_email', 
                '{{oficina}}' => 'cnew_get_workshop',
                '{{titulo_site}}' => 'cnew_get_blogname',
                '{{ano_corrente}}' => 'cnew_get_year',
                '{{pagina_inicial}}' => 'cnew_get_page_front',
                );
    if ( !empty( $add_tokens ) &&  is_array( $add_tokens ) ) :
        $tokens = array_merge( $tokens, $add_tokens);
    endif;
    
    return $tokens;
}

function cnew_replace_tokens_value( $registration, $tokens ) {
    
    foreach( $tokens as $token => $value ) :
        
        if( is_string( $value ) && function_exists( $value ) ) {
            $value = call_user_func( $value, $registration );
            
            $replace_pairs[ $token ] = $value ? $value : __( 'Sem Valor', 'cnew' );
        }
        
    endforeach;
    
    return $replace_pairs;
    
}

function cnew_get_user_name( $registration ) {
    $user_name = $registration->email ? substr($registration->email, 0, strpos($registration->email, '@')) : '';
    return $user_name;
}

/*
 * Usa o email como nome de usuario
 */
function cnew_get_user_name_email( $registration ) {
    $user_name = $registration->email ? preg_replace( '/\s+/', '', sanitize_user( $registration->email, true ) ) : '';
    return $user_name;
}

function cnew_get_email( $registration ) {
    $email = $registration->email ? $registration->email : '';
    return $email;
}

function cnew_get_name( $registration ) {
    $name = $registration->name ? $registration->name : '';
    return $name;
}

function cnew_get_password( $registration ) {
    $password = 'cne'.cnew_get_year().$registration->registration_id;
    return $password;
}

function cnew_get_workshop( $registration ) {
    $workshop_title = '';
    if ( $registration->workshop_id ) :
        $workshop = get_post( $registration->workshop_id );
        if( $workshop && $workshop->post_title ) :
            $workshop_title = $workshop->post_title;
        endif;
    endif;
    
    return $workshop_title;
}

function cnew_get_activate_url( $registration ) {
    $activate_url = '';
    $registration_page_id = cnew_get_registration_form_page_id();
    
    if( $registration_page_id && $registration->confirmation_key ) {
        $permalink = get_permalink($registration_page_id);
        $get = '?';

        if( empty(get_option('permalink_structure')) ) :
            $get = '&';
        endif;

        $activate_url = $permalink . $get . 'key=' .$registration->confirmation_key;
    }
    
    return $activate_url;
}

function cnew_get_blogname() {
    return get_bloginfo( 'name' );
}

function cnew_get_year() {
    return date( "Y" );
}

function cnew_get_page_front() {
    return get_home_url();
}
