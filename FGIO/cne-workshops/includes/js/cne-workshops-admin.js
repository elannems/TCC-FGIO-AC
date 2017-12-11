jQuery(document).ready(function($){
    
    console.log('js admin');
    
    $('#cnew-reg-date-birth').mask('99/9999',{placeholder:"mm/aaaa"});
    
    $('#cnew-reg-parent-phone').mask('(99) 99999999?9');
    
    $('#cnew-start-date').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: 0
    });
    
    $('#cnew-end-date').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: 0
    });
    
    $.validator.addMethod(
        "formatDate",
        function(value, element) {
            //Retirado de <http://regexlib.com/REDetails.aspx?regexp_id=409>
            return value.match(/^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((1[6-9]|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((1[6-9]|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((1[6-9]|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/);
        },
        "Formato de data inválido! Por favor, informe uma data no formato dd/mm/yyyy."
    );
        
    $.validator.addMethod(
        "startDate",
        function(value, element) {
            var today = new Date();
            today.setHours(0,0,0,0);
            var startDate = convertDate(value);
            return today <= startDate;
        },
        "A data de início das inscrições precisa ser igual ou maior que a data de hoje."
    );   
    //Baseado em <http://stackoverflow.com/questions/833997/validate-that-end-date-is-greater-than-start-date-with-jquery>
    $.validator.addMethod(
        "endDate",
        function(value, element, params) {
            var startDate = convertDate($(params).val());
            var endDate = convertDate(value);
            return startDate <= endDate;
        },
        "A data de encerramento das inscrições precisa ser igual ou maior que a data de início."
    );
        
    $.validator.addMethod(
        "formatDateBirth",
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
    
    $('#post')
    .validate({
        rules : {
            cnew_content : {
                required : true
            },
            cnew_objective : {
                required : true
            },
            cnew_target_audience : {
                required : true
            },
            cnew_start_date : {
                formatDate : true,
                required : true,
                startDate: true
            },
            cnew_end_date : {
                formatDate : true,
                required : true,
                endDate : "#cnew-start-date"
            },
            cnew_date_event : {
                required : true
            },
            cnew_vacancies : {
                min: 0
            },
            cnew_form_type : {
                required : true
            },
            cnew_reg_name: {
                required : true,
                maxlength : 255
            },
            cnew_reg_date_birth: {
                required : true,
                formatDateBirth : true,
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
            cnew_content: {
                required: "Por favor, insira o conteúdo da oficina."
            },
            cnew_objective: {
                required: "Por favor, informe o objetivo da oficina."
            },
            cnew_target_audience: {
                required: "Por favor, informe qual o público alvo da oficina."
            },
            cnew_form_type: {
                required: "Por favor, informe o tipo de formulário de inscrição para esta oficina."
            },
            cnew_start_date: {
                required: "Por favor, informe uma data para iniciar as inscrições."
            },
            cnew_end_date: {
                required: "Por favor, informe uma data para encerrar as inscrições."
            },
            cnew_date_event: {
                required: "Por favor, informe a data em que ocorrerá a oficina."
            },
            cnew_vacancies: {
                min: "Por favor, o número de vagas precisa ser igual ou maior que 0."
            },
            cnew_reg_name: {
                required: "Por favor, informe o nome do participante.",
                maxlength: "O campo só aceita 255 caracteres."
            },
            cnew_reg_date_birth: {
                required: "Por favor, informe o mês e ano de nascimento do participante."
            },
            cnew_reg_gender: {
                required: "Por favor, selecione uma das opções."
            },
            cnew_reg_parent_name: {
                required: "Por favor, informe o nome do responsável.",
                maxlength: "O campo só aceita 255 caracteres."
            },
            cnew_reg_parent_phone: {
                required: "Por favor, informe o número de telefone do responsável.",
                maxlength: "O campo só aceita 15 caracteres."
            },
            cnew_reg_email: {
                required: "Por favor, informe o e-mail do responsável.",
                email: "Por favor, informe um endereço de e-mail válido",
                maxlength: "O campo só aceita 100 caracteres."
            }
        }
    });
    
});
    
function convertDate(date) {
    var parts = date.split("/");
    //Baseado em <http://stackoverflow.com/questions/10430321/how-to-parse-a-dd-mm-yyyy-or-dd-mm-yyyy-or-dd-mmm-yyyy-formatted-date-stri>
    var newDate = new Date(
                    parseInt(parts[2], 10),
                    parseInt(parts[1], 10) - 1,
                    parseInt(parts[0], 10)
                );

    return newDate;
}
        
