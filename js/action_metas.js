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

/*------------------------|NOVA META|--------------------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	25/01/2018											|
\*-------------------------------------------------------------*/
	$(document.body).on("click","#bt_meta",function(){
		var container = $("#formerrosmeta");
			$("#cad_meta").validate({
	            debug: true,
	            errorClass: "error",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                meta_ini	: {required: true},
	                meta_fim	: {required: true},
	                meta_user 	: {required: true}
	            },
	            messages: {
	                meta_ini	: {required: "Informe a data inicial"},
	                meta_fim 	: {required: "Informe a data final"},
	                meta_user 	: {required: "Informe o usuário"}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
				if($("#cad_meta").valid()==true){
					$("#bt_meta").html("<i class='fa fa-cog fa-spin'></i> Processando...");
					$.post("../controller/TRIMetas.php",{
						acao		: "nova_meta",
						meta_ini	: $("#meta_ini").val(),
						meta_fim	: $("#meta_fim").val(),
						meta_user	: $("#meta_user").val()
						},
						function(data){
							if(data.status=="OK"){
								$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
								javascript:history.go(-1);
								//location.reload();
								
							} else{
								$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
	                       		$("#bt_meta").html("<i class='fa fa-cog'></i> Iniciar");
							}
	                        console.log(data.sql);//TO DO mensagem OK
						},
						"json"
					);
				}
		
	});

/*---------------|RELATORIOS DE SAÍDAS|------------------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	03/03/2018											|
\*-------------------------------------------------------------*/
	$(document.body).on("click", "#btn_pesqmetas", function(){
		$("#aguarde").modal("show");
		$(this).html("<i class='fa fa-spin fa-spinner'></i>");
		var dep 	= $("#metas_depart").val();
		var emp 	= $("#metas_colab").val();
		var din		= $("#metas_dtini").val();
		var dif 	= $("#metas_dtfim").val();
		$("#vismetas").load('minhas_metas.php?dep='+dep+'&emp='+emp+'&di='+din+'&df='+dif, function(){
			$("#aguarde").modal("hide");
			$("#btn_pesqmetas").html("<i class='fa fa-search'></i> Pesquisar");
			console.log('minhas_metas.php?dep='+dep+'&emp='+emp+'&di='+din+'&df='+dif);
		});				
	});

/*---------------|PESQUISA OBRIGAÇÕES|-------------------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	26/04/2018											|
\*-------------------------------------------------------------*/
	$(document.body).on("click", "#btn_pesq_tarefa", function(){
		$("#aguarde").modal("show");
		$(this).html("<i class='fa fa-spin fa-spinner'></i>");
		var emp 	= $("#lismetas_emp").val();
		var dep 	= $("#lismetas_depart").val();
		var tipo 	= $("#lismetas_tipo").val();
		var din		= $("#lismetas_inicial").val();
		var dif 	= $("#lismetas_final").val();
		var obriga 	= $("#lismetas_obriga").val();
		var colab 	= $("#lismetas_colab").val();
		var lista	= $("#lismetas_lista").val();
		var compet	= $("#lismetas_compet").val();
		$("#metas_obr").load('vis_metas_aberto.php?dep='+dep+'&emp='+emp+'&di='+din+'&df='+dif+'&tipo='+tipo+'&obriga='+obriga+'&lista='+lista+'&compet='+compet+'&colab='+colab, function(){
			$("#aguarde").modal("hide");
			$("#btn_pesq_tarefa").html("<i class='fa fa-search'></i> Pesquisar");
		});				
	});

/*----------|ADICIONAR TAREFAS À LISTA DE METAS|-----------*\
| Author: 	Cleber Marrara Prado		                 	|
| Version: 	1.0 			            					|
| Email: 	cleber.marrara.prado@gmail.com 					|
| Date: 	29.01.2018									    |	
\*---------------------------------------------------------*/
	$(document.body).on("click","#btn_nova_tarefa", function(){
		var checkeditems = $('input:checkbox[name="lista_tasks[]"]:checked')
        	.map(function() { return $(this).val() })
			.get()
			.join(",");
	    if(checkeditems==""){
	        alert("Escolha a empresa!");
	    }
	    else{
        $.post("../controller/TRIMetas.php",
            {
                acao	: "listar_metas",
                valor 	: checkeditems,
                lista 	: $("#lismetas_listaat").val()
            },
            function(data){
                if(data.status=="OK"){
                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                        $("#btn_pesq_tarefa").trigger("click");
                        $("#vis_metas").load("vis_metaslistadas.php?lista="+$("#lismetas_listaat").val());
                        //alert("vis_metaslistadas.php?lista="+$("#lismetas_listaat").val());
                        
                    } else{
                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
                    }
                    console.log(data.sql);//TO DO mensagem OK
            	},
            	"json"
        	);
    	}
	});

/*---------------|EXCLUIR TAREFAS EM LOTE|-----------------*\
| Author: 	Cleber Marrara Prado		                 	|
| Version: 	1.0 			            					|
| Email: 	cleber.marrara.prado@gmail.com 					|
| Date: 	07.05.2018									    |	
\*---------------------------------------------------------*/
	$(document.body).on("click","#exclote", function(){
		var checkeditems = $('input:checkbox[name="listados[]"]:checked')
        	.map(function() { return $(this).val() })
			.get()
			.join(",");
	    if(checkeditems==""){
	        alert("Escolha uma tarefa!");
	    }
	    else{
	    	if(confirm("Confirma a exclusão multipla de tarefas?")){
		        $.post("../controller/TRIMetas.php",
		            {
		                acao	: "excluir_lote",
		                valor 	: checkeditems,
		                lista 	: $("#lismetas_listaat").val()
		            },
		            function(data){
		                if(data.status=="OK"){
		                        $("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
		                        $("#btn_pesq_tarefa").trigger("click");
		                        $("#vis_metas").load("vis_metaslistadas.php?lista="+$("#lismetas_listaat").val());
		                        //alert("vis_metaslistadas.php?lista="+$("#lismetas_listaat").val());
		                        
		                    } else{
		                        $("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
		                    }
		                    console.log(data.sql);//TO DO mensagem OK
		            	},
		           	"json"
		        );
		    }
    	}
	});


/*------------------|NOVA OCORRENCIAS DE META|-----------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	05/02/2018											|
\*-------------------------------------------------------------*/

	$(document.body).on("click","#bt_save_ocmetas", function(){
		var container = $("#formerrosocmetas");
		$("#bt_save_ocmetas").html("<i class='fa fa-cog fa-spin'></i> Processando...");
		$.post("../controller/TRIEmpresas.php",{
			acao			: "oc_metas",
			metasobs_tarId	: $("#metas_task").val(),
			metasobs_obs	: CKEDITOR.instances.metas_obs.getData()
			},
			function(data){
				if(data.status=="OK"){
					$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					$("#bt_save_ocmetas").html("<i class='fa fa-save'></i> Salvar");
					//$("#slc").load("meus_chamados.php").fadeIn("slow");
					location.reload();
					
				} else{
					$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					$("#bt_save_ocmetas").html("<i class='fa fa-save'></i> Salvar");
				}
                console.log(data.sql);//TO DO mensagem OK
			},
			"json"
		);						
	});

/*---------------------|EXCLUIR META|--------------------------*\
| Author: 	Cleber Marrara Prado 								|
| Version: 	1.0 												|
| Email: 	cleber.marrara.prado@gmail.com 						|
| Date: 	20/02/2018											|
\*-------------------------------------------------------------*/

	$(document.body).on("click",".exc_metalista",function(){
	    console.log("CLICK OK");
	    //cod = $("#cod").val();
	    $.post("../controller/TRIEmpresas.php",{
	        acao: "exclui_metaLista",
	        tarmetas_id: $(this).data("reg")
	    },
	    function(data){
	        if(data.status=="OK"){
	        	$("#confirma").modal("hide");
	            alert(data.mensagem);
	            $("#aguarde").modal("show");
	            location.reload();
	        } 
	        else{
	            alert(data.mensagem);   
	        }
	    },
	    "json");
	    
	});
});