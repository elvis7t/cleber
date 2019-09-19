<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");
	date_default_timezone_set("America/Sao_Paulo");
	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();
?>
<!--
	<div class=" col-md-12">
		<form role="form" class="form form-inline" method="GET">
			<div class="form-group col-xs-3">
				Data Inicial:<br>
				<input type="text" name="di" class="form-control input-sm col-md-3" />
			</div>
			
			<div class="form-group col-xs-3">
				Data Final: <br>
				<input type="text" name="di" class="form-control input-sm col-md-3" />
			
			</div>
			<div class="form-group col-xs-3">
				<button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Pesquisar</button>
			</div>					
		</form>
	</div>
-->
	<table class="table table-striped">
		<tr>
			<th class="hidden-xs">#Id</th>
			<th class="hidden-xs">P&aacute;gina</th>
			<th>Acesso</th>
			<th>Inclus&atilde;o</th>
			<th>Exclus&atilde;o</th>
			<th>Altera&ccedil;&atilde;o</th>
			
		</tr>	
<?php
	$sql = "SELECT * FROM permissoes";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	/*
	echo $sql;
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	if($rs->linhas==0):
	echo "<tr><td colspan=3> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		while($rs->GeraDados()){
			?>
			<tr>
				<td><?=$rs->fld("pem_id");?></td>
				<td class="hidden-xs"><?=$rs->fld("pem_desc");?></td>
				<td class="hidden-xs"><input type="checkbox"></td>
				<td class="hidden-xs"><input type="checkbox"></td>
				<td class="hidden-xs"><input type="checkbox"></td>
				<td class="hidden-xs"><input type="checkbox"></td>
				
			</tr>
		<?php  
		}
		echo "<tr><td colspan=7><strong>".$rs->linhas." P&aacute;ginas Permissionadas</strong></td></tr>";
	endif;	
	
	?>
</table>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
<script type="text/javascript">
// Atualizar a cada 10 segundos
	 
	

	 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover({
		        html:true
		    });
		});
</script>


			