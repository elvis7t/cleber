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

/*---------------------|NOVO CHAMADO|--------------------*/
	$(document.body).on("click","#bt_cham",function(){
		var container = $("#formerros1");
		$("#cad_cham").validate({
	        debug: true,
	        errorClass: "error",
	        errorContainer: container,
	        errorLabelContainer: $("ol", container),
	        wrapper: 'li',
	        rules: {
	            sel_dept	: {required: true},
	            sel_tipo	: {required: true},
	            sel_maquina	: {required: true},
	            chm_obs		: {required: true}
	        },
	        messages: {
	            sel_dept	: {required: "Informe o departamento..."},
	            sel_tipo 	: {required: "Escolha uma tarefa:"},
	            sel_maquina : {required: "Escolha uma máquina:"},
	            chm_obs 	: {required: "Digite uma descri&ccedil;&atilde;o para a tarefa:"}
	        },
	         highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
	        },
	        unhighlight: function(element) {
	            $(element).closest('.form-group').removeClass('has-error');
	        }
	    });
	    if($("#cad_cham").valid()==true){
			$("#bt_cham").html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIEmpresas.php",{
				acao		: "novo_chamado",
				cham_dept	: $("#sel_dept").val(),
				cham_task	: $("#sel_tipo").val(),
				cham_maq	: $("#sel_maquina").val(),
				cham_cola	: $("#sel_colab").val(),
				cham_obs	: CKEDITOR.instances.chm_obs.getData()
				},
				function(data){
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#cad_cham")[0].reset();
						$("#bt_cham").html("<i class='fa fa-plus'></i> Incluir");
						
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
/*------------------------|SALVAR ATENDIMENTO|---------------------------*/
	$(document.body).on("click","#bt_save_cham", function(){
		$("#bt_save_cham").html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIEmpresas.php",{
				acao		: "salva_chamado",
				cham_id		: $("#chm_id").val(),
				cham_status	: $("#sel_status").val(),
				cham_percent: $("#cham_percent").val(),
				cham_obs	: CKEDITOR.instances.chm_obs.getData()
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
		$.post("../controller/TRIEmpresas.php",{
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
						acao		: "novo_listaver",
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

});