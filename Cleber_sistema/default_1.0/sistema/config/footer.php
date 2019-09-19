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

<script type="text/javascript" src="<?=$hosted;?>/js/controle.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/js/jquery.cookie.js"></script>

<script type="text/javascript">
	setTimeout(function(){
		$("#alms").load(location.href+" #almsg");
		console.log("Atualizado AlertMSG");
	},7500);
	setInterval(function(){

		$("#chatContent").load(location.href+" #msgs");	
		$("#chatContent").scrollTop($("#msgs").height());
		// NOTIFICAÇÔES DE MENSAGENS
		if($.cookie('msg_lido')==0) {
			notify($.cookie("mensagem"),$.cookie("pag"),"NOVA MENSAGEM ("+$.cookie("user")+")");
			$.cookie("msgant");
			$.cookie('msg_lido',1);
		}
		//NOTIFICAÇÕES DE DOCUMENTOS
		if($.cookie('doclido')==0) {
			notify($.cookie("docmensagem"),$.cookie("docpage"),"NOVO DOCUMENTO ("+$.cookie("docdep")+")");
			$.cookie("docant");
			$.cookie('doclido',1);
		}
		//NOTIFICAÇÕES DE ARQUIVOS
		
		if($.cookie('arqlido')==0) {
			notify($.cookie("arqmensagem"),$.cookie("arqpage"),"NOVO ARQUIVO ");
			$.cookie("arqant");
			$.cookie('arqlido',1);
		}
		//NOTIFICAÇÕES DE ENVIOS
		
		if($.cookie('envlido')==0) {
			notify($.cookie("envmensagem"),"#","DISPONÍVEL PARA ENVIO ");
			$.cookie("envant");
			$.cookie('envlido',1);
		}
		//NOTIFICAÇÕES DE PEDIDOS DE MATERIAL
		
		if($.cookie('mat_lido')==0) {
			notify($.cookie("mat_mensagem"),$.cookie("mat_page"),"NOVO PEDIDO DE MATERIAL ");
			$.cookie("mat_ant");
			$.cookie('mat_lido',1);
		}
		
		//NOTIFICAÇÕES DE PAUSA
		if($.cookie('pausalido')==0){
			notify($.cookie("pausamsg"),"#","PAUSA");
			$.cookie("pausa");
			$.cookie('pausalido',1);
			
		}
		//NOTIFICAÇÕES DE CALENDÁRIO
		if($.cookie('ncal')==0){
			if($.cookie("calmsg")!=""){
				msg = $.cookie("calmsg");
			}
			else{
				msg = "Existe um Novo Evento";
			}
			notify(msg,"<?=$hosted;?>/view/calendar.php?token=<?=$_SESSION['token'];?>","CALENDARIO");
			$.cookie('ncal',1);
			
		}
		//NOTIFICAÇÕES DE CHAMADOS
		if($.cookie('chamlido')==0) {
			notify($.cookie("chammensagem"),"#","NOVO CHAMADO ");
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

	},3500);
</script>