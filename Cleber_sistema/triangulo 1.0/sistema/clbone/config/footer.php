<footer class="main-footer">
	<div class="pull-right hidden-xs">
	  <b>Version</b> 1.1.3 | <img src="<?=$hosted;?>/images/sitema/logo1.png" width="100"/>
	</div>
	<strong>Licenciado para <a href="http://www.triangulocontabil.com.br">NIFF Empreendimentos e Participações Ltda.</a></strong> Todos os Direitos Reservados. 
</footer>

 <script src="<?=$hosted;?>/clbone/js/controle.js"></script>
 <script src="<?=$hosted;?>/clbone/js/jquery.cookie.js"></script>

<script type="text/javascript">
	setInterval(function(){

		$("#chatContent").load(location.href+" #msgs");	
		$("#chatContent").scrollTop($("#msgs").height());
		
		if($.cookie('msg_lido')==0) {
			notify($.cookie("mensagem"),$.cookie("pag"),"NOVA MENSAGEM ("+$.cookie("user")+")");
			$.cookie("msgant");
			$.cookie('msg_lido',1);
		}

		if($.cookie('doclido')==0) {
			notify($.cookie("docmensagem"),$.cookie("docpage"),"NOVO DOCUMENTO ("+$.cookie("docdep")+")");
			$.cookie("docant");
			$.cookie('doclido',1);
		
		}
		if($.cookie('pausalido')==0){
			notify($.cookie("pausamsg"),"#","PAUSA");
			$.cookie("pausa");
			$.cookie('pausalido',1);
			
		}
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

	},3500);
</script>