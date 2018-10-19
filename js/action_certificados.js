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
	
	/*---------------------|CADASTRA CERTIFICADOS|----------------------*\
	| Author:   Cleber Marrara Prado                                    
	| Email:    cleber.marrara.prado@mail.com                           
	| Version:  1.1.6 													 
	| Date: 	15/10/2018
	| Cadastrar certificados no painel do cliente, aba certificados 	
	\*------------------------------------------------------------------*/
	$(document.body).on("click","#bt_cadCertif",function(){
		tipo = "aguarde";
	    var container = $("#formerros_cert");
	    $("#cad_cert").validate({
	        debug: true,
	        errorClass: "error",
	       errorContainer: container,
	        errorLabelContainer: $('ol', container),
	        wrapper: 'li',
	        rules: {
	            cer_tipo: 		{required: true},
	            cer_val: 		{required:true},
	            cer_status: 	{required:true},
	            cer_pin: 		{required:true, minlength:4}
 	        },
	        messages: {
	            cer_tipo: 		{required:"Escolha o tipo:"},
	            cer_val: 		{required:"Digite a data de Validade:"},
	            cer_status: 	{required:"escolha um status"},
	            cer_pin: 		{required:"Digite o PIN", minlength:"Mínimo 4 caracteres"}
	        },
	        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
	        },
	        unhighlight: function(element) {
	            $(element).closest('.form-group').removeClass('has-error');
	        }
	    });
	    if ($("#cad_cert").valid() == true) {
	        $.post("../controller/TRICertificados.php", {
	            acao: 		$("#acao").val(),
	            cer_cli: 	$("#clicod").val(),
	            cer_tipo: 	$("#cer_tipo").val(),
	            cer_enti: 	$("#cer_entidade").val(),
	            cer_val: 	$("#cer_val").val(),
	            cer_pin: 	$("#cer_pin").val(),
	            cer_puk: 	$("#cer_puk").val(),
	            cer_local: 	$("#cer_local").val(),
	            cer_sta: 	$("#cer_status").val(),
	            cer_id: 	$("#cer_id").val()
	        },
	                function (data) {
	                     if (data.status == "OK") {
			                $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-check"></i> ('+data.mensagem+') <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			                console.log(data.sql);
			                location.href = "clientes.php?token=" +$("#token").val()+"&clicod="+$("#clicod").val()+"&tab=certif";
					
			            }
			            else {
			                $("<div></div>").addClass("alert alert-warning alert-dismissable").html('<i class="fa fa-warning"></i> Cliente j&aacute; cadastrado <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			            }
	                }, "json");
	    }
	});

});
