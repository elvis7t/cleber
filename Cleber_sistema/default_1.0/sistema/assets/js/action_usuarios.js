$(document).ready(function(){

	/*AjaxStart e AjaxStop*/
	var tipo="";
	$(document).ajaxStart(function(){
		console.log(tipo);
		$('#'+tipo).modal('show');
	});
	$(document).ajaxStop(function(){
		$('#'+tipo).modal('hide');
	});
	
/*-------------------consulta CPF-------------------------*/
	$("#bt_pes_usu").click(function(){
		//tipo do modal
		tipo = "aguarde";
			$(".table td").each(function(){
				$(this).remove();
			});
		if(($("#usu_mail").val()=="")){
			$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-ban"></i> Verifique o email digitado! <a href="#" class="alert-link">Mais sobre CPF</a> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
		}
		else{
			$.post("../controller/PRIUsuarios.php",
			{
				acao:"consulta",
				usu_mail:$("#usu_mail").val()
			},
			function(data){
				$("#usu_mail").attr("readonly",true); //desabilita o preenchimento do CPF
				if(data.status==0){
					$("<div></div>").addClass("alert alert-info alert-dismissable").html('<i class="fa fa-check"></i> Usu&aacute;rio n&atilde;o existe, prosseguir! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					$("#firms").addClass("hide");
					$("#cadastro").removeClass("hide");
					$("#bt_pes_usu").addClass("hide");
					$("#bt_cad_usu").removeClass("hide");
					$("#bt_nova_usu").removeClass("hide");
					$("#usu_user").val($("#usu_mail").val());
					console.log(data.query);
				}
				else{
					//$("<div></div>").addClass("alert alert-warning alert-dismissable").html('<i class="fa fa-warning"></i> Cliente j&aacute; cadastrado <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					$("#firms").removeClass("hide");
					$("#cadastro").addClass("hide");
					$("#bt_pes_usu").addClass("hide");
					$("#bt_nova_usu").removeClass("hide");
					$(".table").append(data.mensagem);
				}
			}, "json");
		}
	});	

/*---------------------------------Nova Pesquisa USUARIO ---------------------------------*/	
	$("#bt_nova_usu").click(function(){
		$(this).addClass("hide");
		$("#bt_pes_usu").removeClass("hide");
		$("#bt_cad_usu").addClass("hide");
		$("#firms").addClass("hide");
		$("#cadastro").addClass("hide");
		$("#usu_mail").attr("readonly",false); //desabilita o preenchimento do CPF
		$("#formerros").fadeOut();
		
	});

/*----------------------------cadastra usuario-------------------------------------*/	
	$("#bt_cad_usu").click(function(){
		tipo = "cadastrar";
        var container = $("#formerros2");
		$("#cad_usu").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $('ol', container),
            wrapper: 'li',
			rules: {
				usu_mail:{required:true, email:true},
				usu_sexo:{required:true},
				usu_ncp	:{required:true, minlength:5},
				usu_rg	:{required:true, minlength:5},
				cep	:{required:true, minlength:8},
				num	:{required:true, minlength:1},
				bai	:{required:true, minlength:3},
				cid	:{required:true, minlength:3},
				uf	:{required:true, minlength:2},
				usu_log	:{required:true, minlength:5},
				usu_user:{required:true, email:true},
				usu_senha:{required:true, minlength:6},
				usu_csenha:{equalTo:"#usu_senha"}
			},
			messages: {
				usu_mail:{required: "Usu&aacute;rio Obrigat&oacute;rio", 		email:"Formato do email inv&aacute;lido. Use nome@provedor.com"},
				usu_sexo:{required: "Escolha o Sexo do usu&aacute;rio."},
				usu_ncp	:{required: "Qual o nome completo do Usu&aacute;rio?", 	minlenght:"Minimo 5 Letras"},
				usu_rg	:{required: "Qual o RG?",						 		minlength:"Minimo 6 N&uacute;meros"},
				cep	:{required: "Qual o CEP? Pesquisa automatica :)", 			minlength:"Minimo 8 Numeros"},
				num	:{required: "Numero do local.", 							minlength:"Minimo 1 Numero"},
				bai	:{required: "Bairro da Localidade e Obrigatorio.", 			minlength:"Minimo 3 Letras"},
				cid	:{required: "Cidade da Localidade e Obrigatorio.", 			minlength:"Minimo 3 Letras"},
				uf	:{required: "Estado Obrigat&oacute;rio.", 					minlength:"Min e Max 2 Letras"},
				usu_log	:{required: "Login Obrigat&oacute;rio.", 				minlength:"Min 5 Letras"},
				usu_user:{required: "Usu&aacute;rio Obrigat&oacute;rio", 		email:"Formato do email inv&aacute;lido. Use nome@provedor.com"},
				usu_senha:{required: "Senha &eacute; obrigat&oacute;rio", 		minlenght:"Min de 6 caracteres para Senha"},
				usu_csenha:{equalTo: "As senhas n&atilde;o conferem... Verifique!"}
			}
		
		});
		console.log($("#cad_usu").valid());
		
		if($("#cad_usu").valid()==true){
			$.post("../controller/PRIUsuarios.php",{
				acao		: "inclusao",
				usu_cpf		: $("#usu_cpf").val(),
				usu_sexo	: $("#usu_sexo:checked").val(),
				usu_senha	: $("#usu_senha").val(),
				usu_ncp		: $("#usu_ncp").val(),
				usu_rg	 	: $("#usu_rg").val(),
				usu_cep		: $("#cep").val(),
				usu_log		: $("#log").val(),
				usu_num		: $("#num").val(),
				usu_compl	: $("#compl").val(),
				usu_bai		: $("#bai").val(),
				usu_cid		: $("#cid").val(),
				usu_uf		: $("#uf").val(),
				usu_user	: $("#usu_user").val(),
				doc			: $("#documento").val()
				
			},
			function(data){
				$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> Usu&aacute;rio '+$("#usu_ncp").val()+' cadastrado com sucesso na PRIORE! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				console.log(data.status);//TO DO mensagem OK
				//limpa_formulario_all();
				$("#bt_nova_usu").trigger('click');
			},"json");
		}
		
	});
});