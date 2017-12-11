<?php

function cnew_get_select_pages( $selected ) {
    
    $args = array(
	'parent' => 0,
	'post_type' => 'page',
	'post_status' => 'publish'
    ); 
    
    $pages = get_pages($args);

    $select = '<select name="cnew_registration_form_page_id" id="cnew-registration-form-page-id">';

    $select .= '<option value="">' . esc_attr( __('Selecione uma página', 'cnew') ) . '</option>';

    foreach ( $pages as $page ) :

        $select .= '<option value="' . $page->ID . '" ' . ( ($selected == $page->ID) ?  'selected="selected"' : '' ) . '>' . $page->post_title . '</option>';

    endforeach;

    $select .= '</select>';

    echo $select;
    
}

function cnew_get_registration_form_page_id() {
    $option = get_option( 'cnew_registration_form_page_id' );
    $registration_form_page_id = ( $option ) ?
                    $option : '';
    
    return $registration_form_page_id;
    
}

function cnew_get_email_subject_resend() {
    $option = get_option( 'cnew_email_subject_resend' );
    $cnew_email_subject_resend = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_subject_resend' );
    
    return $cnew_email_subject_resend;
    
}

function cnew_get_email_content_resend() {
    $option = get_option( 'cnew_email_content_resend' );
    
    $cnew_email_content_resend = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_content_resend' );
    
    return $cnew_email_content_resend;  
}

function cnew_get_email_default_text( $option_name ) {
    $default_text = '';
    switch ($option_name) {
        case 'cnew_email_header':
            $default_text = 'Olá {{nome_usuario}}';
            break;
        case 'cnew_email_footer':
            $default_text = '<p>{{titulo_site}} - {{ano_corrente}}<br>Para saber mais sobre a iniciativa acesse: <a href="{{pagina_inicial}}" target="_blank">{{pagina_inicial}}</a></p>
                <p style="font-size:12px;">Computação na Escola é uma iniciativa do INCoD - Instituto Nacional de Convergência Digital / INE – Departamento de Informática e Estatística / UFSC - Universidade Federal de Santa Catarina, em parceria com o IFSC - Instituto Federal de Santa Catarina.</p>';
            break;
        case 'cnew_email_subject_resend':
            $default_text = 'CnE - Confirmação de E-mail';
            break;
        case 'cnew_email_content_resend':
            $default_text = '<p>Acabamos de receber uma solicitação de inscriçao para a oficina "{{oficina}}" em que foi utilizado este e-mail.</p>
                            <p>Caso você reconheça esta solicitação, confirme seu e-mail clicando no link abaixo: <br />
                                <ul>
                                    <li><a href="{{link_ativacao}}">{{link_ativacao}}</a></li>
                                </ul>
                            </p>
                            <p><strong>Observações:</strong>
                                <ul>
                                    <li>Após a confirmação do seu e-mail, entraremos em contato, via e-mail, para confirmar sua participação na oficina.</li>
                                    <li>Caso o número de inscrições recebidas seja superior ao número de vagas para a oficina, os participantes serão selecionados por ordem de inscrição.</li>
                                    <li>Para sua segurança, ressaltamos que não entramos em contato para solicitar informações, pois as informações que precisamos já foram solicitadas no formulário de inscrição.</li>
                                </ul>
                            </p>
                            <p><strong>Dúvidas? entre em contato:</strong>
                                <ul>
                                    <li>Telefones: +55 48 3721-7380 /+55 48 3721 4715</li>
                                    <li>E-mail: computacaonaescola@incod.ufsc.br</li>
                                </ul>
                            </p>
                            <p>Saudações,<br />
                            Equipe Computação na Escola.</p>';
            break;
        case 'cnew_email_subject_accepted':
            $default_text = 'CnE - Confirmação de Participação';
            break;
        case 'cnew_email_content_accepted':
            $default_text = '<p>Temos o prazer de comunicar que você foi selecionado para participar da oficina "{{oficina}}".</p>
                            <p>Se você tiver algum dúvida, entre em contato conosco e, caso você não possa comparecer a oficina, pedimos que nos comunique, pois assim você dará oportunidade para outra pessoa participar.</p>
                            <strong>Contatos:</strong>
                            <p>
                                <ul>
                                    <li>Telefones: +55 48 3721-7380 /+55 48 3721 4715</li>
                                    <li>E-mail: computacaonaescola@incod.ufsc.br</li>
                                </ul>
                            </p>
                            <strong>Observações:</strong>
                            <p>
                                <ul>
                                    <li>A seleção dos participantes é feita por ordem de inscrição, nenhum outro critério é utilizado</li>
                                    <li>Para sua segurança, ressaltamos que não entraremos em contato para solicitar informações, pois as informações que precisamos já foram solicitadas no formulário de inscrição.</li>
                                </ul>
                            </p>
                            <p>Saudações,<br />
                            Equipe Computação na Escola.</p>';
            break;
        case 'cnew_email_subject_declined':
            $default_text = 'CnE - Oficina Sem Vagas';
            break;
        case 'cnew_email_content_declined':
            $default_text = '<p>Comunicamos que a oficina para qual você se inscreveu "{{oficina}}" preencheu todas as vagas disponíveis.</p>
                            <p>Contudo, se houver alguma desistência, você ainda pode ser selecionado. Neste caso entraremos em contato via e-mail.</p>
                            <p>Se você tiver algum dúvida, entre em contato conosco.</p>
                            <p><strong>Contatos:</strong>
                                <ul>
                                    <li>Telefones: +55 48 3721-7380 /+55 48 3721 4715</li>
                                    <li>E-mail: computacaonaescola@incod.ufsc.br</li>
                                </ul>
                            </p>
                            <p><strong>Observações:</strong>
                                <ul>
                                    <li>A seleção dos participantes é feita por ordem de inscrição, nenhum outro critério é utilizado</li>
                                    <li>Para sua segurança, ressaltamos que não entraremos em contato para solicitar informações, pois as informações que precisamos já foram solicitadas no formulário de inscrição.</li>
                                </ul>
                            </p>
                            <p>Saudações,<br />
                            Equipe Computação na Escola.</p>';
            break;
        case 'cnew_email_subject_cancel':
            $default_text = 'CnE - Participação Cancelada';
            break;
        case 'cnew_email_content_cancel':
            $default_text = '<p>Conforme solicitado, cancelamos sua participação na oficina "{{oficina}}". No entanto, aguardamos sua participação nos próximos eventos. </p>
                            <p><strong>Dúvidas? entre em contato:</strong>
                            <ul>
                                <li>Telefones: +55 48 3721-7380 /+55 48 3721 4715</li>
                                <li>E-mail: computacaonaescola@incod.ufsc.br</li>
                            </ul>
                            </p>
                            <p><strong>Observações:</strong>
                                <ul>
                                    <li>A seleção dos participantes é feita por ordem de inscrição, nenhum outro critério é utilizado</li>
                                    <li>Para sua segurança, ressaltamos que não entraremos em contato para solicitar informações, pois as informações que precisamos já foram solicitadas no formulário de inscrição.</li>
                                </ul>
                            </p>
                            <p>Saudações,<br />
                            Equipe Computação na Escola.</p>';
            break;
        case 'cnew_email_subject_create_user':
            $default_text = 'CnE - Criação de Usuário';
            break;
        case 'cnew_email_content_create_user':
            $default_text = '<p>Como recebemos sua inscrição para a oficina "{{oficina}}" pensamos que talvez você possa se interessar em participar da nossa comunidade, por isso criamos um usuário para você. </p>
                            <p>Na nossa comunidade você pode encontrar materiais para aprender mais computação, encontrar projetos feitos por outros participantes das nossas oficinas, compartilhar seus projetos ou outros materiais que achar interessante sobre computação, ajudar nossos outros usuários, criar amizades e muito mais. </p>
                            <p>Caro usuário, caso você se interesse em participar da nossa comunidade é só ativar sua conta clicando no link abaixo:<br />
                                <ul>
                                    <li><a href="{{link_ativacao_conta}}">{{link_ativacao_conta}}</a></li>
                                </ul>
                            </p>
                            <p>e utilizar os seguintes dados para se conectar:</p>
                            <ul>
                                <li><strong>Nome de usuário:</strong> {{nome_usuario_email}}</li>
                                <li><strong>Senha:</strong> {{senha_usuario}}</li>
                            </ul>
                            <p>Caso contrário, se você não deseja participar da nossa comunidade, é só ignorar este e-mail que logo removeremos o seu cadastro.</p>
                            <p>Destacamos que você sempre será bem-vindo, podendo se cadastrar na nossa comunidade quando desejar.</p>
                            <p><strong>Observação:</strong>
                                <ul>
                                    <li>Para sua segurança, recomendamos que em seu primeiro acesso você modifique suas informações de perfil, principalmente sua <strong>Senha</strong> e seu <strong>Nome de exibição</strong></li>
                                </ul>
                            </p>
                            <p><strong>Dúvidas? entre em contato:</strong>
                            <ul>
                                <li>Telefones: +55 48 3721-7380 /+55 48 3721 4715</li>
                                <li>E-mail: computacaonaescola@incod.ufsc.br</li>
                            </ul>
                            </p>
                            <p>Saudações,<br />
                            Equipe Computação na Escola.</p>';
            break;
    }
    
    return $default_text;
}


function cnew_get_email_subject_accepted() {
    $option = get_option( 'cnew_email_subject_accepted' );
    $cnew_email_subject_accepted = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_subject_accepted' );
    
    return $cnew_email_subject_accepted;   
}

function cnew_get_email_content_accepted() {
    $option = get_option( 'cnew_email_content_accepted' );
    
    $cnew_email_content_accepted = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_content_accepted' );;
    
    return $cnew_email_content_accepted;  
}

function cnew_get_email_subject_declined() {
    $option = get_option( 'cnew_email_subject_declined' );
    $cnew_email_subject_declined = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_subject_declined' );
    
    return $cnew_email_subject_declined; 
}

function cnew_get_email_content_declined() {
    $option = get_option( 'cnew_email_content_declined' );
    $cnew_email_content_declined = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_content_declined' );
    
    return $cnew_email_content_declined; 
}

function cnew_get_email_subject_cancel() {
    $option = get_option( 'cnew_email_subject_cancel' );
    $cnew_email_subject_cancel = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_subject_cancel' );
    
    return $cnew_email_subject_cancel; 
}

function cnew_get_email_content_cancel() {
    $option = get_option( 'cnew_email_content_cancel' );
    $cnew_email_content_cancel = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_content_cancel' );
    
    return $cnew_email_content_cancel; 
}

function cnew_get_email_subject_create_user() {
    $option = get_option( 'cnew_email_subject_create_user' );
    $cnew_email_subject_create_user = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_subject_create_user' );
    
    return $cnew_email_subject_create_user;   
}

function cnew_get_email_content_create_user() {
    $option = get_option( 'cnew_email_content_create_user' );
    
    $cnew_email_content_create_user = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_content_create_user' );
    
    return $cnew_email_content_create_user;  
}

function cnew_get_email_header() {
    $option = get_option( 'cnew_email_header' );
    $cnew_email_header = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_header' );
    
    return $cnew_email_header;
}

function cnew_get_email_footer() {
    $option = get_option( 'cnew_email_footer' );
    $cnew_email_footer = ( $option ) ?
                    $option : cnew_get_email_default_text( 'cnew_email_footer' );
    
    return $cnew_email_footer;
}

function cnew_add_workshop_admin_filter(){
    global $post_type;
    global $wpdb;
    if( $post_type == cnew_get_registration_post_type() ){
        
        $workshops = $wpdb->get_results( 
                        $wpdb->prepare( 
                                "SELECT * FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = %s ORDER BY post_title",
                                cnew_get_workshop_post_type() 
                        )
                    );
        
        $key_selected = '';
        if( !empty( $_GET['workshop_admin_filter'] ) ){
            $key_selected = (int)$_GET['workshop_admin_filter'];
        }
        
        $dropdown = '<select name="workshop_admin_filter" id="workshop-admin-filter">';
        $dropdown .= '<option value = "" >Todas as oficinas </option>';
        if( $workshops ) {
            foreach ( $workshops as $post ) {
                $dropdown .= '<option value="'. $post->ID. '" ' . ( ( $key_selected === (int)$post->ID ) ?  'selected="selected"' : '' ) . '>'. $post->post_title. '</option>';
            }
        }
        $dropdown .= '</select>';

        echo $dropdown;

    }
}

function cnew_add_status_admin_filter(){
    global $post_type;

    if( $post_type == cnew_get_registration_post_type() ) {
        
        $status = array( 
            CNEW_Registration::EMAIL_NAO_ENVIADO => 'E-mail não enviado',
            CNEW_Registration::EMAIL_NAO_CONFIRMADO   => 'E-mail não confirmado',
            CNEW_Registration::EMAIL_CONFIRMADO   => 'E-mail confirmado',
            CNEW_Registration::PARTICIPANTE   => 'Participante',
            CNEW_Registration::SEM_VAGAS   => 'Sem Vagas',
            CNEW_Registration::CANCELADO   => 'Cancelado'
        );
        
        $key_selected = '';
        if( isset( $_GET['status_admin_filter'] ) && $_GET['status_admin_filter'] != '' ){
            $key_selected = (int)$_GET['status_admin_filter'];
        }
        
        $dropdown = '<select name="status_admin_filter" id="status-admin-filter">';
        $dropdown .= '<option value = "" >Todas as situações </option>';
        foreach ( $status as $key => $value ) {
            $dropdown .= '<option value="'. $key. '" ' . ( ( $key_selected === $key ) ?  'selected="selected"' : '' ) . '>'. $value. '</option>';
        }

        $dropdown .= '</select>';

        echo $dropdown;

    }
}

function cnew_add_filter_posts_workshop($query){
    global $post_type, $pagenow, $wpdb;

    if( $pagenow == 'edit.php' && $post_type == cnew_get_registration_post_type() ){
        if( !empty( $_GET['workshop_admin_filter'] ) ){
            $select_admin_filter = sanitize_text_field($_GET['workshop_admin_filter']);
            $result = $wpdb->get_col("SELECT post_id FROM ".$wpdb->prefix."cnew_registrations WHERE workshop_id = $select_admin_filter");
            if(!empty($query->query_vars['post__in'])){
                $result = array_intersect($query->query_vars['post__in'], $result);
            }
            if(empty($result)) {
                $result[]=0;
            }
            $query->query_vars['post__in'] = $result;
        }
    }   
}

function cnew_add_filter_posts_status($query){
    global $post_type, $pagenow, $wpdb;

    if($pagenow == 'edit.php' && $post_type == cnew_get_registration_post_type()){
        if( isset($_GET['status_admin_filter']) && $_GET['status_admin_filter'] != '' ){
            $select_admin_filter = (int) $_GET['status_admin_filter'];
            $result = $wpdb->get_col("SELECT post_id FROM ".$wpdb->prefix."cnew_registrations WHERE status = $select_admin_filter");
            if(!empty($query->query_vars['post__in'])){
                $result = array_intersect($query->query_vars['post__in'], $result);
            }
            if(empty($result)) {
                $result[]=0;
            }
            $query->query_vars['post__in'] = $result;
        }
    }   
}

