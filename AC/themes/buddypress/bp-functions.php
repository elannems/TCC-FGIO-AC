<?php

/**
 * BUDDYPRESS
 */

/**
 * - Remove a barra de menu do buddypress, pois a barra so sera visivel 
 *  para os usuarios com acesso a area de admin do wordpress;
 * - Remove os itens de menu do buddypress da wpadminbar
 */
function cne_ac_remove_bp_admin_bar() {
    remove_action( 'admin_bar_menu', 'bp_admin_bar_my_account_root', 100 );
    remove_action( 'admin_bar_menu', 'bp_setup_admin_bar', 20 ); 
}
add_action( 'admin_bar_menu', 'cne_ac_remove_bp_admin_bar' );


/**
 * Remove o meta box bp_group_settings pois nao sera utilizado o recurso de privacidade dos grupos
 */
function cne_ac_remove_groups_meta_box() {
    remove_meta_box( 'bp_group_settings' , get_current_screen()->id , 'side' ); 
}
add_action( 'bp_groups_admin_load' , 'cne_ac_remove_groups_meta_box' );

/**
 * Add um novo meta box de configuracao para o post type groups sem o recurso de privacidade
 */
function cne_ac_add_groups_meta_box() {
    add_meta_box( 'cne_ac_bp_group_settings', __( 'Configurações', 'cne-ac' ), 'cne_ac_bp_groups_admin_edit_metabox_settings', get_current_screen()->id, 'side', 'core' );
}
add_action( 'bp_groups_admin_load' , 'cne_ac_add_groups_meta_box' );

/**
 * Meta box de configuracao do post type groups sem o recurso de privacidade
 */
function cne_ac_bp_groups_admin_edit_metabox_settings( $item ) {

    $invite_status = bp_group_get_invite_status( $item->id ); ?>

    <div class="bp-groups-settings-section" id="bp-groups-settings-section-invite-status">
        <fieldset>
            <legend><?php _e( 'Quem pode convidar outras pessoas para o grupo?', 'cne-ac' ); ?></legend>

            <label for="bp-group-invite-status-members"><input type="radio" name="group-invite-status" id="bp-group-invite-status-members" value="members" <?php checked( $invite_status, 'members' ) ?> /><?php _e( 'Todos os usuários do grupo', 'cne-ac' ) ?></label>
            <label for="bp-group-invite-status-mods"><input type="radio" name="group-invite-status" id="bp-group-invite-status-mods" value="mods" <?php checked( $invite_status, 'mods' ) ?> /><?php _e( 'Somente os administradores e moderadores do grupo', 'cne-ac' ) ?></label>
            <label for="bp-group-invite-status-admins"><input type="radio" name="group-invite-status" id="bp-group-invite-status-admins" value="admins" <?php checked( $invite_status, 'admins' ) ?> /><?php _e( 'Somente os administradores do grupo', 'cne-ac' ) ?></label>
        </fieldset>
    </div>

<?php
}

/**
 * Modifica as colunas da grid do post type groups na area de admin do wordpress
 */
function cne_ac_bp_groups_list_table_get_columns( $columns ) {
    $columns = array(
                'cb'          => '<input name type="checkbox" />',
                'comment'     => _x( 'Nome', 'Cabecalho da coluna Nome do grupo na area de admin dos grupos', 'cne-ac' ),
                'description' => _x( 'Descrição', 'Cabecalho da coluna Descricao do grupo na area de admin dos grupos', 'cne-ac' ),
                'members'     => _x( 'No. de Membros', 'Cabecalho da coluna Numero de Membros do grupo na area de admin dos grupos', 'cne-ac' ),
                'last_active' => _x( 'Última Atividade', 'Cabecalho da coluna Ultima Atividade do do grupo na area de admin dos grupos', 'cne-ac' )
		);
    
    return $columns;
}
add_filter( 'bp_groups_list_table_get_columns', 'cne_ac_bp_groups_list_table_get_columns' );

/**
 * Altera o html do search_form para usar o bootstrap
 */
function cne_ac_change_search_form() {
    
    $query_arg = bp_core_get_component_search_query_arg( 'members' );
    
    if ( ! empty( $_REQUEST[ $query_arg ] ) ) {
        $search_value = stripslashes( $_REQUEST[ $query_arg ] );
    } else {
        $search_value = bp_get_search_default_text( 'members' );
    }

    $search_form_html =
        '<form action="" method="get" id="search-members-form">
            <div class="form-group">
                <label for="members_search">
                    <input type="text" name="' . esc_attr( $query_arg ) . '" id="members_search" class="form-control" placeholder="'. esc_attr( $search_value ) .'" />
                </label>
            </div>
            <input type="submit" class="btn btn-default" id="members_search_submit" name="members_search_submit" value="'. __( 'Search', 'buddypress' ) .'" />
        </form>';  

    echo $search_form_html;
}
add_filter( 'bp_directory_members_search_form', 'cne_ac_change_search_form' );
 
/**
 * Retorna a quantidade de usuarios em um grupo
 */    
function cne_ac_member_count_change( $count_string ) {

    $count = preg_replace("/[^0-9]/","",$count_string);

    $count_string = sprintf( __( 'Usuários: %s', 'cne-ac' ), bp_core_number_format( $count ) );

    return $count_string;
}
add_filter( 'bp_get_group_member_count', 'cne_ac_member_count_change' );

/**
 * Altera as palavras especificadas sempre que aparecerem, pois se alterar no arquivo de traducao o mesmo pode ser perdido com a atualizacao dos plugins
 */
function cne_ac_text_change( $text ){
    $search = array( 'membro','membros','of' );
    $replace = array( 'usuário','usuários','de' );
    $default_text = str_ireplace( $search, $replace, $text );
    
    return $default_text;
}
add_filter('bp_get_search_default_text', 'cne_ac_text_change');
add_filter( 'bp_members_pagination_count', 'cne_ac_text_change' );

/**
 * Retorna a quantidade de amigos de um usuario
 */ 
function cne_ac_get_total_user_friends() {
    global $members_template;
    
    $friend_count = 0;
    
    if( isset( $members_template->member->total_friend_count ) ) {
        $friend_count = $members_template->member->total_friend_count;
    }

    return $friend_count;
}

/** 
 * Funcao baseada na funcao bp_groups_front_template_part() para chamar a funcao cne_ac_groups_members_template em
 * vez da funcao bp_groups_members_template_part() e remover o template do activity 
 */
function cne_ac_groups_front_template_part() {
    $located = bp_groups_get_front_template();

    if ( false !== $located ) {
        $slug = str_replace( '.php', '', $located );

        do_action( 'get_template_part_' . $slug, $slug, false );

        load_template( $located, true );

    } else if ( bp_is_active( 'members'  ) ) {
        cne_ac_groups_members_template_part();
    }

    return $located;
}

/**
 * Funcao baseada na funcao bp_groups_members_template_part() para alterar o template
 */
function cne_ac_groups_members_template_part() { ?>
    <div class="item-list-tabs" id="subnav" aria-label="<?php esc_attr_e( 'Group secondary navigation', 'buddypress' ); ?>" role="navigation">
        <div class="form-inline">
            <ul>
                <?php cne_ac_groups_members_filter(); ?>
                <?php do_action( 'bp_members_directory_member_sub_types' ); ?>

                <li class="groups-members-search" role="search">
                    <?php bp_directory_members_search_form(); ?>
                </li>

            </ul>
        </div>
    </div>

    <h2 class="bp-screen-reader-text sr-only"><?php _e( 'Usuários', 'cne-ac' ); ?></h2>

    <div id="members-group-list" class="group_members dir-list">

        <?php bp_get_template_part( 'groups/single/members' ); ?>

    </div>
<?php
}

/**
 * Funcao baseada na funcao bp_groups_members_filter() para alterar o template
 */
function cne_ac_groups_members_filter() { ?>
    <li id="group_members-order-select" class="last filter">

        <div class="form-group">
            <label for="group_members-order-by"><?php _e( 'Order By:', 'buddypress' ); ?></label>
            <select id="group_members-order-by" class="form-control">
                <option value="last_joined"><?php _e( 'Newest', 'buddypress' ); ?></option>
                <option value="first_joined"><?php _e( 'Oldest', 'buddypress' ); ?></option>

                <?php if ( bp_is_active( 'activity' ) ) : ?>
                        <option value="group_activity"><?php _e( 'Group Activity', 'buddypress' ); ?></option>
                <?php endif; ?>

                <option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ); ?></option>

                <?php do_action( 'bp_groups_members_order_options' ); ?>

            </select>
        </div>
        
    </li>
<?php
}

/**
 * Selecione apenas os componentes que serao utilizados do buddypress
 */
function cne_ac_core_get_components ( $components, $type ) {
    $required_components = array(
                'xprofile' => array(
			'title'       => __( 'Extended Profiles', 'buddypress' ),
			'description' => __( 'Customize your community with fully editable profile fields that allow your users to describe themselves.', 'buddypress' )
		),
                'friends'  => array(
			'title'       => __( 'Friend Connections', 'buddypress' ),
			'description' => __( 'Let your users make connections so they can track the activity of others and focus on the people they care about the most.', 'buddypress' )
		),
                'groups'   => array(
			'title'       => __( 'User Groups', 'buddypress' ),
			'description' => __( 'Groups allow your users to organize themselves into specific public, private or hidden sections with separate activity streams and member listings.', 'buddypress' )
		),
		'core' => array(
			'title'       => __( 'BuddyPress Core', 'buddypress' ),
			'description' => __( 'It&#8216;s what makes <del>time travel</del> BuddyPress possible!', 'buddypress' )
		),
		'members' => array(
			'title'       => __( 'Community Members', 'buddypress' ),
			'description' => __( 'Everything in a BuddyPress community revolves around its members.', 'buddypress' )
		),
	);

        $optional_components = array();
        
	$retired_components = array();

	switch ( $type ) {
		case 'required' :
			$components = $required_components;
			break;
		case 'optional' :
			$components = $optional_components;
			break;
		case 'retired' :
			$components = $retired_components;
			break;
		case 'all' :
		default :
			$components = array_merge( $required_components, $optional_components, $retired_components );
			break;
	}
        return $components;
}
add_filter( 'bp_core_get_components', 'cne_ac_core_get_components', 10, 2 );

add_filter( 'bp_ignore_deprecated', '__return_true' );

function cne_ac_bp_core_render_message_content( $message, $type ) {
    switch( $type ) {
        case 'updated' :
            $class = 'alert alert-success';
            break;
        default :
            $class = 'alert alert-danger';
    }
    
    $output = '<div class="' . $class . ' fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $message . '</div>';
    
    return $output;
}
add_filter( 'bp_core_render_message_content', 'cne_ac_bp_core_render_message_content', 10, 2 );

function cne_ac_nav_change_avatar( $html, $subnav_item, $selected_item ) {
    $selected = '';
    
    if ( $subnav_item->slug === $selected_item ) {
        $selected = ' class="current selected"';
    }
    
    $list_type = bp_is_group() ? 'groups' : 'personal';
    $subnav_item->name = __( 'Alterar avatar', 'cne-ac' );
    
    return '<li id="' . esc_attr( $subnav_item->css_id . '-' . $list_type . '-li' ) . '" ' . $selected . '><a id="' . esc_attr( $subnav_item->css_id ) . '" href="' . esc_url( $subnav_item->link ) . '">' . $subnav_item->name . '</a></li>';

}
add_filter( 'bp_get_options_nav_change-avatar', 'cne_ac_nav_change_avatar', 10, 3 );

function cne_ac_nav_change_replies( $html, $subnav_item, $selected_item ) {
    $selected = '';
    
    if ( $subnav_item->slug === $selected_item ) {
        $selected = ' class="current selected"';
    }
    
    $subnav_item->name = __( 'Comentários', 'cne-ac' );
    
    return '<li id="' . esc_attr( $subnav_item->css_id . '-personal-li' ) . '" ' . $selected . '><a id="' . esc_attr( $subnav_item->css_id ) . '" href="' . esc_url( $subnav_item->link ) . '">' . $subnav_item->name . '</a></li>';

}
add_filter( 'bp_get_options_nav_replies', 'cne_ac_nav_change_replies', 10, 3 );

function cne_ac_nav_change_forums( $html, $user_nav_item ) {
    
    $user_nav_item->name = __( 'Colaboração', 'cnew' );
    $selected = '';
    
    if ( bp_is_current_component( $user_nav_item->slug ) ) {
        $selected = ' class="current selected"';
    }

    if ( bp_loggedin_user_domain() ) {
        $link = str_replace( bp_loggedin_user_domain(), bp_displayed_user_domain(), $user_nav_item->link );
    } else {
        $link = trailingslashit( bp_displayed_user_domain() . $user_nav_item->link );
    }
    
    return '<li id="' . $user_nav_item->css_id . '-personal-li" ' . $selected . '><a id="user-' . $user_nav_item->css_id . '" href="' . $link . '">' . $user_nav_item->name . '</a></li>';
   
}
add_filter( 'bp_get_displayed_user_nav_forums', 'cne_ac_nav_change_forums', 10, 2 );


function cne_ac_remove_subnav_settings() {
    bp_core_remove_subnav_item( BP_SETTINGS_SLUG, 'delete-account' );
    bp_core_remove_subnav_item( BP_SETTINGS_SLUG, 'general' );
}
add_action( 'bp_setup_components', 'cne_ac_remove_subnav_settings', 7 );

function cne_ac_remove_subnav_subscriptions() {
    bp_core_remove_subnav_item( BP_FORUMS_SLUG, bbp_get_user_subscriptions_slug() );
}
add_action( 'bp_setup_nav', 'cne_ac_remove_subnav_subscriptions' );

function cne_ac_bp_modify_page_title( $new_title, $title, $sep ) {
    $array = explode( $sep, $new_title);
    $key = array_search('Fóruns ', $array);
    
    if( $key !== false ) {
        $array[$key] = __( 'Áreas ', 'cne_ac' );
    }
    
    $key = array_search('Respostas ', $array);
    if( $key !== false ) {
        $array[$key] = __( 'Comentários ', 'cne_ac' );
    }
    $new_title = implode( $sep,  $array );
    return $new_title;
}
add_filter( 'bp_modify_page_title', 'cne_ac_bp_modify_page_title', 10, 3 );

function cne_ac_add_subnav_item_profile() {
    $parent_slug = 'profile';
    
    if ( bp_displayed_user_domain() ) {
        $user_domain = bp_displayed_user_domain();
    } elseif ( bp_loggedin_user_domain() ) {
        $user_domain = bp_loggedin_user_domain();
    } else {
        return;
    }

    $settings_link = trailingslashit( $user_domain . $parent_slug );
    
    bp_core_new_subnav_item( array(
                'name'            => __( 'Configurar conta', 'cne-ac' ),
                'slug'            => 'general',
                'parent_url'      => $settings_link,
                'parent_slug'     => $parent_slug,
                'screen_function' => 'cne_ac_bp_profile_screen_general',
                'position'        => 80,
                'user_has_access' => bp_core_can_edit_settings()
        ) );
    
    if ( ( ! bp_disable_account_deletion() && bp_is_my_profile() ) || bp_current_user_can( 'delete_users' ) ) {	
        bp_core_new_subnav_item( array( 
                'name'			=> __( 'Excluir conta', 'cne-ac' ),
                'slug'			=> 'delete-account', 
                'parent_url'		=> $settings_link, 
                'parent_slug'		=> $parent_slug, 
                'screen_function'	=> 'cne_ac_bp_profile_screen_delete_account',
                'position'              => 90,
                'user_has_access'       => !is_super_admin( bp_displayed_user_id() )
        ) );
    }   
}
add_action( 'bp_setup_nav', 'cne_ac_add_subnav_item_profile', 100 );

function cne_ac_bp_profile_screen_delete_account() {

    if ( bp_action_variables() ) {
        bp_do_404();
        return;
    }

    bp_core_load_template( apply_filters( 'cne_ac_bp_profile_screen_delete_account', 'members/single/profile/delete-account' ) );
}

function cne_ac_bp_profile_screen_general() {

    if ( bp_action_variables() ) {
        bp_do_404();
        return;
    }

    bp_core_load_template( apply_filters( 'cne_ac_bp_profile_screen_general', 'members/single/profile/general' ) );
    
}

/**
 * Altera a funcao bp_settings_action_delete_account para considerar a acao delete_account no profile em vez de em settings
 */
function cne_ac_bp_profile_action_delete_account() {

    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
        return;

    if ( ! isset( $_POST['delete-account-understand'] ) )
        return;

    if ( !bp_is_profile_component() || ! bp_is_current_action( 'delete-account' ) )
        return false;

    if ( bp_action_variables() ) {
        bp_do_404();
        return;
    }

    if ( bp_disable_account_deletion() && ! bp_current_user_can( 'delete_users' ) ) {
        return false;
    }

    check_admin_referer( 'delete-account' );

    if ( bp_core_delete_account( bp_displayed_user_id() ) ) {
        bp_core_add_message( __( 'Usuário excluído com sucesso.', 'cne-ac' ), 'success' );
        $link = bp_get_members_directory_permalink();
        bp_core_redirect( $link );
    }
}
add_action( 'bp_actions', 'cne_ac_bp_profile_action_delete_account' );

/**
 * Altera a funcao bp_settings_action_general para considerar a acao general no profile em vez de em settings
 */
function cne_ac_bp_profile_action_general() {

    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
        return;

    if ( ! isset( $_POST['submit'] ) )
            return;

    if ( ! bp_is_profile_component() || ! bp_is_current_action( 'general' ) )
            return;

    if ( bp_action_variables() ) {
            bp_do_404();
            return;
    }

    // define valores default
    $bp            = buddypress(); // instancia
    $pass_error    = false;        // invalid|mismatch|empty|nochange
    $pass_changed  = false;        // true se usuario alterar sua senha
    $feedback_type = 'error';      // success|error
    $feedback      = array();      // array de resposta.

    // verifica nonce
    check_admin_referer('cne_ac_bp_profile_general');

    if ( ( is_super_admin() ) || ( !empty( $_POST['pwd'] ) && wp_check_password( $_POST['pwd'], $bp->displayed_user->userdata->user_pass, bp_displayed_user_id() ) ) ) {

        $update_user = get_userdata( bp_displayed_user_id() );

        if ( !empty( $_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {

            if ( ( $_POST['pass1'] == $_POST['pass2'] ) && !strpos( " " . $_POST['pass1'], "\\" ) ) {

                if ( ( ! empty( $_POST['pwd'] ) && $_POST['pwd'] != $_POST['pass1'] ) || is_super_admin() )  {
                    $update_user->user_pass = $_POST['pass1'];
                    $pass_changed = true;
                } else {
                    $pass_error = 'same';
                }
                
            } else {
                    $pass_error = 'mismatch';
            }
        } elseif ( empty( $_POST['pass1'] ) && empty( $_POST['pass2'] ) ) {
            $pass_error = false;
        } elseif ( ( empty( $_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) || ( !empty( $_POST['pass1'] ) && empty( $_POST['pass2'] ) ) ) {
            $pass_error = 'empty';
        }

        if ( isset( $update_user->data ) && is_object( $update_user->data ) ) {
            $update_user = $update_user->data;
            $update_user = get_object_vars( $update_user );

            if ( false === $pass_changed ) {
                unset( $update_user['user_pass'] );
            }
        }

        if ( ( false === $pass_error ) && ( wp_update_user( $update_user ) ) ) {
            wp_cache_delete( 'bp_core_userdata_' . bp_displayed_user_id(), 'bp' );
            $bp->displayed_user->userdata = bp_core_get_core_userdata( bp_displayed_user_id() );
        }

    } else {
        $pass_error = 'invalid';
    }

    switch ( $pass_error ) {
        case 'invalid' :
            $feedback['pass_error']    = __( 'Sua senha atual é inválida.', 'cne-ac' );
            break;
        case 'mismatch' :
            $feedback['pass_mismatch'] = __( 'Os valores inseridos são diferentes.', 'cne-ac' );
            break;
        case 'empty' :
            $feedback['pass_empty']    = __( 'Campos obrigatórios não preenchidos.', 'cne-ac' );
            break;
        case 'same' :
            $feedback['pass_same'] 	   = __( 'A nova senha precisa ser diferente da senha atual.', 'cne-ac' );
            break;
    }

    if ( ( false == $pass_error ) && ( true === $pass_changed ) ) {
        $feedback[]    = __( 'Your settings have been saved.', 'buddypress' );
        $feedback_type = 'success';
    } elseif ( ( false === $pass_error ) && ( false === $pass_changed ) ) {
        if ( bp_is_my_profile() ) {
            $feedback['nochange'] = __( 'Nenhuma alteração foi feita em sua conta.', 'cne-ac' );
        } else {
            $feedback['nochange'] = __( 'Nenhuma alteração foi feita nesta conta.', 'cne-ac' );
        }
    }

    bp_core_add_message( implode( "\n", $feedback ), $feedback_type );

    do_action( 'bp_core_general_settings_after_save' );

    bp_core_redirect( trailingslashit( bp_displayed_user_domain() . bp_get_profile_slug() . '/general' ) );    
}
add_action( 'bp_actions', 'cne_ac_bp_profile_action_general' );

/**
 * Baseado em: <https://wordpress.stackexchange.com/questions/142517/remove-ability-to-access-certain-admin-menus>
 */
function cne_ac_restrict_bp_admin_pages() {
    
    $author = wp_get_current_user();
     
    if( isset( $author->roles[0] ) && isset( $author->roles[1] ) ) { 
        $role_site = $author->roles[0];
        $role_bbpress = $author->roles[1];
    } else {
        wp_die( __( 'You do not have permission to do that.' ) );
    }
    
    $current_screen_id = get_current_screen()->id;
    
    $restricted_screens = array(
            'settings_page_bp-components',
            'settings_page_bp-page-settings',
            'settings_page_bp-settings',
            'settings_page_bbpress',
            'bp-email_page_bp-emails-customizer-redirect', 
            'users_page_bp-profile-setup', 
            'tools_page_bbp-converter', 
            'tools_page_bbp-repair', 
            'tools_page_bbp-reset', 
            'tools_page_bp-tools', 
            'appearance_page_bp-emails-customizer-redirect',
            'edit-bp-email',
            'bp-email'
        );
    
    if( !bbp_is_user_keymaster()) {
        $restricted_screens[] = 'toplevel_page_bp-groups';
    }
    
    if(!isset( $role_site ) || $role_site == 'subscriber') {
        $restricted_screens[] = 'edit-comments';
        $restricted_screens[] = 'edit-post';
        $restricted_screens[] = 'post';
    }
    
    if( !isset( $role_site ) || $role_site != 'administrator' ) {
        $restricted_screens[] = 'options-general';
        $restricted_screens[] = 'options-writing';
        $restricted_screens[] = 'options-reading';
        $restricted_screens[] = 'options-discussion';
        $restricted_screens[] = 'options-media';
        $restricted_screens[] = 'options-permalink';
        $restricted_screens[] = 'tools';
    }
    
    foreach ( $restricted_screens as $restricted_screen ) {

        if ( $current_screen_id === $restricted_screen ) {
            wp_die( __( 'You do not have permission to do that.' ) );
        }

    }
    
}
add_action( 'current_screen', 'cne_ac_restrict_bp_admin_pages' );

function remove_menus(){
  
    remove_menu_page( 'edit.php?post_type=bp-email' ); //E-mail BP
    remove_submenu_page( 'tools.php', 'bp-tools' ); //Ferramentas BP
    remove_submenu_page( 'tools.php', 'bbp-repair' ); //Ferramentas BBP
    remove_submenu_page( 'options-general.php', 'bp-components' ); //Configuracoes BP
    remove_submenu_page( 'options-general.php', 'bbpress' ); //Configuracoes BBP
    remove_submenu_page( 'users.php', 'bp-profile-setup' ); //Campos de perfil BP
    remove_submenu_page('themes.php', 'bp-emails-customizer-redirect'); //E-mail BP em Aparência
    
    $author = wp_get_current_user();
     
    if( isset( $author->roles[0] ) && isset( $author->roles[1] ) ) { 
        $role_site = $author->roles[0];
        $role_bbpress = $author->roles[1];
    }
    if( !bbp_is_user_keymaster()) {
        remove_menu_page('bp-groups'); //Groups BP
    }
    
    if( $role_site != 'administrator') {
        remove_menu_page( 'tools.php' ); 
    }
    
    if($role_site == 'subscriber') {
        remove_menu_page( 'edit-comments.php' ); //Comments
        remove_menu_page( 'edit.php' ); //Posts
    }
  
}
add_action( 'admin_menu', 'remove_menus' );