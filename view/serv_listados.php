<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();
	$rs2 = new recordset();

	$sql = "SELECT * FROM serv_saidas a
				LEFT JOIN servicos b ON a.said_id = b.ser_lista
				LEFT JOIN usuarios c ON a.said_useralt = c.usu_cod
				JOIN codstatus d ON a.said_status = d.st_codstatus
				WHERE said_status <>90 AND said_data BETWEEN curdate() - interval 200 day and curdate() + interval 1 day GROUP BY said_id";
	/*--|alteração - Cleber Marrara 25/02/2016|
		|adequação de variaveis para reutilização do programa em relatórios|
	*/
	
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o.</td></tr>";
	else: ?>
		<?php
		$soma = 0;
		while($rs->GeraDados()){
			
			?>
			<input type="hidden" name="clicod" value="<?=$rs->fld("cod");?>" />
			<tr>
				<td><?=$rs->fld("said_id");?></td>
				<td><?=($rs->fld("said_ativo")==1?"Ativo":"Cancelado");?></td>
				<td><?=$fn->data_br($rs->fld("said_venc"));?></td>
				<td><?=$rs->fld("st_desc");?></td>
				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$fn->data_hbr($rs->fld("said_dataalt"));?></td>
				<td>
					<?php
						$nok = $rs2->pegar("count(ser_id)","servicos","ser_lista=".$rs->fld("said_id")." AND ser_status=99");
						$nit = $rs2->pegar("count(ser_id)","servicos","ser_lista=".$rs->fld("said_id"));
						echo str_pad($nok,2,0,STR_PAD_LEFT);
						echo " / ".str_pad($nit,2,0,STR_PAD_LEFT);
					?>
					
				</td>
				<td>
					
						<a href="serv_print.php?ssaid=<?=$rs->fld("said_id");?>"
							id="ver_recibo"
							class='btn btn-xs btn-success' 
							data-toggle='tooltip' 
							data-placement='bottom'
							target='_blank'
							title='Imprimir'><i class='fa fa-print'></i> 
						</a> 
						<?php
						if($rs->fld("said_status")==0){ // Mostra opções de cancelar e baixar somente se estiver Aguardando
							?>
							<a 	class='btn btn-xs btn-info' 
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='Realizar'
								href="javascript:baixa(<?=$rs->fld("said_id");?>,'Realizar_Saida','Este serviço está sendo executado?');"><i class='fa fa-car'></i>
							</a> 
							<a 	class='btn btn-xs btn-danger' 
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='Cancelar'
								href="javascript:del(<?=$rs->fld("said_id");?>,'exc_Saida','a saída');"><i class='fa fa-trash'></i>
							</a>

						<?php }
						if($rs->fld("said_status")<>90 AND $rs->fld("said_status")<>0){// se tiver OK, dá opçãode baixar ?>
							<a 	class='btn btn-xs btn-primary' 
								data-toggle='tooltip' 
								data-placement='bottom' 
								title='Gerenciar Itens'
								href="ger_itens.php?token=<?=$_SESSION['token'];?>&lista=<?=$rs->fld('said_id');?>"><i class='fa fa-check'></i>
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
<script src="<?=$hosted;?>/sistema/js/action_triang.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
	
