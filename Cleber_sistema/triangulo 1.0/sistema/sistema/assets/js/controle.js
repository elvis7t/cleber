$(document).ready(function(){
	var tipo="";
	/*AjaxStart e AjaxStop*/
	$(document).ajaxStart(function(){
		$('#'+tipo).modal('show');
	});
	$(document).ajaxStop(function(){
		$('#'+tipo).modal('hide');
	});

/*------------------------tooltip--------------------------------------------------*/
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})

/*--------------------------------Add Contatos-------------------------------------*/
	$("#bt_add_cont").on("click",function(){
		tipo = "cadastrar";
		var container = $("#formerros1");
		$("#cad_dados").validate({
			debug:true,
			errorClass: "invalid",
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: 'li',
			rules: {
				con_tipo:{required:true}
			},
			messages: {
				con_tipo:{required: "O campo &eacute; obrigat&oacute;rio para qualquer valor."}
			}
		});
		if($("#cad_dados").valid()==true){
			$.post("../controller/PRIConsultaEmpresa.php",{
				acao:"dados",
				con_cli_cnpj: $("#emp_cnpj").val(),
				con_tp: $("#tpcon").attr("class"),
				con_cont: $("#con_tipo").val()			
			}, function(){
				$("#tabela_ctt").fadeOut();
				$("#tabela_ctt").load("../view/contatos.php?cnpj="+ $("#emp_cnpj").val()).fadeIn("slow");
				$("#con_tipo").val("");
			});
		}
	});
/*-----------------Links do tipo de Contato-------------------------------------------*/
	$("a").click(function(){
		switch($(this).data('type')){
			case "mail":
				$("#tpcon").removeClass();
				$("#con_tipo").removeClass();
				$("#tpcon").addClass("fa fa-envelope");
				$("#con_tipo").addClass("form-control input-sm email");
				break;
				
			case "cel":
				$("#tpcon").removeClass();
				$("#con_tipo").removeClass();
				$("#tpcon").addClass("fa fa-mobile");
				$("#con_tipo").addClass("form-control input-sm cel");
				break;
				
			case "wts":
				$("#tpcon").removeClass();
				$("#con_tipo").removeClass();
				$("#tpcon").addClass("fa fa-whatsapp");
				$("#con_tipo").addClass("form-control input-sm cel");
				break;
				
			case "tel":
				$("#tpcon").removeClass();
				$("#con_tipo").removeClass();
				$("#tpcon").addClass("fa fa-phone");
				$("#con_tipo").addClass("form-control input-sm tel");
				break;
		}
	});
	
	
/*-----------------------------busca_cep------------------------------------*/	
	function limpa_formulario_all(){
		$(".form-control").each(function(){
			$(this).val("");
		});
	}	
	
	function limpa_formulario_cep() {
		// Limpa valores do formulário de cep.
		$("#log").val("");
		$("#bai").val("");
		$("#cid").val("");
		$("#uf").val("");
	}

	//Quando o campo cep perde o foco.
	$("#cep").blur(function() {

	//Nova variável "cep" somente com dígitos.
	var cep = $(this).val().replace(/\D/g, '');

	//Verifica se campo cep possui valor informado.
	if (cep != "") {

	//Expressão regular para validar o CEP.
	var validacep = /^[0-9]{8}$/;

	//Valida o formato do CEP.
	if(validacep.test(cep)) {

		//Preenche os campos com "..." enquanto consulta webservice.
		$("#log").val("...");
		$("#bai").val("...");
		$("#cid").val("...");
		$("#uf").val("...");


	//Consulta o webservice viacep.com.br/
		$.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
			if (!("erro" in dados)) {
				//Atualiza os campos com os valores da consulta.
				$("#log").val(dados.logradouro);
				$("#bai").val(dados.bairro);
				$("#cid").val(dados.localidade);
				$("#uf").val(dados.uf);
				$("#num").focus();
			} //end if.
			else {
				//CEP pesquisado não foi encontrado.
				limpa_formulario_cep();
				alert("CEP não encontrado.");
			}
			});
		} //end if.
		else {
			//cep é inválido.
			limpa_formulario_cep();
			alert("Formato de CEP inválido.");
			}
		} //end if.
		else {
			//cep sem valor, limpa formulário.
			limpa_formulario_cep();
		}
	});


});