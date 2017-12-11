<?php

/**
 * Classe que manipula os registros de inscricao
 */
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'CNEW_Registration' ) ) :

    class CNEW_Registration {
        const EMAIL_NAO_ENVIADO = 0;
        const EMAIL_NAO_CONFIRMADO = 1;
        const EMAIL_CONFIRMADO = 2;
        const PARTICIPANTE = 3;
        const SEM_VAGAS = 4;
        const CANCELADO = 5;

        public function __construct() {
            $this->cnew_includes();
        }

        private function cnew_includes() {
            require( CNEW_PLUGIN_DIR . 'includes/registration/cnew-registration-functions.php' );
            require( CNEW_PLUGIN_DIR . 'includes/admin/cnew-settings.php' );
        }

        function cnew_add ( $name, $date_birth, $gender, $email, $parent_name, $parent_phone, $workshop ) {

            $name           = addslashes( $name );
            $parent_name    = addslashes( $parent_name );
            $date_birth     = $this->cnew_convert_date_to_db( '01/'.$date_birth);

            $success = false;
            $registration_id = 0;

            $post_id = wp_insert_post(
                        array(
                            'post_type' => 'cnew_registration',
                            'post_title' => $name,
                            'post_status' => 'publish',
                            'post_parent' => $workshop->ID,
                        ),
                        true
                    );
            if( $post_id ) :
                global $wpdb;

                $generate = wp_generate_password( 32, true );
                $confirmation_key = hash( 'sha256', $generate . $email. $post_id );

                $args = array(
                        'post_id'           => $post_id,
                        'workshop_id'       => $workshop->ID,
                        'ip'                => $this->cnew_get_ip(),
                        'name'              => $name,
                        'gender'            => $gender,
                        'date_birth'        => $date_birth,
                        'email'             => $email,
                        'parent_name'       => $parent_name,
                        'parent_phone'      => $parent_phone,
                        'confirmation_key'  => $confirmation_key,
                        'status'            => CNEW_Registration::EMAIL_NAO_CONFIRMADO,
                );

                $table_name = $wpdb->prefix . "cnew_registrations";

                $success = $wpdb->insert(
                        $table_name,
                        $args,
                        array(
                            '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d'
                        )
                    );
                if( $success ) :
                    $registration_id = $wpdb->insert_id;
                    $registration = self::cnew_get_by_post_id( $post_id );
                    if( $registration ) :
                        $success = cnew_email_resend( $registration );
                    endif;
                endif;
            endif;

            //se ocorreu um problema precisa deletar os posts
            if( !$success ) :
                //se tiver registration_id entao inseriu na tabela de posts e na cnew_registrations
                if( $registration_id ) :
                    //envia o post_id pois este e unico na tabela cnew_registrations, 
                    //assim usa o post_id para deletar na tabela cnew_registrations e posts
                    $this->cnew_delete_registration( $post_id );
                //senao verifica se foi criado apenas registro na tabela de posts, entao deleta o mesmo
                elseif( $post_id ):
                    $this->cnew_delete_post( $post_id );
                endif;
            endif;

        return $success;

        }

        private function cnew_delete_registration( $post_id ) {
            if( absint( $post_id ) ) :
                global $wpdb;
                $table_name = $wpdb->prefix . "cnew_registrations";
                $wpdb->delete( $table_name, array( 'post_id' => $post_id ), array( '%d' ) );
                $this->cnew_delete_post( $post_id );
            endif;
        }
        private function cnew_delete_post( $post_id ) {
            if( absint( $post_id ) ) :
                wp_delete_post( $post_id, true );
            endif;
        }

        private function cnew_convert_date_to_db( $date_birth ) {
            $current_date = DateTime::createFromFormat('d/m/Y', $date_birth );
            return $current_date ? $current_date->format('Y-m-d') : $current_date;
        }

        private function cnew_get_ip() {
            $ip = __( 'Desconhecido', 'cnew' );

            if( getenv( 'HTTP_CLIENT_IP' ) ) :
                $ip = getenv( 'HTTP_CLIENT_IP' );
            elseif( getenv( 'HTTP_X_FORWARDED_FOR' ) ) :
                $ip = getenv( 'HTTP_X_FORWARDED_FOR' );
            elseif( getenv( 'HTTP_X_FORWARDED' ) ) :
                $ip = getenv( 'HTTP_X_FORWARDED' );
            elseif( getenv( 'HTTP_FORWARDED_FOR' ) ) :
                $ip = getenv( 'HTTP_FORWARDED_FOR' );
            elseif( getenv( 'HTTP_FORWARDED' ) ) :
                $ip = getenv( 'HTTP_FORWARDED' );
            elseif( getenv( 'REMOTE_ADDR' ) ) :
                $ip = getenv( 'REMOTE_ADDR' );
            endif;

            return $ip;
        }

        public static function cnew_update_status( $registration_id, $status ) {
            global $wpdb;
            $table_name = $wpdb->prefix . "cnew_registrations";
            $result = $wpdb->update(
                $table_name, 
                array( 
                    'status' => $status,	
                ), 
                array( 'registration_id' => $registration_id ), 
                array( '%d' ), 
                array( '%d' ) 
            );

            return $result;
        }

        public static function cnew_update( $post_id, $name, $date_birth, $gender, $email, $parent_name, $parent_phone ) {
            global $wpdb;
            $table_name = $wpdb->prefix . "cnew_registrations";
            $name           = addslashes( $name );
            $parent_name    = addslashes( $parent_name );
            $date_birth = DateTime::createFromFormat('d/m/Y', '01/'.$date_birth );
            $date_birth = $date_birth ? $date_birth->format('Y-m-d') : date('Y-m-d');
            $result = $wpdb->update(
                $table_name, 
                array( 
                    'name' => $name,	
                    'date_birth' => $date_birth,	
                    'gender' => $gender,	
                    'email' => $email,	
                    'parent_name' => $parent_name,	
                    'parent_phone' => $parent_phone,	
                ), 
                array( 'post_id' => $post_id ), 
                array( '%s' ), 
                array( '%s' ), 
                array( '%s' ), 
                array( '%s' ), 
                array( '%s' ), 
                array( '%s' ), 
                array( '%d' )
            );
            return $result;
        }

        public function cnew_confirma_inscricao( $key ) {
            global $wpdb;
            $result = false;

            $table_name = $wpdb->prefix . "cnew_registrations";
            $registration = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE status = %d AND confirmation_key = %s", CNEW_Registration::EMAIL_NAO_CONFIRMADO, $key), OBJECT );

            if( $registration ) {
                /* 
                 * Se quiser bloquear a confirmacao de inscricao depois que o periodo de inscricao terminou e so retirar o comentario das linhas seguintes 
                 */
                //$cnew_end_date = get_post_meta( $registration->workshop_id, 'cnew_end_date' );
                //if( !empty( $cnew_end_date ) && date('Y-m-d') <= $cnew_end_date[0] ) {
                    $result = $wpdb->update(
                        $table_name, 
                        array( 
                            'confirmation_date' => date('Y-m-d H:i:s'),
                            'status' => CNEW_Registration::EMAIL_CONFIRMADO,
                        ), 
                        array( 'registration_id' => $registration->registration_id ), 
                        array( '%s' ), 
                        array( '%d' ), 
                        array( '%d' ) 
                    ); 
                //}
            }
            return (bool) $result;
        }

        public static function cnew_get( $email, $workshop_id ) {
            global $wpdb;
            $table_name = $wpdb->prefix . "cnew_registrations";

            $registration = null;

            if( !empty( $email ) && !empty( $workshop_id ) ) {
                $registration = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $table_name WHERE workshop_id = %d AND email = %s", $workshop_id, $email), OBJECT );
            }

            return $registration;

        }

        /*
         * Retorna uma inscricao a partir do post_id
         */
        public static function cnew_get_by_post_id( $post_id ) {
            global $wpdb;
            $table_name = $wpdb->prefix . "cnew_registrations";

            $registration = null;

            if( !empty( $post_id ) ) {
                //se passar apenas um id, retona apenas a linha solicitada
                $registration = $wpdb->get_row( 
                    $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id = %d", $post_id ),
                    OBJECT );
            }

            return $registration;

        }

        /*
         * Retorna as inscricoes a partir de uma lista de ids
         */
        public static function cnew_get_by_post_ids( $post_ids ) {
            global $wpdb;
            $table_name = $wpdb->prefix . "cnew_registrations";

            $registrations = null;

            if( !empty( $post_ids ) ) {
                $post_ids = wp_parse_id_list( $post_ids );
                $total_ids = count($post_ids);

                $placeholders = array_fill( 0, $total_ids, '%d' );
                $registrations = $wpdb->get_results( 
                        $wpdb->prepare( "SELECT * FROM $table_name WHERE post_id IN (" . implode( ', ', $placeholders ) . ")", $post_ids ),
                        OBJECT );
            }

            return $registrations;

        }

        public static function cnew_get_total_reg_workshop( $workshop_id ) {
            global $wpdb;

            $total = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND  post_type = 'cnew_registration' AND post_parent = %d", (int)$workshop_id ) );

            return (int)$total;
        }

        public static function cnew_get_total_reg_accepted_workshop( $workshop_id ) {
            global $wpdb;
            $table_name = $wpdb->prefix . "cnew_registrations";

            $total = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts AS p INNER JOIN $table_name AS r ON p.ID = r.post_id WHERE post_status = 'publish' AND  post_type = %s AND post_parent = %d AND status = %d", cnew_get_registration_post_type(), (int)$workshop_id, self::PARTICIPANTE ) );

            return (int)$total;
        }

        public static function cnew_check_registrations_status( $registrations = array(), $status = array() ) {

            $send_email_to = array();

            if( !empty($registrations) && !empty($status) ) :
                $send_email_to = array_filter( $registrations, function ($object) use ($status) {
                                                if( in_array( $object->status, $status ) && get_post( $object->workshop_id ) ) :
                                                     return $object;
                                                endif;
                                            });

            endif;

            return $send_email_to;

        }

        public static function cnew_check_emails( $registrations = array() ) {
            $valid_users = array();

            if( !empty($registrations) ) :
                $valid_users = array_filter( $registrations, function ($object) {
                                                if( !email_exists( $object->email ) ) :
                                                     return $object;
                                                endif;
                                            });

            endif;

            return $valid_users;

        }

        public static function cnew_send_emails( $registration_ids = array(), $action = '' ) {

            $result = array();

            if( !empty( $action ) && !empty( $registration_ids ) && is_array( $registration_ids ) ) :
                $send_email_to = self::cnew_get_by_post_ids( $registration_ids );

                $send_email_to_ids = wp_list_pluck( $send_email_to, 'post_id' );

                if( $registration_ids == $send_email_to_ids ) {

                    foreach( $send_email_to as $registration ) {
                        $success = false;

                        if( $registration->email ) {
                            //$actions = array( 'cnew_resend', 'cnew_accepted', 'cnew_declined', 'cnew_cancel' );
                            $send_email = false;
                            switch( $action ) {
                                case 'cnew_resend' :
                                    $send_email = cnew_email_resend( $registration );
                                    $status = CNEW_Registration::EMAIL_NAO_CONFIRMADO;
                                break;
                                case 'cnew_accepted' :
                                    $send_email = cnew_email_accepted( $registration );
                                    $status = CNEW_Registration::PARTICIPANTE;
                                break;
                                case 'cnew_declined' :
                                    $send_email = cnew_email_declined( $registration );
                                    $status = CNEW_Registration::SEM_VAGAS;
                                break;
                                case 'cnew_cancel' :
                                    $send_email = cnew_email_cancel( $registration );
                                    $status = CNEW_Registration::CANCELADO;
                                break;
                            }

                            if( $send_email && isset( $status ) ) :
                                //se esta reenviando confirmacao nao precisa atualizar status, porque este nao e alterado
                                if( $status == CNEW_Registration::EMAIL_NAO_CONFIRMADO && $registration->status == CNEW_Registration::EMAIL_NAO_CONFIRMADO ) :
                                    $success = true;
                                else :
                                $success = self::cnew_update_status( $registration->registration_id, $status );
                                endif;
                            endif;

                        }

                        $success ? $result['success'][] = $registration : $result['error'][] = $registration;

                    }  

                }

            endif;

            return $result;

        }

        /*
         * Baseado na funcao bp_core_screen_signup do buddypress, cria uma conta de usuario a partir de uma inscricao
         */
        public static function cnew_create_user( $registration_ids = array() ) {

            $result = array();

            if( !empty( $registration_ids ) && is_array( $registration_ids ) ) :
                $registrations = self::cnew_get_by_post_ids( $registration_ids );

                $registrations_ids_db = wp_list_pluck( $registrations, 'post_id' );

                if( $registration_ids == $registrations_ids_db ) {

                    foreach( $registrations as $registration ) {
                        $success = false;

                        $user_email = cnew_get_email($registration);

                        if(!email_exists($user_email)) {
                            $user_password = cnew_get_password($registration);

                            $usermeta['password'] = wp_hash_password( $user_password );

                            $user_login     = cnew_get_user_name_email($registration);
                            $activation_key = wp_generate_password( 32, false );

                            if ( ! defined( 'BP_SIGNUPS_SKIP_USER_CREATION' ) || ! BP_SIGNUPS_SKIP_USER_CREATION ) {
                                $user_id = BP_Signup::add_backcompat( $user_login, $user_password, $user_email, $usermeta );

                                if ( !is_wp_error( $user_id ) ) {
                                    bp_update_user_meta( $user_id, 'activation_key', $activation_key );
                                }

                            }

                            if(!isset($user_id) || !is_wp_error( $user_id )) {
                                $args = array(
                                        'user_login'     => $user_login,
                                        'user_email'     => $user_email,
                                        'activation_key' => $activation_key,
                                        'meta'           => $usermeta,
                                );

                                $user_id2 = BP_Signup::add( $args );

                                if($user_id2) {
                                    $success = cnew_email_create_user( $registration, $activation_key );
                                }
                            }

                            if(!$success && isset($user_id2)) {
                                BP_Signup::delete( array( $user_id2 ) );
                            }
                        }

                        $success ? $result['success'][] = $registration : $result['error'][] = $registration;

                    }  

                }

            endif;

            return $result;

        }

    } /* CNEW_Registration */

endif;
