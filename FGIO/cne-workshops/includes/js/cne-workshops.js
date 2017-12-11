jQuery(document).ready(function($){
    
    $('#cnew-reg-date-birth').mask('99/9999',{placeholder:"mm/aaaa"});
    
    $('#cnew-reg-parent-phone').mask('(99) 99999999?9');
    
    $.validator.addMethod(
        "formatDate",
        function(value, element) {
            return value.match(/^(((0[1-9]|1[0-2])\/((19|[2-9]\d)\d{2})))$/);
        },
        "Formato de data inválido! Por favor, informe uma data no formato mm/aaaa."
    );
        
    $.validator.addMethod(
        "lastYear",
        function(value, element) {
            var today = new Date();
            var birth_year = parseInt(value.split("/")[1], 10);
            
            return today.getFullYear() > birth_year;
        },
        "O ano de nascimento precisa ser menor que o ano corrente."
    );
    
    $.validator.addMethod(
        "phonelength",
        function(value, element) {
            var phone = value.replace(/\D/g, '');
            
            return phone.length == 10 || phone.length == 11;
        },
        "O telefone precisa ter 10 ou 11 dígitos."
    );
    
    
    
    $('#cnew-registration-form')
    .validate({
        rules : {
            cnew_reg_name: {
                required : true,
                maxlength : 255
            },
            cnew_reg_date_birth: {
                required : true,
                formatDate : true,
                lastYear : true
            },
            cnew_reg_gender: {
                required : true
            },
            cnew_reg_parent_name: {
                required : true,
                maxlength : 255
            },
            cnew_reg_parent_phone: {
                required : true,
                phonelength : true
            },
            cnew_reg_email: {
                required : true,
                email : true,
                maxlength : 100
            }
        },
        messages: {
            cnew_reg_name: {
                required: "Por favor, informe o nome.",
                maxlength: "O campo só aceita 255 caracteres."
            },
            cnew_reg_date_birth: {
                required: "Por favor, informe a data de nascimento."
            },
            cnew_reg_gender: {
                required: "Por favor, selecione uma das opções."
            },
            cnew_reg_parent_name: {
                required: "Por favor, informe o nome.",
                maxlength: "O campo só aceita 255 caracteres."
            },
            cnew_reg_parent_phone: {
                required: "Por favor, informe um número de telefone.",
                maxlength: "O campo só aceita 15 caracteres."
            },
            cnew_reg_email: {
                required: "Por favor, informe o e-mail.",
                email: "Por favor, informe um endereço de e-mail válido",
                maxlength: "O campo só aceita 100 caracteres."
            }
        },
        highlight: function(element) {
            if ( $(element).is(":radio") ) {
                $(element).parent().addClass('cnew-error');
            } else {
                $(element).addClass('cnew-error');
            }
        },
        unhighlight: function(element) {
            $(element).removeClass('cnew-error');
        },
        errorPlacement: function(error, element) {
            if ( element.is(":radio") ) {
                error.insertAfter( element.parent() );
            } else {
                error.insertAfter( element );
            }
         }
    });
    
    /* === Filtra as oficinas pelo periodo de inscricao: com inscricao aberta ou fechada === */
    $('#cnew-workshops-filter').each(function() {
         $(this).selectedIndex = 0;
     });
    $('#cnew-workshops-filter').change( function() {
        var filter = $(this).val();
        cnew_filter(filter);
    });
    $('.cnew-paginate a').live('click', function(e){
        e.preventDefault();
        var paged = getURLParameter($(this).attr('href'), 'paged');
        var filter = $('#cnew-workshops-filter').val();
        cnew_filter(filter,paged);
    });
    
    function cnew_filter(filter,paged) {
    var data = {
                action: 'archive_workshop',
                nonce: cnew_workshop_js.ws_filter_nonce,
                filter: filter,
                paged: paged
            };
        
        $.post( cnew_workshop_js.cnew_ajaxurl, data, function ( result ) {
            if( result.status ) {
                $('.cnew-workshops-loop').html(result.content);
            } else {
                alert( result.content );
            }
        }).fail( function() {
            alert( 'Ocorreu um erro ao processar sua solicitação. Por favor, tente novamente.');
        });
}
});

function getURLParameter(url, param) {
     $param = RegExp(param + '=' + '(.+?)(&|$)').exec(url);
     
     if( $param )
         $param = $param[1];
     
     return $param;
}