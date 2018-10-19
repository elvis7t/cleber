		
<div class="col-md-12">
	<div class="box collapsed-box">
		<div class="box-header with-border">
			<h3 class="box-title">Impostos Pr&oacute;ximos</h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
				<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div><!--/box title-->
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="box-group" id="proxenvios">
				<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
				<?php
					$hoje = 01;
					$dez = date("d", strtotime("+5 days")); 
					$sql = "SELECT a.imp_id, imp_nome, imp_venc FROM tipos_impostos a 
							WHERE 1
								AND imp_venc IS NOT NULL
								AND imp_depto = ".$_SESSION['dep']."
								AND imp_tipo IN ('O','T')
								AND imp_venc BETWEEN '".$hoje."' AND '".$dez."'
						GROUP BY imp_id
						ORDER BY imp_venc ASC";
					//echo $sql;
					$rs->FreeSql($sql);
					while($rs->GeraDados()){
						$hidden = ""; 
						$sql2 = "SELECT ob_cod, empresa FROM obrigacoes 
							JOIN tri_clientes ON ob_cod = cod 
							JOIN impostos_enviados c ON c.env_codEmp = ob_cod
							WHERE ob_titulo  = ".$rs->fld("imp_id")."
							AND ativo = 1 
							AND ob_ativo = 1
							AND c.env_compet = '".date("m/Y", strtotime("-1 month"))."'
							AND c.env_enviado = 0
							GROUP BY ob_cod
							ORDER BY empresa";
						$rs2->FreeSql($sql2);
						if($rs2->linhas==0){$hidden = "hide";
						}
						else{
							$msg = "";
							$data = date("d");
							$rem = $data - $rs->fld("imp_venc");
							if($rem==0){
									$msg="<p class='pull-right text-primary'><strong> Vence hoje</strong></p>";
									$class = "box-primary";
							}
							else{
								if($rem < 0){
									$msg="<p class='pull-right text-success'> <strong>Falta(m) ".abs($rem)." dia(s)</strong></p>";
									$class = "box-success";
								}
								else{
									$msg="<p class='pull-right text-danger'> <strong>".abs($rem)." dia(s) em atraso</strong></p>";
									$class = "box-danger";
								}
							}
						}
						?>
						<!-- COMECA AQUI-->
						<div class="panel box <?=$class." ".$hidden;?>">
				  			<div class="box-header with-border">
								<h5 class="box-title">
						  			<a class="btn btn-xs btn-primary" data-toggle="collapse" data-parent="#proxenvios" href="#imp_<?=$rs->fld('imp_id');?>">
										<i class="fa fa-book"></i> 
						  			</a>
									<?=$rs->fld("imp_nome")." (".$rs2->linhas.")";?>
								</h5>
								<?=$msg;?>
				  			</div>
							<div id="imp_<?=$rs->fld('imp_id');?>" class="panel-collapse collapse">
								<div class="box-body">
						  			<table class="table table-striped table-condensed">
						  				<thead>
						  					<tr>
						  						<th>Empresa</th>
						  					</tr>
						  				</thead>
						  				<tbody>
						  					<?php
								  			while($rs2->GeraDados()){ ?>
												<tr>
													<td>
														<?=$rs2->fld('empresa');?><br>
													</td>
												</tr>
											<?php }
								  			?>
						  				</tbody>
						  			</table>
								</div>
							</div>
						</div>
						<!--TERMINA AQUI-->
					<?php }
				?>

			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div><!-- /.col -->
</div>
		