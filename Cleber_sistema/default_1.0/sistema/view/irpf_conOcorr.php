<?php
	session_start();
	require_once("../model/recordset.php");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT * FROM irrf_historico a
				JOIN irrf b 
					ON a.irh_ir_id = b.ir_Id
				JOIN usuarios c
					ON a.irh_usu_cod = c.usu_cod";
	if(isset($ir_id)){
		$sql.= " WHERE irh_ir_id = ".$ir_id;
	}
	else{
		$sql.= " WHERE irh_ir_id = ".$_GET['ircod'];
	}
				
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhum tr&acirc;mite para o IRPF selecionado...</td></tr>";
	else: 
		while($rs->GeraDados()){?>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  		<div class="panel panel-default">
				        	<div class="panel-heading" role="tab" id="heading<?=$rs->fld('irh_id');?>">
								<div class="col-md-1">
									<h4 class="panel-title">
										<button class="btn btn-xs btn-info" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#collapse<?=$rs->fld('irh_id');?>" aria-expanded="true" aria-controls="collapse<?=$rs->fld('irh_id');?>">
										  	<i class="fa fa-book"></i>
										</button>
									</h4>
								</div>
								<div class="col-md-5"><?=$rs->fld("usu_nome");?></div>
								<div class="col-md-4"><?=$fn->data_hbr($rs->fld("irh_dataalt"));?></div>
								<br>
				        	</div>
				        	<div id="collapse<?=$rs->fld('irh_id');?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$rs->fld('irh_id');?>">
				          		<div class="panel-body">
				            		<?=$rs->fld('irh_obs');?>
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
