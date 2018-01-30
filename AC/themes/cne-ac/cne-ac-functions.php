<?php

/*
 * Carrega os scripts necessarios para as paginas do buddypress, bbpress e que utilizam o template cne-ac.php
 */
function cne_ac_load_scripts(){  
    if( function_exists( 'bbpress' ) && function_exists( 'buddypress' ) ) {
	if ( is_page_template('cne-ac.php') || is_buddypress() || is_bbpress() ) {
            wp_enqueue_style( 'cne-ac-css', get_template_directory_uri() . '/cne-ac/css/cne-ac.css' );
            wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/cne-ac/css/bootstrap.min.css' );
            wp_enqueue_style( 'fontawesome-css', get_template_directory_uri() . '/cne-ac/css/font-awesome.min.css' );
            wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/cne-ac/css/slick.css' );
            wp_enqueue_style( 'slick-theme-css', get_template_directory_uri() . '/cne-ac/css/slick-theme.css' );
            wp_enqueue_script( 'slick', get_template_directory_uri() . '/cne-ac/js/slick.min.js', array( 'jquery' ), '20120206', true );
            wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/cne-ac/js/bootstrap.min.js', array( 'jquery' ), '20120206', true );
            wp_enqueue_script( 'validate', get_template_directory_uri() . '/cne-ac/js/jquery.validate.min.js', array( 'jquery' ), '20120206', true );
            wp_enqueue_script( 'main', get_template_directory_uri() . '/cne-ac/js/cne-ac.js', array( 'jquery' ), '20120206', true );
        }
    }
}
add_action('wp_enqueue_scripts','cne_ac_load_scripts');

/*
 * Carrega os scripts necessarios para a area administrativa do wordpress
 */
function cne_ac_load_scripts_admin( ) { 
    if( function_exists( 'bbpress' ) && function_exists( 'buddypress' ) ) {
        wp_register_style( 'cne-ac-css-admin', get_template_directory_uri() . '/cne-ac/css/cne-ac-admin.css' );
        if( get_current_screen()->id === 'topic' || get_current_screen()->id === 'toplevel_page_bp-groups') :
            wp_register_script( 'cne-ac-js-admin', get_template_directory_uri() . '/cne-ac/js/cne-ac-admin.js', array( 'jquery', 'cne-ac-js-jquery-validate' ), '', true );
            wp_register_script( 'cne-ac-js-jquery-validate', get_template_directory_uri() . '/cne-ac/js/jquery.validate.min.js', array( 'jquery' ), '', true );
            

            wp_enqueue_script( 'cne-ac-js-admin' );
            wp_enqueue_style( 'cne-ac-js-jquery-validate' );
            
        endif;
        wp_enqueue_style( 'cne-ac-css-admin' );
    }
}
add_action( 'admin_enqueue_scripts', 'cne_ac_load_scripts_admin' );

/*
 * Mostra apenas o upload do usuario conectado
 * Baseado em <https://codex.wordpress.org/Plugin_API/Filter_Reference/ajax_query_attachments_args>
 */
function cne_ac_show_current_user_attachments( $query = array() ) {
    $user_id = get_current_user_id();
    if( $user_id ) {
        $query['author'] = $user_id;
    }
    
    return $query;
}
add_filter( 'ajax_query_attachments_args', 'cne_ac_show_current_user_attachments', 10 );

/*
 * Nao mostra a barra de ferramentas fora da area administrativa do wordpress
 */
add_filter( 'show_admin_bar', '__return_false' );

/*
 * Listagem das regras de utilizacao do AC
 */
function cne_ac_rules_list() {
    echo '<div class="cne-rules-list">
            <ul>
                <li>' . __('Conter palavras grosseiras ou ofensivas', 'cne-ac') . '</li>
                <li>' . __('Fazer discriminação de qualquer tipo', 'cne-ac') . '</li>
                <li>' . __('Conter material de outra pessoa sem autorização', 'cne-ac') . '</li>
                <li>' . __('Mostrar informações pessoais', 'cne-ac') . '</li>
                <li>' . __('Incomodar, irritar ou chatear outras pessoas', 'cne-ac') . '</li>
                <li>' . __('Fazer propaganda ou vender', 'cne-ac') . '</li>
                <li>' . __('Fingir ser outra pessoa', 'cne-ac') . '</li>
                <li>' . __('Conter imagens que contenham nudez', 'cne-ac') . '</li>
                <li>' . __('Ser violento ou utilizar figuras de armas', 'cne-ac') . '</li>
                <li>' . __('Ser contrário a alguma lei', 'cne-ac') . '</li>
            </ul>
        </div>';
}

/*
 * Bloqueia o acesso da area administrativa do wordpress se o usuario for apenas assinante e nao e administrador do ambiente colaborativo
 */
function cne_ac_block_users_admin_area() {
    if ( is_admin() && ( current_user_can( 'subscriber' ) && !current_user_can( 'bbp_keymaster' ) ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) :
        wp_redirect( home_url() );
        exit;
    endif;
}
add_action( 'init', 'cne_ac_block_users_admin_area' );

/*
 * Adiciona os itens de menu Perfil, Sair, Cadastre-se e Entrar no item de menu informado na pag de configuracao do AC
 */
function cne_ac_menu_login_logout( $items, $menu ) {
    
    if( !is_admin() ) {
        $parent_page_id = cne_ac_get_parent_page_id();
        
        $parent_id = 0;
        if($parent_page_id) {
            foreach ( $items as $item ) {
                if($item->object_id == $parent_page_id){
                    $parent_id = $item->ID;
                }
            }
        }
        
        if ( is_user_logged_in() ) {
            $last_item = count( $items );
            $items[] = cne_ac_create_item_menu( __( 'Perfil', 'cne-ac' ), bp_get_loggedin_user_link(), $last_item + 1, $parent_id );
            $items[] = cne_ac_create_item_menu( __( 'Sair', 'cne-ac' ), wp_logout_url(), $last_item + 2, $parent_id ); 
        } else {
            $last_item = count( $items );
            $items[] = cne_ac_create_item_menu( __( 'Cadastre-se', 'cne-ac' ), get_site_url() . '/cadastre-se/', $last_item + 1, $parent_id );
            $items[] = cne_ac_create_item_menu( __( 'Entrar', 'cne-ac' ), get_site_url() . '/entrar/', $last_item + 2, $parent_id );
        }
    }
    return $items;
}
add_filter('wp_get_nav_menu_items','cne_ac_menu_login_logout', 10, 2);

/*
 * Cria um item de menu
 */
function cne_ac_create_item_menu( $title, $url, $order, $parent_id ) {
    $item = (object) array(
            'ID'                => $order + 100000, //Adiciona um ID que o WP dificilmente vai usar
            'title'             => $title,
            'url'               => $url,
            'menu_item_parent'  => $parent_id,
            'menu_order'        => $order,
            'type'              => '',
            'object'            => '',
            'object_id'         => '',
            'db_id'             => '',
            'classes'           => '',
            'post_title'        => '',
        );
    
    return $item;
}

/*
 * Modifica logo na tela de login do wordpress
 */
function cne_ac_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/cne-ac/img/logo-cne.png);
            height:200px;
            width:320px;
            background-size: 320px 200px;
            background-repeat: no-repeat;
            margin: 0;
        }
        
        .login {
            background: #ffffff !important;
        }
        
        .login form {
            -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.55);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.55);
            margin: 0;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'cne_ac_login_logo' );

/*
 * Modifica url da logo na tela de login do wordpress
 */
function cne_ac_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'cne_ac_login_logo_url' );

/*
 * Remove os help_tabs dos componentes que sao utilizados dos plugins
 */
function cne_ac_remove_bp_help_tabs() {
    $remove_tab_screen = array('forum', 'topic', 'reply', 'toplevel_page_bp-groups', 'users_page_bp-signups');
    $screen = get_current_screen();
    if( in_array($screen->id, $remove_tab_screen) || in_array($screen->post_type, $remove_tab_screen )){
        $screen->remove_help_tabs();
    }
}
add_action( 'admin_head', 'cne_ac_remove_bp_help_tabs', 999);

/*
 * Adiciona pag de configuracao do AC no administrativo do WP
 */
function cne_ac_admin_menus() {

    add_options_page( __('Configurações do Ambiente Colaborativo', 'cne-ac'), __('Ambiente Colaborativo', 'cne-ac'), 'manage_options', 'cne_ac_setting', 'cne_ac_create_admin_page' );
                
}
add_action( 'admin_menu', 'cne_ac_admin_menus' );

/*
 * Cria pag de configuracao do AC
 */
function cne_ac_create_admin_page(){
?>
    <div class="wrap">

        <h2>Configurações do Ambiente Colaborativo</h2>

        <form method="post" action="options.php">

            <?php settings_fields('cne_ac_setting_admin'); ?>

            <?php do_settings_sections('cne_ac_setting_admin'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row"><label for="cne-ac-form-topic-page-id">Página do Formulário de Criação/Edição de Tópico</label></th>
                    <td>
                        <?php cne_ac_get_select_pages(cne_ac_get_form_topic_page_id(), 'form_topic', 'form-topic'); ?>
                        <p class="description">Para exibir o formulário de criação/edição de tópico adicione o shortcode <strong>[cne-ac-bbp-form-novo-topico]</strong> na página informada.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cne-ac-parent-page-id">Página Pai dos Itens de Menu: Perfil, Sair, Cadastre-se e Entrar</label></th>
                    <td>
                        <?php cne_ac_get_select_pages(cne_ac_get_parent_page_id(), 'parent', 'parent'); ?>
                        <p class="description" id="cnew-registration-form-page-id-description">Selecione uma página que conste no menu.</p>
                    </td>
                </tr>
                <?php cne_ac_bp_core_admin_slugs_options(); ?>
            </table>
            
            

            <?php submit_button(); ?>

        </form>

    </div>
<?php
}

/*
 * Adiciona na pag de configuracao do AC itens de configuracao do plugin buddypress
 */
function cne_ac_bp_core_admin_slugs_options() {
    $existing_pages = bp_core_get_directory_page_ids();

    $directory_pages = bp_core_admin_get_directory_pages();
    
    $replacements = array('members' => 'Página da Lista de Usuários', 'groups' => 'Página da Lista de Grupos');

    $directory_pages = array_replace($directory_pages, $replacements);
    
    foreach ( $directory_pages as $name => $label ) : 
        ?>
        
        <tr valign="top">
            <th scope="row">
                <label for="bp_pages[<?php echo esc_attr( $name ) ?>]"><?php echo esc_html( $label ) ?></label>
            </th>

            <td>

                <?php echo wp_dropdown_pages( array(
                    'name'             => 'bp_pages[' . esc_attr( $name ) . ']',
                    'echo'             => false,
                    'show_option_none' => __( '- Nenhum -', 'cne-ac' ),
                    'selected'         => !empty( $existing_pages[$name] ) ? $existing_pages[$name] : false
                ) ); ?>

            </td>
        </tr>
 
    <?php 
    endforeach;
    
    do_action( 'bp_active_external_directories' );
    
    $static_pages = bp_core_admin_get_static_pages();
            
    $replacements = array('register' => 'Página do Formulário de Cadastro', 'activate' => 'Página de Ativação da Conta');

    $static_pages = array_replace($static_pages, $replacements);
    
    if (bp_get_signup_allowed() ) : 
        
        foreach ( $static_pages as $name => $label ) : ?>

            <tr valign="top">
                <th scope="row">
                    <label for="bp_pages[<?php echo esc_attr( $name ) ?>]"><?php echo esc_html( $label ) ?></label>
                </th>

                <td>

                    <?php echo wp_dropdown_pages( array(
                        'name'             => 'bp_pages[' . esc_attr( $name ) . ']',
                        'echo'             => false,
                        'show_option_none' => __( '- Nenhum -', 'cne-ac' ),
                        'selected'         => !empty( $existing_pages[$name] ) ? $existing_pages[$name] : false
                    ) ) ?>

                </td>
            </tr>

        <?php 
        endforeach; 
        
    endif;
    
    do_action( 'bp_active_external_pages' );
}

/*
 * Dropdown com as paginas adicionadas no WP
 */
function cne_ac_get_select_pages( $selected = 0, $name='', $id='' ) {
    
    echo wp_dropdown_pages( array(
                                    'name'             => 'cne_ac_' . esc_attr( $name ) . '_page_id',
                                    'id'               => 'cne-ac-' . esc_attr( $id ) . '-page-id',
                                    'echo'             => false,
                                    'show_option_none' => __( '- Nenhum -', 'cne-ac' ),
                                    'selected'         => $selected
                            ) );

}

/*
 * Registra as configuracoes do AC
 */
function cne_ac_register_settings() {
    register_setting( 'cne_ac_setting_admin', 'cne_ac_form_topic_page_id' );
    register_setting( 'cne_ac_setting_admin', 'cne_ac_parent_page_id' );
    
    if ( isset( $_POST['bp_pages'] ) ) {
        $valid_pages = array_merge( bp_core_admin_get_directory_pages(), bp_core_admin_get_static_pages() );

        $new_directory_pages = array();
        foreach ( (array) $_POST['bp_pages'] as $key => $value ) {
            if ( isset( $valid_pages[ $key ] ) ) {
                    $new_directory_pages[ $key ] = (int) $value;
            }
        }
        bp_core_update_directory_page_ids( $new_directory_pages );
    }
}
add_action( 'admin_init', 'cne_ac_register_settings' );

/*
 * Retorna a pag em que o formulario de novo ou edicao de topico deve ser exibido
 */
function cne_ac_get_form_topic_page_id() {
    $option = get_option( 'cne_ac_form_topic_page_id' );
    return( $option ) ? $option : 0;
}

/*
 * Retorna o link da pag do formulario de novo ou edicao de topico
 */
function cne_ac_get_form_topic_page_link($area_id = '') {
    
    $link = '';
    $page_id = cne_ac_get_form_topic_page_id();
    
    if($page_id) {
        $link = add_query_arg( array (
                            'area_id'=> $area_id
                        ),
                        get_permalink($page_id)
                    );
    }
    return $link;
    
}

/*
 * Retorna o id da pag em que deve ser adicionado os itens de menu Perfil, Sair, Cadastre-se e Entrar
 * Observacao: caso a pag informada nao esteja no menu, os itens de menu Perfil, Sair, Cadastre-se e Entrar sao adicionados no menu principal
 */
function cne_ac_get_parent_page_id() {
    $option = get_option( 'cne_ac_parent_page_id' );
    return( $option ) ? $option : 0;
}
