<li class="dropdown notifications-menu">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
	$nova = 0;
	$sql = "SELECT * FROM alerta_compras a 
			LEFT JOIN mat_cadastro b ON a.alerta_matId = b.mcad_id
			WHERE (a.alerta_matcomp - a.alerta_matentr) <= a.alerta_matmin
			AND a.alerta_matId NOT IN (SELECT mat_cadId FROM mat_historico WHERE mat_operacao = 'I' AND mat_lista IS NOT NULL )
			 ORDER BY alerta_id DESC";
	$rsa->FreeSql($sql);
	
	$nlin = $rsa->linhas;

	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-shopping-cart"></i>
			<span class="label label-success"><?=($nlin==0?"":$nlin);?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
			
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; tem <?=($nlin==0?"":$nlin);?> solicita&ccedil;&otilde;es</li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php
				$rsa->FreeSql($sql);
				while($rsa->GeraDados()){
				?>
				<li><!-- start message -->
					<a href="#">
						<div class="pull-left">
							<i class="fa fa-shopping-cart text-primary"></i> <?=$rsa->fld("mcad_desc");?>
						</div>
					</a>
				</li><!-- end message -->
				<?php 
				}
				?>
				<!--<li class="footer"><a href="#">Veja todas as Mensagens</a></li>-->
			</ul>
		</li>
	</ul>	
</li>
