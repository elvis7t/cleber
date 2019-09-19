$(function(){
	var nav = $("#menu_top");
	$(window).scroll(function(){
		if($(this).scrollTop() > 100){
			nav.addClass("fixo").fadeIn();
		}
		else{
			nav.removeClass("fixo").hide();
		}
	});
});
$(document).ready(function(){
/* funções dropdown */
	
	$(".dropdown").click(function(){
		$(".dropdown-toggle").dropdown("toggle");
	});
	
/* funcoes collapese */	
	$(".clps").tooltip('toggle');	
/* AjaxStart - AjaxStop 
	$(document).ajaxStart(function(obj, ico, msg1, msg2) {
		$("#"+obj).attr('disabled',true).html('<i class="fa fa-spin fa-spinner"></i> '+msg1);
	});
	
	$(document).ajaxStop(function(obj, ico, msg1, msg2) {
		$("#"+obj).attr('disabled',false).html('<i class="fa fa-'+ico+'"></i> '+msg2);
	});
*/

/* botão de envio de e-mail*/
	$("#bt_mailenv").click(function(){
		
		$.post(
			"controller/TRIContato.php",
			{	
				nome: 		$("#Name").val(), 
				email: 		$("#Email").val(), 
				assunto: 	"CONTATO SITE TRIANGULO", 
				mensagem: 	$("#Message").val()
			},
			function(data){
				if(data.st=="NOK"){
					$("<div></div>").addClass("alert alert-danger alert-dismissable").html(data.ms+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#frc");
				}
				else{
					$("<div></div>").addClass("alert alert-success alert-dismissable").html(data.ms+'<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#frc");
					$("#frm_Mail")[0].reset();
				}
			}, 
			"json"
		);
	});

	
/*Scroll changes active link */
$(document).on("scroll", onScroll);
    //smoothscroll
    $('#menu_top a[href^="#"]').on('click', function (e) {
        $(document).off("scroll");
        e.preventDefault();
        $('#menu_top li').each(function () {
            $(this).removeClass('active');
        });
        $(this).addClass('active');
         var target = this.hash,
         menu = target;
        $target = $(target);
              
       $('html, body').stop().animate({
            'scrollTop': $target.offset().top + 47
        }, 600, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });
});

function onScroll(event){
    var scrollPos = $(document).scrollTop();
    $('#menu_top li a').each(function () {
        var currLink = $(this);
		//console.log(currLink);
        var refElement = $(currLink.attr("href"));
        if ( (refElement.position().top <= scrollPos) && (refElement.position().top + refElement.height() > scrollPos) ) {
            $('#menu_top li').removeClass("active");
            currLink.parent().addClass("active");
        }
        else{
            currLink.parent().removeClass("active");
        }
    });
}

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