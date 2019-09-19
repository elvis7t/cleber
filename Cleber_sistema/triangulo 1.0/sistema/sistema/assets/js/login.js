$(document).ready(function(){
	var tipo="";
	/*AjaxStart e AjaxStop*/
	$(document).ajaxStart(function(){
		console.log(tipo);
		$('#'+tipo).modal('show');
	});
	$(document).ajaxStop(function(){
		$('#'+tipo).modal('hide');
	});
	
	$("#bt_entrar").click(function(){
		//valida o e-mail
		tipo="aguarde";
		$("#erros_frm li").each(function(){
			$(this).remove();
		});
		
		$("#login .form-control").each(function(){
			valida($(this).attr("id"));
		});
		var erro = 0;
		$("#erros_frm li").each(function(){
			erro = erro + 1;
		});
		console.log(erro);
		// se o e-mail for v�lido, envia informa��es para login (compara com banco)
		if(erro == 0){
			$.post("../config/entrar.php",
			{
				usuario:	$("#lg_email").val(),
				senha:		$("#lg_password").val()
			},
			function(data){
				// existe no banco
				$("#ers div").each(function(){
					$(this).remove();
				});
	
				if(data.status=="OK"){
					//$("<li></li>").addClass("").html("Este endere�o de email n�o � v�lido!").appendTo("#ers");
					$("<div></div>").addClass("alert alert-success alert-dismissable").html(data.mensagem+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#ers").fadeIn("slow");
					console.log(data.mensagem);
					$(location).attr('href','http://www.priorecontabil.com.br/sistema/');
				}
				else{
					$("<div></div>").addClass("alert alert-danger alert-dismissable").html(data.mensagem+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#ers").fadeIn("slow");
					console.log(data.mensagem);
					
				}
			},
			"json");
		}
	});
});