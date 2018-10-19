<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");
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
			<th>#</th>
			<th class="hidden-xs">Categoria</th>
			<th class="hidden-xs">Material</th>
			<th class="hidden-xs">Mínimo</th>
			<th class="hidden-xs">Mínimo de Compra</th>
			<th class="hidden-xs" title="Alerta Estoque Mínimo">AEM</th>
			<th class="hidden-xs">Ações</th>
			
		</tr>	
<?php
	$sql = "SELECT * FROM mat_cadastro a
				JOIN mat_categorias b ON a.mcad_catId = b.mcat_id ";
	
		
	$sql.=" ORDER BY mcad_desc ASC";
	$rs->FreeSql($sql);
	/*echo $rs->sql;
	/*
	echo $sql;
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
	if($rs->linhas==0):
	echo "<tr><td colspan=8> Nenhum material...</td></tr>";
	else:
		while($rs->GeraDados()){
			?>
			<tr>
				<td><?=$rs->fld("mcad_id");?></td>
				<td class="hidden-xs"><?=$rs->fld("mcat_desc");?></td>
				<td class="hidden-xs"><?=$rs->fld("mcad_desc");?></td>
				<td class="hidden-xs" align="center"><?=$rs->fld("mcad_minimo");?></td>
				<td class="hidden-xs" align="center"><?=$rs->fld("mcad_compra");?></td>
				<td>
					<input 
						class='check_alerta'
						type='checkbox' 
						value=1
						data-onstyle='success' 
						data-size='mini'
						<?=($rs->fld("mcad_alerta")==1?"CHECKED":"");?>
						onchange="mark_alerta('<?=$rs->fld("mcad_id");?>',this.checked)"
					>
				</td>
				<td><a href="materiais.php?&token=<?=$_SESSION['token'];?>&prodid=<?=$rs->fld("mcad_id");?>" class="btn btn-xs btn-info"  data-toggle='tooltip' data-placement='bottom' title="Alterar"><i class="fa fa-pencil"></i></a></td>
				
			</tr>
		<?php  
		}
		echo "<tr><td colspan=8><strong>".$rs->linhas." Materiais</strong></td></tr>";
	endif;
	/* DEBUG	
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";
	*/
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


			