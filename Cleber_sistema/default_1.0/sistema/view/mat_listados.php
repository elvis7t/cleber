<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();

	$sql = "SELECT * FROM mat_listas a
				LEFT JOIN usuarios c ON a.mlist_solic = c.usu_cod
				JOIN codstatus d ON a.mlist_status = d.st_codstatus
				WHERE mlist_data BETWEEN curdate() - interval 7 day and curdate() + interval 1 day GROUP BY mlist_id";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/
	
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma Lista.</td></tr>";
	else: ?>
		<?php
		$soma = 0;
		while($rs->GeraDados()){
			
			?>
			<input type="hidden" name="clicod" value="<?=$rs->fld("cod");?>" />
			<tr>

				<td><?=$rs->fld("mlist_id");?></td>
				<td><?=$fn->data_hbr($rs->fld("mlist_data"));?></td>
				<td><?=$fn->data_br($rs->fld("mlist_venc"));?></td>
				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$rs->fld("st_desc");?></td>
				
				<td>
					
						<a href="mat_print.php?imlist=<?=$rs->fld("mlist_id");?>"
							id="ver_recibo"
							class='btn btn-sm btn-success' 
							data-toggle='tooltip' 
							data-placement='bottom'
							target='_blank'
							title='Imprimir'><i class='fa fa-print'></i> 
						</a> 
						<?php
						if($rs->fld("mlist_status")==0){ // Mostra opções de cancelar e baixar somente se estiver Aguardando
							?>
							<a 	class='btn btn-sm btn-info' 
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='Realizar'
								href="javascript:baixa(<?=$rs->fld("mlist_id");?>,'Saida_mat','Efetuar compra');"><i class='fa fa-money'></i>
							</a> 
							<a 	class='btn btn-sm btn-danger' 
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='Cancelar'
								href="javascript:del(<?=$rs->fld("mlist_id");?>,'exc_listaMat','a lista');"><i class='fa fa-trash'></i>
							</a>

						<?php }
						if($rs->fld("mlist_status")<>90 AND $rs->fld("mlist_status")<>0){// se tiver OK, dá opçãode baixar ?>
							<a 	class='btn btn-sm btn-primary' 
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='Gerenciar Itens'
								href="mat_ger_itens.php?token=<?=$_SESSION['token'];?>&lista=<?=$rs->fld('mlist_id');?>"><i class='fa fa-check'></i>
							</a>
						<?php } 
					?>
				</td>
					
			</tr>
		<?php  
		}
		?>		<?php endif;?>
	<script>
 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover();
	});

	setTimeout(function(){
		//$("#slc").load("vis_controlehora.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);

</script>
<script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
	
