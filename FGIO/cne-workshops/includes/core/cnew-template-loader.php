<?php

/**
 * Permite carregar templates como a funcao get_template_part do wordpress
 * Extraido de <https://github.com/GaryJones/Gamajo-Template-Loader>
 * 
 */
if ( !defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
  require CNEW_PLUGIN_DIR . 'includes/core/class-gamajo-template-loader.php';
}

class CNEW_template_loader extends Gamajo_Template_Loader {
    
    protected $filter_prefix = 'cnew';
    
    protected $theme_template_directory = 'cnew';
    
    protected $plugin_directory = CNEW_PLUGIN_DIR;
    
    protected $plugin_template_directory = 'templates';
}
