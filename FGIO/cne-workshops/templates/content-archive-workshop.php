<?php

$template = cnew_get_template_loader();
?>

<div class="wrap">
    <div class="cnew-workshops-filter-div" id="subnav" role="navigation">
        <label for="cnew-workshops-filter-label"><?php _e( 'Filtrar Oficinas:', 'cnew' ); ?></label>
        <select id="cnew-workshops-filter">
                <option value="open"><?php _e( 'Inscrições Abertas', 'cnew' ); ?></option>
                <option value="closed"><?php _e( 'Inscrições Fechadas', 'cnew' ); ?></option>
        </select>
    </div>
</div>

<?php $template->get_template_part( 'workshops', 'loop' ); ?>

