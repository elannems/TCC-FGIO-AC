<?php

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Baseada na funcao bp_verify_nonce_request do plugin buddypress <https://br.wordpress.org/plugins/buddypress/> para verificar nonce
 */
function cnew_verify_nonce_request( $action = '', $query_arg = '_wpnonce' ) {

    $result = isset( $_REQUEST[$query_arg] ) ? wp_verify_nonce( $_REQUEST[$query_arg], $action ) : false;

    if ( empty( $result ) || empty( $action ) ) {
            $result = false;
    }

    return $result;
}

/**
 * Baseada na funcao bp_send_email() do plugin buddypress <https://br.wordpress.org/plugins/buddypress/> para enviar email
 */
function cnew_send_email( $email, $args = array() ) {
    	$result = false;
        
        if( !empty( $args ) ) {
            
            //altera o wp_mail_content_type de text/plain para text/html
            add_filter( 'wp_mail_content_type', function( $content_type ) {
                return 'text/html';
            });

            $to = sanitize_email( $email );
            $header = cnew_replace_tokens_text( $args['header'], $args['replace_pairs'] );
            $content = cnew_replace_tokens_text( $args['content'], $args['replace_pairs'] );
            $footer = cnew_replace_tokens_text( $args['footer'], $args['replace_pairs'] );
            
            $message = cnew_get_html_email( wpautop( $header ), wpautop( $content ), wpautop( $footer ) );
            
            $result = wp_mail(
                   $to,
                   $args['subject'],
                   $message
            );
            
        }
        
        return $result;
}

function cnew_replace_tokens_text( $text, $replace_pairs ) {
    $text = strtr( $text, $replace_pairs );
    
    return $text;
}

/** 
 * Baseado no arquivo single-bp-email.php do plugin buddypress <https://br.wordpress.org/plugins/buddypress/>
 */
function cnew_get_html_email( $header, $content, $footer ) {
    $html_email = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR">
    <head>
        <meta charset="' . esc_attr( get_bloginfo( 'charset' ) ) . '">
        <meta name="viewport" content="width=device-width"> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <style type="text/css">
                html,
                body {
                        margin: 0 !important;
                        padding: 0 !important;
                        height: 100% !important;
                        width: 100% !important;
                }

                * {
                        -ms-text-size-adjust: 100%;
                        -webkit-text-size-adjust: 100%;
                }

                /* Outlook.com */
                .ExternalClass {
                        width: 100%;
                }

                /* Android 4.4 */
                div[style*="margin: 16px 0"] {
                        margin: 0 !important;
                }

                /* Outlook.com */
                table,
                td {
                        mso-table-lspace: 0pt !important;
                        mso-table-rspace: 0pt !important;
                }

                /* Outlook.com */
                table {
                        border-spacing: 0 !important;
                        border-collapse: collapse !important;
                        table-layout: fixed !important;
                        margin: 0 auto !important;
                }
                table table table {
                        table-layout: auto;
                }

                /* Yahoo */
                .yshortcuts a {
                        border-bottom: none !important;
                }

                /* iOS */
                a[x-apple-data-detectors] {
                        color: inherit !important;
                        text-decoration: underline !important;
                }
        </style>

    </head>
    <body width="100%" height="100%" bgcolor="#ffffff" margin=0;>
        <table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%" bgcolor="#ffffff" style="border-collapse:collapse;">
            <tr>
                <td valign="top">
                    <center style="width: 100%;">

                    <div style="max-width: 600px;">
                    
                        <!--[if (gte mso 9)|(IE)]>
                        <table cellspacing="0" cellpadding="0" border="0" width="600" align="center">
                            <tr>
                                <td>
                        <![endif]-->

                        <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; border-top: 7px solid #35bff2" bgcolor="#ffffff">
                            <tr>
                                <td style="text-align: center; padding: 15px 0; mso-height-rule: exactly; font-weight: bold; color: #707070; font-size: 30px">
                                    '. get_option( 'blogname' ) .'
                                </td>
                            </tr>
                        </table>
                        
                        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="100%" style="max-width: 600px;">
                        <tr>
                            <td>
                                <table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-bottom: 7px solid #35bff2">
                                    <tr>
                                        <td style="padding: 20px; mso-height-rule: exactly; line-height: 30px; color: #707070; font-size: 14px">
                                            <span style="font-weight: bold; font-size: 18px" class="cnew_header">' . $header . '</span>
                                            <hr color="#c0c0c0">
                                            <p style="margin: 20px 0;" class="cnew_content">' . $content . '</p>
                                            <hr color="#c0c0c0">
                                            <span class="cnew_footer">' . $footer . '</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        </table>


                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                        </tr>
                    </table>
                    <![endif]-->
                    
                    </div>
                    </center>
                </td>
            </tr>
        </table>
    </body>
    </html>';
    
    return $html_email;
    
}
