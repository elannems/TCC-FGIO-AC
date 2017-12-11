jQuery(document).ready(function( $ ) {
    $('.cne-carousel').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 3,
      slidesToScroll: 3
    });
       
    $.validator.addMethod(
        "userValidator",
        function(value, element) {
            return value.match(/^[a-zA-Z0-9_-]+$/);
            },
        "Nome de exibição pode conter apenas letras, número, - e _");


    if( !$( "#profile-details-section" ).find( ".error" ).length && $( "#basic-details-section" ).find( ".error" ).length ) {
        $('#profile-details-section').hide();
        $('#basic-details-section').show();
    }

    $("#signup_form").validate({
        errorElement: 'span',
        errorClass: 'help-block',
        highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        },
        ignore: '#signup_submit, .cne-next-step',
        rules: {
                field_1: {
                    required: true,
                    maxlength: 15,
                    userValidator: true
                },
                field_2_day : {
                    required: true
                },
                field_2_month : {
                    required: true
                },
                field_2_year : {
                    required: true
                },
                signup_username: {
                    required: true
                },
                signup_email : {
                    required: true
                },
                signup_password : {
                    required: true
                },
                signup_password_confirm : {
                    required: true,
                    equalTo: '#signup_password'
                }

        },
        messages: {
                field_1: {
                    required: "Nome de exibição é obrigatório",
                    maxlength: "Nome de exibição aceita apenas 10 caracteres"
                },
                field_2_day : {
                    required: "Dia de nascimento é obrigatório"
                },
                field_2_month : {
                    required: "Mês de nascimento é obrigatório"
                },
                field_2_year: {
                    required: "Ano de nascimento é obrigatório"
                },
                signup_username: {
                    required: "Nome de usuário é obrigatório"
                },
                signup_email : {
                    required: "E-mail é obrigatório",
                    email: "Endereço de e-mail inválido"
                },
                signup_password : {
                    required: "Senha é obrigatório"
                },
                signup_password_confirm: {
                    required: "Repetir senha é obrigatório",
                    equalTo: "Senhas incompatíveis"
                }
        }
    });
    
    $("#signup_submit").click(function() {
        if( !$("#basic-details-section:visible :input").valid() ) {
            return;
        }
    }); 

    $(".cne-next-step").click(function() {
        if( $("#profile-details-section:visible :input").valid() ){
            /* Baseado em <https://stackoverflow.com/questions/4060004/calculate-age-given-the-birth-date-in-the-format-yyyymmdd> */
            var birthday = new Date(Date.parse($('#field_2_month').val() + " " + $('#field_2_day').val()+ ", "+$('#field_2_year').val() ));
            var age = Math.floor((Date.now() - birthday) / (31557600000));
            if( age < 18 ) {
                $('#cne-label-signup-email').html("E-mail dos pais ou responsável (obrigatório)");
            } 
            if ($('#profile-details-section').is(':visible')){
                current_step = $('#profile-details-section');
                next_step = $('#basic-details-section');
            }

            next_step.show(); 
            current_step.hide();
        }
    });
    
    if($(".bbp-replies div.reply").length<=5){
            $("#cne-btn-load-more").hide();
    }else {
        $("#cne-btn-load-more").show();
    }
    
    /* Baseado em <https://codepen.io/elmahdim/pen/sGkvH> */
    $(".bbp-replies div.reply").slice(0, 5).show();
    $("#cne-btn-load-more").on('click', function (e) {
        e.preventDefault();
        $(".bbp-replies div.reply:hidden").slice(0, 5).slideDown();
        $(this).blur();
        if ($(".bbp-replies div.reply:hidden").length == 0) {
            $(this).fadeOut('slow');
        }
        $('body').animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
    
    $(".bbp-template-notice").attr('class', 'alert alert-warning');
        
    //equalHeight($(".thumbnail")); 
    //equalHeight($(".caption"));
    //equalHeight($(".cne-thumbnail-middle"));

});

/* extraido de <http://jsfiddle.net/PbfpU/2/> */
/*function equalHeight(group) {    
    tallest = 0;
    group.each(function($) {       
        thisHeight = $(this).height();       
        if(thisHeight > tallest) {          
            tallest = thisHeight;       
        }    
    })( jQuery );;    
    group.each(function($) { 
        $(this).height(tallest); 
    })( jQuery );;
} */


