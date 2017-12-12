<?php

/*
 * BBPRESS
 */

/*
 * Desabilita a edicao de forum
 */
function cne_ac_disable_forum_edit() {
    return false;
}
add_filter( 'bbp_is_forum_edit', 'cne_ac_disable_forum_edit' );

/*
 * Verifica se existe imagem de destaque no post, senao adiciona imagem padrao
 */
function cne_ac_card_image() {
    global $post;
    if ( has_post_thumbnail($post->ID) ) :
        echo the_post_thumbnail();
    else : ?>
        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/cne-ac/img/logo-cne.png">
    <?php 
    endif;
}

/*
 * Ajusta imagem do topico para apresentar no perfil do usuario
 */
function cne_ac_card_user_topic_image( $post_id ) {
    if ( has_post_thumbnail( (int)$post_id ) ) {
        echo get_the_post_thumbnail( (int)$post_id, array( 50,50 ) );
    } else {
        ?>
        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/cne-ac/img/logo-cne.png" width="50" height="50">
        <?php
    }
}

/*
 * Remove os widgets do bbpress
 */
function cne_ac_bbp_remove_widgets() {
    remove_all_actions('bbp_widgets_init');
}
add_action( 'widgets_init', 'cne_ac_bbp_remove_widgets', 1 );

/*
 * Remove os shortcodes nao utilizados do bbpress
 */
function cne_ac_remove_bbp_shortcodes( $shortcodes ) {
    $new_shortcodes = null;
    if( isset($shortcodes) && isset($shortcodes['bbp-login'])) {
        $new_shortcodes = array(
            'cne-ac-bbp-login' => $shortcodes['bbp-login'],
            'cne-ac-bbp-topic-form' => $shortcodes['bbp-topic-form'],
            );
    }
    return $new_shortcodes;
} 
add_filter( 'bbp_shortcodes', 'cne_ac_remove_bbp_shortcodes' );

/* === ALTERA CUSTOM POST TYPE FORUM === */
function cne_ac_bbp_get_forum_post_type_labels() {
	$labels = array(
		'name'               => __( 'Áreas de Conteúdo', 'cne_ac' ),
		'menu_name'          => __( 'Áreas de Conteúdo', 'cne_ac' ),
		'singular_name'      => __( 'Área de Conteúdo', 'cne_ac' ),
		'all_items'          => __( 'Todas as Áreas de Conteúdo', 'cne_ac' ),
		'add_new'            => __( 'Nova Área de Conteúdo', 'cne_ac' ),
		'add_new_item'       => __( 'Criar Nova Área de Conteúdo',         'cne_ac' ),
		'edit'               => __( 'Editar', 'cne_ac' ),
		'edit_item'          => __( 'Editar Área de Conteúdo', 'cne_ac' ),
		'new_item'           => __( 'Nova Área de Conteúdo', 'cne_ac' ),
		'view'               => __( 'Ver Área de Conteúdo', 'cne_ac' ),
		'view_item'          => __( 'Ver Área de Conteúdo', 'cne_ac' ),
		'search_items'       => __( 'Procurar Áreas de Conteúdo', 'cne_ac' ),
		'not_found'          => __( 'Nenhuma área de conteúdo encontrada', 'cne_ac' ),
		'not_found_in_trash' => __( 'Nenhuma área de conteúdo encontrada no lixo', 'cne_ac' ),
		'parent_item_colon'  => __( 'Área de Conteúdo Pai:', 'cne_ac' )
	);
        return $labels;
}
add_filter( 'bbp_get_forum_post_type_labels', 'cne_ac_bbp_get_forum_post_type_labels' );

function cne_ac_bbp_register_forum_post_type($array) {
    $array['description']  = __( 'bbPress Áreas de Conteúdo', 'cne_ac' );
    $array['hierarchical'] = false;
    $array['show_in_nav_menus'] = false;
    
    return $array;
}
add_filter( 'bbp_register_forum_post_type', 'cne_ac_bbp_register_forum_post_type' );

function cne_ac_bbp_get_forum_post_type_supports() {
    $supports = array(
        'title',
        'excerpt',
        'thumbnail'
    );
    return $supports;
}
add_filter('bbp_get_forum_post_type_supports', 'cne_ac_bbp_get_forum_post_type_supports' );

function cne_ac_bbp_custom_css_admin() {
    if ( !isset( get_current_screen()->post_type ) || ( bbp_get_forum_post_type() != get_current_screen()->post_type ) )
        return;
    ?>

    <style type="text/css" media="screen">
    /*<![CDATA[*/
    
            .column-cne_ac_bbp_forum_type {
                    width: 15% !important;
            }

    /*]]>*/
    </style>
    <?php
}
add_action( 'bbp_admin_head', 'cne_ac_bbp_custom_css_admin' );

function cne_ac_bbp_admin_forums_column_headers() {
    $columns = array (
			'cb'                    => '<input type="checkbox" />',
			'title'                 => __( 'Áreas de Conteúdo', 'cne-ac' ),
			'cne_ac_bbp_forum_type' => __( 'Tipo', 'cne-ac' ),
			'bbp_forum_topic_count' => __( 'Topics',    'bbpress' ),
			'bbp_forum_reply_count' => __( 'Comentários', 'cne-ac' ),
			'author'                => __( 'Creator',   'bbpress' ),
			'bbp_forum_created'     => __( 'Criado em', 'cne-ac' ),
		);
    
    return $columns;
}
add_filter( 'bbp_admin_forums_column_headers', 'cne_ac_bbp_admin_forums_column_headers' );

function cne_ac_bbp_admin_forums_column_data( $column, $forum_id ) {
    if( $column === 'cne_ac_bbp_forum_type') {
        $type = get_post_meta( $forum_id, 'cne_ac_secao_tipo' );
        
        if( isset( $type ) && isset( $type[0] ) ) {
            echo $type[0] === 'privado' ? 'Privado' : 'Público';
        }
    }
}
add_action( 'bbp_admin_forums_column_data', 'cne_ac_bbp_admin_forums_column_data', 10, 2 );

function cne_ac_bbp_set_title( $new_title ){
        if ( bbp_is_single_forum() ) {
            $new_title['format'] = __( 'Área: %s', 'cne-ac' );
        }
	return $new_title;

}
add_filter( 'bbp_before_title_parse_args', 'cne_ac_bbp_set_title' );

/* === ALTERA CUSTOM POST TYPE TOPIC === */

function cne_ac_bbp_get_topic_post_type_supports( $supports ) {
    $supports = array(
        'title',
        'editor',
        'thumbnail'
    );
    
    return $supports;
}
add_filter( 'bbp_get_topic_post_type_supports', 'cne_ac_bbp_get_topic_post_type_supports');

function cne_ac_bbp_admin_topics_column_headers( $columns ) {
    $columns['bbp_topic_forum'] = __( 'Área de Conteúdo', 'cne-ac' );
    $columns['bbp_topic_reply_count'] = __( 'Comentários', 'cne-ac' );
    $columns['bbp_topic_created'] = __( 'Criado em', 'cne-ac' );
    unset( $columns['bbp_topic_voice_count'] );
    unset( $columns['bbp_topic_freshness'] );
    
    return $columns;
}
add_filter( 'bbp_admin_topics_column_headers', 'cne_ac_bbp_admin_topics_column_headers' );

function cne_ac_bbp_get_topic_caps( $array ) {
    $array['create_posts'] = false;
    return $array;
}
add_filter( 'bbp_get_topic_caps', 'cne_ac_bbp_get_topic_caps' );

/* === ALTERA CUSTOM POST TYPE REPLY */
function cne_ac_bbp_get_reply_title_fallback( $reply_title, $post_id, $topic_title ) {
    $reply_title = sprintf( __( 'Resposta ao tópico: %s', 'bbpress', 'cne-ac' ), $topic_title );
    
    return $reply_title;
}
add_filter( 'bbp_get_reply_title_fallback', 'cne_ac_bbp_get_reply_title_fallback', 10, 3 );

function cne_ac_bbp_get_reply_caps( $array ) {
    $array['create_posts'] = false;
    return $array;
}
add_filter( 'bbp_get_reply_caps', 'cne_ac_bbp_get_reply_caps' );

function cne_ac_bbp_get_reply_post_type_supports() {
    $supports = array(
		'editor',
            );
    return $supports;
}
add_filter( 'bbp_get_reply_post_type_supports', 'cne_ac_bbp_get_reply_post_type_supports' );

function cne_ac_bbp_register_reply_post_type( $array ) {
    $array['public'] = false;
    
    return $array;
}
add_filter( 'bbp_register_reply_post_type', 'cne_ac_bbp_register_reply_post_type' );

function edit_form_top_reply() {
    if ( bbp_get_reply_post_type() === get_current_screen()->post_type ) {
       echo "<h3>". bbp_get_reply_topic_title()."</h3>";
    }
}
add_action( 'edit_form_top', 'edit_form_top_reply' );

function cne_ac_bbp_admin_replies_column_headers( $columns ) {
    $columns['bbp_reply_forum'] = __( 'Área de Conteúdo', 'cne-ac' );
    $columns['bbp_reply_created'] = __( 'Criado em', 'cne-ac' );
    
    return $columns;
}
add_filter( 'bbp_admin_replies_column_headers', 'cne_ac_bbp_admin_replies_column_headers' );

function cne_ac_manage_users_columns( $columns ) {
    $columns['bbp_user_role'] = __( 'Função no Ambiente Colaborativo', 'bbpress' );

    return $columns;
}
add_filter( 'manage_users_columns', 'cne_ac_manage_users_columns', 11);

/* === PERMISSOES DE ACESSO === */

function cne_ac_bbp_get_caps_for_role( $caps, $role ){
    switch ( $role ) {
        case bbp_get_keymaster_role() :
            $caps['manage_options'] = true;
            $caps['edit_posts'] = true;
            $caps['edit_users'] = true;
            $caps['edit_published_pages'] = true;
            $caps['edit_others_pages'] = true;
            $caps['create_users'] = true;
            $caps['list_users'] = true;
            $caps['delete_users'] = true;
            $caps['promote_users'] = true;
            $caps['upload_files'] = true;
            $caps['trash_topics'] = true;
            $caps['trash_replies'] = true;
            $caps['unfiltered_html'] = true;
            break;
        case bbp_get_moderator_role() :
            $caps['moderate'] = false;
            $caps['throttle'] = false;
            $caps['view_trash'] = false;
            $caps['publish_forums'] = false;
            $caps['edit_forums'] = false;
            $caps['read_hidden_forums'] = false;
            $caps['edit_others_topics'] = false;
            $caps['delete_topics'] = false;
            $caps['delete_others_topics'] = false;
            $caps['read_private_topics'] = false;
            $caps['edit_others_replies'] = false;
            $caps['delete_replies'] = false;
            $caps['delete_others_replies'] = false;
            $caps['read_private_replies'] = false;
            $caps['manage_topic_tags'] = false;
            $caps['edit_topic_tags'] = false;
            $caps['assign_topic_tags'] = false;
            
            $caps['cne_ac_contributor'] = true;
            $caps['upload_files'] = true;
            $caps['edit_others_pages'] = true;
            $caps['edit_published_pages'] = true;
            $caps['trash_topics'] = true;
            $caps['trash_replies'] = true;
            $caps['unfiltered_html'] = true;
            
            break;
        case bbp_get_participant_role() :
            $caps['trash_topics'] = true;
            $caps['trash_replies'] = true;
            $caps['unfiltered_html'] = true;
            break;
    }
    
    return $caps;
}
add_filter( 'bbp_get_caps_for_role', 'cne_ac_bbp_get_caps_for_role', 100, 2 );

function cne_ac_name_roles( $roles ) {
    if( isset( $roles ) ) :
        
        if( isset( $roles['bbp_keymaster'] ) )
            $roles['bbp_keymaster']['name'] = __( 'AC - Administrador', 'cne_ac' );
        if( isset( $roles['bbp_participant'] ) )
            $roles['bbp_participant']['name'] = __( 'AC - Participante', 'cne_ac' );
        if( isset( $roles['bbp_blocked'] ) )
            unset($roles['bbp_blocked'] );
        if( isset( $roles['bbp_spectator'] ) )
            unset($roles['bbp_spectator'] );
        if( isset( $roles['bbp_moderator'] ) )
            $roles['bbp_moderator']['name'] = __( 'AC - Colaborador', 'cne_ac' );

    endif;
    return $roles;
}
add_filter( 'bbp_get_dynamic_roles', 'cne_ac_name_roles' );

function cne_ac_remove_bbpress_roles(){

    if( get_role('bbp_blocked') ) {
        remove_role( 'bbp_blocked' );
    }
    if( get_role('bbp_spectator') ) {
        remove_role( 'bbp_spectator' );
    }
    
}
add_action( 'after_setup_theme', 'cne_ac_remove_bbpress_roles' );

function cne_ac_bbp_kses_allowed_tags( $allowed_tags ) {
    $add_allowed_tags = array(
                            'h1'         => array(),
                            'h2'         => array(),
                            'h3'         => array(),
                            'h4'         => array(),
                            'h5'         => array(),
                            'h6'         => array(),
                            'hr'         => array(),
                            'table'      => array(),
                            'tbody'      => array(),
                            'tfoot'      => array(),
                            'thead'      => array(),
                            'tr'         => array(),
                            'td'         => array(
                                'colspan'   => true,
                                'rowspan'   => true,
                                ),
                            'th'          => array(
                                'colspan'      => true,
                                'rowspan'   => true,
                                ),
                            );
    $new_tags = bbp_parse_args( $add_allowed_tags, $allowed_tags );
    return $new_tags;
}
add_filter( 'bbp_kses_allowed_tags', 'cne_ac_bbp_kses_allowed_tags' );

//add_action( 'edit_user_profile', 'remove_my_class_action',11 );
//function remove_my_class_action(){

//die(var_dump(class_exists('BBP_Users_Admin')));
//	$result = remove_action( 'edit_user_profile', array( 'BBP_Users_Admin', 'secondary_role_display' ), 10 );
        //die(var_dump($result));
//}


function cne_ac_secondary_role_display( $profileuser ) {
    //die(var_dump($result));
		// Bail if current user cannot edit users
		if ( ! current_user_can( 'edit_user', $profileuser->ID ) )
			return;

		// Get the roles
		$dynamic_roles = bbp_get_dynamic_roles();

		// Only keymasters can set other keymasters
		if ( ! bbp_is_user_keymaster() )
			unset( $dynamic_roles[ bbp_get_keymaster_role() ] ); ?>

		<h3><?php esc_html_e( 'Colaboração', 'cne_ac' ); ?></h3>

		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="bbp-forums-role"><?php esc_html_e( 'Função no Ambiente Colaborativo', 'cne_ac' ); ?></label></th>
					<td>

						<?php $user_role = bbp_get_user_role( $profileuser->ID ); ?>

						<select name="bbp-forums-role" id="bbp-forums-role">

							<?php if ( ! empty( $user_role ) ) : ?>

								<option value=""><?php esc_html_e( '&mdash; Nenhuma função no ambiente colaborativo &mdash;', 'cne_ac' ); ?></option>

							<?php else : ?>

								<option value="" selected="selected"><?php esc_html_e( '&mdash; Nenhuma função no ambiente colaborativo &mdash;', 'bbpress' ); ?></option>

							<?php endif; ?>

							<?php foreach ( $dynamic_roles as $role => $details ) : ?>

								<option <?php selected( $user_role, $role ); ?> value="<?php echo esc_attr( $role ); ?>"><?php echo translate_user_role( $details['name'] ); ?></option>

							<?php endforeach; ?>

						</select>
					</td>
				</tr>

			</tbody>
		</table>

		<?php
	}
        //add_action( 'edit_user_profile', 'cne_ac_secondary_role_display', 10 );


/*function teste( $caps, $role ) {
    die(var_dump($role));
}
add_filter( 'bbp_get_caps_for_role', 'teste', 10, 2 );*/

/*function cne_ac_forum_title_icons() {
    global $post;

    if ( has_post_thumbnail($id_post) ) {
        //echo get_the_post_thumbnail($id_post, array( 290,220 ), array('class' => 'forum-icon'));
        echo the_post_thumbnail();
    } else {
        ?>
        <img src="<?php echo bloginfo('stylesheet_directory'); ?>/assets/img/logo-cne.png">
        <?php
    }
}
add_action('bbp_theme_before_forum_header_title','cne_ac_forum_title_icons');

/* ------------------------------------------------------------------------------- */ 
        
function cne_ac_current_user_can_edit_delete() {
    $user_can_edit_delete = false;
  if ( bp_is_my_profile() || bbp_is_user_keymaster() ) {
    $user_can_edit_delete = true;
  }
  return $user_can_edit_delete;
}
  

// Adicionar um shortcode para add o formulario de "Novo Topico" em uma pagina
function cne_ac_bbp_create_new_topic(){

    $forum_id = isset($_GET['area_id']) ? (int)$_GET['area_id'] : 0; 
    
    if( cne_ac_is_forum_id_valid( $forum_id ) ) {
        return do_shortcode( "[cne-ac-bbp-topic-form forum_id=".$forum_id."]" );
    } else {
        bbp_get_template_part( 'feedback' , 'no-forum');
    }

}
add_shortcode('cne-ac-bbp-form-novo-topico', 'cne_ac_bbp_create_new_topic', 10);

function cne_ac_get_topic_forum_id() {
    $id = 0;
    if( bbp_is_topic_edit() ) {
        $id = bbp_get_topic_forum_id();
    } else {
        $id = cne_ac_is_forum_id_valid( $_GET['area_id'] );
    }
    
    return $id;
}

// Verifica se o ID informado eh valido (id eh inteiro, post existe e post eh do tipo certo)
function cne_ac_is_forum_id_valid( $forum_id ) {
    $id = 0;

    $forum = get_post( (int)$forum_id);
    
    if( $forum && $forum->post_type === bbp_get_forum_post_type() ) {
        $id = $forum->ID;
    }

    return $id;
}


// Desativa breadcrumb do plugin
add_filter( 'bbp_no_breadcrumb', '__return_true' );

// Conta quantos usuarios marcaram um topico como favorito
function cne_ac_bbp_topic_like_count( ) {
    $users = bbp_get_topic_favoriters();
    echo count($users);
}


/*function cne_ac_bbp_topic_subscriber_count( ) {
    $users = bbp_get_topic_subscribers();
    echo count($users);
}*/

function cne_bbp_header_title() {
    if( bbp_get_topic_id() ) {
            bbp_topic_title();
    } else {
            bbp_forum_title();
    }
}

/*
 * Adiciona shortcode para visualizar topicos recentes
 */ 
add_shortcode('cne-ac-bbp-topicos-recentes', 'cne_ac_bbp_new_topics', 10);
function cne_ac_bbp_new_topics() {
    bbp_get_template_part( 'loop', 'new-topics' );
}

function cne_bbp_new_topics_forum() {
    if ( bbp_has_topics( array( 'post_parent' => bbp_get_forum_id(), 'order' => 'DESC', 'posts_per_page' => 10, 'show_stickies' => false, 'max_num_pages'=>1 ) ) )
        bbp_get_template_part( 'bbpress/loop-single', 'topic' );
}

/*
 * Exibe a idade cadastrada ao criar/editar topico
 */ 
function cne_bbp_form_topic_age() {
    echo cne_bbp_get_form_topic_age();
}
    /*
     * Retorna a idade cadastrada
     */
    function cne_bbp_get_form_topic_age() {

            // Get _POST data
            if ( bbp_is_post_request() && isset( $_POST['cne_bbp_topic_age'] ) ) {
                    $topic_age = $_POST['cne_bbp_topic_age'];

            // Get edit data
            } elseif ( bbp_is_topic_edit() ) {
                    $topic_age = get_post_meta( bbp_get_topic_id(), 'cne_bbp_topic_age', true);

            // No data
            } else {
                    $topic_age = '';
            }

            return esc_attr( $topic_age );
    }
    
function cne_ac_topic_age() {
    echo cne_ac_get_topic_age();
}

function cne_ac_get_topic_age() {
    $show_age = get_post_meta(bbp_get_topic_id(), 'cne_bbp_topic_age', true);
    $age = '';
    if( $show_age == 'yes' ) {
        $author_id = bbp_get_topic_author_id();
        if( $author_id ) {
            $birth_date = bp_get_member_profile_data( array( 'field'=>'Data de nascimento', 'user_id' => $author_id ) );
            if( $birth_date ) {
                $date = new DateTime($birth_date);
                $age = $date->diff(new DateTime())->y;
            }
        }
    }
    return $age;
}
        
function cne_bbp_form_topic_city() {
    echo cne_bbp_get_form_topic_city();
}
function cne_bbp_get_form_topic_city() {
    if ( bbp_is_post_request() && isset( $_POST['cne_bbp_topic_city'] ) ) {
            $topic_city = $_POST['cne_bbp_topic_city'];
    } elseif ( bbp_is_topic_edit() ) {
            $topic_city = get_post_meta( bbp_get_topic_id(), 'cne_bbp_topic_city', true);
    } else {
            $topic_city = '';
    }

    return esc_attr( $topic_city );
}

function cne_bbp_form_topic_objective() {
    echo cne_bbp_get_form_topic_objective();
}

function cne_bbp_get_form_topic_objective() {
    if ( bbp_is_post_request() && isset( $_POST['cne_bbp_topic_objective'] ) ) {
            $topic_objective = $_POST['cne_bbp_topic_objective'];
    } elseif ( bbp_is_topic_edit() ) {
            $topic_objective = get_post_meta( bbp_get_topic_id(), 'cne_bbp_topic_objective', true);
    } else {
            $topic_objective = '';
    }
    
    return apply_filters( 'cne_bbp_get_form_topic_objective', esc_attr( $topic_objective ) );
}

function cne_bbp_form_topic_author() {
	echo cne_bbp_get_form_topic_author();
}

function cne_bbp_get_form_topic_author() {
    if ( bbp_is_post_request() && isset( $_POST['cne_bbp_topic_author'] ) ) {
            $topic_author = $_POST['cne_bbp_topic_author'];
    } elseif ( bbp_is_topic_edit() ) {
            $topic_author = get_post_meta( bbp_get_topic_id(), 'cne_bbp_topic_author', true);
    } else {
            $topic_author = '';
    }

    return apply_filters( 'cne_bbp_get_form_topic_author', esc_attr( $topic_author ) );
}

function cne_bbp_form_topic_image() {
	echo cne_bbp_get_form_topic_image();
}
function cne_bbp_get_form_topic_image() {
    if ( bbp_is_post_request() && isset( $_POST['cne_bbp_topic_image'] ) ) {
            $topic_image = $_POST['cne_bbp_topic_image'];
    } elseif ( bbp_is_topic_edit() ) {
            $topic_image = get_post_meta( bbp_get_topic_id(), 'cne_bbp_topic_image', true);
    } else {
            $topic_image = '';
    }

    return esc_attr( $topic_image );
}

function cne_bbp_form_topic_desc() {
	echo cne_bbp_get_form_topic_desc();
}
function cne_bbp_get_form_topic_desc() {
    if ( bbp_is_post_request() && isset( $_POST['cne_bbp_topic_desc'] ) ) {
            $topic_desc = $_POST['cne_bbp_topic_desc'];
    } elseif ( bbp_is_topic_edit() ) {
            $topic_desc = get_post_meta( bbp_get_topic_id(), 'cne_bbp_topic_desc', true);
    } else {
            $topic_desc = '';
    }

    return esc_attr( $topic_desc );
}

function cne_ac_bbp_validate_custom_fields( $post_id ) {
    
    $author = isset( $_POST['cne_bbp_topic_author'] ) ? $_POST['cne_bbp_topic_author'] : '' ;
    $desc = isset( $_POST['cne_bbp_topic_desc'] ) ? $_POST['cne_bbp_topic_desc'] : '';
    $city = isset( $_POST['cne_bbp_topic_city'] ) ? $_POST['cne_bbp_topic_city'] : ''; //publico
    $objective = isset( $_POST['cne_bbp_topic_objective'] ) ? $_POST['cne_bbp_topic_objective'] : ''; //privado
    //$image = isset( $_POST['cne_bbp_topic_image'] ) ? $_POST['cne_bbp_topic_image'] : '';
    
    $is_private = cne_ac_is_secao_privado( bbp_get_topic_forum_id( $post_id ) );
    
    if ( empty( $desc ) ) :
        bbp_add_error( 'bbp_topic_desc', __( '<strong>Erro</strong>: Seu tópico precisa de uma descrição.', 'cne-ac' ) );
    endif;
    
    if( $is_private && empty( $objective ) ) :
        bbp_add_error( 'bbp_topic_objective', __( '<strong>Erro</strong>: Seu tópico precisa ter um objetivo.', 'cne-ac' ) );
    endif;
                
    if( ( strlen( $desc ) > 160 ) || ( strlen( $author ) > 100 ) || ( $is_private && strlen( $objective ) > 255 ) || ( !$is_private && strlen( $city ) > 100 ) ) :
        bbp_add_error( 'bbp_topic_maxlength', __( '<strong>Erro</strong>: Algum campo excede o limite de caracteres. Por favor, revise o formulário.', 'cne-ac' ) );
    endif;
    
    /*if ( !empty( $image ) && !validate_file( $image, array( '.jpg', '.jpeg', '.png' ) ) ) :
        bbp_add_error( 'bbp_topic_desc', __( '<strong>Erro</strong>: Por favor, adicione uma imagem em um dos seguintes extenções: jpg, jpeg ou png.', 'cne-ac' ) );
    endif;
    $teste = wp_check_filetype( $image, array( 'jpg', 'jpeg', 'png' ) );*/
        
}
add_action( 'bbp_new_topic_pre_extras', 'cne_ac_bbp_validate_custom_fields' );
add_action( 'bbp_edit_topic_pre_extras', 'cne_ac_bbp_validate_custom_fields' );

function cne_ac_remove_validate_forum_id() {
    if( bbp_has_errors() ) {
       bbpress()->errors->remove('bbp_topic_forum_id');
    }
}
add_action( 'bbp_edit_topic_pre_extras', 'cne_ac_remove_validate_forum_id' );

function cne_ac_bbp_edit_topic_pre_insert( $array ) {
    $array['post_parent'] = bbp_get_topic_forum_id( $array['ID'] );
    
    return $array;
}
add_filter( 'bbp_edit_topic_pre_insert', 'cne_ac_bbp_edit_topic_pre_insert' ); 

add_action ( 'bbp_new_topic', 'cne_bbp_save_custom_fields', 10, 1 );
add_action ( 'bbp_edit_topic', 'cne_bbp_save_custom_fields', 10, 1 );

function cne_ac_add_filter_topic_content( $deprecated, $attr, $content = null ) {
    return $content;
}
add_filter( 'img_caption_shortcode', 'cne_ac_add_filter_topic_content', 10, 3 );

add_filter( 'disable_captions', '__return_true' );

function cne_bbp_save_custom_fields( $post_id ) {
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $file_handler = 'cne_bbp_topic_image'; //Form attachment Field name.
    $attach_id = media_handle_upload( $file_handler, $post_id );
    //making it featured!
    set_post_thumbnail($post_id, $attach_id );

    $author = $_POST['cne_bbp_topic_author'];
    $desc = $_POST['cne_bbp_topic_desc'];
    $age = isset( $_POST['cne_bbp_topic_age'] ) && $_POST['cne_bbp_topic_age'] == 'yes' ? 'yes' : 'no'; //publico
    $city = $_POST['cne_bbp_topic_city']; //publico
    $objective = $_POST['cne_bbp_topic_objective']; //privado
    
    $is_private = cne_ac_is_secao_privado( bbp_get_topic_forum_id( $post_id ) );
            
    if ( !$is_private ) {
        update_post_meta( $post_id, 'cne_bbp_topic_age', sanitize_text_field( $age ) );
    }
    if ( !$is_private && !empty( $city ) ) {
        update_post_meta( $post_id, 'cne_bbp_topic_city', sanitize_text_field( $city ) );
    }
    if ( !empty( $author ) ) {
        update_post_meta( $post_id, 'cne_bbp_topic_author', sanitize_text_field( $author ) );
    }
    update_post_meta( $post_id, 'cne_bbp_topic_desc', sanitize_text_field( $desc ) );
    if ( $is_private ) {
        update_post_meta( $post_id, 'cne_bbp_topic_objective', sanitize_text_field( $objective ) );
    } else {

    }
}

function cne_ac_button_topic_parent() {
    global $post;
    if( $post->post_parent ) {
        echo '<a href="' . esc_url( bbp_get_topic_permalink( $post->post_parent ) ) . '" class="btn btn-default pull-right" role="button"><i class="fa fa-arrow-left"></i> ' . bbp_get_topic_title( $post->post_parent ) . '</a>';
    }    
}

function custom_bbp_show_lead_topic( $show_lead ) {
  $show_lead[] = 'true';
  return $show_lead;
}
 
add_filter('bbp_show_lead_topic', 'custom_bbp_show_lead_topic' );

function cne_ac_custom_bbp_topic_tag_list() {
    $args = array( 
                'before' => '', 
                'sep'    => ', ', 
                'after'  => '' 
            );
    
    return bbp_topic_tag_list( 0, $args );                 
}

//customiza o link de retorno da funcao bbp_get_reply_to_link()
function cne_ac_custom_bbp_reply_to_link( $retval, $r ) {
    $r['reply_text'] = '<i class="fa fa-reply" title="'. __( 'Responder', 'cne-ac' ).'"></i>';
    
    $reply = bbp_get_reply( bbp_get_reply_id( (int) $r['id'] ) );
    
    if ( bbp_thread_replies() ) {

            $move_form = array(
                    $r['add_below'] . '-' . $reply->ID,
                    $reply->ID,
                    $r['respond_id'],
                    $reply->post_parent
            );

            $onclick  = ' onclick="return addReply.moveForm(\'' . implode( "','", $move_form ) . '\');"';

    } else {
            $onclick  = '';
    }
    
    $retval   = $r['link_before'] . '<a href="' . esc_url( $r['uri'] ) . '" class="bbp-reply-to-link"' . $onclick . '>' . $r['reply_text'] . '</a>' . $r['link_after'];
    
    return $retval;
}
add_filter( 'bbp_get_reply_to_link', 'cne_ac_custom_bbp_reply_to_link', 10, 2);

function cne_ac_custom_bbp_topic_favorite_link( $args ) {
    $args['before'] = __('Gostou?', 'cne-ac');
    //$args['after'] = '</span>';
    $args['favorite'] = '<i class="fa fa-heart-o" aria-hidden="true"></i>';
    $args['favorited'] = '<i class="fa fa-heart" aria-hidden="true"></i>';   
    
    return $args;
}

add_filter( 'bbp_after_get_forum_favorite_link_parse_args', 'cne_ac_custom_bbp_topic_favorite_link');
add_filter( 'bbp_before_get_user_favorites_link_parse_args', 'cne_ac_custom_bbp_topic_favorite_link');

function cne_ac_get_topic_share_link() {
    _e('Compartilhe:', 'cne-ac');
    echo '<a href="http://www.facebook.com/sharer.php?u=' . get_permalink() . '" class="cne-btn-circle facebook" target="_blank" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
    echo '<a href="http://twitter.com/share?url=' . get_permalink() . '" class="cne-btn-circle twitter" target="_blank" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
    echo '<a href="https://plus.google.com/share?url=' . get_permalink() . '" class="cne-btn-circle googleplus" target="_blank" title="Google+"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
    echo '<a href="mailto:?subject='.the_title(null,null,false).'&body='.get_permalink().'" class="cne-btn-circle email" target="_blank" title="E-mail"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
}

function cne_ac_get_topic_alert_link() {
    if( is_user_logged_in() ) :
        $args['report_text'] = esc_html__( 'Denunciar', 'cne-ac' );
        $args['unreport_text'] = esc_html__( 'Remover denúncia', 'cne-ac' );

        $topic = bbp_get_topic( bbp_get_topic_id() );

        if ( empty( $topic ) )
                return;

        $reported = cne_ac_is_topic_reported( $topic->ID );

        if ( $reported && ! current_user_can( 'moderate', $topic->ID ) ) {
                return;
        }

        $uri     = add_query_arg( array( 'action' => 'cne_ac_bbp_toggle_topic_report', 'topic_id' => $topic->ID ) );
        $uri     = wp_nonce_url( $uri, 'report-topic_' . $topic->ID );
        if ( $reported === true ) {
                $title = __( 'Remover denúncia deste tópico', 'cne-ac' );
                $label = __('Remover denúncia:', 'cne-ac');
                $class = 'fa fa-eraser';
        } else {
                $title = __( 'Denunciar este tópico', 'cne-ac' );
                $label = __('Denunciar:', 'cne-ac');
                $class = 'fa fa-bullhorn';
        }
        $retval  = '<a href="' . esc_url( $uri ) . '" class="cne-btn-circle cne-alert" title="' . esc_attr( $title ) . '"><i class="'. esc_attr( $class ) . '" aria-hidden="true"></i></a>';

        echo esc_html( $label );
        echo $retval;
        
    endif;
}

function cne_ac_get_reply_alert_link() {
    if( is_user_logged_in() ) :
        $args['report_text'] = esc_html__( 'Denunciar', 'cne-ac' );
        $args['unreport_text'] = esc_html__( 'Remover denúncia', 'cne-ac' );

        $reply = bbp_get_reply( bbp_get_reply_id() );

        if ( empty( $reply ) )
                return;

        $reported = cne_ac_is_reply_reported( $reply->ID );

        if ( $reported && ! current_user_can( 'moderate', $reply->ID ) ) {
                return;
        }

        $uri     = add_query_arg( array( 'action' => 'cne_ac_bbp_toggle_reply_report', 'reply_id' => $reply->ID ) );
        $uri     = wp_nonce_url( $uri, 'report-reply_' . $reply->ID );
        if ( $reported === true ) {
                $title = __( 'Remover denúncia deste comentário', 'cne-ac' );
                $label = __('Remover denúncia:', 'cne-ac');
                $class = 'fa fa-eraser';
        } else {
                $title = __( 'Denunciar este comentário', 'cne-ac' );
                $label = __('Denunciar:', 'cne-ac');
                $class = 'fa fa-bullhorn';
        }
        $retval   = '<a href="' . esc_url( $uri ) . '" class="cne-btn-circle cne-alert" title="' .esc_attr( $title ) . '"><i class="'. esc_attr( $class ) . '" aria-hidden="true"></i></a>';
        
        echo $retval;
        
    endif;
    
}

function cne_ac_remove_meta_boxes() {
    remove_meta_box( 'bbp_forum_attributes' , bbp_get_forum_post_type(), 'side');
    remove_meta_box( 'bbp_topic_attributes' , bbp_get_topic_post_type(), 'side');
    remove_meta_box( 'bbp_reply_attributes' , bbp_get_reply_post_type(), 'side');
}
add_action( 'do_meta_boxes' , 'cne_ac_remove_meta_boxes' );

function cne_ac_add_meta_boxes() {
    add_meta_box(
        'cne_ac_attributes',
        __( 'Área de Conteúdo Atributos', 'cne_ac' ),
        'cne_ac_custom_meta_box_forum',
        bbp_get_forum_post_type(),
        'side',
        'high'
    );
    
    add_meta_box(
        'cne_ac_attributes',
        __( 'Informações Adicionais', 'cne_ac' ),
        'cne_ac_custom_meta_box_topic',
        bbp_get_topic_post_type(),
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'cne_ac_add_meta_boxes' );

function cne_ac_custom_meta_box_topic( $post ) {

    //seguranca
    wp_nonce_field( basename( __FILE__ ), 'cne_ac_meta_boxes_topic_nonce' );
    
    //verifica o tipo da secao para mostrar os campos corretos
    $is_private = cne_ac_is_secao_privado( bbp_get_topic_forum_id( $post->ID ) ); 
    
    $value_author = get_post_meta($post->ID, "cne_bbp_topic_author", true );
    
    $value_desc = get_post_meta($post->ID, "cne_bbp_topic_desc", true );
    
    if( $is_private ) {
        $value_objective = get_post_meta($post->ID, "cne_bbp_topic_objective", true );
        echo '<div class="cne-metabox-div">'; 
            echo '<div class="cne-metabox-div-label">'; 
                echo '<label for="cne-topic-objective" class="cne-metabox-label">';
                    _e( 'Objetivo (Número de caracteres permitidos: 255)', 'cne-ac' );
                echo '<span class="cne-required"> *</span></label> ';
            echo '</div>';
            echo '<div class="cne-metabox-div-input">'; 
                echo '<input type="text"  id="cne-topic-objective" name="cne_bbp_topic_objective" class="cne-metabox-input" value="'.esc_attr( $value_objective ).'" />';
            echo '</div>';
        echo '</div>';
    } else {
        $value_age = get_post_meta($post->ID, "cne_bbp_topic_age", true );
        
        $value_city = get_post_meta($post->ID, "cne_bbp_topic_city", true );
        
        echo '<div class="cne-metabox-div">'; 
            echo '<div class="cne-metabox-div-label">'; 
                echo '<label for="cne-topic-age" class="cne-metabox-label">';
                    _e( 'Idade', 'cne-ac' );
                echo '</label> ';
            echo '</div>';
            echo '<div class="cne-metabox-div-input">'; 
            echo '<input type="checkbox" name="cne_bbp_topic_age" id="cne-topic-age" value="yes"' . checked( $value_age, 'yes', false ) .' />';
            _e( 'Mostrar idade atual do autor do tópico', 'cne-ac' );
            echo '</div>';
        echo '</div>';
        
        echo '<div class="cne-metabox-div">'; 
            echo '<div class="cne-metabox-div-label">'; 
                echo '<label for="cne-topic-city" class="cne-metabox-label">';
                    _e( 'Cidade (Número de caracteres permitidos: 100)', 'cne-ac' );
                echo '</label> ';
            echo '</div>';
            echo '<div class="cne-metabox-div-input">'; 
                echo '<input type="text"  id="cne-topic-city" name="cne_bbp_topic_city" class="cne-metabox-input" value="'.esc_attr( $value_city ).'" />';
            echo '</div>';
        echo '</div>';
    }
    
    echo '<div class="cne-metabox-div">'; 
        echo '<div class="cne-metabox-div-label">'; 
            echo '<label for="cne-topic-author" class="cne-metabox-label">';
                _e( 'Autor Original (Número de caracteres permitidos: 100) - Antes de compartilhar o material de outra pessoa, solicite sua autorização.', 'cne-ac' );
            echo '</label> ';
        echo '</div>';
        echo '<div class="cne-metabox-div-input">'; 
            echo '<input type="text"  id="cne-topic-author" name="cne_bbp_topic_author" class="cne-metabox-input" value="'.esc_attr( $value_author ).'" />';
        echo '</div>';
    echo '</div>';
    
    echo '<div class="cne-metabox-div">'; 
        echo '<div class="cne-metabox-div-label">'; 
            echo '<label for="cne-topic-desc" class="cne-metabox-label">';
                _e( 'Breve Descrição (Número de caracteres permitidos: 160)', 'cne-ac' );
            echo '<span class="cne-required"> *</span></label> ';
        echo '</div>';
        echo '<div class="cne-metabox-div-input">'; 
            echo '<input type="text"  id="cne-topic-desc" name="cne_bbp_topic_desc" class="cne-metabox-input" value="'.esc_attr( $value_desc ).'" />';
        echo '</div>';
    echo '</div>';
    
}

function cne_ac_custom_meta_box_forum( $post ) {

    //seguranca
    wp_nonce_field( basename( __FILE__ ), 'cne_ac_meta_boxes_nonce' );

    //label
    echo '<strong class="label" for="cne_ac_tipo_label_mb">';
        esc_html_e('Tipo:', 'cne_ac' );
    echo '</strong> ';
    
    //select
    echo '<select name="cne-ac-tipo-drop-mb">';

        $array = array(
           'publico'    =>  __( 'Público', 'cne_ac' ), 
           'privado'    =>  __( 'Privado', 'cne_ac' )
        );
        $option_selected = get_post_meta($post->ID, "cne_ac_secao_tipo", true );
        foreach($array as $key => $value) {
            echo '<option value="'.$key.'" ' . selected( $option_selected, $key, false ) . '>' . $value . '</option>';
        }
        
    echo '</select>';
    
    //ip
    echo '<input name="ping_status" type="hidden" id="ping_status" value="open" />';
}

/*
 * Salva os dados do Custom Meta Box
 */ 
function cne_ac_meta_boxes_save( $post_id, $post ) {
    
    if( !is_admin() ) 
        return;
    
    if ( !isset( get_current_screen()->post_type ) ) 
        return;
                
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
                
    if( !('POST' === strtoupper( $_SERVER['REQUEST_METHOD'] )) )
        return;
                
    if( bbp_get_forum_post_type() == get_current_screen()->post_type ) {
        $nonce_valido = ( isset( $_POST[ 'cne_ac_meta_boxes_nonce' ] ) && wp_verify_nonce( $_POST[ 'cne_ac_meta_boxes_nonce' ], basename( __FILE__ ) ) ) ? true : false;
        if( !$nonce_valido || !current_user_can( 'edit_forums', $post_id ) ) {
            return;
        }
        
        cne_ac_meta_boxes_forum_save( $post_id );
        
    } elseif( bbp_get_topic_post_type() == get_current_screen()->post_type ) {
        $nonce_valido = ( isset( $_POST[ 'cne_ac_meta_boxes_topic_nonce' ] ) && wp_verify_nonce( $_POST[ 'cne_ac_meta_boxes_topic_nonce' ], basename( __FILE__ ) ) ) ? true : false;
        if( !$nonce_valido || !current_user_can( 'edit_topics', $post_id ) ) {
            return;
        }
        
        cne_ac_meta_boxes_topic_save( $post_id );
    }
    
        
}
add_action( 'save_post', 'cne_ac_meta_boxes_save', 10, 2 );

function cne_ac_meta_boxes_forum_save( $post_id ) {
    if( isset( $_POST['cne-ac-tipo-drop-mb'] ) ) {
        $tipo = sanitize_text_field( $_POST['cne-ac-tipo-drop-mb'] );
        $tipo = $tipo == 'privado' ? 'privado' : 'publico';
        update_post_meta( $post_id, 'cne_ac_secao_tipo', $tipo );
    }
}

function cne_ac_meta_boxes_topic_save( $post_id ) {
    
    $age = sanitize_text_field( isset( $_POST['cne_bbp_topic_age'] ) && $_POST['cne_bbp_topic_age'] == 'yes' ? 'yes' : 'no' );
    $city = sanitize_text_field( isset( $_POST['cne_bbp_topic_city'] ) ? stripslashes( $_POST['cne_bbp_topic_city'] ) : '' );
    $objective = sanitize_text_field( isset( $_POST['cne_bbp_topic_objective'] ) ? stripslashes( $_POST['cne_bbp_topic_objective'] ) : '' );
    $desc = sanitize_text_field( isset( $_POST['cne_bbp_topic_desc'] ) ? stripslashes( $_POST['cne_bbp_topic_desc'] ) : '' );
    $author = sanitize_text_field( isset( $_POST['cne_bbp_topic_author'] ) ? stripslashes( $_POST['cne_bbp_topic_author'] ) : '' );
    
    
    global $form_error;
     
    $form_error = new WP_Error;

    $is_private = cne_ac_is_secao_privado( bbp_get_topic_forum_id( $post_id ) ); 
    
    if ( empty( $desc ) || ( $is_private && empty( $objective ) ) ) :
        $form_error->add( 'required', __( 'Algum campo obrigatório não foi preenchido. Por favor, revise o formulário.', 'cne-ac' ) );
    endif;
                
    if( ( strlen( $desc ) > 160 ) || ( strlen( $author ) > 100 ) || ( $is_private && strlen( $objective ) > 255 ) || ( !$is_private && strlen( $city ) > 100 ) ) :
        $form_error->add( 'maxlength', __( 'Algum campo excede o limite de caracteres. Por favor, revise o formulário.', 'cne-ac' ) );
    endif;

    if( !empty( $form_error->get_error_messages() ) ) {   

        if( get_post_status($post_id) != 'draft' ){
            remove_action('save_post', 'cne_ac_meta_boxes_save' );
            wp_update_post( array( 'ID' => $post_id, 'post_status' => 'draft' ) );
            add_action('save_post', 'cne_ac_meta_boxes_save' );
        }

        $list_error = '<ul>';
        foreach ( $form_error->get_error_messages() as $error ) {
            $list_error .= '<li>' . $error . '</li>';
        }
        $list_error .= '</ul>';
        $list_error .= '<p>'.__('Observação: O post foi salvo como rascunho', 'cne-ac').'</p>';
        wp_die( $list_error, __( 'Erro ao atualizar tópico', 'cne-ac'), array( 'back_link' => true ));

    }
    
    if( $is_private ) {
        update_post_meta( $post_id, 'cne_bbp_topic_objective', addslashes( $objective ) );
    } else {
        update_post_meta( $post_id, 'cne_bbp_topic_age', $age );
        update_post_meta( $post_id, 'cne_bbp_topic_city', addslashes( $city ) );
    }
    update_post_meta( $post_id, 'cne_bbp_topic_desc', addslashes( $desc ) );
    update_post_meta( $post_id, 'cne_bbp_topic_author', addslashes( $author ) );
    
}

function cne_ac_get_list_meta_values( $meta_key = '' ) {
    global $wpdb;
    
    if( empty( $meta_key ) ) 
        return;
    
    $meta_values = $wpdb->get_col( $wpdb->prepare( 
                                    "SELECT DISTINCT meta_value
                                    FROM {$wpdb->postmeta} 
                                    WHERE meta_key = '%s'", $meta_key ) );
    return $meta_values;
}

function cne_ac_get_list_post_ids( $meta_key = '', $meta_value = '', $post_type = '' ) {
    global $wpdb;
    
    if( empty( $post_type ) ) {
        return;
    } else {
        if( !empty( $meta_key ) && !empty( $meta_key ) )
            $sql = $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} INNER JOIN {$wpdb->posts} ON post_id = id WHERE meta_key = '%s' AND meta_value='%s' AND post_type='%s'", $meta_key, $meta_value, $post_type );
        else if( !empty( $meta_key ) )
            $sql = $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} INNER JOIN {$wpdb->posts} ON post_id = id WHERE meta_key='%s' AND AND post_type='%s'", $meta_key, $post_type );
        else if( !empty( $meta_value ) )
            $sql = $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} INNER JOIN {$wpdb->posts} ON post_id = id WHERE meta_value='%s' AND post_type='%s'", $meta_value, $post_type );
        else
            $sql = $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} INNER JOIN {$wpdb->posts} ON post_id = id WHERE post_type='%s'", $post_type );
    }
        
    $posts_id = $wpdb->get_col( $sql );
    
    return $posts_id;
    
}

function cne_ac_display_forums( $attr, $content = '' ) {

    // Sanity check required info
    if ( !empty( $content ) || ( empty( $attr['tipo'] ) ) )
            return $content;

    global $forum;
    
    $forum = cne_ac_get_list_post_ids( 'cne_ac_secao_tipo', $attr['tipo'], bbp_get_forum_post_type() );
    
    if( empty( $forum ) ) {
        bbp_get_template_part( 'feedback', 'no-forums' );
        return $content;
    }
    
    //if ( !bbp_is_forum_archive() ) {
        add_filter( 'bbp_before_has_forums_parse_args', 'cne_ac_custom_bbp_forums_args' ) ;
    //}
    
    

    // Start output buffer
    cne_ac_bbp_start( 'bbp-archive-forum' );

    // Check forum caps
    //if ( bbp_user_can_view_forum( array( 'forum_id' => $forum_id ) ) ) {
    bbp_get_template_part( 'content',  'archive-forum' );

    // Forum is private and user does not have caps
    //} elseif ( bbp_is_forum_private( $forum_id, false ) ) {
    //        bbp_get_template_part( 'feedback', 'no-access'    );
    //}
    
    return cne_ac_bbp_end();
}

add_shortcode('cne-ac-bbp-areas', 'cne_ac_display_forums');

function cne_ac_bbp_start( $query_name = '' ) {
    // Set query name
    bbp_set_query_name( $query_name );

    // Start output buffer
    ob_start();
}

function cne_ac_bbp_end(){
    
    // Reset the query name
    bbp_reset_query_name();

    // Return and flush the output buffer
    return ob_get_clean();
}

function cne_ac_custom_bbp_forums_args( $args ) {
    global $forum;
    
    $args['post__in'] = $forum;  
    
    return $args;
}

//<https://bbpress.org/forums/topic/change-posting-order/>
function cne_ac_reverse_reply_order( $query = array() ) {
    if ( empty( $query ) ) return;
    
    $query['order']='DESC';
    
    return $query;
}
add_filter('bbp_has_replies_query', 'cne_ac_reverse_reply_order');

function cne_ac_get_secao_tipo( $forum_id = 0 ) {
    $forum_id = bbp_get_forum_id( $forum_id );

    $tipo = get_post_meta( $forum_id, 'cne_ac_secao_tipo', true );

    if ( !isset( $tipo ) )
            $tipo = 'publico';

    return $tipo;
}

function cne_ac_is_secao_privado( $forum_id = 0 ) {
    
    $retval = false;

    if ( cne_ac_get_secao_tipo( $forum_id ) == 'privado' )
            $retval = true;

    return $retval;
        
}

function cne_ac_verify_secao_tipo( $retval ) {
    
    if( $retval && (cne_ac_get_secao_tipo() == 'privado') && !bbp_is_user_keymaster() ) :
    
        $retval = false;
    
        if( current_user_can( 'cne_ac_contributor' ) ) :
            $retval = true;
        endif;
            
    endif;
    
    return (bool) $retval;
}
add_filter( 'bbp_current_user_can_access_create_topic_form', 'cne_ac_verify_secao_tipo' );


/* 
 * Baseado no plugin "LS oEmbed support for Scratch Mit", feito por: lenasterg, NTS on CTI.gr. 
 * Disponivel em: <https://br.wordpress.org/plugins/ls-oembed-support-for-scratch-mit/>
 * O código do plugin foi adaptado para embutir somente os links de projetos do scratch adicionados no campo de conteúdo de um topico
 */
function cne_ac_add_embed_scratch( $content ) {
    $args = wp_embed_defaults() ;
   	if ($args['width'] >=485 ) {
		$width='485';
		$height ='402';
	}
	else {
		$width=$args['width'] ;
		$height = round( $width * 402 / 485 );
	}
        
    preg_match_all('/<a\s(.*?)href="(http|https):\/\/scratch.mit.edu\/projects\/(\w+)\/"(.*?)>(.*?)<\/a>/', $content, $matches);
    
    if( $matches ) {
        for( $i = 0; $i < count($matches); $i++ ) :
            $embed = '<div align="center">
		<iframe allowtransparency="true" width="' . $width . '" height="' . $height . '" src="//scratch.mit.edu/projects/embed/' . $matches[3][$i] . '/?autostart=false" '
	    . 'scrolling="no" frameborder="0" '
            . 'allowtransparency="true" allowfullscreen="" mozallowfullscreen="" webkitallowfullscreen=""></iframe>'
		. '</div>';
        
            $content = str_replace($matches[0][$i], $embed, $content);
        
        endfor;
        
    }
    
    return $content;
}
add_filter( 'bbp_get_topic_content', 'cne_ac_add_embed_scratch' );

function cne_ac_remove_html_reply( $content ) {
    $content = bbp_encode_bad( $content );
    $content = bbp_filter_kses( $content );
    
    return $content;
}
add_filter( 'bbp_new_reply_pre_content', 'cne_ac_remove_html_reply' );

/* === MOVER TOPICO PARA LIXEIRA === */
function cne_ac_bbp_get_topic_trash_link( ) {
    $topic   = bbp_get_topic( bbp_get_topic_id() );
    if ( empty( $topic ) || ( !bbp_is_user_keymaster() && !current_user_can( 'trash_topics', $topic->ID ) ) ) {
        return;
    }
    
    
    if( cne_ac_is_topic_reported( $topic->ID ) )
        return;

    if ( bbp_is_topic_trash( $topic->ID ) || !EMPTY_TRASH_DAYS ) {
        return;
    }

    if ( EMPTY_TRASH_DAYS ) {
            $link = '<a title="' . esc_attr__( 'Excluir tópico',      'cne-ac' ) . '" href="' . esc_url( wp_nonce_url( add_query_arg( array( 'action' => 'cne_ac_bbp_toggle_topic_trash', 'sub_action' => 'trash', 'topic_id' => $topic->ID ) ), 'trash-'   . $topic->post_type . '_' . $topic->ID ) ) . '" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash-o"></i></a>';
    }

    return $link;
}

/* === MOVER COMENTARIO PARA LIXEIRA === */
function cne_ac_bbp_get_reply_trash_link( ) {

    $reply   = bbp_get_reply( bbp_get_reply_id() );
    if ( empty( $reply ) || ( !bbp_is_user_keymaster() && !current_user_can( 'trash_replies', $reply->ID ) ) ) {
        return;
    }
    
    
    if( cne_ac_is_reply_reported( $reply->ID ) )
        return;

    if ( bbp_is_reply_trash( $reply->ID ) || !EMPTY_TRASH_DAYS ) {
        return;
    }

    if ( EMPTY_TRASH_DAYS ) {
            $link = '<a title="' . esc_attr__( 'Excluir comentário', 'cne-ac' ) . '" href="' . esc_url( wp_nonce_url( add_query_arg( array( 'action' => 'cne_ac_bbp_toggle_reply_trash', 'sub_action' => 'trash', 'reply_id' => $reply->ID ) ), 'trash-'   . $reply->post_type . '_' . $reply->ID ) ) . '" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash-o"></i></a>';
    }

    return $link;
}

/* === DENUNCIAR CONTEUDO === */
/* 
 * Baseado no plugin "bbpress-report-content", feito por: Josh Eaton <josh@josheaton.org>
 * Disponivel em: <https://br.wordpress.org/plugins/bbpress-report-content/>
 */

function cne_ac_get_post_status_report() {
    return __( 'report', 'cne_ac' );
}

function cne_ac_register_post_status_report() {
    register_post_status(
        cne_ac_get_post_status_report(),
        array(
            'label'                     => _x( 'Denúncias', 'post', 'cne_ac' ),
            'label_count'               => _nx_noop( 'Denúncias <span class="count">(%s)</span>', 'Denúncias <span class="count">(%s)</span>', 'post', 'cne_ac' ),
            'public'                    => true,
            'exclude_from_search'       => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => false
        )
     );
}
add_action( 'bbp_register_post_statuses', 'cne_ac_register_post_status_report' );

function cne_ac_is_topic_reported( $topic_id = 0 ) {
    $topic_status = bbp_get_topic_status( bbp_get_topic_id( (int) $topic_id ) ) === cne_ac_get_post_status_report();
    return (bool) $topic_status;
}

function cne_ac_is_reply_reported( $reply_id = 0 ) {
    $reply_status = bbp_get_reply_status( bbp_get_reply_id( (int) $reply_id ) ) === cne_ac_get_post_status_report();
    return (bool) $reply_status;
}

function cne_ac_add_topic_status_report( $statuses ) {
    $statuses[cne_ac_get_post_status_report()] = _x( 'Denunciar', 'Denunciar este tópico', 'cne_ac' );

    return $statuses;
}
add_filter( 'bbp_get_topic_statuses', 'cne_ac_add_topic_status_report' ); 

        function cne_ac_unreport_post( $post = 0 ) {
            if ( empty( $post ) )
                    return $post;

            if ( cne_ac_get_post_status_report() !== $post->post_status )
                    return false;

            if ( !current_user_can( 'moderate', $post->ID ) )
                    return false;

            $post->post_status = get_post_meta( $post->ID, 'cne_ac_bbp_report_meta_status', true );
            
            if ( empty( $post->post_status ) ) {
                $post->post_status = bbp_get_public_status_id();
            }

            delete_post_meta( $post->ID, 'cne_ac_bbp_report_meta_status' );

            delete_post_meta( $post->ID, 'cne_ac_bbp_report_user_id' );

            remove_action( 'pre_post_update', 'wp_save_post_revision' );

            $post_id = wp_update_post( $post );
            
            return $post_id;
	}
        
        function cne_ac_report_post( $post = 0 ) {

            if ( empty( $post ) )
                    return $post;

            if (cne_ac_get_post_status_report() === $post->post_status )
                    return false;

            update_post_meta( $post->ID, 'cne_ac_bbp_report_user_id', wp_get_current_user()->ID );

            add_post_meta( $post->ID, 'cne_ac_bbp_report_meta_status', $post->post_status );

            $post->post_status = cne_ac_get_post_status_report();

            remove_action( 'pre_post_update', 'wp_save_post_revision' );

            $post_id = wp_update_post( $post );

            return $post_id;
	}
        
        function cne_ac_topic_row_actions( $actions, $topic ) {

		if ( bbp_get_topic_post_type() != get_current_screen()->post_type ) 
                    return $actions;
                
                //retira opcao de fixar topico
		unset( $actions['stick'] );
		unset( $actions['spam'] );

		if ( current_user_can( 'moderate', $topic->ID ) ) {
                    
                        $report_uri  = wp_nonce_url( add_query_arg( array( 'topic_id' => $topic->ID, 'action' => 'cne_ac_bbp_toggle_topic_report' ), remove_query_arg( array( 'bbp_topic_toggle_notice', 'topic_id', 'failed', 'super' ) ) ), 'report-topic_'  . $topic->ID );
			if ( cne_ac_is_topic_reported( $topic->ID ) )
				$actions['report'] = '<a href="' . esc_url( $report_uri ) . '" title="' . esc_attr__( 'Remover denúncia deste tópico', 'cne-ac' ) . '">' . esc_html__( 'Remover Denúncia', 'cne-ac' ) . '</a>';
                        else
                            $actions['report'] = '<a href="' . esc_url( $report_uri ) . '" title="' . esc_attr__( 'Denunciar este tópico', 'cne-ac' ) . '">' . esc_html__( 'Denunciar', 'cne-ac' ) . '</a>';

		}
                
                if ( current_user_can( 'delete_topic', $topic->ID ) ) {
                    if ( bbp_get_trash_status_id() === $topic->post_status ) {
                        unset( $actions['report'] );
                    }

                    if ( cne_ac_get_post_status_report() === $topic->post_status ) {
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr__( 'Delete this item permanently', 'bbpress' ) . "' href='" . esc_url( add_query_arg( array( '_wp_http_referer' => add_query_arg( array( 'post_type' => bbp_get_topic_post_type() ), admin_url( 'edit.php' ) ) ), get_delete_post_link( $topic->ID, '', true ) ) ) . "'>" . esc_html__( 'Delete Permanently', 'bbpress' ) . "</a>";
                        unset( $actions['trash'] );
                    }
		}

		return $actions;
        }
        add_filter( 'post_row_actions', 'cne_ac_topic_row_actions', 999,  2 );
        
        function cne_ac_reply_row_actions( $actions, $reply ) {

		if ( bbp_get_reply_post_type() != get_current_screen()->post_type ) 
                    return $actions;
                
                unset( $actions['spam'] );

		if ( current_user_can( 'moderate', $reply->ID ) ) {
                    
                        $report_uri  = wp_nonce_url( add_query_arg( array( 'reply_id' => $reply->ID, 'action' => 'cne_ac_bbp_toggle_reply_report' ), remove_query_arg( array( 'bbp_reply_toggle_notice', 'reply_id', 'failed', 'super' ) ) ), 'report-reply_'  . $reply->ID );
			if ( cne_ac_is_reply_reported( $reply->ID ) )
				$actions['report'] = '<a href="' . esc_url( $report_uri ) . '" title="' . esc_attr__( 'Remover denúncia deste comentário', 'cne-ac' ) . '">' . esc_html__( 'Remover Denúncia', 'cne-ac' ) . '</a>';
                        else
                            $actions['report'] = '<a href="' . esc_url( $report_uri ) . '" title="' . esc_attr__( 'Denunciar este comentário', 'cne-ac' ) . '">' . esc_html__( 'Denunciar', 'cne-ac' ) . '</a>';

		}
                
                if ( current_user_can( 'delete_reply', $reply->ID ) ) {
                    if ( bbp_get_trash_status_id() === $reply->post_status ) {
                        unset( $actions['report'] );
                    }

                    if ( cne_ac_get_post_status_report() === $reply->post_status ) {
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr__( 'Delete this item permanently', 'bbpress' ) . "' href='" . esc_url( add_query_arg( array( '_wp_http_referer' => add_query_arg( array( 'post_type' => bbp_get_reply_post_type() ), admin_url( 'edit.php' ) ) ), get_delete_post_link( $reply->ID, '', true ) ) ) . "'>" . esc_html__( 'Delete Permanently', 'bbpress' ) . "</a>";
                        unset( $actions['trash'] );
                    }
		}

		return $actions;
        }
        add_filter( 'post_row_actions', 'cne_ac_reply_row_actions', 999,  2 );
        
        function cne_ac_toggle_topic_report() {

            if ( bbp_get_topic_post_type() != get_current_screen()->post_type )
                return;

            if ( bbp_is_get_request() && !empty( $_GET['action'] ) && $_GET['action'] === 'cne_ac_bbp_toggle_topic_report' && !empty( $_GET['topic_id'] ) ) {
                $topic_id  = (int) $_GET['topic_id'];    
                $success   = false;                     
                $topic     = bbp_get_topic( $topic_id );

                if ( empty( $topic ) )
                        wp_die( __( 'The topic was not found!', 'bbpress' ) );

                if ( !current_user_can( 'moderate', $topic->ID ) )
                        wp_die( __( 'You do not have the permission to do that!', 'bbpress' ) );

                check_admin_referer( 'report-topic_' . $topic_id );

                $is_reported  = cne_ac_is_topic_reported( $topic_id );
                $message      = true === $is_reported ? 'unreported' : 'reported';
                $success      = true === $is_reported ? cne_ac_unreport_post( $topic ) : cne_ac_report_post( $topic );

                
                $message = array( 'bbp_topic_toggle_notice' => $message, 'topic_id' => $topic->ID );

                if ( false === $success || is_wp_error( $success ) )
                        $message['failed'] = '1';

                $redirect = add_query_arg( $message, remove_query_arg( array( 'action', 'topic_id' ) ) );
                wp_safe_redirect( $redirect );

                exit();
            }
	}
        add_action( 'load-edit.php', 'cne_ac_toggle_topic_report' );
        
        function cne_ac_toggle_reply_report() {

            if ( bbp_get_reply_post_type() != get_current_screen()->post_type )
                return;

            if ( bbp_is_get_request() && !empty( $_GET['action'] ) && $_GET['action'] === 'cne_ac_bbp_toggle_reply_report' && !empty( $_GET['reply_id'] ) ) {
                $reply_id  = (int) $_GET['reply_id'];    
                $success   = false;                     
                $reply     = bbp_get_reply( $reply_id );

                if ( empty( $reply ) )
                        wp_die( __( 'The reply was not found!', 'bbpress' ) );

                if ( !current_user_can( 'moderate', $reply->ID ) )
                        wp_die( __( 'You do not have the permission to do that!', 'bbpress' ) );

                check_admin_referer( 'report-reply_' . $reply_id );

                $is_reported  = cne_ac_is_reply_reported( $reply_id );
                $message      = true === $is_reported ? 'unreported' : 'reported';
                $success      = true === $is_reported ? cne_ac_unreport_post( $reply ) : cne_ac_report_post( $reply );

                
                $message = array( 'bbp_reply_toggle_notice' => $message, 'reply_id' => $reply->ID );

                if ( false === $success || is_wp_error( $success ) )
                        $message['failed'] = '1';

                $redirect = add_query_arg( $message, remove_query_arg( array( 'action', 'reply_id' ) ) );
                wp_safe_redirect( $redirect );

                exit();
            }
	}
        add_action( 'load-edit.php', 'cne_ac_toggle_reply_report' );
        
        function cne_ac_toggle_topic_notice() {

            if ( bbp_get_topic_post_type() != get_current_screen()->post_type )
                    return;

            if ( bbp_is_get_request() && !empty( $_GET['bbp_topic_toggle_notice'] ) && in_array( $_GET['bbp_topic_toggle_notice'], array( 'unreported', 'reported' ) ) && !empty( $_GET['topic_id'] ) ) {
                    $notice     = $_GET['bbp_topic_toggle_notice'];         // Which notice?
                    $topic_id   = (int) $_GET['topic_id'];                  // What's the topic id?
                    $is_failure = !empty( $_GET['failed'] ) ? true : false; // Was that a failure?
                    
                    if ( empty( $notice ) || empty( $topic_id ) )
                            return;

                    $topic = bbp_get_topic( $topic_id );
                    if ( empty( $topic ) )
                            return;

                    $topic_title = bbp_get_topic_title( $topic->ID );

                    switch ( $notice ) {
                        case 'reported' :
                            $message = $is_failure === true ? sprintf( __( 'Ocorreu um problema ao tentar denunciar o tópico "%1$s".',   'cne_ac' ), $topic_title ) : sprintf( __( 'Tópico "%1$s" denúnciado com sucesso.',   'cne_ac' ), $topic_title );
                        break;
                        case 'unreported'    :
                            $message = $is_failure === true ? sprintf( __( 'Ocorreu um problema ao tentar remover denúncia do tópico "%1$s".', 'cne_ac' ), $topic_title ) : sprintf( __( 'Sucesso ao remover denúncia do tópico "%1$s".', 'cne_ac' ), $topic_title );
                        break;
                    }
                    
                    ?>

                    <div id="message" class="<?php echo $is_failure === true ? 'error' : 'updated'; ?> fade">
                            <p style="line-height: 150%"><?php echo esc_html( $message ); ?></p>
                    </div>

                    <?php
            }
	}
        add_filter( 'admin_notices', 'cne_ac_toggle_topic_notice' );
        
        function cne_ac_reply_topic_notice() {

            if ( bbp_get_reply_post_type() != get_current_screen()->post_type )
                    return;

            if ( bbp_is_get_request() && !empty( $_GET['bbp_reply_toggle_notice'] ) && in_array( $_GET['bbp_reply_toggle_notice'], array( 'unreported', 'reported' ) ) && !empty( $_GET['reply_id'] ) ) {
                    $notice     = $_GET['bbp_reply_toggle_notice'];         // Which notice?
                    $reply_id   = (int) $_GET['reply_id'];                  // What's the reply id?
                    $is_failure = !empty( $_GET['failed'] ) ? true : false; // Was that a failure?
                    
                    if ( empty( $notice ) || empty( $reply_id ) )
                            return;

                    $reply = bbp_get_reply( $reply_id );
                    if ( empty( $reply ) )
                            return;

                    $reply_title = bbp_get_reply_title( $reply->ID );

                    switch ( $notice ) {
                        case 'reported' :
                            $message = $is_failure === true ? sprintf( __( 'Ocorreu um problema ao tentar denunciar a "%1$s".',   'cne_ac' ), $reply_title ) : sprintf( __( '"%1$s" denúnciado com sucesso.',   'cne_ac' ), $reply_title );
                        break;
                        case 'unreported'    :
                            $message = $is_failure === true ? sprintf( __( 'Ocorreu um problema ao tentar remover denúncia da "%1$s".', 'cne_ac' ), $reply_title ) : sprintf( __( 'Sucesso ao remover denúncia da "%1$s".', 'cne_ac' ), $reply_title );
                        break;
                    }
                    
                    ?>

                    <div id="message" class="<?php echo $is_failure === true ? 'error' : 'updated'; ?> fade">
                            <p style="line-height: 150%"><?php echo esc_html( $message ); ?></p>
                    </div>

                    <?php
            }
	}
        add_filter( 'admin_notices', 'cne_ac_reply_topic_notice' );
        
        function cne_ac_admin_topics_column_headers( $columns ) {

            if ( !isset($_GET['post_status']) || $_GET['post_status'] != cne_ac_get_post_status_report() || get_current_screen()->post_type != bbp_get_topic_post_type() )
                return $columns;

		$columns['cne_ac_reported_by'] = __( 'Denunciado por', 'cne_ac' );

		return $columns;
	}
        add_filter( 'bbp_admin_topics_column_headers',  'cne_ac_admin_topics_column_headers'  );
        
        function cne_ac_admin_replies_column_headers( $columns ) {

            if ( !isset($_GET['post_status']) || $_GET['post_status'] != cne_ac_get_post_status_report() || get_current_screen()->post_type != bbp_get_reply_post_type() )
                return $columns;

		$columns['cne_ac_reported_by'] = __( 'Denunciado por', 'cne_ac' );

		return $columns;
	}
        add_filter( 'bbp_admin_replies_column_headers',  'cne_ac_admin_replies_column_headers'  );
        
        function cne_ac_admin_topics_column_data( $column, $topic_id ) {

		if ( !isset($_GET['post_status']) || $_GET['post_status'] != cne_ac_get_post_status_report() || get_current_screen()->post_type != bbp_get_topic_post_type() )
                    return;

		switch ( $column ) {
			case 'cne_ac_reported_by':
                            $user_id = get_post_meta( $topic_id, 'cne_ac_bbp_report_user_id', true );
                            $data = cne_ac_get_data_col_report( $user_id );
                            echo $data;
                            break;
		}
	}
        add_action( 'bbp_admin_topics_column_data', 'cne_ac_admin_topics_column_data', 10,  2 );
        
        function cne_ac_admin_replies_column_data( $column, $reply_id ) {

		if ( !isset($_GET['post_status']) || $_GET['post_status'] != cne_ac_get_post_status_report() || get_current_screen()->post_type != bbp_get_reply_post_type() )
                    return;

		switch ( $column ) {
			case 'cne_ac_reported_by':
                            $user_id = get_post_meta( $reply_id, 'cne_ac_bbp_report_user_id', true );
                            $data = cne_ac_get_data_col_report( $user_id );
                            echo $data;
                            break;
		}
	}
        add_action( 'bbp_admin_replies_column_data', 'cne_ac_admin_replies_column_data', 10,  2 );
        
        function cne_ac_get_data_col_report( $user_id ) {
            $data = __( 'Anônimo', 'cne_ac' );
            $user = get_userdata( (int) $user_id );
            
            if( $user ) :
                $username = $user->user_login;
                $data = '<a class="cne-ac-col-report" href="' . admin_url( 'user-edit.php?user_id=' . intval($user_id) ) . '">' . esc_html( $username ) . '</a>';
            endif;
            
            return $data;
	}
        
        /* === DENUNCIAR FRONT  === */
        function cne_ac_insert_report_status( $r ) {

            if ( is_admin() || !bbp_get_view_all() )
                return $r;

            if ( ! isset( $r['post_status'] ) )
                return $r;

            $statuses = explode( ',', $r['post_status'] );

            $statuses[] = cne_ac_get_post_status_report();

            $r['post_status'] = implode( ',', $statuses );

            return $r;
	}
        add_filter( 'bbp_after_has_topics_parse_args', 'cne_ac_insert_report_status' ); 
        add_filter( 'bbp_after_has_replies_parse_args', 'cne_ac_insert_report_status' );
        
        function cne_ac_output_topic_notice() {
            if ( !cne_ac_is_topic_reported( get_the_ID() ) )
                return;

            echo '<div class="alert alert-danger" role="alert">';
                    echo '<p>';
                            _e( 'ALERTA: Este tópico foi denunciado!', 'cne-ac' );
                    echo '</p>';
                    echo '<p>';
                            _e( 'Nossa equipe irá avaliar o conteúdo do tópico e, caso confirmado que o conteúdo é inapropriado, esse será removido.', 'cne-ac' );
                    echo '</p>';
            echo '</div>';
	}
        add_action( 'bbp_template_before_single_topic', 'cne_ac_output_topic_notice' );  
        
       function cne_ac_output_reply_notice() {
		$reply_id = get_the_ID();

		// If post is a topic, return. (handled with 'output_topic_notice')
		if ( bbp_is_topic( $reply_id ) ) {
			return;
		}

		if ( ! cne_ac_is_topic_reported( $reply_id ) )
			return;

		echo '<div class="alert alert-danger" role="alert">';
                    echo '<p>';
                            _e( 'ALERTA: Este comentário foi denunciado!', 'cne-ac' );
                    echo '</p>';
                    echo '<p>';
                            _e( 'Nossa equipe irá avaliar o conteúdo do comentário e, caso confirmado que o conteúdo é inapropriado, esse será removido.', 'cne-ac' );
                    echo '</p>';
            echo '</div>';
	}
        add_action( 'bbp_theme_after_reply_content', 'cne_ac_output_reply_notice' );
        
        function cne_ac_toggle_topic_handler( $action = '' ) {

		// Bail if required GET actions aren't passed
		if ( empty( $_GET['topic_id'] ) )
			return;

		// Setup possible get actions
		$possible_actions = array(
			'cne_ac_bbp_toggle_topic_report',
			'cne_ac_bbp_toggle_topic_trash',
		);

		// Bail if actions aren't meant for this function
		if ( !in_array( $action, $possible_actions ) )
			return;

		$failure   = '';                         // Empty failure string
		$view_all  = false;                      // Assume not viewing all
		$topic_id  = (int) $_GET['topic_id'];    // What's the topic id?
		$success   = false;                      // Flag
		$redirect  = '';                         // Empty redirect URL

		// Make sure topic exists
		$topic = bbp_get_topic( $topic_id );
		if ( empty( $topic ) )
			return;
                
                if( !is_user_logged_in() )
                    return;
                
		if ( 'cne_ac_bbp_toggle_topic_trash' === $action && ( cne_ac_is_topic_reported( $topic->ID ) || ( !bbp_is_user_keymaster() && !current_user_can( 'trash_topics', $topic->ID ) ) ) ) {
                    bbp_add_error( 'cne_ac_bbp_toggle_topic_permission', __( '<strong>ERRO:</strong> Não é possível excluir o tópico.', 'bbpress' ) );
                    return;
                }
                
                
		
                // What action are we trying to perform?
		switch ( $action ) {

			// Toggle reported
			case 'cne_ac_bbp_toggle_topic_report' :
				check_ajax_referer( 'report-topic_' . $topic_id );

				$is_reported  = cne_ac_is_topic_reported( $topic_id );
				$success  = true === $is_reported ? cne_ac_unreport_post( $topic ) : cne_ac_report_post( $topic );
				$failure  = true === $is_reported ? __( '<strong>ERRO</strong>: Ocorreu um problema ao tentar remover a denúncia deste tópico.', 'cne-ac' ) : __( '<strong>ERRO</strong>: Ocorreu um problema ao tentar denunciar este tópico.', 'cne-ac' );
				

//                              $view_all = !$is_reported; // Only need this if we want to hide it, like spam

				break;
                    
                    case 'cne_ac_bbp_toggle_topic_trash' :

			$sub_action = !empty( $_GET['sub_action'] ) && in_array( $_GET['sub_action'], array( 'trash' ) ) ? $_GET['sub_action'] : false;

			if ( empty( $sub_action ) )
				break;

			switch ( $sub_action ) {
                            case 'trash':
                                check_ajax_referer( 'trash-' . bbp_get_topic_post_type() . '_' . $topic_id );

                                $view_all = true;
                                $success  = wp_trash_post( $topic_id );
                                $failure  = __( '<strong>ERRO</strong>: Ocorreu um problema ao tentar excluir o tópico.', 'cne-ac' );

                                break;
			}

			break;
		}

		// No errors
		if ( false !== $success && !is_wp_error( $success ) ) {

			// Redirect back to the topic's forum
			if ( isset( $sub_action ) && ( 'trash' === $sub_action ) ) {
                                $redirect = trailingslashit( bp_core_get_user_domain( bp_displayed_user_id() ) . bp_current_component() . '/' . bbp_get_topic_archive_slug() );

			// Redirect back to the topic
			} else {

				// Get the redirect destination
				$permalink = bbp_get_topic_permalink( $topic_id );
				$redirect  = bbp_add_view_all( $permalink, $view_all );
			}

			wp_safe_redirect( $redirect );

			// For good measure
			exit();

		// Handle errors
		} else {
			bbp_add_error( 'cne_ac_toggle_topic_handler', $failure );
		}
	}
        add_action( 'bbp_get_request', 'cne_ac_toggle_topic_handler', 1 );
        
        function cne_ac_toggle_reply_handler( $action = '' ) {
            
		// Bail if required GET actions aren't passed
		if ( empty( $_GET['reply_id'] ) )
			return;

		// Setup possible get actions
		$possible_actions = array(
			'cne_ac_bbp_toggle_reply_report',
			'cne_ac_bbp_toggle_reply_trash',
		);

		// Bail if actions aren't meant for this function
		if ( !in_array( $action, $possible_actions ) )
			return;

		$failure   = '';                         // Empty failure string
		$view_all  = false;                      // Assume not viewing all
		$reply_id  = (int) $_GET['reply_id'];    // What's the reply id?
		$success   = false;                      // Flag
		
		// Make sure reply exists
		$reply = bbp_get_reply( $reply_id );
               
		if ( empty( $reply ) )
			return;

		// Bail if non-logged-in user
		if ( ! is_user_logged_in() )
			return;
                
                if ( 'cne_ac_bbp_toggle_reply_trash' === $action && ( cne_ac_is_reply_reported( $reply->ID ) || ( !bbp_is_user_keymaster() && !current_user_can( 'trash_replies', $reply->ID ) ) ) ) {
                    bbp_add_error( 'cne_ac_bbp_toggle_reply_permission', __( '<strong>ERRO:</strong> Não é possível excluir o comentário.', 'cne-ac' ) );
                    return;
                }

		// What action are we trying to perform?
		switch ( $action ) {

			// Toggle reported
			case 'cne_ac_bbp_toggle_reply_report' :
                             
				check_ajax_referer( 'report-reply_' . $reply_id );
                            
				$is_reported  = cne_ac_is_reply_reported( $reply_id );
				$success  = true === $is_reported ? cne_ac_unreport_post( $reply ) : cne_ac_report_post( $reply );
				$failure  = true === $is_reported ? __( '<strong>ERRO</strong>: Ocorreu um problema ao tentar remover a denúncia deste comentário.', 'cne-ac' ) : __( '<strong>ERRO</strong>: Ocorreu um problema ao tentar denunciar este comentário.', 'cne-ac' );
				break;
                        
                        case 'cne_ac_bbp_toggle_reply_trash' :

                            $sub_action = in_array( $_GET['sub_action'], array( 'trash' ) ) ? $_GET['sub_action'] : false;

                            if ( empty( $sub_action ) )
                                break;

                            switch ( $sub_action ) {
                                    case 'trash':
                                            check_ajax_referer( 'trash-' . bbp_get_reply_post_type() . '_' . $reply_id );

                                            $view_all = true;
                                            $success  = wp_trash_post( $reply_id );
                                            $failure  = __( '<strong>ERRO</strong>: Ocorreu um problema ao tentar excluir o comentário.', 'cne-ac' );

                                    break;
                            }
                }

		// No errors
		if ( ( false !== $success ) && !is_wp_error( $success ) ) {

                    /** Redirect **********************************************************/
                    
                    if ( isset( $sub_action ) && ( 'trash' === $sub_action ) ) {
                        $redirect = trailingslashit( bp_core_get_user_domain( bp_displayed_user_id() ) . bp_current_component() . '/' . bbp_get_reply_archive_slug() );
                    } else {
                        // Redirect to
			$redirect_to = bbp_get_redirect_to();

			// Get the reply URL
			$redirect = bbp_get_reply_url( $reply_id, $redirect_to );

			// Add view all if needed
			if ( !empty( $view_all ) )
				$redirect = bbp_add_view_all( $redirect, true );
                    }
			// Redirect back to reply
			wp_safe_redirect( $redirect );

			// For good measure
			exit();

		// Handle errors
		} else {
                    bbp_add_error( 'cne_ac_toggle_reply_handler', $failure );
		}
	}
        add_action( 'bbp_get_request', 'cne_ac_toggle_reply_handler' );
        
        /* ========== FIM DENUNCIA ============= */
        
        /* nao foi feita a traducao da frase. Modificacao via filter para nao ter problemas com atualizacao do plugin */
        function cne_ac_reply_pagination_count( $retstr ) {
            if ( bbp_show_lead_topic() ) {
                $search = array ( 'Viewing', 'reply', 'replies', 'through', 'of', 'total' );
                $replace = array ( 'Visualizando', 'comentário', 'comentários', 'até', 'de', 'do total' );
                $retstr = str_replace($search, $replace, $retstr);
            }
            
            return $retstr;
            
        }
        add_filter( 'bbp_get_topic_pagination_count', 'cne_ac_reply_pagination_count' );
       //define( 'BP_FORUMS_SLUG', 'teste' );
        
                

       
        

