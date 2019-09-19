<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM servicos a 
				LEFT JOIN tri_clientes b ON a.ser_cliente = b.cod
				JOIN codstatus c  ON a.ser_status = c.st_codstatus 
				JOIN usuarios d ON a.ser_usuario = d.usu_cod 
				WHERE ser_lista = ".$_GET['lista']."
				ORDER BY ser_lista ASC, regiao ASC, ser_id asc";
	
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhuma solicita&ccedil;&atilde;o.</td></tr>";
	else: ?>
		<?php
		
		while($rs->GeraDados()){
			
			?>
			<tr>
				<td><?=$rs->fld("ser_id");?></td>
				<td><?=$rs->fld("apelido");?></td>
				<td><?=$rs->fld("regiao");?></td>
				<td>
					<a class='btn btn-xs btn-info btn-xs' data-toggle='popover' data-trigger="hover" data-placement='auto bottom' data-content='<?=$rs->fld("ser_obs");?>' title=' <?=$rs->fld("apelido");?>'><i class='fa fa-book'></i> </a>
				</td>
				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$fn->data_hbr($rs->fld("ser_data"));?></td>
				<td>
					<a 	class="btn btn-primary btn-xs"
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Ver Tarefa'
						a href="serv_feed_item.php?token=<?=$_SESSION['token']?>&acao=P&serv=<?=$rs->fld('ser_id');?>"><i class="fa fa-search"></i>
					</a>
					<?php if($rs->fld("ser_status")==0){ ?>
					<a 	class="btn btn-success btn-xs"
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='Entregue'
						a href="javascript:baixa(<?=$rs->fld("ser_id");?>,'baixa_Serv','Deseja realizar o serviço');"><i class="fa fa-thumbs-o-up"></i>
					</a> 
					<a 	class="btn btn-warning btn-xs" 	
						data-toggle='tooltip' 
						data-placement='bottom' 
						title='N&aacute;o Entregue'
						a href="serv_feed_item.php?token=<?=$_SESSION['token']?>&acao=N&serv=<?=$rs->fld('ser_id');?>&lista=<?=$_GET['lista'];?>"><i class="fa fa-thumbs-o-down"></i>
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
<script src="<?=$hosted;?>/triangulo/js/action_triang.js"></script>
<script src="<?=$hosted;?>/triangulo/js/functions.js"></script>
	
