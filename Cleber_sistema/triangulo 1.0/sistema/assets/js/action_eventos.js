$(document).ready(function(){
	var tipo = "";
    /*AjaxStart e AjaxStop*/
    $(document).ajaxStart(function () {
        console.log(tipo);
        $('#' + tipo).modal('show');
    });
    $(document).ajaxStop(function () {
        $('#' + tipo).modal('hide');
    });
	
	$("#eve_valor").on("change", function(){
		$("#vtr").text("Valor Truck R$"+$(this).val()+" - ");
		$("#vbk").text("Valor Bike R$"+($(this).val()/2));
	});

/*-------------------#btn-partok ----------------------*/
	$("#btn-partok").on("click", function(){
		//tipo = "cadastrar";
        var container = $("#formerros");
		$("#participe").validate({
            debug: true,
            errorClass: "has-error",
            errorContainer: container,
            errorLabelContainer: $("ol", container),
            wrapper: 'li',
            rules: {
                //rd_pag: {required: true},
                eve_data1: {required: true},
                eve_data2: {required: true}
            },
            messages: {
                //rd_pag: {required: "Escolha uma forma de pagamento"},
                eve_data1: {required: "Escolha uma data para o primeiro pgamento"},
                eve_data2: {required: "Escolha uma data para o segundo pagamento"}
            }
        });
        
	});

/*-------------------#atodos - Seleciona todos os Checkboxes ----------------------*/
	$("#atodos").on("click", function(){
		if($("#atodos").hasClass("btn-danger")){
			
			$("#atodos").removeClass("btn-danger").addClass("btn-success");
			$("#itodos").removeClass("fa-times").addClass("fa-check-square-o")
			$('input[type="checkbox"]').iCheck('check');
		}
		else{
			$("#atodos").removeClass("btn-success").addClass("btn-danger");
			$("#itodos").removeClass("fa-check-square-o").addClass("fa-times");
			$('input[type="checkbox"]').iCheck('uncheck');
		}
	});
	
/* bt_cad_eve - Cadastrar Evento */
	$("#bt_cad_eve").on("click", function(){
		tipo = "cadastrar";
        var container = $("#formerros");
		$("#cad_eve").validate({
			debug: true,
            errorClass: "invalid",
            errorContainer: container,
            errorLabelContainer: $("ol", container),
            wrapper: 'li',
            rules: {
                eve_local	: {required: true, minlength: 10},
                eve_emp		: {required: true},
                eve_det		: {required: true, minlength: 30},
                eve_valor	: {required: true, minlength: 4},
				cep			: {required: true, minlength: 8},
                num			: {required: true, minlength: 1},
                bai			: {required: true, minlength: 3},
                cid			: {required: true, minlength: 3},
                uf			: {required: true, minlength: 2}
            },
            messages: {
                eve_local	: {required: "Digite o Local", minlength: "M&iacute;nimo 10 caracteres"},
                eve_emp		: {required: "Escolha uma empresa."},
                eve_det		: {required: "Detalhes para o evento. Deixe-o chamativo", minlength: "Exigido mais de 30 caracteres"},
                eve_valor	: {required: "Quanto Custa?", minlength: "Valor inv&aacute;lido..."},
				cep			: {required: "Qual o CEP? Pesquisa automatica :)", minlength: "Minimo 8 Numeros"},
                num			: {required: "Numero do local.", minlength: "Minimo 1 Numero"},
                bai			: {required: "Bairro da Localidade e Obrigatorio.", minlength: "Minimo 3 Letras"},
                cid			: {required: "Cidade da Localidade e Obrigatorio.", minlength: "Minimo 3 Letras"},
                uf			: {required: "Estado Obrigatorio.", minlength: "Min e Max 2 Letras"}
                
			}
        });
        if ($("#cad_eve").valid() == true) {
            $.post("../controller/PRIEventos.php", {
                acao: "inclusao",
                eve_local	: $("#eve_local").val(),
                eve_emp		: $("#eve_emp").val(),
                eve_data	: $("#eve_data").val(),
                eve_det		: $("#eve_det").val(),
                eve_valor	: $("#eve_valor").val(),
				eve_cep		: $("#cep").val(),
                eve_log		: $("#log").val(),
                eve_num		: $("#num").val(),
                eve_compl	: $("#compl").val(),
                eve_bai		: $("#bai").val(),
                eve_cid		: $("#cid").val(),
                eve_uf		: $("#uf").val(),
                eve_ativo	: 1
				},
				function (data) {
					$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> Evento cadastrada com sucesso na PRIORE! Envie o convite para a lista abaixo! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					 console.log(data.status);//TO DO mensagem OK
                        //limpa_formulario_all();
                        $("#bt_nova_pes").trigger('click');
						$("#firms").removeClass("hide").fadeIn();
                   }, "json");
        }
	});
/*---------------------------------Nova Pesquisa ---------------------------------*/	
	$("#bt_nova_pes").click(function () {
        $(this).addClass("hide");
        $("#bt_pes_eve").removeClass("hide");
        $("#bt_cad_eve").addClass("hide");
        $("#event").addClass("hide");
        $("#firms").addClass("hide");
        $("#cadastro").fadeOut();
        $("#eve_data").attr("readonly", true);
        $("#formerros").fadeOut();
		$(".alert-info").fadeOut();
		$(".alert-danger").fadeOut();
		
    });
	
/*------------------------------------ btn_part - Botão participar ----------------------------*/
	$(".btn-part").on("click", function(){
		var evt = $(this).data("evento");
		$("#participar").modal('show');
		$("#eve_data1").val("");
		$("#eve_data2").val("");
		$("#dataini").val($("#eve_dtini"+evt).val());
		$("#datafin").val($("#eve_dtfin"+evt).val());
		/*Preencher campos ID com informações do evento para o contrato*/
		$("#cnpj").val($("#eve_empcnpj"+evt).val());
		$("#nome").val($("#eve_empnome"+evt).val());
		$("#local").val($("#eve_local"+evt).val());
		$("#dataeve").val($("#eve_dataeve"+evt).val());
		$("#dataate").val($("#eve_dataate"+evt).val());
		$("#respons").val($("#eve_empresp"+evt).val());
		$("#endere").val($("#eve_ender"+evt).val());
		$("#valor").val($("#eve_valor"+evt).val());
		$("#valorpext").val($("#eve_vpext"+evt).val());
		
		/*Passando informações sobre datas para o calendário*/
		$('#eve_data1').daterangepicker({
			singleDatePicker: true,
			language		: 'pt',
			format			: 'DD/MM/YYYY',
			maxDate			: $("#dataini").val()
		});
		$('#eve_data2').daterangepicker({
			singleDatePicker: true,
			language		: 'pt',
			format			: 'DD/MM/YYYY',
			maxDate			: $("#datafin").val()
		});
	});
	
/*--------------------------------- btn_con_eve - Consultar evento pela data -------------------*/
	$("#bt_pes_eve").on("click", function(){
		tipo = "aguarde";
		$("#event td").each(function () {
            $(this).remove();
        });
		if($("#eve_data").val()==""){
			$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-check"></i> Digite uma data v&aacute;lida <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    
		}
		else{
			$.post("../controller/PRIEventos.php", {
				acao: "consulta",
				eve_data	: $("#eve_data").val(),
				},
				function (data){
					if (data.status == 0) {
						$("<div></div>").addClass("alert alert-info alert-dismissable").html('<i class="fa fa-check"></i> Evento n&atilde;o existe, prosseguir! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#firms").addClass("hide");
						$("#cadastro").fadeIn();
						$("#eve_emp").chosen({
							no_results_text: "Nada encontrado..."
						});
						$("#bt_pes_eve").addClass("hide");
						$("#bt_cad_eve").removeClass("hide");
						$("#bt_nova_pes").removeClass("hide");
						console.log(data.query);
					}
					else {
						$("<div></div>").addClass("alert alert-warning alert-dismissable").html('<i class="fa fa-warning"></i> Evento j&aacute; cadastrado <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#event").removeClass("hide");
						$("#cadastro").fadeOut();
						$("#bt_pes_emp").addClass("hide");
						$("#bt_nova_pes").removeClass("hide");
						$("#table_eve").append(data.mensagem);
					}
			}, "json");
		}
	});
});