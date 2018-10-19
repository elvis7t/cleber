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
	$(document.body).on("click","#bt_art",function(){
		var container = $("#formerros_artigos");
		$("#cad_art").validate({
	        debug: true,
	        errorClass: "error",
	        errorContainer: container,
	        errorLabelContainer: $("ol", container),
	        wrapper: 'li',
	        rules: {
	            art_dep 	: {required: true},
	            art_col 	: {required: true},
	            art_title	: {required: true},
	            art_title2	: {required: true},
	            art_fonte	: {required: true},
	            art_email	: {required: true},
	            art_descr	: {required: true},
	            art_brief	: {required: true},
	            art_cont	: {required: true},
	            art_img		: {required: true}
	        },
	        messages: {
	            art_dep 	: {required: "Informe o departamento:"},
	            art_col		: {required: "Informe um colaborador:"},
	            art_title	: {required: "Digite o titulo:"},
	            art_title2	: {required: "Digite o subtitulo:"},
	            art_fonte 	: {required: "Digite a fonte do artigo:"},
	            art_email 	: {required: "Digite o email de resposta:"},
	            art_descr 	: {required: "Digite a descrição do artigo:"},
	            art_brief 	: {required: "Digite um pequeno resumo do artigo:"},
	            art_cont 	: {required: "Digite conteúdo do artigo:"},
	            art_img 	: {required: "Digite a URL da Imagem"}
	        },
	         highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
	        },
	        unhighlight: function(element) {
	            $(element).closest('.form-group').removeClass('has-error');
	        }
	    });
	    if($("#cad_art").valid()==true){
			$("#bt_art").html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIArtigos.php",{
				acao		: "novo_artigo",
				art_dep		: $("#art_dep").val(),
				art_col		: $("#art_col").val(),
				art_title	: $("#art_title").val(),
				art_title2	: $("#art_title2").val(),
				art_email 	: $("#art_email").val(),
				art_fonte	: $("#art_fonte").val(),
				art_img		: $("#art_img").val(),
				art_descr	: CKEDITOR.instances.art_descr.getData(),
				art_brief	: CKEDITOR.instances.art_brief.getData(),
				art_cont	: CKEDITOR.instances.art_cont.getData()
				},
				function(data){
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
						$("#cad_art")[0].reset();
						$("#bt_art").html("<i class='fa fa-plus'></i> Incluir");
						
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
});