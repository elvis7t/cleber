function valida(campo){
	var caixa = "";
	switch($("#"+campo).data('type')){
		case "email":
			caixa = "email";
			var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			if($("#"+campo).val() != ""){
				if(filtro.test($("#"+campo).val())){
					$("#"+caixa).removeClass("has-error");
					$("#li"+caixa).remove();
					console.log(caixa+" OK!");
				} 
				else {
					$("<li id='li"+caixa+"'></li>").addClass("").html("Este endereço de email não é válido!"+campo.val).appendTo("#erros_frm");
					$("#"+caixa).addClass("has-error");
					$("#"+campo).focus();
				}
			} 
			else {
				$("<li id='li"+caixa+"'></li>").addClass("").html("Digite um e-mail válido!").appendTo("#erros_frm");
				$("#"+caixa).addClass("has-error");
				$("#"+campo).focus();
			}
			break;
			
		case "nome":
			caixa = "nome";
			if($("#"+campo).val().length < 3){
				$("<li id='li"+caixa+"'></li>").addClass("").html("Qual Seu nome? Mínimo 3 Letras!").appendTo("#erros_frm");
				$("#"+caixa).addClass("has-error");
				$("#"+campo).focus();
			}
			else{
				$("#"+caixa).removeClass("has-error");
				$("#li"+caixa).remove();
				console.log(caixa + " OK!");
			}
			break;
		
		case "assunto":
			caixa = "assunto";
			if($("#"+campo).val().length < 3){
				$("<li id='li"+caixa+"'></li>").addClass("").html("Seu e-mail não pode ser enviado sem assunto...").appendTo("#erros_frm");
				$("#"+caixa).addClass("has-error");
				$("#"+campo).focus();
			}
			else{
				$("#"+caixa).removeClass("has-error");
				$("#li"+caixa).remove();
				console.log(caixa + " OK!");
			}
			break;
			
			case "telefone":
				caixa = "telefone";
				if($("#"+campo).val().length < 10){
				$("<li id='li"+caixa+"'></li>").addClass("").html("Esse telefone tá certo?").appendTo("#erros_frm");
				$("#"+caixa).addClass("has-error");
				$("#"+campo).focus();
			}
			else{
				$("#"+caixa).removeClass("has-error");
				$("#li"+caixa).remove();
				console.log(caixa + " OK!");
			}
				break;
				
			case "mensagem":
				caixa = "mensagem";
				if($("#"+campo).val().length < 10){
				$("<li id='li"+caixa+"'></li>").addClass("").html("Mensagem muito curta...").appendTo("#erros_frm");
				$("#"+caixa).addClass("has-error");
				$("#"+campo).focus();
			}
			else{
				$("#"+caixa).removeClass("has-error");
				$("#li"+caixa).remove();
				console.log(caixa + " OK!");
			}
				break;
	}
}