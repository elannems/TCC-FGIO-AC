jQuery(document).ready(function($){
    
    /* === INICIO VALIDACAO FORM TOPICO === */
    $('#post')
    .validate({
        rules : {
            cne_bbp_topic_city : {
                maxlength : 100
            },
            cne_bbp_topic_author : {
                maxlength : 100
            },
            cne_bbp_topic_desc : {
                required : true,
                maxlength : 160
            },
            cne_bbp_topic_objective : {
                required : true,
                maxlength : 255
            }
        },
        messages: {
            cne_bbp_topic_city: {
                maxlength: "O campo só aceita 100 caracteres."
            },
            cne_bbp_topic_author: {
                maxlength: "O campo só aceita 100 caracteres."
            },
            cne_bbp_topic_desc: {
                required: "Por favor, informe uma descrição para o tópico.",
                maxlength: "O campo só aceita 160 caracteres."
            },
            cne_bbp_topic_objective: {
                required: "Por favor, informe um objetivo.",
                maxlength: "O campo só aceita 255 caracteres."
            }
        }
    });
    /* === FIM VALIDACAO FORM TOPICO === */
    
});
        
