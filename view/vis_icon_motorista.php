<li class="dropdown notifications-menu">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
	$nova = 0;
	$sql = "SELECT * FROM servicos a
				JOIN codstatus b
					ON b.st_codstatus = a.ser_status
				JOIN tri_clientes c
					ON c.cod = a.ser_cliente
				WHERE ser_status = 0 AND ser_lista=0
				ORDER BY ser_id DESC LIMIT 200";
		
		$rsa->FreeSql($sql);

		$nlin = $rsa->linhas;
		$rsa->GeraDados();

	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-truck"></i>
			<span class="label label-warning"><?=($nlin==0?"":$nlin);?></span>
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
							<i class="fa fa-car text-aqua"></i> <?=$rsa->fld("apelido");?>
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
