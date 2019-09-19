<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM mat_historico a
				JOIN mat_cadastro b ON b.mcad_id = a.mat_cadId
				JOIN codstatus c  ON a.mat_status = c.st_codstatus 
				JOIN usuarios d ON a.mat_usuSol = d.usu_cod 
				WHERE mat_lista = ".$_GET['lista']."
				ORDER BY mat_lista ASC, mat_id asc";
	
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhum item na lista.</td></tr>";
	else: ?>
		<?php
		
		while($rs->GeraDados()){
			
			?>
			<tr>
				<td><?=$rs->fld("mat_id");?></td>
				<td><?=$rs->fld("mcad_desc");?></td>
				<td><?=$rs->fld("mat_qtd");?></td>
				<td><?=$rs->fld("mat_obs");?></td>
					<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$fn->data_hbr($rs->fld("mat_data"));?></td>
				<td>
					
					<?php if($rs->fld("mat_status")==0){ ?>
					<a 	class="btn btn-success btn-xs"
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Entregue'
						a href="javascript:baixa(<?=$rs->fld("mat_id");?>,'ent_mat','Deseja acrescentar o produto');"><i class="fa fa-thumbs-o-up"></i>
					</a> 
					<a 	class="btn btn-warning btn-xs" 	
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='N&aacute;o Entregue'
						a href="javascript:baixa(<?=$rs->fld("mat_id");?>,'neg_mat','Deseja cancelar o pedido do produto');"><i class="fa fa-thumbs-o-down"></i>
					</a> 
					 
					<?php 
					}
					?>
				</td>
			</tr>
		<?php  
		}
		?>		
	<?php endif;?>
	<script>
 /*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	

	setTimeout(function(){
		//$("#slc").load("vis_controlehora.php");		
		$("#alms").load(location.href+" #almsg");
	 },10500);

</script>
<script src="<?=$hosted;?>/js/action_triang.js"></script>
<script src="<?=$hosted;?>/js/action_empresas.js"></script>
<script src="<?=$hosted;?>/js/functions.js"></script>
	
