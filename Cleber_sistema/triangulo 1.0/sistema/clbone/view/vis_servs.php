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
			<th>Cliente</th>
			<th>Regi&atilde;o</th>
			<th>Cadast. por</th>
			<th>Cadast. em</th>
			<th>Status</th>
			<th>Acts</th>

		</tr>	
<?php
	
	$sql = "SELECT * FROM servicos a 
				JOIN tri_clientes b ON a.ser_cliente = b.cod
				JOIN codstatus c  ON a.ser_status = c.st_codstatus 
				JOIN usuarios d ON a.ser_usuario = d.usu_cod
				WHERE ser_status <> 99 GROUP BY ser_id
				ORDER BY ser_id ASC";
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o...</td></tr>";
	else:
		while($rs->GeraDados()){
			$ls = $rs->fld("ser_lista");
		?>
			<tr>
				<td><?=$rs->fld("ser_id");?></td>
				<td><?=$rs->fld("apelido");?></td>
				<td><?=$rs->fld("regiao");?></td>
				

				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$fn->data_hbr($rs->fld("ser_data"));?></td>
				
				<td><?=($ls==0 ? $rs->fld("st_desc") :"Na lista {$ls}");?></td>
				<td>
					<!--VISUALIZAÇÃO DE DOCUMENTOS-->
					<a class='btn btn-xs btn-info btn-xs' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content='<?=$rs->fld("ser_obs");?>' title=' <?=$rs->fld("apelido");?>'><i class='fa fa-book'></i> </a>
					<!--PESQUISAR-->
					<a 	class="btn btn-primary btn-xs"
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Ver Tarefa'
						a href="serv_feed_item.php?token=<?=$_SESSION['token']?>&acao=P&serv=<?=$rs->fld('ser_id');?>"><i class="fa fa-search"></i>
					</a>
					<!--Alterar-->
					<a 	class="btn btn-warning btn-xs"
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Alterar Tarefa'
						a href="serv_feed_item.php?token=<?=$_SESSION['token']?>&acao=N&serv=<?=$rs->fld('ser_id');?>"><i class="fa fa-pencil"></i>
					</a>
					<!--EXCLUIR-->
					<a 	class="btn btn-danger btn-xs" 
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Excluir'
						a href='javascript:del(<?=$rs->fld("ser_id");?>,"exc_Item","o item");'><i class="fa fa-trash"></i>
					</a>
				
					
				</td>
			</tr>
		<?php  
		}
		echo "<tr><td colspan=7><strong>".$rs->linhas." Solicita&ccedil;&otilde;es</strong></td></tr>";
	endif;		
	?>
</table>
<script src="<?=$hosted;?>/clbone/js/functions.js"></script> 

<script>
// Atualizar a cada 10 segundos
/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/


setTimeout(function(){
	$("#alms").load(location.href+" #almsg");
},10500);

$(function () {
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover({
        html:true
     });
});


</script>


			