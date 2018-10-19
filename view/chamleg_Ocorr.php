<?php
	session_start("portal");
	require_once("../class/class.functions.php");

	$fn = new functions();
	$rs = new recordset();

	$sql = "SELECT a.*, b.cleg_abert, c.usu_nome FROM chamleg_obs a
				JOIN chamados_legal b 	ON a.chlegobs_chamid = b.cleg_id
				JOIN usuarios c			ON a.chlegobs_user= c.usu_cod";

	$sql.= " WHERE chlegobs_chamid = ".$_GET['chamado'];
					
	$rs->FreeSql($sql);
	//echo $rs->sql;
	if($rs->linhas==0):
	echo "<tr><td colspan=7> Nenhum tr&acirc;mite para o CHAMADO selecionado...</td></tr>";
	else: 
		while($rs->GeraDados()){?>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading<?=$rs->fld('chobs_id');?>">
						<div class="col-md-1">
							<h4 class="panel-title">
								<button class="btn btn-xs btn-info" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#collapse<?=$rs->fld('chlegobs_id');?>" aria-expanded="true" aria-controls="collapse<?=$rs->fld('chlegobs_id');?>">
								  	<i class="fa fa-book"></i>
								</button>
							</h4>
						</div>
						<div class="col-md-5"><?=$rs->fld("usu_nome");?></div>
						<div class="col-md-6"><p class="pull-right text-muted"><i class="fa fa-clock-o"></i> <?=$fn->data_hbr($rs->fld("chlegobs_horario"))." - ".$fn->simple_horas_uteis($rs->fld("cleg_abert"),$rs->fld("chlegobs_horario"));?></p></div>
						<br>
					</div>
					<div id="collapse<?=$rs->fld('chlegobs_id');?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$rs->fld('chlegobs_id');?>">
						<div class="panel-body">
							<?=$rs->fld('chlegobs_obs');?>
						</div>
					</div>
				</div>
			</div>
			
		<?php
		}
		?>
		<tr>
			<td>
				<strong><?=$rs->linhas; ?> Registro(s) Encontrado(s)</strong>
			</td>
		</tr>
	<?php endif; ?>
