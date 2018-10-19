<?php


//	$con = $per->getPermissao("minhas_metas.php",$_SESSION['usu_cod']);
?>
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>#</th>
				<th>Colaborador</th>
				<th class="hidden-xs">Data Inicio</th>
				<th class="hidden-xs">Data Fim</th>
				<th class="hidden-xs">Criado por</th>
				<th>Real / Meta</th>
				<th>Progresso</th>
				<th>A&ccedil;&otilde;es</th>
			</tr>	
		</thead>
		<tbody>
		</tbody>
	</table>
<script>
	$(document).ready(function () {
		
	});


	setTimeout(function(){
		//$("#slc").load("meus_chamados.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);
</script>