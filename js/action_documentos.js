$(document).on("ready", function(){

	/*---------------|PEQUISA SOLIC DOCUMENTOS|--------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	22/11/2017											|
	| RELATORIO QUE VISUALIZA OS DOCUMENTOS JÁ DISPONÍVEIS			|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_doc_pesq",function(e){
			e.preventDefault;
			var token= $("#token").val();
			var emp = $("#sel_emp").val();
			var dep = $("#sel_dep").val();
			var ref = $("#doc_ref").val();
			$("#bt_doc_pesq").html("<i class='fa fa-spin fa-spinner'></i> Aguarde...");
			$("#doc_report").load("vis_solicitadocs.php?token="+token+"&dep="+dep+"&emp="+emp+"&ref="+ref,
				function(){
					$("#bt_doc_pesq").html("<i class='fa fa-search'></i> Pesquisar");
				});
			$("#doc_reportf").load("vis_solicitadocsf.php?token="+token+"&dep="+dep+"&emp="+emp+"&ref="+ref)
		});

	/*--------------------------DOCUMENTOS--------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - 12/03/2018 - Cleber Marrara Prado 				|
 	| Inserir docs no banco de dados 								|
	\*-------------------------------------------------------------*/
	$(document.body).on("click", "#bt_entradocs", function(){
		var container = $("#formerros_docs");
		//e.preventDefault;
		$("#doc_entrada").validate({
            debug: true,
            errorClass: "error",
            errorContainer: container,
            errorLabelContainer: $("ol", container),
            wrapper: 'li',
            rules: {
                sel_emp 	: {required: true},
                sel_docs 	: {required: true},
                sel_dep 	: {required: true},
                doc_ref 	: {required: true}
            },
            messages: {
                sel_emp 	: {required: "Selecione uma empresa"},
                sel_docs 	: {required: "Selecione um Documento "},
                sel_dep 	: {required: "Selecione um Departamento"},
                doc_ref 	: {required: "Informe a data de refer&ecirc;ncia"} 
            },
            highlight: function(element) {
        		$(element).closest('.form-group').addClass('has-error');
    		},
    		unhighlight: function(element) {
        		$(element).closest('.form-group').removeClass('has-error');
    		}
        });
		
		if($("#doc_entrada").valid()==true){
			$("#bt_doc_ent").html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIDocumentos.php",{
				acao	: "entra_docs",
				doc 	: $("#sel_docs").val(),
				emp 	: $("#sel_emp").val(),
				dep 	: $("#sel_dep").val(),
				res 	: $("#sel_resp").val(),
				obs 	: $("#doc_obs").val(),
				ori 	: $("#doc_origem").val(),
				loc 	: $("#doc_local").val(),
				ref 	: $("#doc_ref").val()
				},
				function(data){
					if(data.status=="OK"){
						//altera o status tal qual url
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#doc_entrada")[0].reset();
						$("#doc_report").load("vis_entradadocs.php").fadeIn("slow");
						$("#bt_doc_ent").html("<i class='fa fa-folder-open'></i> Receber");

					}
					else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
					}
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		}
	});

	/*-------------------------GERAR E-MAIL-------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - 13/03/2018 - Cleber Marrara Prado 				|
 	| Enviar o email para o banco de dados (status 2 - Draft)		|
	\*-------------------------------------------------------------*/
	$(document.body).on("click", "#bt_geraemail", function(){
		$(this).html("<i class='fa fa-cog fa-spin'></i> Processando...");
		$.post("../controller/TRIDocumentos.php",{
			acao	: "gera_email",
			dep 	: $("#sel_dep").val(),
			emp 	: $("#sel_emp").val(),
			ref 	: $("#doc_ref").val()
			},
			function(data){
				if(data.status=="OK"){
					//altera o status tal qual url
					$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
					$("#bt_geraemail").html("<i class='fa fa-plane'></i> Gerar Envio");
					$("#bt_geraemail").attr("disabled",true);

				}
				else{
					$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
				}
				console.log(data.sql);//TO DO mensagem OK
			},
			"json"
		);
	});
	/*---------------|RECEBER DOCUMENTOS|--------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/03/2016											|
	| ALTERAÇÂO CLEBER MARRARA PRADO 15/03/2016
	| BOTAO PARA ALTERAÇÃO DO STATUS DE RECIBO DE DOCS
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".dlink",function(e){
			e.preventDefault;
			tipo = "fa fa-spinner fa-spin";
			$.post("../controller/TRIDocumentos.php",{
				acao	: "recebe_doc",
				action	: $(this).data('action'),
				solic	: $(this).data('solic')
				},
				function(data){
					if(data.status=="OK"){
						$("#msg_conf").text("Status alterado para "+data.status);
						$("#doc_report").fadeOut();
						$("#doc_report").load("vis_entradadocs.php").fadeIn("slow");
						$("#pes_docs").trigger("click");//location.reload();
					} 
					else{
						$("#msg_conf").text("Status alterado para "+data.status);
						$("#doc_report").fadeOut();
						$("#doc_report").load("vis_docs.php").fadeIn("slow");
						//location.reload();
					}
					
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		});

});