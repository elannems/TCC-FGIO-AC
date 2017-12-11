<?php
/**
 * BuddyPress Uploader templates.
 *
 * @package cne-ac
 */

?>
<script type="text/html" id="tmpl-upload-window">
	<?php if ( ! _device_can_upload() ) : ?>
		<h3 class="upload-instructions"><?php esc_html_e( 'Seu navegador ou dispositivo não permite o upload de arquivos.', 'cne-ac' ); ?></h3>
	<?php elseif ( is_multisite() && ! is_upload_space_available() ) : ?>
		<h3 class="upload-instructions"><?php esc_html_e( 'Tamanho do arquivo maior que o permitido', 'cne-ac' ); ?></h3>
	<?php else : ?>
		<div id="{{data.container}}">
			<div id="{{data.drop_element}}">
				<div class="drag-drop-inside">
					<p class="drag-drop-info"><?php esc_html_e( 'Solte seu arquivo aqui', 'cne-ac' ); ?></p>
					<p><?php _ex( 'ou', 'Solte seu arquivo aqui - ou - Selecione seu arquivo', 'cne-ac' ); ?></p>
					<p class="drag-drop-buttons"><label for="{{data.browse_button}}" class="<?php echo is_admin() ? 'screen-reader-text sr-only' : 'bp-screen-reader-text sr-only' ;?>"><?php
						esc_html_e( 'Selecione seu arquivo', 'cne-ac' );
					?></label><input id="{{data.browse_button}}" type="button" value="<?php esc_attr_e( 'Selecione seu arquivo', 'cne-ac' ); ?>" class="btn btn-default" /></p>
				</div>
			</div>
		</div>
	<?php endif; ?>
</script>

<script type="text/html" id="tmpl-progress-window">
	<div id="{{data.id}}">
		<div class="bp-progress progress">
			<div class="bp-bar progress-bar"></div>
		</div>
		<div class="filename">{{data.filename}}</div>
	</div>
</script>
