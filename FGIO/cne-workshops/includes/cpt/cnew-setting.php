<?php
if ( !defined( 'ABSPATH' ) ) exit;

function cnew_get_workshop_post_type() {
                return 'cnew_workshop';
}

function cnew_get_workshop_post_type_labels() {
    return array(
            'name'               => __( 'Oficinas',                   'cnew' ),
            'menu_name'          => __( 'Oficinas',                   'cnew' ),
            'singular_name'      => __( 'Oficina',                    'cnew' ),
            'all_items'          => __( 'Oficinas',               'cnew' ),
            'add_new'            => __( 'Nova Oficina',                'cnew' ),
            'add_new_item'       => __( 'Criar Nova Oficina',         'cnew' ),
            'edit'               => __( 'Editar',                     'cnew' ),
            'edit_item'          => __( 'Editar Oficina',               'cnew' ),
            'new_item'           => __( 'Nova Oficina',                'cnew' ),
            'view'               => __( 'Visualizar Oficina',               'cnew' ),
            'view_item'          => __( 'Visualizar Oficina',               'cnew' ),
            'search_items'       => __( 'Pesquisar Oficinas',            'cnew' ),
            'not_found'          => __( 'Nenhuma oficina encontrada',          'cnew' ),
            'not_found_in_trash' => __( 'Nenhuma oficina encontrada no lixo', 'cnew' )
    );
}

function cnew_get_workshop_post_type_rewrite() {
    return array(
            'slug'       => 'cnew-workshops',
            'with_front' => false
    );
}

function cnew_get_workshop_post_type_supports() {
    return array(
            'title',
            'editor',
            'thumbnail'
    );
}

function cnew_get_workshop_menu_icon() {
    return 'dashicons-welcome-learn-more';
}

function cnew_get_registration_post_type() {
                return 'cnew_registration';
}

function cnew_get_registration_post_type_labels() {
    return array(
            'name'               => __( 'Inscrições',                   'cnew' ),
            'menu_name'          => __( 'Inscrições',                   'cnew' ),
            'singular_name'      => __( 'Inscrição',                    'cnew' ),
            'all_items'          => __( 'Inscrições',               'cnew' ),
            'add_new'            => __( 'Nova Inscrição',                'cnew' ),
            'add_new_item'       => __( 'Criar Nova Inscrição',         'cnew' ),
            'edit'               => __( 'Editar',                     'cnew' ),
            'edit_item'          => __( 'Editar Inscrição',               'cnew' ),
            'new_item'           => __( 'Nova Inscrição',                'cnew' ),
            'view'               => __( 'Visualizar Inscrição',               'cnew' ),
            'view_item'          => __( 'Visualizar Inscrição',               'cnew' ),
            'search_items'       => __( 'Pesquisar Inscrição',            'cnew' ),
            'not_found'          => __( 'Nenhuma inscrição encontrada',          'cnew' ),
            'not_found_in_trash' => __( 'Nenhuma inscrição encontrada no lixo', 'cnew' )
    );
}

function cnew_get_registration_post_type_rewrite() {
    return array(
            'slug'       => 'cnew_registration',
            'with_front' => false
    );
}

function cnew_get_registration_post_type_supports() {
    return false;
}

function cnew_get_registration_menu_icon() {
    return 'dashicons-welcome-learn-more';
}


