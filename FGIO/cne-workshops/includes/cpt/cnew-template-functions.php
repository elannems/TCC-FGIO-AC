<?php

if ( !defined( 'ABSPATH' ) ) exit;

function cnew_workshops() {
        
    //ordenar por fechamento de inscricao
    //buscar so posts com inscricao aberta
    $args = array( 
        'post_type' => cnew_get_workshop_post_type(),
        'post_status' => 'publish',
        'posts_per_page' => get_option('posts_per_page'),
        'order' => 'DESC'
    );

    $workshops = new WP_Query( $args );

    return $workshops;
        
}

/**
 * Retorna apenas as oficinas com o periodo de inscricao em aberto
 */
function cnew_open_workshops( $paged = 1 ) {
        
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : $paged;

    $args = array( 
        'post_type' => cnew_get_workshop_post_type(),
        'post_status' => 'publish',
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $paged,
        'order' => 'DESC',
        'meta_query' => array(
            array( 
                'key' => 'cnew_start_date',
                'value' => date('Y-m-d'),
                'compare' => '<=',
                'type' => 'DATE'
            ),
            array( 
                'key' => 'cnew_end_date',
                'value' => date('Y-m-d'),
                'compare' => '>=',
                'type' => 'DATE'
            )
        )
    );

    $workshops = new WP_Query( $args );

    return $workshops;
 
}

function cnew_closed_workshops( $paged = 1 ) {
        
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : $paged;

    $args = array( 
        'post_type' => cnew_get_workshop_post_type(),
        'post_status' => 'publish',
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $paged,
        'order' => 'DESC',
        'meta_query' => array(
            'relation' => 'OR',
            array( 
                'key' => 'cnew_start_date',
                'value' => date('Y-m-d'),
                'compare' => '>',
                'type' => 'DATE'
            ),
            array( 
                'key' => 'cnew_end_date',
                'value' => date('Y-m-d'),
                'compare' => '<',
                'type' => 'DATE'
            )
        )
    );

    $workshops = new WP_Query( $args );

    return $workshops;
 
}

function cnew_reset_postdata() {
    wp_reset_postdata();
}

function cnew_pagination( $total = '', $paged = 1) {

    if(empty($total)) {
        $total = 1;
    } 
    $get = '?paged=';
    if( empty(get_option('permalink_structure')) ) :
                $get = '/paged/';
    endif;
    
    $pagination_args = array(
        'base'            => '%_%',
        'format'          => $get.'%#%',
        'total'           => $total,
        'current'         => $paged,
        'show_all'        => false,
        'mid_size'        => 1,
        'prev_text'       => __('&laquo;'),
        'next_text'       => __('&raquo;'),
    );

    return paginate_links($pagination_args);

}

function cnew_get_template_loader() {
    $template_loader = new CNEW_template_loader();
    
    return $template_loader;
}

function cnew_is_workshop_open( $start_date, $end_date ) {
        
    $open = false;

    if( !empty($start_date) && !empty($end_date) ) {
        if( $start_date <= date('Y-m-d') && $end_date >= date('Y-m-d'))
            $open = true;
    }

    return $open;
        
}

function cnew_get_registration_form_page_link( $post_id, $start_date, $end_date ) {
    
    $link = '';
    
    //primeiro verifica se esta com a inscricao aberta
    if( cnew_is_workshop_open( $start_date, $end_date ) ) {

        $registration_form_page_id = get_option('cnew_registration_form_page_id');

        if( $registration_form_page_id ) :
            $permalink = get_permalink($registration_form_page_id);
            $get = '?';

            if( empty(get_option('permalink_structure')) ) :
                $get = '&';
            endif;

            $link = $permalink . $get . 'wid=' .$post_id;

        endif;

    }
    
    return $link;
    
}

function cnew_converter_date_to_front( $date ) {   
    $date_db = DateTime::createFromFormat('Y-m-d', $date);
    return $date_db ? $date_db->format('d/m/Y') : $date_db;
    
}

function cnew_registration_name_value() {
    echo cnew_get_registration_name_value();
}

function cnew_get_registration_name_value() {
    $value = '';
    if ( isset( $_POST['cnew_reg_name'] ) )
        $value = stripslashes( $_POST['cnew_reg_name'] );

    return $value;
}

function cnew_registration_date_birth_value() {
    echo cnew_get_registration_date_birth_value();
}

function cnew_get_registration_date_birth_value() {
    $value = '';
    if ( isset( $_POST['cnew_reg_date_birth'] ) )
        $value = $_POST['cnew_reg_date_birth'];

    return $value;
}

function cnew_registration_gender_checked( $gender = 'male' ) {
    echo cnew_get_registration_gender_checked( $gender );
}

function cnew_get_registration_gender_checked($gender = 'male' ) {
    $value = '';
    if ( isset( $_POST['cnew_reg_gender'] ) && $gender === $_POST['cnew_reg_gender'] )
        $value = 'checked';

    return $value;
}

function cnew_registration_gender_value() {
    echo cnew_get_registration_gender_value();
}

function cnew_get_registration_gender_value() {
    $value = '';
    if ( isset( $_POST['cnew_reg_gender'] ) )
        $value = $_POST['cnew_reg_gender'];

    return $value;
}

function cnew_registration_parent_name_value() {
    echo cnew_get_registration_parent_name_value();
}

function cnew_get_registration_parent_name_value() {
    $value = '';
    if ( isset( $_POST['cnew_reg_parent_name'] ) )
        $value = stripslashes( $_POST['cnew_reg_parent_name']) ;

    return $value;
}

function cnew_registration_parent_phone_value() {
    echo cnew_get_registration_parent_phone_value();
}

function cnew_get_registration_parent_phone_value() {
    $value = '';
    if ( isset( $_POST['cnew_reg_parent_phone'] ) )
        $value = $_POST['cnew_reg_parent_phone'];

    return $value;
}

function cnew_registration_email_value() {
    echo cnew_get_registration_email_value();
}

function cnew_get_registration_email_value() {
    $value = '';
    if ( isset( $_POST['cnew_reg_email'] ) )
        $value = $_POST['cnew_reg_email'];

    return $value;
}


function cnew_email_has_registration( $email, $workshop_id ) {
    $has_registration = false;
    
    $registration = CNEW_Registration::cnew_get( $email, $workshop_id );
    
    if( $registration ) {
        $has_registration = true;
    }
    
    return $has_registration;
}
