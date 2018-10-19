$(document).ready(function () {
    var tipo = "";
    /*AjaxStart e AjaxStop*/
    
    $(document).ajaxStart(function () {
        console.log(tipo);
        $('#' + tipo).modal('show');
    });

    $(document).ajaxStop(function () {
        $('#' + tipo).modal('hide');
    });

    /*---------------------CADASTRO DE ARQUIVOS---------------------*\
    | Author:   Cleber Marrara Prado                                |
    | Version:  1.0                                                 |
    | Email:    cleber.marrara.prado@gmail.com                      |
    | Date:     15/032018                                           |
    | Objetivo: cadastrar arquivos que são recebidos dos clientes   |
    \*-------------------------------------------------------------*/
    $(document.body).on("click","#bt_cadarquivos",function(){
        tipo = "cadastrar";
        var container = $("#formerros_arquivos");
        $("#cad_arquivo").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $('ol', container),
            wrapper: 'li',
            ignore: 'input[type=hidden], .select2-input, .select2-focusser',
            rules: {
                tarq_nome:       {required: true},
                tarq_depto:      {required: true},
                tarq_formato:    {required: true},
                tarq_ativo:      {required: true}
            },
            messages: {
                tarq_nome:       {required: "Digite o nome do aquivo:"},
                tarq_depto:      {required: "Qual o departamento?"},
                tarq_formato:    {required: "Qual o formato de envio?"},
                tarq_desc:       {required: "Forne&ccedil;a detalhes para do imposto"}
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            }
        });

        if ($("#cad_arquivo").valid() == true) {
            $.post("../controller/TRIArquivos.php", {
                acao:           $("#acao").val(),
                tarq_nome:      $("#tarq_nome").val(),
                tarq_id:        $("#arq_id").val(),
                tarq_depto:     $("#tarq_depto").val(),
                tarq_formato:   $("#tarq_formato").val(),
                tarq_duplica:   $("#tarq_duplica").val(),
                tarq_status:    $("#tarq_status").val(),
                tarq_desc:      CKEDITOR.instances.tarq_desc.getData()
            },
                    function (data) {
                        if(data.status=="OK"){
                            $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                            console.log(data.sql);//TO DO mensagem OK
                            //limpa_formulario_all();
                            location.href = "cad_arquIvOs.php?token=" +$("#token").val()+"&cnpj="+$("#cnpj").val();
                        }
                        else{
                            $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-flag-checkered"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        }
                        
                    }, "json");
        }
     });
});