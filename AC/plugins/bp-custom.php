<?php
/**
 * Neste arquivo o plugin buddypress é modificado,
 * utilizando os ganchos que sao executados antes de iniciar um tema do wordpress
 *
 * @author Elanne M de Souza
 * @version 1.0
 */

/* Mais informacoes do arquivo:
 * https://codex.buddypress.org/themes/bp-custom-php/
 */

/*
 * Remove os widgets do buddypress
 */
function cne_ac_remove_bp_widgets() {
    remove_all_actions( 'bp_register_widgets' );
}
add_action( 'bp_loaded', 'cne_ac_remove_bp_widgets', 6 ); 

/*
 * Remove o meta box adicionado pelo buddypress no nav-menus.php
 */
function cne_ac_remove_bp_menu(){
    remove_action('load-nav-menus.php', 'bp_admin_wp_nav_menu_meta_box');

}
add_action( 'bp_loaded', 'cne_ac_remove_bp_menu', 11 );

