<?php
$sql = "SELECT * FROM sistema WHERE sys_cnpj = '{$_SESSION['usu_empresa']}'";
$rs->FreeSql($sql);
$rs->GeraDados();
?>

	<footer class="main-footer">
		<div class="pull-right hidden-xs">
		  <strong>Version</strong> <?=$rs->fld("sys_versao")." | ";?>
		  <img src="<?=$hosted;?>/images/logo_Origemw.png" class="img-responsive" width="75"/ align="right" />
		</div>
		<strong>Licenciado para <a href="<?=$rs->fld("sys_site");?>"><?=$rs->fld("sys_empresa");?></a>.</strong> Todos os Direitos Reservados.
	</footer>


<!-- Main row -->

<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		setInterval(function(){
			//console.log("Cleber");
			// NOTIFICAÇÔES DE MENSAGENS
			//NOTIFICAÇÕES DE CHAMADOS
			$.notifyDefaults({
					// settings
					element: 'body',
					position: null,
					type: "info",
					allow_dismiss: true,
					newest_on_top: true,
					showProgressbar: false,
					delay: 10000,
					timer: 3000,
					placement: {
						from: "top",
						align: "right"
					},
					
					animate: {
						enter: 'animated fadeInDown',
						exit: 'animated fadeOutUp'
					}
			});
			
			if($.cookie('cleg_lido')==0){
				notify($.cookie("cleg_mensagem"),$.cookie("cleg_page"),"NOVO CHAMADO LEGAL");
				$.notify({
					title: 		"<b>NOVO CHAMADO LEGAL</b><br>",
					message: 	$.cookie("cleg_mensagem"),
					url: 		$.cookie("cleg_page"),
					target: 	"_blank"
				}, {
					type: 			"info",
					allow_dismiss: 	true
				});
				$.cookie("cleg_ant");
				$.cookie('cleg_lido',1);
			}

			
			//NOTIFICAÇÕES DE DOCUMENTOS
			if($.cookie('doclido')==0) {
				notify($.cookie("docmensagem"),$.cookie("docpage"),"NOVO DOCUMENTO ("+$.cookie("docdep")+")");
				$.notify({
					title: 		"<b>NOVO DOCUMENTO </b><br>",
					message: 	$.cookie("docmensagem"),
					url: 		$.cookie("docpage"),
					target: 	"_blank"
				}, {
					type: 			"danger",
					allow_dismiss: 	true
				});
				$.cookie("docant");
				$.cookie('doclido',1);
			}
			

			//NOTIFICAÇÕES DE ARQUIVOS
			
			if($.cookie('arqlido')==0) {
				notify($.cookie("arqmensagem"),$.cookie("arqpage"),"NOVO ARQUIVO ");
				$.notify({
					title: 		"<b>NOVO ARQUIVO </b><br>",
					message: 	$.cookie("arqmensagem"),
					url: 		$.cookie("arqpage"),
					target: 	"_blank"
				}, {
					type: 			"danger",
					allow_dismiss: 	true
				});
				$.cookie("arqant");
				$.cookie('arqlido',1);
			}
			//NOTIFICAÇÕES DE ENVIOS
			
			if($.cookie('envlido')==0) {
				notify($.cookie("envmensagem"),"#","DISPONÍVEL PARA ENVIO ");
				$.notify({
					title: 		"<b>DISPONÍVEL PARA ENVIO </b><br>",
					message: 	$.cookie("envmensagem")
				}, {
					type: 			"success",
					allow_dismiss: 	true
				});
				$.cookie("envant");
				$.cookie('envlido',1);
			}
			

			//NOTIFICAÇÕES DE PEDIDOS DE MATERIAL
			
			if($.cookie('mat_lido')==0) {
				notify($.cookie("mat_mensagem"),$.cookie("mat_page"),"NOVO PEDIDO DE MATERIAL ");
				$.notify({
					title: 		"<b>NOVO PEDIDO DE MATERIAL </b><br>",
					message: 	$.cookie("mat_mensagem"),
					url: 		$.cookie("mat_page"),
					target: 	"_blank"
				}, {
					type: 			"danger",
					allow_dismiss: 	true
				});
				$.cookie("mat_ant");
				$.cookie('mat_lido',1);
			}
			

			//NOTIFICAÇÕES DE PEDIDOS DE CPC
			
			if($.cookie('cpc_lido')==0) {
				notify($.cookie("cpc_mensagem"),$.cookie("cpc_page"),"ALTERAÇÃO DE CPC");
				$.notify({
					title: 		"<b>ALTERAÇÃO DE CPC </b><br>",
					message: 	$.cookie("cpc_mensagem"),
					url: 		$.cookie("cpc_page"),
					target: 	"_blank"
				}, {
					type: 			"danger",
					allow_dismiss: 	true
				});
				$.cookie("cpc_ant");
				$.cookie('cpc_lido',1);
			}
			
			//NOTIFICAÇÕES DE LIGAÇÕES
			if($.cookie('liga_lido')==0) {
				notify($.cookie("liga_msg"),$.cookie("liga_page"),"SOLICITAÇÃO DE LIGAÇÃO ");
				$.notify({
					title: 		"<b>SOLICITAÇÃO DE LIGAÇÃO </b><br>",
					message: 	$.cookie("liga_msg"),
					url: 		$.cookie("liga_page"),
					target: 	"_blank"
				}, {
					type: 			"info",
					allow_dismiss: 	true
				});
				$.cookie("liga_ant");
				$.cookie('liga_lido',1);
			}
			//NOTIFICAÇÕES DE CALENDÁRIO
			if($.cookie('eve_lido')==0){
				notify($.cookie("eve_mensagem"),"<?=$hosted;?>/view/calendar.php?token=<?=$_SESSION['token'];?>","CALENDARIO");
				$.notify({
					title: 		"<b>NOVO EVENTO </b><br>",
					message: 	$.cookie("eve_mensagem"),
					url: 		$.cookie("eve_page"),
					target: 	"_blank"
				}, {
					type: 			"warning",
					allow_dismiss: 	true
				});
				$.cookie('eve_ant');
				$.cookie('eve_lido',1);

				
			}
			/*

			//NOTIFICAÇÕES DE PAUSA
			if($.cookie('pausalido')==0){
				notify($.cookie("pausamsg"),"#","PAUSA");
				$.cookie("pausa");
				$.cookie('pausalido',1);
				
			}
			//NOTIFICAÇÕES DE CHAMADOS
			if($.cookie('chamlido')==0) {
				notify($.cookie("chammensagem"),"#","NOVO CHAMADO");
				$.cookie("chams");
				$.cookie('chamlido',1);
			}


			//NOTIFICAÇÕES DE HOMOLOGAÇÃO
			if($.cookie('hom_lido')==0) {
				notify($.cookie("hom_mensagem"),$.cookie("hom_page"),"HOMOLOGAÇÃO");
				$.cookie("hom_ant");
				$.cookie('hom_lido',1);
			}
			//NOTIFICAÇÕES DE RECALCULOS
			if($.cookie('rec_lido')==0) {
				notify($.cookie("rec_mensagem"),$.cookie("rec_page"),"RECÁLCULO ");
				$.cookie("rec_ant");
				$.cookie('rec_lido',1);
			}
			*/

		},10000);
	});
</script>