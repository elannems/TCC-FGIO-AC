<?php
/*
  Plugin Name: CnE - Ferramenta de Gerenciamento de Inscrições em Oficinas
  Plugin URI:
  Description: Com este plugin é possível gerenciar as inscrições de participantes nas oficinas, desde oferecer uma oficina (abrir as inscrições) até a confirmação de participação dos inscritos.
  Version: 0.1
  Author: Elanne M de Souza
  Author URI:
  License:
  License URI:
  Domain Path: /languages
  Text Domain: cnew 
 */

/**
 * Evita o acesso direto ao arquivo
 */
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'CNE_Workshops' ) ) :

class CNE_Workshops {
    private static $instance;
    
    private $admin;
    
    public static function getInstance() {
        
        if(!isset(self::$instance)) {
            self::$instance = new self;
        }
        
        return self::$instance;
    }
    
    private function __construct() { 
        $this->cnew_globals();
        $this->cnew_includes();
        $this->cnew_hooks();
    }
    
    private function __clone() {
    }
    
    private function __wakeup() {
    }
    
    private function cnew_globals() {
        define( 'CNEW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'CNEW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }
    
    private function cnew_includes() {
        require ( CNEW_PLUGIN_DIR . 'includes/cpt/cnew-setting.php' );
        require ( CNEW_PLUGIN_DIR . 'includes/cpt/cnew-template-functions.php' );
        require ( CNEW_PLUGIN_DIR . 'includes/core/cnew-template-loader.php' );
        require ( CNEW_PLUGIN_DIR . 'includes/core/cnew-core-functions.php' );
        require ( CNEW_PLUGIN_DIR . 'includes/core/cnew-registration.php' );
        require ( CNEW_PLUGIN_DIR . 'includes/registration/cnew-manage-registration.php' );
        
        if ( is_admin() ) :
                require( CNEW_PLUGIN_DIR . 'includes/core/cnew-admin.php'   );
        endif;
    }
    
    
    
    /* === HOOKS === */
    private function cnew_hooks() {
        
        add_action( 'init', array( $this, 'cnew_register_custom_post_types' ) );
        
        add_action( 'plugins_loaded', array( $this, 'cnew_load_plugin_textdomain' ) );
        
        register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
        
        register_activation_hook( __FILE__, array( $this, 'cnew_activate_plugin' ) );
        
        if ( is_admin() ) :
            add_action( 'init', array( $this, 'cnew_init_admin' ) );
        endif;

        add_action( 'init', array( $this, 'cnew_shortcodes_add' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'cnew_load_scripts' ) );
        
        add_filter( 'wp_enqueue_scripts', array( $this, 'cnew_localize_workshop_script'   ) );
        
        add_action( 'template_include', array( $this, 'cnew_cpt_templates' ));
        
        add_action( 'pre_get_posts', array( $this, 'cnew_set_post_type' ) );
        
        add_action( 'wp_ajax_archive_workshop', array( $this, 'cnew_ajax_archive_workshop') );
        
        add_action( 'wp_ajax_nopriv_archive_workshop', array( $this, 'cnew_ajax_archive_workshop') );

        
    }
    
    function cnew_load_plugin_textdomain() {
        load_plugin_textdomain( 'cnew', false, CNEW_PLUGIN_DIR . '/languages/' );
    }

    
    function cnew_init_admin() {
        $this->admin = new CNEW_Admin();
    }
    
    /* === CUSTOM POST TYPES === */
    public static function cnew_register_custom_post_types() {
        register_post_type(
            cnew_get_workshop_post_type(),
            array(
                    'labels'              => cnew_get_workshop_post_type_labels(),
                    'rewrite'             => cnew_get_workshop_post_type_rewrite(),
                    'supports'            => cnew_get_workshop_post_type_supports(),
                    'description'         => '',
                    'has_archive'         => true,
                    'exclude_from_search' => true,
                    'show_in_nav_menus'   => false,
                    'public'              => true,
                    'show_ui'             => true,
                    'menu_icon'           => 'dashicons-welcome-learn-more',
                    'hierarchical'        => false,
                    'query_var'           => true,
                    'capabilities' => array(
                        'edit_post'          => 'update_core',
                        'read_post'          => 'update_core',
                        'delete_post'        => 'update_core',
                        'edit_posts'         => 'update_core',
                        'edit_others_posts'  => 'update_core',
                        'delete_posts'       => 'update_core',
                        'publish_posts'      => 'update_core',
                        'read_private_posts' => 'update_core'
                    )
            )
        );
        
        register_post_type(
            cnew_get_registration_post_type(),
            array(
                    'labels'              => cnew_get_registration_post_type_labels(),
                    'rewrite'             => cnew_get_registration_post_type_rewrite(),
                    'supports'            => cnew_get_registration_post_type_supports(),
                    'description'         => '',
                    'has_archive'         => false,
                    'exclude_from_search' => true,
                    'show_in_nav_menus'   => false,
                    'public'              => false,
                    'show_ui'             => true,
                    'show_in_menu'        => 'edit.php?post_type='.cnew_get_workshop_post_type(),
                    'hierarchical'        => false,
                    'query_var'           => true,
                    'capabilities' => array(
                        'edit_post'          => 'update_core',
                        'read_post'          => 'update_core',
                        'delete_post'        => 'update_core',
                        'edit_posts'         => 'update_core',
                        'edit_others_posts'  => 'update_core',
                        'delete_posts'       => 'update_core',
                        'publish_posts'      => 'update_core',
                        'read_private_posts' => 'update_core',
                        'create_posts' => 'do_not_allow',
                    ),
                    'map_meta_cap' => true
             )
        );
    }
    
    function cnew_cpt_templates( $template ) {
        
        if( is_post_type_archive( cnew_get_workshop_post_type() ) ) {
            $new_template = CNEW_PLUGIN_DIR.'templates/archive-workshop.php';
        } else if( is_singular( cnew_get_workshop_post_type() ) ) {
            $new_template = CNEW_PLUGIN_DIR.'templates/single-workshop.php';
        }
        
        if( isset($new_template) && file_exists($new_template) ) :
            $template = $new_template;
        endif;
        
        return $template;
    }

    function cnew_load_scripts() {
        wp_register_script( 'cnew-js-jquery-validate', CNEW_PLUGIN_URL . 'includes/js/jquery.validate.min.js', array( 'jquery' ), '', true );
        wp_register_script( 'cnew-js-jquery-mask', CNEW_PLUGIN_URL . 'includes/js/jquery.maskedinput.min.js', array( 'jquery' ), '', true );
        wp_register_script( 'cnew-js', CNEW_PLUGIN_URL . 'includes/js/cne-workshops.js', array( 'jquery', 'cnew-js-jquery-validate', 'cnew-js-jquery-mask' ), '', true );
        wp_register_style( 'cnew-css', CNEW_PLUGIN_URL . 'includes/css/cne-workshops.css' );
        wp_register_style( 'cnew-css-font-awesome', CNEW_PLUGIN_URL . 'includes/css/font-awesome/css/font-awesome.min.css' );
        wp_register_style( 'cnew-css-google-fonts', 'https://fonts.googleapis.com/css?family=Bitter|Lato:400,700' );
        
        wp_enqueue_script( 'cnew-js-jquery-validate' );
        wp_enqueue_script( 'cnew-js-jquery-mask' );
        wp_enqueue_script( 'cnew-js' );
        wp_enqueue_style( 'cnew-css' );
        wp_enqueue_style( 'cnew-css-font-awesome' );
        wp_enqueue_style( 'cnew-css-google-fonts' ); 
    }
    
    function cnew_localize_workshop_script() {
        wp_localize_script( 'cnew-js', 'cnew_workshop_js', array( 
            'cnew_ajaxurl' => admin_url( 'admin-ajax.php' ),
            'ws_filter_nonce'  => wp_create_nonce( 'cnew-ws-filter' )
        ) );
        
    }
    

    function cnew_ajax_archive_workshop() {
        
        if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
            $this->cnew_ajax_result(false);
        }

        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'cnew-ws-filter' ) ) {
            $this->cnew_ajax_result(false);
        }
	if ( empty( $_POST['filter'] ) )
		$this->cnew_ajax_result(false);

	$filter = sanitize_title( $_POST['filter'] );
        
        $paged = 1;
        
        if( isset( $_POST['paged'] ) && (int)$_POST['paged'] ) 
            $paged = $_POST['paged'];

        switch($filter) {
            case 'open' :
                $workshops = cnew_open_workshops( $paged );
                break;
            case 'closed' :
                $workshops = cnew_closed_workshops( $paged );
                break;
        }
        
        if( isset($workshops) ) :
            $template = cnew_get_template_loader();
        
            ob_start();

            $template->set_template_data( array( 'workshops' => $workshops, 'paged' => $paged ) )->get_template_part( 'workshops', 'loop' );

            $output = ob_get_clean();
            
            $this->cnew_ajax_result( true, $output );
            
        endif;
        
        $this->cnew_ajax_result(false);
        
    }
    
    function cnew_ajax_result( $success = false, $content = '' ) {
        
        $result = array(
            'status' => 0,
            'content' =>  __( 'Ocorreu um erro ao processar sua solicitação. Por favor, tente novamente.', 'cnew' )
        );
        
	if ( $success === true ) {
            $result['status'] = 1;
            $result['content'] = $content;
            
        } 
        
	@header( 'Content-type: application/json' );
	echo json_encode( $result );
        
	die();
    }

    public function cnew_create_db_tables() {

        global $wpdb;
        
        //retorna o charset utilizado pelo banco de dados 
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$wpdb->prefix}cnew_registrations ("
        . "registration_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT, "
        . "ip varchar(32) NOT NULL, "
        . "post_id BIGINT(20) UNSIGNED NOT NULL, "
        . "workshop_id BIGINT(20) UNSIGNED NOT NULL, "
        . "name VARCHAR(255) NOT NULL, "
        . "gender VARCHAR(6) NOT NULL, "
        . "date_birth DATE NOT NULL, "
        . "email VARCHAR(100) NOT NULL, "
        . "parent_name VARCHAR (255),"
        . "parent_phone VARCHAR (15),"
        . "confirmation_key VARCHAR(64), "
        . "confirmation_date DATETIME, "
        . "status TINYINT(1) DEFAULT 0, "
        . "created_at DATETIME, "
        . "updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, "
        . "UNIQUE KEY post_id (post_id), "
        . "UNIQUE KEY registration (workshop_id, email), "
        . "PRIMARY KEY (registration_id)"
        . ") $charset_collate;";

        //evita problemas com a funcao dbDelta
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        dbDelta( $sql ); //examina a estrura da tabela e depois adiciona ou atulializa se ja existir a mesma tabela
        
    }
    
    function cnew_set_post_type( $query ) {
        
        if ( $query->is_home() && $query->is_main_query() ) :
            $query->set( 'post_type', array( 'post', 'cnew_workshop' ) );
        endif;
        
        return $query;
    }

    public function cnew_activate_plugin() {

        self::cnew_register_custom_post_types();
        $this->cnew_create_db_tables();
        flush_rewrite_rules();

    }

    /* === 8. SHORTCODES === */
    function cnew_shortcodes_add() {
        
        add_shortcode( 'cnew-oficina-index', array( $this, 'cnew_workshop_index_shortcode' ) );
        
        add_shortcode( 'cnew-inscricao-form', array( $this, 'cnew_registration_form_shortcode' ) );
    }
    
    function cnew_workshop_index_shortcode() {
        
        $template = cnew_get_template_loader();
        
        ob_start();
        
        $template->get_template_part( 'content', 'archive-workshop' );
        
        return ob_get_clean();
        
    }
    
    function cnew_registration_form_shortcode() {
        
        $template = cnew_get_template_loader();
        
        if( isset( $_GET['wid'] ) ) :
            
            $id = $_GET['wid'];
        
            $workshop = get_post((int)$id);

            if( isset($workshop) && $workshop->post_type === cnew_get_workshop_post_type() ) :
                
                if( cnew_is_workshop_open( get_post_meta( $workshop->ID, 'cnew_start_date', true ), get_post_meta( $workshop->ID, 'cnew_end_date', true ) ) ) :
                    ob_start();

                    cnew_page_registration( $template, $workshop );

                    return ob_get_clean();
                else :
                    
                    $data = array( 'class' => 'cnew-warning', 'msg' => 'As inscrição para a oficina selecionada estão fechadas.');
                
                endif;
                    
            else :
        
                $data = array( 'class' => 'cnew-error', 'msg' => 'A oficina solicitada não foi encontrada.');
                
            endif;
            
        elseif( isset( $_GET['key'] ) ) :
            $key = $_GET['key'];
            if( preg_match( '/^[0-9a-z]+$/i', $key ) && strlen($key) === 64 ) :
            
                $data = cnew_ativa_inscricao( $key );
                
            endif;
        endif;
        
        if( !isset( $data ) ) :
            $data = array( 'class' => 'cnew-error', 'msg' => 'Não foi possível reconhecer sua solictação.');
        endif;

        ob_start();
        $template->set_template_data( $data )->get_template_part( 'feedback', 'message' );
        return ob_get_clean();
        
    }

}

function cne_workshops() {
    return CNE_Workshops::getInstance();
}

cne_workshops();

endif;