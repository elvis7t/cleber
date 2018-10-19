<?php
	session_start();
	require_once("../../model/recordset.php");
	require_once("../../sistema/class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM implanta_obs a
				JOIN implantacoes b ON a.impobs_impId = b.impla_id
				JOIN usuarios c	ON a.impobs_user= c.usu_cod";

	$sql.= " WHERE impobs_impId = ".$_GET['impla'];
					
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhum tr&acirc;mite para a IMPLANTAÇÃO selecionada...</td></tr>";
	else: 
		while($rs->GeraDados()){?>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  		<div class="panel panel-default">
				        	<div class="panel-heading" role="tab" id="heading<?=$rs->fld('chobs_id');?>">
								<div class="col-md-1">
									<h4 class="panel-title">
										<button class="btn btn-xs btn-info" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#collapse<?=$rs->fld('impobs_id');?>" aria-expanded="true" aria-controls="collapse<?=$rs->fld('impobs_id');?>">
										  	<i class="fa fa-book"></i>
										</button>
									</h4>
								</div>
								<div class="col-md-5"><?=$rs->fld("usu_nome");?></div>
								<div class="col-md-6"><p class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?=$fn->data_hbr($rs->fld("impla_data"))." - ".$fn->simple_horas_uteis($rs->fld("impobs_data"), date("Y-m-d H:i:s"));?></p></div>
								<br>
				        	</div>
				        	<div id="collapse<?=$rs->fld('impobs_id');?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$rs->fld('impobs_id');?>">
				          		<div class="panel-body">
				            		<?=$rs->fld('impobs_obs');?>
				          		</div>
				        	</div>
				      	</div>
				    </div>
			
		<?php
		}
		/*
		while($rs->GeraDados()){?>
			<tr>
				<td><?=$rs->fld("usu_nome");?></td>
				<td><?=$fn->data_hbr($rs->fld("irh_dataalt"));?></td>
				<td><button class="btn btn-xs btn-info info_obs"> <i class="fa fa-book" data-toggle="collapse" data-target="#collapse<?=$rs->fld('irh_id');?>" data-code="2" aria-expanded="false" aria-controls="collapse<?=$rs->fld('irh_id');?>"></i></button></td>
				
			</tr>
			<tr>
				<td colspan="3">
					<div class="collapse" id="collapse<?=$rs->fld('irh_id');?>">
						<div class="well">
    						<?=$rs->fld('irh_obs');?>
  						</div>
					</div>
				</td>
			</tr>
		<?php  
		}
		*/
		?>
		<tr>
			<td>
				<strong><?=$rs->linhas; ?> Registro(s) Encontrado(s)</strong>
			</td>
		</tr>
	<?php endif; ?>
