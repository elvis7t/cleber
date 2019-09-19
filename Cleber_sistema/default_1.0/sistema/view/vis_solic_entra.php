<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();
?>
	<table class="table table-striped">
		<tr>
			<th>Empresa</th>
			<th>Telefone</th>
			<th>Respons&aacute;vel</th>
			<th>Falar com</th>
			<th>Atendido Por</th>
			<th>Status</th>
			<th>Observa&ccedil;&otilde;es</th>
		</tr>	
<?php
	$sql = "SELECT * FROM tri_ligac
				JOIN codstatus 
					ON sol_status = st_codstatus
				JOIN usuarios
					ON sol_real_por = usu_cod";
				
	$sql.=" AND sol_datareal BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59' ORDER BY sol_status, sol_datareal DESC";
	$rs->FreeSql($sql);
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma liga&ccedil;&atilde;o recebida...</td></tr>";
	else:
	
		while($rs->GeraDados()){?>
			<tr>
				<td><?=$rs->fld("sol_emp");?></td>
				<td><?=$rs->fld("sol_tel");?></td>
				<td><?=$rs->fld("sol_cont");?></td>
				<td><?=$rs->fld("sol_fcom");?></td>
				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$rs->fld("st_desc");?>
					<small>
						<?php
							echo "(Em ".$fn->data_hbr($rs->fld("sol_datareal")).")";
						?>
					</small>
				</td>
				<td class="acts">
					<a class='btn btn-xs btn-primary' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content="<?=$rs->fld("sol_obs");?>" title='Realizado Por: <?=$rs->fld("sol_real_por");?>'><i class='fa fa-book'></i> </a>
				</td>
			</tr>
		<?php  
		}
		echo "<tr><td colspan=7><strong>".$rs->linhas." Liga&ccedil;&otilde;es Rcebidas</strong></td></tr>";
	endif;		
	?>
</table>
<script src="<?=$hosted;?>/js/functions.js"></script>
<script>
// Atualizar a cada 7 segundos
	 setTimeout(function(){
		$("#slc_e").load("vis_solic_entra.php");					 
		$("#alms").load(location.href+" #almsg");	
	 },10000);
$(function () {
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover({
        html:true
    });
});

</script>

			