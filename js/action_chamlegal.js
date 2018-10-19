$(document).ready(function(){
/*-----------------------------|CHAMADOS|-----------------------*/
/*  Autor: Cleber Marrara Prado
	Data: 25/05/2016
*/

	var nome="";
	var tipo = "";
	/*AjaxStart e AjaxStop*/
	$(document).ajaxStart(function(){
		$('#'+nome).html("<i class='fa fa-spinner fa-spin'></i> Processando");
	});
	$(document).ajaxStop(function(){
		$('#'+nome).html(tipo);
	});

/*---------------------|NOVO CHAMADO|---------------------|
|
|
|
\*-------------------------------------------------------*/

	$(document.body).on("click","#bt_chamleg",function(){
		var container = $("#formerros_chamaleg");
		$("#cad_chamleg").validate({
	        debug: true,
	        errorClass: "error",
	        errorContainer: container,
	        errorLabelContainer: $("ol", container),
	        wrapper: 'li',
	        rules: {
	            cleg_depto		: {required: true},
	            cleg_tipo		: {required: true},
	            cleg_clist		: {required: true},
	            cleg_cliente	: {required: true},
	            cleg_datafim	: {required: true},
	            cleg_obs		: {required: function(){
	            					CKEDITOR.instances.cleg_obs.updateElement();
	            				  }
	            				}
	        },
	        messages: {
	            cleg_depto		: {required: "Informe o departamento..."},
	            cleg_tipo 		: {required: "Escolha o checklist"},
	            cleg_clist 		: {required: "Escolha ao menos uma tarefa:"},
	            cleg_cliente 	: {required: "Escolha um cliente"},
	            cleg_datafim 	: {required: "Estipule um prazo para o final da tarefa"},
	            cleg_obs 		: {required: "Digite uma descri&ccedil;&atilde;o para a tarefa:"}
	        },
	         highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
	        },
	        unhighlight: function(element) {
	            $(element).closest('.form-group').removeClass('has-error');
	        }
	    });
	    if($("#cad_chamleg").valid()==true){
			$("#bt_chamleg").html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIChamadosLegal.php",{
				acao		: "novo_chamado",
				cleg_depto	: $("#cleg_depto").val(),
				cleg_id 	: $("#cleg_id").val(),
				cleg_items 	: $("#cleg_clist").val(),
				cleg_cliente: $("#cleg_cliente").val(),
				cleg_datafim: $("#cleg_datafim").val(),
				cleg_colab	: $("#cleg_colab").val(),
				cleg_contato: $("#cleg_contato").val(),
				cleg_via	: $("#cleg_via").val(),
				cleg_obs	: CKEDITOR.instances.cleg_obs.getData()
				},
				function(data){
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#cad_chamleg")[0].reset();
						$("#bt_chamleg").html("<i class='fa fa-plus'></i> Incluir");
						
						javascript:history.go(-1);
						
					} else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					}
	                console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		}
	});

/*---------------------|ALTERAR CHAMADO|---------------------|
|
|
|
\*----------------------------------------------------------*/

	$(document.body).on("click","#bt_alt_chamleg",function(){
		var container = $("#formerros_chamaleg");
		$("#cad_chamleg").validate({
	        debug: true,
	        errorClass: "error",
	        errorContainer: container,
	        errorLabelContainer: $("ol", container),
	        wrapper: 'li',
	        rules: {
	            cleg_depto		: {required: true},
	            cleg_contato 	: {required: true},
	            cleg_datafim	: {required: true},
	            cleg_cliente	: {required: true},
	            cleg_obs 		: { required: function(textarea) {
       								CKEDITOR.instances[textarea.id].updateElement();
       								var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
       								return editorcontent.length === 0;
       							}
       						}
	        },
	        messages: {
	            cleg_depto		: {required: "Informe o departamento..."},
	            cleg_contato 	: {required: "Informe o Solicitante"},
	            cleg_datafim 	: {required: "Estipule um prazo para o final da tarefa"},
	            cleg_cliente 	: {required: "Escolha um cliente"},
	            cleg_obs 		: {required: "Digite uma descri&ccedil;&atilde;o para a tarefa:", minlength:"Digite ao menos 10 caracteres"}
	        },
	         highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
	        },
	        unhighlight: function(element) {
	            $(element).closest('.form-group').removeClass('has-error');
	        }
	    });
	    if($("#cad_chamleg").valid()==true){
			$("#bt_chamleg").html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIChamadosLegal.php",{
				acao		: "altera_chamado",
				cleg_depto	: $("#cleg_depto").val(),
				cleg_id		: $("#cleg_id").val(),
				cleg_cliente: $("#cleg_cliente").val(),
				cleg_datafim: $("#cleg_datafim").val(),
				cleg_colab	: $("#cleg_colab").val(),
				cleg_contato: $("#cleg_contato").val(),
				cleg_obs	: CKEDITOR.instances.cleg_obs.getData()
				},
				function(data){
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#cad_chamleg")[0].reset();
						$("#bt_chamleg").html("<i class='fa fa-plus'></i> Incluir");
						
						javascript:history.go(-1);
						
					} else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					}
	                console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		}
	});

	
/*---------------|PESQUISAR CHAMADOS - FILTRO |----------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	15/09/2016											|
\*-------------------------------------------------------------*/
	$(document.body).on("click","#btn_pes_cham",function(){
		nome = "btn_pes_cham";
		tipo = "<i class='fa fa-search'></i> Pesquisar"
		var user = $("#sel_user").val();
		var dtini = $("#cham_dtini").val();
		var dtfim = $("#cham_dtfim").val();
		var tarefa = $("#cham_tarefa").val();
		console.log("vis_chamados.php?user="+user+"&dtini="+dtini+"&dtfin="+dtfim+"&tarefa="+tarefa);
		$("#sl").load("meus_chamados.php?user="+user+"&dtini="+dtini+"&dtfin="+dtfim+"&tarefa="+tarefa);
		$("#sl2").load("chamados_fin.php?user="+user+"&dtini="+dtini+"&dtfin="+dtfim+"&tarefa="+tarefa);
		
	});
/*---------------|FECHAR CHAMADOS E AVALIAR |------------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	13/10/2016											|
\*-------------------------------------------------------------*/

	$(document.body).on("click","#bt_encerra_cham",function(){
		$("#close_chamado").modal("show");
	});

	$(document.body).on("click","#bt_closescore",function(){
		$.post("../controller/TRIChamadosLegal.php",{
			acao		: "encerra_chamado",
			cham_id		: $("#chm_id").val(),
			cham_aval	: $("#aval_score").rating().val()
			},
			function(data){
				if(data.status=="OK"){
					$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					$("#cad_atend")[0].reset();
					$("#bt_save_cham").html("<i class='fa fa-save'></i> Salvar");
					//$("#slc").load("meus_chamados.php").fadeIn("slow");
					location.reload();
					
				} else{
					$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				}
                console.log(data.sql);//TO DO mensagem OK
			},
			"json"
		);
	});
/*---------------|NOVO ITENS de CHECKLIST|---------------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	12/12/2017											|
\*-------------------------------------------------------------*/
	$(document.body).on("click","#bt_verif",function(){
		var container = $("#formerros_check");
			$("#cad_lista").validate({
	            debug: true,
	            errorClass: "error",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                lista_empresa 	: {required: true},
	                lista_data		: {required: true},
	                lista_compet	: {required: true},
	                lista_usuario 	: {required: true}
	            },
	            messages: {
	                lista_empresa	:{required: "Escolha a empresa"},
					lista_data		: {required: "Informe a data"},
	                lista_compet 	: {required: "Informe a competÊncia"},
	                lista_usuario 	: {required: "Informe o usuário"}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
				if($("#cad_lista").valid()==true){
					$("#bt_verif").html("<i class='fa fa-cog fa-spin'></i> Processando...");
					$.post("../controller/TRIEmpresas.php",{
						acao			: "novo_listaver",
						lista_empresa 	: $("#sel_emp").val(),
						lista_data		: $("#verif_data").val(),
						lista_compet	: $("#verif_compet").val(),
						lista_usuario	: $("#sel_colab").val()
						},
						function(data){
							if(data.status=="OK"){
								$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
								javascript:history.go(-1);
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
/*--------------------|SALVAR ATENDIMENTO|--------------------
|
|
|
\*-----------------------------------------------------------*/
	$(document.body).on("click","#bt_save_cleg", function(){
		var token = $("#token").val();
		var cnpj = $("#cnpj").val();
		$("#bt_save_cham").html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIChamadosLegal.php",{
				acao		: "salva_chamado",
				cleg_id		: $("#cleg_id").val(),
				cleg_percent: $("#cleg_percent").val(),
				cleg_obs	: CKEDITOR.instances.cleg_obs.getData()
				},
				function(data){
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#cad_atend")[0].reset();
						$("#bt_save_cham").html("<i class='fa fa-save'></i> Salvar");
						//$("#slc").load("meus_chamados.php").fadeIn("slow");
						location.reload();
						
					} else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					}
	                console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		window.location.href = "vis_tarefaslegal.php?token="+token+"&cnpj="+cnpj;
	});
/*---------------|FECHAR CHAMADOS E AVALIAR |------------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	13/10/2016											|
\*-------------------------------------------------------------*/

	$(document.body).on("click","#bt_encerra_cleg",function(){
		$("#close_chamado").modal("show");
	});

	$(document.body).on("click","#bt_closescore",function(){
		$.post("../controller/TRIChamadosLegal.php",{
			acao		: "encerra_chamado",
			cleg_id		: $("#cleg_id").val(),
			cleg_aval	: $("#aval_score").rating().val()
			},
			function(data){
				if(data.status=="OK"){
					$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					$("#bt_save_cleg").html("<i class='fa fa-save'></i> Salvar");
					//$("#slc").load("meus_chamados.php").fadeIn("slow");
					location.reload();
					
				} else{
					$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
				}
                console.log(data.sql);//TO DO mensagem OK
			},
			"json"
		);
	});

/*---------------|PESQUISAR CHAMADOS - FILTRO |----------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	15/09/2016											|
\*-------------------------------------------------------------*/
	$(document.body).on("click","#btn_pes_cleg",function(){
		nome = "btn_pes_cleg";
		tipo = "<i class='fa fa-search'></i> Pesquisar"
		var user = $("#cleg_colab").val();
		var dtini = $("#cleg_dtini").val();
		var dtfim = $("#cleg_dtfim").val();
		var tarefa = $("#cleg_tarefa").val();
		console.log("vis_tarfaslegal.php?user="+user+"&dtini="+dtini+"&dtfin="+dtfim+"&tarefa="+tarefa);
		$("#sl").load("meus_chamlegal.php?user="+user+"&dtini="+dtini+"&dtfin="+dtfim+"&tarefa="+tarefa);
		$("#sl2").load("chamlegal_consulta.php?user="+user+"&dtini="+dtini+"&dtfin="+dtfim+"&tarefa="+tarefa);
		$("#sl3").load("chamlegal_fin.php?user="+user+"&dtini="+dtini+"&dtfin="+dtfim+"&tarefa="+tarefa);
	});

/*----------|POPULANDO CHECKLIST PELO TIPO DE TAREFA|----------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     30/05/2018                                          |
| Objetivo: Popular o campo Checklist pela tarefa escolhida		|
\*-------------------------------------------------------------*/
	$(document.body).on("change","#cleg_tipo",function(){
	    tipo: "aguarde";
	    $.post("../controller/TRIChamadosLegal.php",
	    {
	        acao: "combo_check", 
	        lista_id: $(this).val()
	    },
	    function(data){
	        $("#cleg_clist").html(data);
	    }
	    , "html");
	});

	$(document.body).on("click","#cleg_allCheck", function(){
		if($(this).is(':checked') ){
        	$("#cleg_clist > option").prop("selected","selected").trigger("change");
    	}
    	else{
        	$("#cleg_clist > option").removeAttr("selected").trigger("change");
        }
	});

/*---------------|EXCLUIR ITEM DE CHECKLIST|-------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     27/06/2018                                          |
\*-------------------------------------------------------------*/

    $(document.body).on("click",".excDocCham", function(){
        cod = $(this).data("reg");
        console.log(cod);
        $.post("../controller/TRIChamadosLegal.php",{
            acao: "exclui_itemchecklist",
            chk_id: cod
        },
        function(data){
            if(data.status=="OK"){
                alert(data.mensagem);
                location.reload();
            } 
            else{
                alert(data.mensagem);   
            }
        },
        "json");
    });
/*---------------|CONF NAO|------------------------------------*\
| Author:   Cleber Marrara Prado                                |
| Version:  1.0                                                 |
| Email:    cleber.marrara.prado@gmail.com                      |
| Date:     11/11/2016                                          |
| Limpa as mensagens armazenadas em msgConf                     |
\*-------------------------------------------------------------*/
	$(document.body).on("click", "#confNao", function(){
		console.log("CLICK OK");
	    $("#msg_conf").html("");
	    $("#confSim").data("reg","");
	});

});
