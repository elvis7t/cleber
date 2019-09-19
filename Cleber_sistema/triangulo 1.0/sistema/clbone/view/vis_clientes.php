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
	<table class="table table-striped" id="empr">
		<tr>
			<th>#</th>
			<th>Empresa</th>
			<th class="hidden-xs">Regi&atilde;o</th>
			<th>Telefone</th>
			<th class="hidden-xs">Falar com</th>
			<th>A&ccedil;&otilde;es</th>
		</tr>	
<?php
	$sql = "SELECT * FROM tri_clientes WHERE 1";
	if(isset($_GET['cod']) AND $_GET['cod']<>""){$sql.=" AND cod=".$_GET['cod'];}
	$sql.= " ORDER BY cod ASC, ativo DESC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		while($rs->GeraDados()){
		?>
			<tr>
				<td><?=$rs->fld("cod");?></td>
				<td class="text-capitalize"><?=$rs->fld("apelido");?></td>
				<td class="hidden-xs"><?=$rs->fld("regiao");?></td>
				<td><?=$rs->fld("telefone");?></td>
				<td class="hidden-xs"><?=$rs->fld("responsavel");?></td>
				<td class="">
					<a class='btn btn-xs btn-success' href="clientes.php?token=<?=$_SESSION['token']?>&clicod=<?=$rs->fld('cod')?>">
					<i class='fa fa-magic'></i> Ativar</a>
					<a class="btn btn-xs btn-danger" data-toggle='tooltip' data-placement='bottom' title='Excluir' href="javascript:del(<?=$rs->fld('cod');?>,'excEmpresa','a empresa');"><i class="fa fa-trash"></i></a>
				</td>
			</tr>
		<?php  
		}
		echo "<tr><td colspan=7><strong>".$rs->linhas." Cliente(s) Encontrado(s)</strong></td></tr>";
	endif;		
	?>
</table>
 
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
// Atualizar a cada 10 segundos
/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/

setTimeout(function(){
	$("#alms").load(location.href+" #almsg");
},10500);

</script>


			