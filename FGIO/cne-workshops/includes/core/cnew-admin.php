<?php

/**
 * Classe que trata das funcionalidade do plugin na area de administracao do WordPress
 */
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'CNEW_Admin' ) ) :

    class CNEW_Admin {

        public function __construct() { 
            $this->cnew_globals();
            $this->cnew_includes();
            $this->cnew_hooks();
        }

        private function cnew_globals() {
        }

        private function cnew_includes() {

            require( CNEW_PLUGIN_DIR . 'includes/admin/cnew-metaboxes.php' );
            require( CNEW_PLUGIN_DIR . 'includes/admin/cnew-settings.php' );
            require( CNEW_PLUGIN_DIR . 'includes/core/cnew-registration.php' );
            require( CNEW_PLUGIN_DIR . 'includes/registration/cnew-registration-functions.php' );

        }



        /* === HOOKS === */
        private function cnew_hooks() {
            add_action('admin_menu', array( $this, 'cnew_admin_menus' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'cnew_load_scripts' ) );

            add_action( 'add_meta_boxes', array( $this, 'cnew_custom_metabox_add' ) );

            add_action( 'save_post', array( $this, 'cnew_custom_metabox_save' ), 10, 2 );

            add_action( 'admin_notices', array( $this, 'cnew_admin_notices' ) );

            add_action( 'admin_init', array( $this, 'cnew_register_plugin_settings' ) );

            add_filter( 'manage_cnew_workshop_posts_columns', array( $this, 'cnew_workshop_column_headers' ) );

            add_filter( 'manage_cnew_registration_posts_columns', array( $this, 'cnew_registration_column_headers' ) );

            add_action( 'manage_cnew_workshop_posts_custom_column', array( $this, 'cnew_workshop_column_data' ), 1, 2 );

            add_action( 'manage_cnew_registration_posts_custom_column', array( $this, 'cnew_registration_column_data' ), 1, 2 );

            //Baseado em <https://www.sitepoint.com/customized-wordpress-administration-filters/>
            add_action( 'restrict_manage_posts', 'cnew_add_workshop_admin_filter' );

            add_action( 'restrict_manage_posts', 'cnew_add_status_admin_filter' );

            add_action( 'pre_get_posts','cnew_add_filter_posts_workshop' );

            add_action( 'pre_get_posts','cnew_add_filter_posts_status' );

            //Baseado em <https://github.com/Seravo/wp-custom-bulk-actions/blob/master/wp-custom-bulk-actions.php>
            //Baseado em <https://www.skyverge.com/blog/add-custom-bulk-action/>
            add_action('admin_footer-edit.php', array( $this, 'cnew_custom_bulk_actions' ));

            add_action('load-edit.php', array( $this, 'cnew_custom_actions' ) );

            //Baseado no plugin Completely Delete <https://br.wordpress.org/plugins/completely-delete/>
            add_action( 'delete_post', array( $this, 'cnew_delete_registration' ), 10 );
            add_action( 'wp_trash_post', array( $this, 'cnew_trash_registration' ), 10 );
            add_action( 'untrash_post', array( $this, 'cnew_untrash_registration' ) );

            add_filter('bulk_actions-edit-cnew_workshop', array( $this, 'cnew_remove_item_bulk_actions' ) );

        }

        function cnew_remove_item_bulk_actions($actions){
            unset( $actions['edit'] );

            return $actions;
        }

        function cnew_delete_registration( $post_id ) {
            global $wpdb;
            $table_name = $wpdb->prefix . "cnew_registrations";
            if( get_post_type( $post_id ) === cnew_get_registration_post_type() ) {

                $wpdb->delete( $table_name, array( 'post_id' => $post_id ), array( '%d' ) );
            } elseif ( get_post_type( $post_id ) === cnew_get_workshop_post_type() ) {
                $wpdb->delete( $wpdb->posts, array( 'post_type' => cnew_get_registration_post_type(), 'post_parent' => $post_id ), array( '%s', '%d' ) );
            }

        }

        function cnew_trash_registration( $post_id ) {
            if( get_post_type( $post_id ) === cnew_get_workshop_post_type() ) :
                global $wpdb;
                remove_action( 'post_updated', 'wp_save_post_revision' );

                $sql = "SELECT ID, post_status FROM $wpdb->posts WHERE post_parent = %d AND post_type != 'revision'";
                $children_query = $wpdb->prepare( $sql, $post_id );
                $children = $wpdb->get_results( $children_query );
                if ( $children ) {
                    foreach ( $children as $child ) {
                        if ( 'trash' != $child->post_status ) {
                            wp_trash_post( $child->ID );
                        }
                    }
                }
            endif;
        }

        function cnew_untrash_registration( $post_id ) {
            if( get_post_type( $post_id ) === cnew_get_workshop_post_type() ) :
                global $wpdb;
                remove_action( 'post_updated', 'wp_save_post_revision' );

                $sql = "SELECT ID, post_status FROM $wpdb->posts WHERE post_parent = %d AND post_type != 'revision'";
                $children_query = $wpdb->prepare( $sql, $post_id );
                $children = $wpdb->get_results( $children_query );
                if ( $children ) {
                    foreach ( $children as $child ) {
                        if ( 'trash' == $child->post_status ) {
                            wp_untrash_post( $child->ID );
                        }
                    }
                }
            endif;
        }

        function cnew_custom_bulk_actions() {

            global $post_type;
            if( $post_type == 'cnew_registration' ) :
            ?>
                <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            $('<option>').val('cnew_resend').text('Enviar Confirmação de E-mail').appendTo("select[name='action']");
                            $('<option>').val('cnew_resend').text('Enviar Confirmação de E-mail').appendTo("select[name='action2']");
                            $('<option>').val('cnew_accepted').text('Confirmar Participação').appendTo("select[name='action']");
                            $('<option>').val('cnew_accepted').text('Confirmar Participação').appendTo("select[name='action2']");
                            $('<option>').val('cnew_declined').text('Sem Vagas').appendTo("select[name='action']");
                            $('<option>').val('cnew_declined').text('Sem Vagas').appendTo("select[name='action2']");
                            $('<option>').val('cnew_cancel').text('Cancelar Participação').appendTo("select[name='action']");
                            $('<option>').val('cnew_cancel').text('Cancelar Participação').appendTo("select[name='action2']");
                            <?php if ( function_exists( 'buddypress' ) && get_option( 'users_can_register' ) ) : ?>
                                $('<option>').val('cnew_create_user').text('Criar Usuário').appendTo("select[name='action']");
                                $('<option>').val('cnew_create_user').text('Criar Usuário').appendTo("select[name='action2']");
                            <?php endif; ?>
                        });
                </script>
            <?php
            endif;

        }

        function cnew_custom_actions() {

            //acao selecionada
            $wp_list_table = _get_list_table('WP_Posts_List_Table');
            $action = $wp_list_table->current_action();

            //acoes possiveis
            $actions = array( 'cnew_resend', 'cnew_accepted', 'cnew_declined', 'cnew_cancel' );

            if ( function_exists( 'buddypress' ) && get_option( 'users_can_register' ) ) :
                $actions[] = 'cnew_create_user';
            endif;

            if( !in_array($action, $actions ) ) :
                return;
            endif;

            //seguranca
            check_admin_referer('bulk-posts');

            //retorna o id dos post selecionados para aplicar a acao
            if( isset( $_REQUEST['post'] ) ) :
                $post_ids = array_map( 'intval', $_REQUEST['post'] );
            endif;

            //se vazio nao executa acao
            if( empty( $post_ids ) ) :
                return;
            endif;

            wp_redirect( add_query_arg(
                                        array(
                                            'page'	    => $action == 'cnew_create_user' ? 'cnew_confirm_create_user' : 'cnew_confirm_send_emails',
                                            'registration_ids' => join( ',', $post_ids ),
                                            'action'    => $action,
                                        ),
                                        admin_url( 'edit.php?post_type=cnew_workshop' )
                                    )
                        );
            exit();

          }


        /* === CARREGA SCRIPTS === */
        function cnew_load_scripts() {
            wp_register_script( 'cnew-js-admin', CNEW_PLUGIN_URL . 'includes/js/cne-workshops-admin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'cnew-js-jquery-validate' ), '', true );
            wp_register_script( 'cnew-js-jquery-mask', CNEW_PLUGIN_URL . 'includes/js/jquery.maskedinput.min.js', array( 'jquery' ), '', true );
            wp_register_script( 'cnew-js-jquery-validate', CNEW_PLUGIN_URL . 'includes/js/jquery.validate.min.js', array( 'jquery' ), '', true );
            wp_register_style( 'cnew-css-admin', CNEW_PLUGIN_URL . 'includes/css/cne-workshops-admin.css' );
            wp_register_style( 'cnew-css-jquery', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css' );

            wp_enqueue_script( 'cnew-js-admin' );
            wp_enqueue_script( 'cnew-js-jquery-mask' );
            wp_enqueue_style( 'cnew-js-jquery-validate' );
            wp_enqueue_style( 'cnew-css-admin' );
            wp_enqueue_style( 'cnew-css-jquery' );
        }

        function cnew_admin_menus() {

            //pagina de configuracao do plugin
            add_submenu_page( 'edit.php?post_type=cnew_workshop', __('Configurações', 'cnew'), __('Configurações', 'cnew'), 'update_core', 'cnew_setting', array( $this, 'cnew_plugin_settings_page' ) );

            //paginas que executam as acoes relacionadas ao envio de e-mail
            add_submenu_page( null, __('Enviar E-mails', 'cnew'), __('Enviar E-mails', 'cnew'), 'update_core', 'cnew_confirm_send_emails', array( $this, 'cnew_confirm_send_emails' ) );
            add_submenu_page( null, __('Resultado - Enviar E-mails', 'cnew'), __('Resultado - Enviar E-mails', 'cnew'), 'update_core', 'cnew_send_emails', array( $this, 'cnew_send_emails' ) );

            //paginas que executam as acoes relacionadas a criacao de contas de usuarios, e necessario que o plugin buddypress esteja ativado
            if ( function_exists( 'buddypress' ) && get_option( 'users_can_register' ) ) {
                add_submenu_page( null, __('Criar Usuários', 'cnew'), __('Criar Usuários', 'cnew'), 'update_core', 'cnew_confirm_create_user', array( $this, 'cnew_confirm_create_user' ) );
                add_submenu_page( null, __('Resultado - Criar Usuários', 'cnew'), __('Resultado - Criar Usuários', 'cnew'), 'update_core', 'cnew_create_user', array( $this, 'cnew_create_user' ) );
            }
        }

        function cnew_confirm_send_emails() {

            if( !current_user_can( 'update_core' ) || empty( $_GET['action'] ) ) {

                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, verifique se você tem acesso a esta funcionalidade.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );

            }

            $action = $_GET['action'];

            $post_ids = false;
            if( !empty( $_GET['registration_id'] ) ) {
                $post_ids = absint( $_GET['registration_id'] );
            } elseif( !empty( $_GET['registration_ids'] ) ) {
               $post_ids = wp_parse_id_list( $_GET['registration_ids'] );
            }

            if( empty( $post_ids ) ) {
             wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            $registrations = CNEW_Registration::cnew_get_by_post_ids( $post_ids );

            if( empty( $registrations ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            switch( $action ) {
                case 'cnew_resend' :
                    $title = __( 'Confirmar e-mail', 'cnew' );
                    $header = __( 'Enviar confirmação de e-mail para:', 'cnew' );
                    $status = array( CNEW_Registration::EMAIL_NAO_ENVIADO, CNEW_Registration::EMAIL_NAO_CONFIRMADO );

                    break;
                case 'cnew_accepted' :
                    $title = __( 'Confirmar Participação', 'cnew' );
                    $header = __( 'Enviar e-mail confirmando participação para:', 'cnew' );
                    $status = array( CNEW_Registration::EMAIL_CONFIRMADO, CNEW_Registration::SEM_VAGAS );


                    break;
                case 'cnew_declined' :
                    $title = __( 'Insuficiência de Vagas', 'cnew' );
                    $header = __( 'Enviar e-mail informando que não há mais vagas para:', 'cnew' );
                    $status = array( CNEW_Registration::EMAIL_CONFIRMADO );

                    break;
                case 'cnew_cancel' :
                    $title = __( 'Cancelar Participação', 'cnew' );
                    $header = __( 'Enviar e-mail cancelando a participação do(a):', 'cnew' );
                    $status = array( CNEW_Registration::PARTICIPANTE );

                    break;
            }

            if( empty( $title ) || empty( $header ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            //retorna apenas as inscricoes em que a situacao seja valida para o tipo de email
            $send_email_to = CNEW_Registration::cnew_check_registrations_status( $registrations, $status );

            //extrai os ids
            $send_email_to_ids = wp_list_pluck( $send_email_to, 'post_id' );

            //prepara url da acao
            if ( is_network_admin() ) {
                $base_url = network_admin_url( 'edit.php?post_type=cnew_workshop' );
            } else {
                $base_url = admin_url( 'edit.php?post_type=cnew_workshop' );
            }

            $action_url = wp_nonce_url(
                    add_query_arg( array (
                            'page' => 'cnew_send_emails',
                            'registration_ids' => implode( ',', $send_email_to_ids ),
                            'action'     => $action,
                        ),
                        $base_url
                    ),
                    'cnew_email_' . $action
            );

            $output = '<div class="wrap">
                <h2>' . esc_html( $title ) . '</h2>';


            if( !empty( $send_email_to ) ) :
                $html_header = '<h3><strong>' . esc_html( $header ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button-primary" style="margin-right: 5px;" href="%1$s">%2$s</a>', esc_url( $action_url ),  __( 'Confirmar', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $send_email_to, $html_footer );

            endif;
            $array_diff = array_diff_key( $registrations, $send_email_to );
            if( !empty( $array_diff ) ) :
                $html_header = '<h3><strong>' . __( 'As seguintes inscrições não são válidas para receber o tipo de e-mail selecionado:', 'cnew' ) . '</strong></h3>';
                $html_footer = '<h3><strong>' . __( 'Por favor, verifique a situação dessas inscrições.', 'cnew' ) . '</strong></h3>';
                $output .= $this->cnew_get_html_list_registrations( $html_header, $array_diff, $html_footer );
            endif;
            $output .= sprintf( '<a class="button" href="javascript:history.back()">%1$s</a>', __( 'Voltar', 'cnew' ) );

            $output .= '</div>';

            echo $output;

        }

        function cnew_send_emails() {

            if ( !current_user_can( 'update_core' ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, verifique se você tem acesso a esta funcionalidade.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            $filter_input_action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
            $filter_input_action2 = filter_input( INPUT_GET, 'action2', FILTER_SANITIZE_STRING );
            $action = !empty( $filter_input_action ) ? $filter_input_action : '';

            if ( !empty( $filter_input_action2 ) && $filter_input_action2 != "-1" ) {
                $action = $filter_input_action2;
            }

            if ( empty( $action ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            $filter_input_ids = filter_input( INPUT_GET, 'registration_ids', FILTER_SANITIZE_STRING );
            if ( !empty( $filter_input_ids ) ) {
                $registration_ids = wp_parse_id_list( $filter_input_ids );
            }

            $result = CNEW_Registration::cnew_send_emails( $registration_ids, $action );

            if( empty( $result ) ||  ( !isset( $result['error'] ) && !isset( $result['success'] ) ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            $url = admin_url('edit.php?post_type='.  cnew_get_registration_post_type());

            $output = '<div class="wrap">
                <h2>Resultado</h2>';

            if( !isset( $result['error'] ) ) :
                $html_header = '<h3><strong>' . __( 'Todos os e-mails foram enviados com sucesso. Inscrições:', 'cnew' ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button-primary" style="margin-right: 5px;" href="%1$s">%2$s</a>', esc_url( $url ),  __( 'Voltar para as inscrições', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $result['success'], $html_footer );
            elseif( !isset( $result['success'] ) ) :
                $html_header = '<h3><strong>' . __( 'Ocorreu algum problema ao processar sua solicitação. Nenhum e-mail foi enviado. Inscrições:', 'cnew' ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button" href="javascript:history.back()">%1$s</a>', __( 'Voltar para tela anterior', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $result['error'], $html_footer );
            else :

                $html_header = '<h3><strong>' . __( 'Foi enviado com sucesso os e-mails para as seguintes inscrições:', 'cnew' ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button-primary" style="margin-right: 5px;" href="%1$s">%2$s</a>', esc_url( $url ),  __( 'Voltar para as inscrições', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $result['success'], $html_footer );
                $html_header = '<h3><strong>' . __( 'Não foi possível enviar e-mail para as seguintes inscrições:', 'cnew' ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button" href="javascript:history.back()">%1$s</a>', __( 'Voltar para tela anterior', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $result['error'], $html_footer );
            endif;

            $output .= '</div>';

            echo $output;		

        }

        function cnew_confirm_create_user() {

            if( !current_user_can( 'update_core' ) || empty( $_GET['action'] ) ) {

                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, verifique se você tem acesso a esta funcionalidade.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );

            }

            $action = $_GET['action'];

            $post_ids = false;
            if( !empty( $_GET['registration_id'] ) ) {
                $post_ids = absint( $_GET['registration_id'] );
            } elseif( !empty( $_GET['registration_ids'] ) ) {
               $post_ids = wp_parse_id_list( $_GET['registration_ids'] );
            }

            if( empty( $post_ids ) ) {
             wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            $registrations = CNEW_Registration::cnew_get_by_post_ids( $post_ids );

            if( empty( $registrations ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            if( $action === 'cnew_create_user' ) {
                $title = __( 'Confirmar Criação de Conta de Usuário', 'cnew' );
                $header = __( 'Criar conta de usuário para:', 'cnew' );
            }

            if( empty( $title ) || empty( $header ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            //retorna apenas as inscricoes em que o e-mail nao consta nos usuarios cadastrados do wordpress
            $valid_users = CNEW_Registration::cnew_check_emails( $registrations );

            //extrai os ids
            $valid_users_ids = wp_list_pluck( $valid_users, 'post_id' );

            //prepara url da acao
            if ( is_network_admin() ) {
                $base_url = network_admin_url( 'edit.php?post_type=' . cnew_get_workshop_post_type() );
            } else {
                $base_url = admin_url( 'edit.php?post_type=' .  cnew_get_workshop_post_type() );
            }

            $action_url = wp_nonce_url(
                    add_query_arg( array (
                            'page' => 'cnew_create_user',
                            'registration_ids' => implode( ',', $valid_users_ids ),
                            'action'     => $action,
                        ),
                        $base_url
                    ),
                    $action
            );

            $output = '<div class="wrap">
                <h2>' . esc_html( $title ) . '</h2>';


            if( !empty( $valid_users ) ) :
                $html_header = '<h3><strong>' . esc_html( $header ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button-primary" style="margin-right: 5px;" href="%1$s">%2$s</a>', esc_url( $action_url ),  __( 'Confirmar', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $valid_users, $html_footer );

            endif;
            $array_diff = array_diff_key( $registrations, $valid_users );
            if( !empty( $array_diff ) ) :
                $html_header = '<h3><strong>' . __( 'Os e-mails utilizados nas seguintes inscrições já estão vinculados com uma conta de usuário:', 'cnew' ) . '</strong></h3>';
                $html_footer = '<h3><strong>' . __( 'Em caso de dúvidas, verifique a lista de usuários cadastrados.', 'cnew' ) . '</strong></h3>';
                $output .= $this->cnew_get_html_list_registrations( $html_header, $array_diff, $html_footer );
            endif;
            $output .= sprintf( '<a class="button" href="javascript:history.back()">%1$s</a>', __( 'Voltar', 'cnew' ) );

            $output .= '</div>';

            echo $output;

        }

        function cnew_create_user() {

            if ( !current_user_can( 'update_core' ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, verifique se você tem acesso a esta funcionalidade.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            $filter_input_action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
            $filter_input_action2 = filter_input( INPUT_GET, 'action2', FILTER_SANITIZE_STRING );
            $action = !empty( $filter_input_action ) ? $filter_input_action : '';

            if ( !empty( $filter_input_action2 ) && $filter_input_action2 != '-1' ) {
                $action = $filter_input_action2;
            }

            if ( empty( $action ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            $filter_input_ids = filter_input( INPUT_GET, 'registration_ids', FILTER_SANITIZE_STRING );
            if ( !empty( $filter_input_ids ) ) {
                $registration_ids = wp_parse_id_list( $filter_input_ids );
            }

            $result = CNEW_Registration::cnew_create_user( $registration_ids );

            if( empty( $result ) ||  ( !isset( $result['error'] ) && !isset( $result['success'] ) ) ) {
                wp_die( __( 'Não foi possível executar sua solicitação! Por favor, tente novamente.','cnew' ), 
                        __( 'ERRO', 'cnew'), 
                        array( 'back_link' => true ) 
                );
            }

            //prepara url da acao
            if ( is_network_admin() ) {
                $base_url = network_admin_url( 'edit.php?post_type='.  cnew_get_registration_post_type() );
            } else {
                $base_url = admin_url( 'edit.php?post_type='.  cnew_get_registration_post_type() );
            }

            $output = '<div class="wrap">
                <h2>Resultado</h2>';

            if( !isset( $result['error'] ) ) :
                $html_header = '<h3><strong>' . __( 'Todos as contas foram criadas com sucesso. Inscrições:', 'cnew' ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button-primary" style="margin-right: 5px;" href="%1$s">%2$s</a>', esc_url( $base_url ),  __( 'Voltar para as inscrições', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $result['success'], $html_footer );
            elseif( !isset( $result['success'] ) ) :
                $html_header = '<h3><strong>' . __( 'Ocorreu algum problema ao processar sua solicitação. Nenhuma conta foi criada. Inscrições:', 'cnew' ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button" href="javascript:history.back()">%1$s</a>', __( 'Voltar para tela anterior', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $result['error'], $html_footer );
            else :
                $html_header = '<h3><strong>' . __( 'Foi criado com sucesso contas de usuários para as seguintes inscrições:', 'cnew' ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button-primary" style="margin-right: 5px;" href="%1$s">%2$s</a>', esc_url( $base_url ),  __( 'Voltar para as inscrições', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $result['success'], $html_footer );
                $html_header = '<h3><strong>' . __( 'Não foi possível criar contas de usuários para as seguintes inscrições:', 'cnew' ) . '</strong></h3>';
                $html_footer = sprintf( '<a class="button" href="javascript:history.back()">%1$s</a>', __( 'Voltar para tela anterior', 'cnew' ) );
                $output .= $this->cnew_get_html_list_registrations( $html_header, $result['error'], $html_footer );
            endif;

            $output .= '</div>';

            echo $output;		

        }

        function cnew_workshop_column_headers( $columns ) {

            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => __( 'Oficina', 'cnew' ),
                'vacancies' => __( 'Nº Vagas', 'cnew' ),
                'registration' => __( 'Nº Inscrições', 'cnew' ),
                'accepted' => __( 'Nº Participantes', 'cnew' ),
                'application_period' => __( 'Período de Inscrição', 'cnew' ),
                'date' => __( 'Criado em', 'cnew' ),
            );

            return $columns;

        }

        function cnew_registration_column_headers( $columns ) {

            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => __( 'Nome', 'cnew' ),
                'workshop_title' => __( 'Oficina', 'cnew' ),
                'age' => __( 'Idade', 'cnew' ),
                'email' => __( 'E-mail', 'cnew' ),
                'parent_phone' => __( 'Telefone', 'cnew' ),
                'status' => __( 'Situação', 'cnew' ),
                'date' => __( 'Criado em', 'cnew' ),
                'actions' => __( 'Ações', 'cnew' ),
            );

            return $columns;

        }

        function cnew_workshop_column_data ( $column, $post_id ) {
            $workshop = get_post($post_id);
            if( $workshop ) {
                $output = '';
                $metas = get_post_meta( $workshop->ID );
                switch( $column ) {
                    case 'vacancies' :
                        if( isset( $metas['cnew_vacancies'] ) )
                            $output .= $metas['cnew_vacancies'][0];
                        break;
                    case 'registration' :
                            $output .= CNEW_Registration::cnew_get_total_reg_workshop($workshop->ID);
                        break;
                    case 'accepted' :
                            $output .= CNEW_Registration::cnew_get_total_reg_accepted_workshop($workshop->ID);
                        break;
                    case 'application_period':
                        if( isset( $metas['cnew_start_date'] ) && isset( $metas['cnew_end_date'] ) )
                            $output .= mysql2date('d/m/Y', $metas['cnew_start_date'][0] ) . ' - ' .  mysql2date('d/m/Y', $metas['cnew_end_date'][0] );
                        break;
                }

            echo $output;

            }
        }

        function cnew_registration_column_data ( $column, $post_id ) {
            $registration = CNEW_Registration::cnew_get_by_post_id( $post_id );

            if( $registration ) {
                $output = '';

                switch( $column ) {
                    case 'workshop_title':
                        $workshop = get_post( $registration->workshop_id );
                        $output .= $workshop->post_title;
                        break;
                    case 'email':
                        $output .= $registration->email;
                        break;
                    case 'age':
                        $output .= $this->cnew_calc_age($registration->date_birth);
                        break;
                    case 'parent_phone':
                        $output .= $registration->parent_phone;
                        break;
                    case 'status':
                        $status = __( 'E-mail não enviado', 'cnew' );
                        if( isset( $registration->status ) ) :
                            switch( $registration->status ) {
                                case CNEW_Registration::EMAIL_NAO_CONFIRMADO :
                                    $status = __( 'E-mail não confirmado', 'cnew' );
                                    break;
                                case CNEW_Registration::EMAIL_CONFIRMADO :
                                    $status = __( 'E-mail confirmado', 'cnew' );
                                    break;
                                case CNEW_Registration::PARTICIPANTE :
                                    $status = __( 'Participante', 'cnew' );
                                    break;
                                case CNEW_Registration::SEM_VAGAS :
                                    $status = __( 'Sem Vagas', 'cnew' );
                                    break;
                                case CNEW_Registration::CANCELADO :
                                    $status = __( 'Cancelado', 'cnew' );
                                    break;
                            }
                        endif;
                        $output .= $status;
                        break;
                    case 'actions':
                        $output .= $this->cnew_column_actions( $registration );
                        break;
                }

            echo $output;

            }
        }

        /* === METABOX WORKSHOP === */
        function cnew_custom_metabox_add() {
            add_meta_box(
                'cnew_custom_metabox_workshop', 
                __( 'Informações da Oficina', 'cnew' ), 
                'cnew_workshop_custom_metabox_callback', 
                'cnew_workshop', 
                'normal',
                'high'
                );

            add_meta_box(
                'cnew_custom_metabox_registration', 
                __( 'Formulário de Inscrição', 'cnew' ), 
                'cnew_registration_custom_metabox_callback', 
                'cnew_registration', 
                'normal',
                'high'
                );
        }

        function cnew_custom_metabox_save( $post_id, $post ) {

            if ( !isset( get_current_screen()->post_type ) ) 
                return;

            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return;

            if( !('POST' === strtoupper( $_SERVER['REQUEST_METHOD'] )) )
                return;

            if( cnew_get_workshop_post_type() == get_current_screen()->post_type ) {

                $this->cnew_custom_metabox_save_workshop( $post_id, $post );

            } else if( cnew_get_registration_post_type() == get_current_screen()->post_type ) {

                $this->cnew_custom_metabox_save_registration( $post_id );

            }
        }

        private function cnew_custom_metabox_save_workshop( $post_id, $post ) {
            $error = 0;

            $is_valid_nonce = ( isset( $_POST[ 'cnew_metabox_nonce' ] ) && wp_verify_nonce( $_POST[ 'cnew_workshop_metabox_nonce' ], 'cnew_workshop_metabox_save' ) ) ? 'true' : 'false';

            if( !$is_valid_nonce || !current_user_can( 'update_core' )) {
                return;
            }

            if( empty( $post->post_title ) || empty( $post->post_content ) ) {
                $error = 5;
            }

            //um if para cada campo (excecao start_date e end_date), assim nao perde todas as informacoes caso ocorra algum erro
            if( !empty( $_POST['cnew_content'] ) ) {
                update_post_meta( $post_id, 'cnew_content', wp_kses( $_POST['cnew_content'],$this->cnew_allowed_html() ) );
            }else {
                $error = 1;
            }
            if( !empty( $_POST['cnew_objective'] ) ) {
                update_post_meta( $post_id, 'cnew_objective', sanitize_text_field( $_POST['cnew_objective'] ) );
            }else {
                $error = 1;
            }
            if( !empty( $_POST['cnew_requirements'] ) ) {
                update_post_meta( $post_id, 'cnew_requirements', wp_kses( $_POST['cnew_requirements'], $this->cnew_allowed_html() ) );
            }
            if( !empty( $_POST['cnew_target_audience'] ) ) {
                update_post_meta( $post_id, 'cnew_target_audience', sanitize_text_field( $_POST['cnew_target_audience'] ) );
            }else {
                $error = 1;
            }
            if( !empty( $_POST['cnew_vacancies'] ) ) {
                update_post_meta( $post_id, 'cnew_vacancies', absint( $_POST['cnew_vacancies'] ) );
            }
            if( !empty( $_POST['cnew_date_event'] ) ) {
                update_post_meta( $post_id, 'cnew_date_event', sanitize_text_field( $_POST['cnew_date_event'] ) );
            }else {
                $error = 1;
            }
            if( !empty( $_POST['cnew_events_place'] ) ) {
                update_post_meta( $post_id, 'cnew_events_place', sanitize_text_field( $_POST['cnew_events_place'] ) );
            }
            if( !empty( $_POST['cnew_contact'] ) ) {
                update_post_meta( $post_id, 'cnew_contact', sanitize_text_field( $_POST['cnew_contact'] ) );
            }
            if( !empty( $_POST['cnew_more_info'] ) ) {
                update_post_meta( $post_id, 'cnew_more_info', wp_kses( $_POST['cnew_more_info'],$this->cnew_allowed_html() ) );
            }
            if( !empty( $_POST['cnew_start_date'] ) && !empty( $_POST['cnew_end_date'] ) ) {
                $start_date = $this->cnew_convert_date_to_db( sanitize_text_field( $_POST['cnew_start_date'] ) );
                $end_date = $this->cnew_convert_date_to_db( sanitize_text_field( $_POST['cnew_end_date'] ) );

                if( $start_date && $end_date ) {
                    update_post_meta( $post_id, 'cnew_start_date', $start_date );
                    update_post_meta( $post_id, 'cnew_end_date', $end_date );
                } else {
                    $error = 2;
                }
            }else {
                $error = 1;
            }

            // se ocorrer algum erro o post nao e publicado, fica como rascunho
            if( !empty($error) ){   

                add_filter('redirect_post_location', 
                    function( $location ) use ( $error ) {
                        return add_query_arg( 'type_error', $error, $location );
                    }
                );

                // erro encontrado, salva post como rascunho
                if( get_post_status($post_id) != 'draft' ){
                    wp_update_post( array( 'ID' => $post_id, 'post_status' => 'draft' ) );
                } 
            } else {
                    // se oficina criada com sucesso, entao cria um grupo para a oficina
                    if( function_exists( 'buddypress' ) && bp_is_active( 'groups' ) ) {
                        get_the_title( $post_id );
                        $workshop_group_id = get_post_meta( $post_id, 'cnew_workshop_group_id', true);
                        $group_name = $post->post_title;
                        $group_description = $post->post_content;
                        $args = array(
                            'group_id'     => $workshop_group_id ? $workshop_group_id : 0,
                            'creator_id'   => get_current_user_id(),
                            'name'         => $group_name,
                            'description'  => $group_description,
                            'status'       => 'public',
                            'date_created' => bp_core_current_time()
                        );
                        $group_id = groups_create_group( $args );
                        if( !$group_id ) {
                            wp_die( __( 'A oficina foi criada/atualizada com sucesso, contudo ocorreu um problema ao criar/atualizar grupo para a oficina' ), __( 'Erro ao criar/atualizar grupo', 'cnew'), array( 'back_link' => true ));
                        } else {
                            $group_status = groups_get_groupmeta( $group_id, 'invite_status', true );
                            update_post_meta( $post_id, 'cnew_workshop_group_id', $group_id );
                            if( empty( $group_status ) ) 
                                groups_update_groupmeta( $group_id, 'invite_status', 'admins' );
                        }
                    }
                }
            // termina verificacao
        }

        private function cnew_custom_metabox_save_registration( $post_id ) {

            $is_valid_nonce = ( isset( $_POST[ 'cnew_metabox_nonce' ] ) && wp_verify_nonce( $_POST[ 'cnew_registration_metabox_nonce' ], 'cnew_registration_metabox_save' ) ) ? 'true' : 'false';

            if( !$is_valid_nonce || !current_user_can( 'edit_post', $post_id )) {
                return;
            }

            $name           = sanitize_text_field( isset( $_POST['cnew_reg_name'] ) ? stripslashes( $_POST['cnew_reg_name'] ) : '' );
            $date_birth     = sanitize_text_field( isset( $_POST['cnew_reg_date_birth'] ) ? $_POST['cnew_reg_date_birth'] : '' );           
            $gender         = isset( $_POST['cnew_reg_gender'] ) ? $_POST['cnew_reg_gender'] : 'male';     
            $email          = isset( $_POST['cnew_reg_email'] ) ? $_POST['cnew_reg_email']  : '';
            $parent_name    = sanitize_text_field( isset( $_POST['cnew_reg_parent_name'] ) ? stripslashes( $_POST['cnew_reg_parent_name'] ) : '' );
            $parent_phone   = sanitize_text_field( isset( $_POST['cnew_reg_parent_phone'] ) ? $_POST['cnew_reg_parent_phone'] : '' );


            global $form_error;

            $form_error = new WP_Error;

            if ( empty( $name ) || empty( $date_birth ) || empty( $gender ) || empty( $email ) || empty( $parent_name ) || empty( $parent_phone ) ) :
                $form_error->add( 'required', __( 'Algum campo obrigatório não foi preenchido. Por favor, revise o formulário.', 'cnew' ) );
            endif;

            $email = sanitize_email( $email );

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

            $registration = CNEW_Registration::cnew_get_by_post_id( $post_id );

            if( $registration->email != $email ) {
                if( ! is_email( $email ) ) :
                    $form_error->add( 'invalid_email', __( 'O e-mail informado é inválido. Por favor, verifique o formato do e-mail inserido.', 'cnew' ) );
                else :
                    $has_registration = CNEW_Registration::cnew_get( $email, $registration->workshop_id );
                    if( $has_registration ) {
                        $form_error->add( 'email_exists', __( 'O e-mail informado já está inscrito nesta oficina.', 'cnew' ) );
                    }
                endif;
            }

            $phone_number = preg_replace("/\D/","",$parent_phone);
            if( strlen( $phone_number ) != 10 && strlen( $phone_number ) != 11 ) :
                    $form_error->add( 'invalid_phone', __( 'O número de telefone inserido é inválido. Por favor, informe um telefone com 10 ou 11 dígitos.', 'cnew' ) );
            endif;

            // se ocorrer algum erro o post nao e publicado, fica como rascunho
            if( !empty( $form_error->get_error_messages() ) ){   

                // erro encontrado, salva post como rascunho
                if( get_post_status($post_id) != 'draft' ){
                    wp_update_post( array( 'ID' => $post_id, 'post_status' => 'draft' ) );
                }

                $list_error = '<ul>';
                foreach ( $form_error->get_error_messages() as $error ) {
                    $list_error .= '<li>' . $error . '</li>';
                }
                $list_error .= '</ul>';
                $list_error .= '<p>'.__('Observação: O post foi salvo como rascunho', 'cnew').'</p>';
                wp_die( $list_error, __( 'Erro ao atualizar inscrição', 'cnew'), array( 'back_link' => true ));

            } 
            // termina verificacao

            $result = CNEW_Registration::cnew_update( $post_id, $name, $date_birth, $gender, $email, $parent_name, $parent_phone );
            if( !( $result === false ) ) :
                $post_registration = array(
                    'ID'           => $post_id,
                    'post_title'   => $name
                );
                remove_action('save_post', array( $this, 'cnew_custom_metabox_save', 25 ) );
                wp_update_post( $post_registration );
                add_action('save_post', array( $this, 'cnew_custom_metabox_save', 25 ) );
            else:
                wp_die( __( 'Ocorreu algum erro ao tenta atualizar a inscrição, tente novamente.', 'cnew' ), __( 'Erro ao atualizar inscrição', 'cnew'), array( 'back_link' => true ));
            endif;

        }            

        public function cnew_admin_notices() {
            if(!isset($_GET['type_error'])) {
                return;
            }else {
                switch($_GET['type_error']) {
                    case 1:
                        $message = __('Algum campo obrigatório não foi preenchido.');
                        break;
                    case 2:
                        $message = __('Formato de data inválido! Por favor, verifique as datas inseridas.');
                        break;
                    case 3:
                        $message = __('A data de início das inscrições precisa ser igual ou maior que a data de hoje.');
                        break;
                    case 4:
                        $message = __('A data de encerramento das inscrições precisa ser igual ou maior que a data de início.');
                        break;
                    case 5:
                        $message = __('É obrigatório o preenchimento do título e da descrição da oficina.');
                        break;
                    default:
                        $message = __('Erro inesperado, por favor, tente novamento.');
                }
                echo '<div class="notice notice-error is-dismissible">
                       <p>'.__('Ocorreu um erro ao publicar o post:').'</p>
                       <p><strong>'.$message.'</strong></p>
                       <p>'.__('O post foi salvo como rascunho.').'</p>
                    </div>';
            }
        }

        /* === CONFIGURACAO DO PLUGIN === */     
        function cnew_plugin_settings_page() {

            ?>
            <div class="wrap">

                <h2>Configurações do Plugin</h2>

                <form method="post" action="options.php">

                    <?php @settings_fields('cnew_plugin_settings'); ?>

                    <?php @do_settings_fields('cnew_plugin_settings'); ?>

                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="cnew-workshops-page-id">Página das Oficinas</label></th>
                            <td>
                                <p class="description" id="cnew-workshop-page-id-description">Para exibir as oficinas cadastradas adicione o shortcode <strong>[cnew-oficina-index]</strong> em uma página.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="cnew-registration-form-page-id">Página do Formulário de Inscrição</label></th>
                            <td>
                                <?php cnew_get_select_pages( cnew_get_registration_form_page_id() ); ?>
                                <p class="description" id="cnew-registration-form-page-id-description">Selecione a página em que foi inserido o shortcode de formulário de inscrição.<br />
                                    Shortcode do formulário: <strong>[cnew-inscricao-form]</strong>.
                                </p>
                            </td>
                        </tr>
                    </table>

                    <h2 class="title">E-mails</h2>
                    <p>Atenção: Todos os e-mails do plugin utilizam o mesmo cabeçalho e rodapé.</p>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="cnew-email-header">Cabeçalho</label></th>
                            <td>
                                <?php echo wp_editor( cnew_get_email_header(), 'cnew_email_header', array( 'media_buttons' => false, 'textarea_rows' => 5 ) ); ?>
                                <p class="description" id="cnew-email-header-description">Você pode utilizar tokens neste campo. Veja a listagem dos tokens possíveis ao lado.</p>
                            </td>
                            <td>
                                <ul>
                                    <li>{{nome_completo}}: Nome completo do participante</li>
                                    <li>{{email}}: E-mail do responsável</li>
                                    <li>{{nome_usuario}}: Nome de usuário do e-mail</li>
                                    <li>{{oficina}}: Título da Oficina</li>
                                    <li>{{titulo_site}}: Título do site</li>
                                    <li>{{ano_corrente}}: Ano corrente</li>
                                    <li>{{pagina_inicial}}: URL da página inicial</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="cnew-email-footer">Rodapé</label></th>
                            <td>
                                <?php echo wp_editor( cnew_get_email_footer(), 'cnew_email_footer', array( 'media_buttons' => false, 'textarea_rows' => 5 ) ); ?>
                                <p class="description" id="cnew-email-content-cancel-description">Você pode utilizar tokens neste campo. Veja a listagem dos tokens possíveis ao lado.</p>
                            </td>
                            <td>
                                <ul>
                                    <li>{{nome_completo}}: Nome completo do participante</li>
                                    <li>{{email}}: E-mail do responsável</li>
                                    <li>{{nome_usuario}}: Nome de usuário do e-mail</li>
                                    <li>{{oficina}}: Título da Oficina</li>
                                    <li>{{titulo_site}}: Título do site</li>
                                    <li>{{ano_corrente}}: Ano corrente</li>
                                    <li>{{pagina_inicial}}: URL da página inicial</li>
                                </ul>
                            </td>
                        </tr>

                    </table>
                    <h2 class="title">E-mail de Confirmação de Inscrição</h2>
                     <table class="form-table">
                        <tr>
                            <th scope="row"><label for="cnew-email-subject-resend">Assunto</label></th>
                            <td>
                                <input name="cnew_email_subject_resend" type="text" id="cnew-email-subject-resend" value="<?php echo cnew_get_email_subject_resend(); ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="cnew-email-content-resend">Conteúdo</label></th>
                            <td>
                                 <?php echo wp_editor( cnew_get_email_content_resend(), 'cnew_email_content_resend', array( 'media_buttons' => false, 'textarea_rows' => 10 ) ); ?>
                                <p class="description" id="cnew-email-content-resend-description">Você pode utilizar tokens neste campo. Veja a listagem dos tokens possíveis ao lado.</p>
                            </td>
                            <td>
                                <ul>
                                    <li>{{nome_completo}}: Nome completo do participante</li>
                                    <li>{{email}}: E-mail do responsável</li>
                                    <li>{{nome_usuario}}: Nome de usuário do e-mail</li>
                                    <li>{{oficina}}: Título da Oficina</li>
                                    <li>{{link_ativacao}}: URL para confirmar a inscrição</li>
                                    <li>{{titulo_site}}: Título do site</li>
                                    <li>{{ano_corrente}}: Ano corrente</li>
                                    <li>{{pagina_inicial}}: URL da página inicial</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                    <h2 class="title">E-mail de Confirmação de Participação</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="cnew-email-subject-accepted">Assunto</label></th>
                            <td>
                                <input name="cnew_email_subject_accepted" type="text" id="cnew-email-subject-accepted" value="<?php echo cnew_get_email_subject_accepted(); ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="cnew-email-content-accepted">Conteúdo</label></th>
                            <td>
                                 <?php echo wp_editor( cnew_get_email_content_accepted(), 'cnew_email_content_accepted', array( 'media_buttons' => false, 'textarea_rows' => 10 ) ); ?>
                                <p class="description" id="cnew-email-content-accepted-description">Você pode utilizar tokens neste campo. Veja a listagem dos tokens possíveis ao lado.</p>
                            </td>
                            <td>
                                <ul>
                                    <li>{{nome_completo}}: Nome completo do participante</li>
                                    <li>{{email}}: E-mail do responsável</li>
                                    <li>{{nome_usuario}}: Nome de usuário do e-mail</li>
                                    <li>{{oficina}}: Título da Oficina</li>
                                    <li>{{titulo_site}}: Título do site</li>
                                    <li>{{ano_corrente}}: Ano corrente</li>
                                    <li>{{pagina_inicial}}: URL da página inicial</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                    <h2 class="title">E-mail Oficina Sem Vagas</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="cnew-email-subject-declined">Assunto</label></th>
                            <td>
                                <input name="cnew_email_subject_declined" type="text" id="cnew-email-subject-declined" value="<?php echo cnew_get_email_subject_declined(); ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="cnew-email-content-declined">Conteúdo</label></th>
                            <td>
                                 <?php echo wp_editor( cnew_get_email_content_declined(), 'cnew_email_content_declined', array( 'media_buttons' => false, 'textarea_rows' => 10 ) ); ?>
                                <p class="description" id="cnew-email-content-declined-description">Você pode utilizar tokens neste campo. Veja a listagem dos tokens possíveis ao lado.</p>
                            </td>
                            <td>
                                <ul>
                                    <li>{{nome_completo}}: Nome completo do participante</li>
                                    <li>{{email}}: E-mail do responsável</li>
                                    <li>{{nome_usuario}}: Nome de usuário do e-mail</li>
                                    <li>{{oficina}}: Título da Oficina</li>
                                    <li>{{titulo_site}}: Título do site</li>
                                    <li>{{ano_corrente}}: Ano corrente</li>
                                    <li>{{pagina_inicial}}: URL da página inicial</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                    <h2 class="title">E-mail de Cancelamento de Participação</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="cnew-email-subject-cancel">Assunto</label></th>
                            <td>
                                <input name="cnew_email_subject_cancel" type="text" id="cnew-email-subject-cancel" value="<?php echo cnew_get_email_subject_cancel(); ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="cnew-email-content-cancel">Conteúdo</label></th>
                            <td>
                                <?php echo wp_editor( cnew_get_email_content_cancel(), 'cnew_email_content_cancel', array( 'media_buttons' => false, 'textarea_rows' => 10 ) ); ?>
                                <p class="description" id="cnew-email-content-cancel-description">Você pode utilizar tokens neste campo. Veja a listagem dos tokens possíveis ao lado.</p>
                            </td>
                            <td>
                                <ul>
                                    <li>{{nome_completo}}: Nome completo do participante</li>
                                    <li>{{email}}: E-mail do responsável</li>
                                    <li>{{nome_usuario}}: Nome de usuário do e-mail</li>
                                    <li>{{oficina}}: Título da Oficina</li>
                                    <li>{{titulo_site}}: Título do site</li>
                                    <li>{{ano_corrente}}: Ano corrente</li>
                                    <li>{{pagina_inicial}}: URL da página inicial</li>
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <h2 class="title">E-mail de Criação de Usuário</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label for="cnew-email-subject-create-user">Assunto</label></th>
                            <td>
                                <input name="cnew_email_subject_create_user" type="text" id="cnew-email-subject-create-user" value="<?php echo cnew_get_email_subject_create_user(); ?>" class="regular-text ltr">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="cnew-email-content-create-user">Conteúdo</label></th>
                            <td>
                                <?php echo wp_editor( cnew_get_email_content_create_user(), 'cnew_email_content_create_user', array( 'media_buttons' => false, 'textarea_rows' => 10 ) ); ?>
                                <p class="description" id="cnew-email-content-create-user-description">Você pode utilizar tokens neste campo. Veja a listagem dos tokens possíveis ao lado.</p>
                            </td>
                            <td>
                                <ul>
                                    <li>{{nome_completo}}: Nome completo do participante</li>
                                    <li>{{email}}: E-mail do responsável</li>
                                    <li>{{nome_usuario}}: Nome de usuário do e-mail</li>
                                    <li>{{nome_usuario_email}}: Nome de usuário da conta (e-mail)</li>
                                    <li>{{senha_usuario}}: Senha do usuário</li>
                                    <li>{{oficina}}: Título da Oficina</li>
                                    <li>{{titulo_site}}: Título do site</li>
                                    <li>{{ano_corrente}}: Ano corrente</li>
                                    <li>{{pagina_inicial}}: URL da página inicial</li>
                                    <li>{{link_ativacao_conta}}: URL para ativar conta</li>
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <?php @submit_button(); ?>

                </form>

            </div>
        <?php

        }

        function cnew_register_plugin_settings() {
            register_setting( 'cnew_plugin_settings', 'cnew_registration_form_page_id' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_header' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_footer' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_subject_resend' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_content_resend' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_subject_accepted' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_content_accepted' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_subject_declined' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_content_declined' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_subject_cancel' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_content_cancel' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_subject_create_user' );
            register_setting( 'cnew_plugin_settings', 'cnew_email_content_create_user' );
        }

        /* === FIM CONFIGURACAO DO PLUGIN === */


        private function cnew_allowed_html() {
            $allowed_html = array(
                'a' => array(
                        'class' => array(),
                        'href'  => array(),
                        'title' => array(),
                ),
                'b' => array(),
                'strong' => array(),
                'em' => array(),
                'h1' => array(),
                'h2' => array(),
                'h3' => array(),
                'h4' => array(),
                'h5' => array(),
                'h6' => array(),
                'i' => array(),
                'ul' => array(
                        'class' => array(),
                ),
                'li' => array(
                        'class' => array(),
                ),
                'ol' => array(
                        'class' => array(),
                ),
                'p' => array(
                        'class' => array(),
                ),
                'q' => array(
                        'cite' => array(),
                ),
                'blockquote' => array(
                        'cite'  => array(),
                ),
                'cite' => array(
                        'title' => array(),
                ),
                'abbr' => array(
                        'title' => array(),
                ),
            );

            return $allowed_html;
        }

        /*
         * Retorna data formatada ou false
         */
        protected function cnew_convert_date_to_db( $date ) {
            $current_date = DateTime::createFromFormat('d/m/Y', $date );
            return $current_date ? $current_date->format('Y-m-d') : $current_date;
        }

        protected function cnew_calc_age( $birth_date ) {
            $date = new DateTime($birth_date);
            $age = $date->diff(new DateTime())->y;

            return $age;
        }

        protected function cnew_column_actions( $registration ) {
            $actions = array();
            $output = '';

            switch( $registration->status ) {
                case CNEW_Registration::EMAIL_NAO_CONFIRMADO :
                    $actions[] = array( 'action' => 'cnew_resend', 'label' => 'Enviar Confirmação de E-mail', 'class' => 'cnew-link-primary' );
                break;
                case CNEW_Registration::EMAIL_NAO_ENVIADO :
                    $actions[] = array( 'action' => 'cnew_resend', 'label' => 'Enviar Confirmação de E-mail', 'class' => 'cnew-link-primary' );
                break;
                case CNEW_Registration::PARTICIPANTE :
                    $actions[] = array( 'action' => 'cnew_cancel', 'label' => 'Cancelar Participação', 'class' => 'cnew-link-danger danger' );
                break;
                case CNEW_Registration::EMAIL_CONFIRMADO:
                    $actions[] = array( 'action' => 'cnew_accepted', 'label' => 'Confirmar Participação', 'class' => 'cnew-link-success accepted' );
                    $actions[] = array( 'action' => 'cnew_declined', 'label' => 'Sem Vagas', 'class' => 'cnew-link-warning warning' );
                break;
                case CNEW_Registration::SEM_VAGAS :
                    $actions[] = array( 'action' => 'cnew_accepted', 'label' => 'Confirmar Participação', 'class' => 'cnew-link-success accepted' );
                break;
            }

            foreach( $actions as $action ) {

                $href = add_query_arg(
                                array(
                                    'page'	    => 'cnew_confirm_send_emails',
                                    'registration_id' => $registration->post_id,
                                    'action'    => $action['action'],
                                ),
                                admin_url( 'edit.php?post_type=cnew_workshop' )
                            );

                $output .= sprintf( '<p><a class="'.$action['class'].'" style="margin-bottom:5px;" href="%1$s">%2$s</a></p>', esc_url( $href ), $action['label'] );
            }

            return $output;
        }

        protected function cnew_get_html_list_registrations( $header, $registrations, $footer ) {
            $output = $header;

            foreach( $registrations as $registration ) :
                $workshop = get_post( $registration->workshop_id );
                $workshop_title = $workshop ? esc_html( $workshop->post_title ) : __('Oficina não encontrada', 'cnew' );
                $output .=
                        '<ul>
                            <li>
                                <strong>' . __( 'Nome do Participante: ', 'cnew' ) . '</strong>' . esc_html( $registration->name ) . '
                            </li>
                            <li>
                                <strong>' . __( 'E-mail: ', 'cnew' ) . '</strong>' . esc_html( $registration->email ) . '
                            </li>
                            <li>
                                <strong>' . __('Oficina: ', 'cnew' ) . '</strong>' . $workshop_title . '
                            </li>
                        </ul>
                        <hr>';
            endforeach;     
            $output .= $footer;
            return $output;
        }

    }

endif;
