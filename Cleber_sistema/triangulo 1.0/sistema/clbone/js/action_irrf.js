$(document).ready(function(){
/*-----------------------------|NOVO IRPF|-----------------------*/
/*  Autor: Cleber Marrara Prado
	Data: 17/02/2016
*/
	$(document.body).on("click","#bt_novo_ir", function(){
		var container = $("#formerros3"); //definido em novo_irrf.php, linha 73
		$("#cad_ir").validate({
	        debug: true,
	        errorClass: "error",
	        errorContainer: container,
	        errorLabelContainer: $("ol", container),
	        wrapper: 'li',
	        rules: {
	            ir_ano	: {required: true},
	            ir_valor: {required: true}
	        },
	        messages: {
	            ir_ano	: {required: "Necessário informar o ANO de declara&ccedil;&atilde;o do IRPF"},
	            ir_valor: {required: "Informe o valor do Honor&aacute;rio"}
	        }
	    });
		if($("#cad_ir").valid()==true){
			$("#bt_novo_ir").html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIEmpresas.php",{
				acao		: "irrf",
				ir_cod		: $("#ir_cod").val(),
				ir_ano		: $("#ir_ano").val(),
				ir_valor	: $("#ir_valor").val(),
				ir_tipo		: $("#ir_tipo").val(),
				ir_compl	: $("#ir_compl").val()
				},
				function(data){
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#cad_ir")[0].reset();
						$("#bt_novo_ir").html("<i class='fa fa-plus'></i> Incluir");
						$("#irrf_cLi").fadeOut();
						$("#irrf_cli tbody").load("irrf_conCli.php?clicod="+$("#ir_cod").val()).fadeIn("slow");
						//location.reload();
						
					} else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					}
	                console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		}
	});
/*-----------------------------|ROTINA PARA ENVIO DO FORM - EMITIR RECIBO|-----------------------------------------------*/

	$(document.body).on("click","#print_recibo",function(){
		location.reload();
	});
/*-----------------------------|ROTINA PARA GERAR RELATÓRIO DE DECLARAÇÕES IRPF|------------------------------------------*/
	$("#bt_irver").on("click", function(){
		$("#aguarde").modal("show");
		var di 		= $("#rel_di").val();
		var df 		= $("#rel_df").val();
		var status 	= $("#rel_status").val();
		var altera	= $("#rel_altera").val();
		var periodo	= $("#rel_per").val();
		var vlde	= $("#rel_vlde").val();
		var vate	= $("#rel_vate").val();
		var pago 	= $("#rel_pago").val();
		$("#rls").load('irrf_conCli.php?di='+di+'&df='+df+'&status='+status+'&altera='+altera+'&periodo='+periodo+'&vlde='+vlde+'&vate='+vate+'&pago='+pago);
		$("#aguarde").modal("hide");
		$("#bt_IR_print").attr({
			'href':'../rel/rel_IR_print.php?di='+di+'&df='+df+'&status='+status+'&altera='+altera+'&periodo='+periodo+'&vlde='+vlde+'&vate='+vate+'&pago='+pago
		});
		
		$("#bt_excel").attr({
			'href':'../rel/rel_IR_excel.php?di='+di+'&df='+df+'&status='+status+'&altera='+altera+'&periodo='+periodo+'&vlde='+vlde+'&vate='+vate+'&pago='+pago
		});	
				
		
	});
/*-----------------------------|ROTINA PARA GERAR VERIFICAR OBSERVAÇÕES|----------------------------------------------------*/
	$(".info_obs").on("click",function(){
		$(".collapse").collapse('toggle');
	});
/*-----------------------------|ROTINA PARA GERAR RECIBO|----------------------------------------------------*/
	$("#gerar_recibo").on("click", function () {
		$(this).html("<i class='fa fa-spinner fa-spin'></i> Gerando Recibo...");
		// solução para pegar todos os check de IR marcados para a geraçao do boleto
		var checkeditems = $('input:checkbox[name="ir_cods[]"]:checked')
                       .map(function() { return $(this).val() })
                       .get()
                       .join(",");
        if(checkeditems==""){
        	alert("Escolha o serviço que deseja faturar!");
        	$("#gerar_recibo").html("<i class='fa fa-printer'></i> Gerar Recibo");
        }
        else{
			$.post("../controller/TRIEmpresas.php",
				{
					acao : "gerar_recibo",
					irpfs : checkeditems
				},
				function(data){
					if(data.status=="OK"){
							$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							$("#gerar_recibo").html("<i class='fa fa-printer'></i> Gerar Recibo");
							location.reload();
							
						} else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						}
		                console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
        }
		
	});
/*-----------------------------|ROTINA PARA CANCELAR RECIBO|----------------------------------------------------*/
	$(".irec_cancela").on("click", function(){
		var recibo = $(this).data("idrec");
		$("#msg_conf").html("");
		$("#confSim").removeClass("excRec").addClass("excRec");
		$("<p></p>").html("Deseja realmente cancelar o recibo " +recibo+ "?").appendTo("#msg_conf");
		$("#confirma").modal("show");
	});

	$(document.body).on("click", ".excRec", function(){
		
		$.post("../controller/TRIEmpresas.php",
		{
			acao : "canc_recibo",
			idrec : $(".irec_cancela").data("idrec")
		},
		function(data){
			if(data.status=="OK"){
				$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				//location.reload();
				console.log(data.mensagem);
				
			} else{
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			}
            console.log(data.sql);//TO DO mensagem OK
		},
		"json");
		$("#confirma").modal("hide");
		
	});
/*-----------------------------|ROTINA PARA PAGAR RECIBO|----------------------------------------------------*/
/*	Alteração - 08/03/2016 - Cleber Marrara
	Marcar recibo como Pago */
	$("#irec_forma").on("change", function(){
		if($(this).val()=="Cheque"){
			$("#dv_compl").removeClass("hide");
		}
		else{
			$("#dv_compl").addClass("hide");	
		}
	});
	var recibo = 0;
	$(".pagar_rec").on("click", function(){
		$("#pagar").modal("show");
		recibo = $(".pagar_rec").data("rec");
	});
		
	$("#bt_pagar_rec").on("click", function(){
		$("#msg_conf").html("");
		$("#confSim").removeClass("pagarRec").addClass("pagarRec");
		$("<p></p>").html("Deseja realmente marcar o recibo " +recibo+ " como pago?").appendTo("#msg_conf");
		$("#confirma").modal("show");	
		$("#pagar").modal("hide");	
	});

	$(document.body).on("click", ".pagarRec", function(){
		
		$.post("../controller/TRIEmpresas.php",
		{
			acao 	: "pagar_recibo",
			idrec 	: $(".pagar_rec").data("rec"),
			fpg		: $("#irec_forma").val(),
			obs 	: $("#irec_obs").val(),
			valor 	: $("#irec_valor").val(),
			compl 	: $("#irec_compl").val()
		},
		function(data){
			if(data.status=="OK"){
				$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				location.reload();
				console.log(data.mensagem);
				
			} else{
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			}
            console.log(data.sql);//TO DO mensagem OK
		},
		"json");
		$("#confirma").modal("hide");
		
	});
/*----------------------------------|ROTINA PARA GERAR RETORNO DA RECEITA|------------------------------*/
	
	$("#bt_novo_irec").on("click",function(){
		$.post("../controller/TRIEmpresas.php",
		{
			acao 	: "retorno",
			irid 	: $("#iret_irid").val(),
			tipo 	: $("#iret_tipo").val(),
			valor	: $("#iret_valor").val(),
			cotas 	: $("#iret_cotas").val(),
			pagto 	: $("#iret_pagto").val(),
			dtlib 	: $("#iret_data").val()
		},
		function(data){
			if(data.status=="OK"){
				$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				location.reload();
				console.log(data.mensagem);
				
			} else{
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			}
            console.log(data.sql);//TO DO mensagem OK
		},
		"json");
	});
/*----------------------------------|ROTINA PARA GERAR SELIC|------------------------------*/
	
	$("#bt_novo_selic").on("click",function(){
		$.post("../controller/TRIEmpresas.php",
		{
			acao 	: "selic",
			ref 	: $("#isel_ref").val(),
			taxa	: $("#isel_taxa").val()
		},
		function(data){
			if(data.status=="OK"){
				$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				location.reload();
				console.log(data.mensagem);
				
			} else{
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			}
            console.log(data.sql);//TO DO mensagem OK
		},
		"json");
	});
/*----------------------------------|ROTINA PARA EXCLUIR RETORNO DA RECEITA|------------------------------*/
	$("#btn_exc_darf").on("click", function(){
		var ret = $(this).data("registro");
		$("#msg_conf").html("");
		$("#confSim").removeClass("excRec").addClass("excDarf");
		$("<p></p>").html("Deseja realmente excluir o retorno  " +ret+ "?").appendTo("#msg_conf");
		$("#confirma").modal("show");
	});
	

	$(document.body).on("click",".excDarf",function(){
		$("#confirma").modal("hide");
		$.post("../controller/TRIEmpresas.php",
		{
			acao 	: "exc_darf",
			codigo 	: $("#btn_exc_darf").data("registro")
		},
		function(data){
			if(data.status=="OK"){
				$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				location.reload();
				console.log(data.mensagem);

				
			} else{
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			}
            console.log(data.sql);//TO DO mensagem OK
		},
		"json");
	});
/*----------------------------------|ROTINA PARA EXCLUIR RETORNO DA TAXA SELIC|------------------------------*/
	$(document.body).on("click","#btn_excSelic", function(){
		var ret = $(this).data("registro");
		$("#msg_conf").html("");
		$("#confSim").removeClass().addClass("btn btn-success excSelic");
		$("<p></p>").html("Deseja realmente excluir a taxa  " +ret+ "?").appendTo("#msg_conf");
		$("#confirma").modal("show");
	});
	

	$(document.body).on("click",".excSelic",function(){
		$("#confirma").modal("hide");
		$.post("../controller/TRIEmpresas.php",
		{
			acao 	: "exc_selic",
			selid 	: $("#btn_excSelic").data("registro")
		},
		function(data){
			if(data.status=="OK"){
				$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				location.reload();
				console.log(data.mensagem);

				
			} else{
				$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
			}
            console.log(data.sql);//TO DO mensagem OK
		},
		"json");
	});

	$(document.body).on("change","#rel_ref",function(){
		var ref = $(this).val();
		console.log(ref);
		$("#rls").load("irpf_conDarfQuota.php?ref="+ref);
	});

/*------------------|ENVIAR DARF VIA E-MAIL|--------------------*/
	$(document.body).on("click","#bt_maildarf", function(){
		$.post("../controller/TRIEmpresas.php",
		{
			acao:"email_darf",
			icotid:$(this).data("cota")
		},
		function(data){
			alert(data.mensagem);
		},
		"json");
	});


});