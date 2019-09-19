$(document).on("ready", function(){
	
	var nome="";
	var tipo = "";
	/*AjaxStart e AjaxStop*/
	$(document).ajaxStart(function(){
		$('#'+nome).html("<i class='fa fa-spinner fa-spin'></i> Processando");
	});
	$(document).ajaxStop(function(){
		$('#'+nome).html(tipo);
	});

	
		
	/*---------------|FUNCAO PARA CADASTRAR FABRICANTE |--------------\
	|	Author: 	Elvis Leite							    		|
	|	E-mail: 	elvis7t@gmail.com								|
	|	Version:	1.0												|
	|	Date:       31/10/2016						   				|
	\--------------------------------------------------------------*/
		
	$(document.body).on("click","#btn_cadFab", function(){
	var container = $("#formerrosCadFab"); 
	$("#cadFab").validate({
		debug: true,
		errorClass: "has-error",
	    validClass: "has-success",
		errorLabelContainer: $("ol", container),
		wrapper: 'li',
		rules: {
			fab_nome : {required: true}
				
		},
		messages:{
			fab_nome : {required:"Informe o Fabricante"}
		},
		highlight: function(element) {
			$(element).closest('.form-group').addClass('has-error');
		},
		unhighlight: function(element) {
			$(element).closest('.form-group').removeClass('has-error');
		}	
	});   
	if($("#cadFab").valid()==true){
			$("#btn_cadFab").html("<i class='fa fa-spin fa-spinner'></i> Processando...");
			$.post("../controller/TRIMaquinas.php",
				{
				acao:			"cadFabricante", 
				fab_nome:		$("#fab_nome").val()
						
				},function(data){
				if (data.status == "OK") {
					location.reload();
					$("#cadFab")[0].reset();
					$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#mens");
				}
				else { 
					$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#mens");
				}
				$("#btn_cadFab").html("<i class='fa fa-save'></i> Salvar");
			}, "json");
			}
		});
	/*---------------|FIM DO CADASTRO FABRICANTE |------------------*/		
	
	/*---------------|ALTERAR FABRICANTE|--------------*\
		|	Author: 	Elvis Leite			    		|
		|	E-mail: 	elvis7t@gmail.com				|
		|	Version:	1.0								|
		|	Date:       18/11/2016						|
		\----------------------------------------------*/
		
	
		$(document.body).on("click","#btn_Altfab",function(){
			console.log("CLICK OK");
			var token = $("#token").val();
			var lista = $("#lista").val();
			cod = $("#fab_id").val();
			
			
			$.post("../controller/TRIMaquinas.php",{
				acao: "Altera_fab",
				fab_id: cod,
				fab_nome: $("#fab_nome").val()
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					$(location).attr('href','fabricante.php?token='+token);
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
		
	/*---------------|FIM DE ALTERAR FABRICANTE |------------------*/	

	/*---------------|EXCLUIR FABRICANTE|-----------------*\
		|	Author: 	Elvis Leite			    		|
		|	E-mail: 	elvis7t@gmail.com				|
		|	Version:	1.0								|
		|	Date:       18/11/2016						|
		\----------------------------------------------*/
		
		/*|COM A CLASSE excHoras, FAZER A EXCLUSÃO DO BD|*/
		$(document.body).on("click",".exc_Fab",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIMaquinas.php",{
				acao: "exclui_fab",
				fab_id: cod
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					location.reload();
				} 
				else{
					alert(data.mensagem);
										
				}
			},
			"json");
		});
	/*---------------|FIM DE EXCLUIR FABRICANTE |------------------*/		
});