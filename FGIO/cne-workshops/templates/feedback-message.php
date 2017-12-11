
<div class="wrap">
    <?php if( isset($data) && isset($data->class) && isset($data->msg) ) : ?>

        <div class="cnew-workshop-notice <?php echo $data->class; ?>">
                <?php echo $data->msg; ?>
        </div>

    <?php else: ?>

    <div class="cnew-workshop-notice">
            <?php _e('Ocorreu algum erro ao executar a solicitação. Por favor, tente novamente.', 'cnew'); ?>
    </div>

    <?php endif; ?>

</div>