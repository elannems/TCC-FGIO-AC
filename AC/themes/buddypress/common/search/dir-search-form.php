<?php

/**
 * BuddyPress - Search form
 */

?>

<div id="<?php echo esc_attr( bp_current_component() ); ?>-dir-search" class="dir-search" role="search">
    <form action="" method="get" id="search-<?php echo esc_attr( bp_current_component() ); ?>-form" class="form-inline">
        <div class="form-group">
            <label for="<?php bp_search_input_name(); ?>" class="bp-screen-reader-text sr-only"><?php bp_search_placeholder(); ?></label>
            <input type="text" name="<?php echo esc_attr( bp_core_get_component_search_query_arg() ); ?>" id="<?php bp_search_input_name(); ?>" class="cne-search-input form-control" placeholder="&#xf002; <?php bp_search_placeholder(); ?>" />

            <input type="submit" class="btn btn-default" id="<?php echo esc_attr( bp_get_search_input_name() ); ?>_submit" name="<?php bp_search_input_name(); ?>_submit" value="<?php esc_attr_e( 'Search', 'buddypress' ); ?>" />
        </div> <!-- .form-group -->
    </form>
</div> <!-- .dir-search -->
