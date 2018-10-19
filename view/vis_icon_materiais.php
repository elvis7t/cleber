<li class="dropdown notifications-menu <?=($mat["I"]==0?"hide" : "");?>">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
	$nova = 0;
	$sql = "SELECT * FROM mat_historico a
				JOIN mat_cadastro b ON a.mat_cadId = b.mcad_id
				JOIN usuarios c ON a.mat_usuSol = c.usu_cod
				WHERE mat_status=0 AND mat_operacao = 'O'
				ORDER BY mat_id DESC";
		
		$rsa->FreeSql($sql);

		$nlin = $rsa->linhas;
		$rsa->GeraDados();
		if($rsa->linhas >0 AND $_SESSION['classe']<=3){
			if( !(isset($_COOKIE['mat_ant'])) OR ($_COOKIE['mat_ant'] <> $rsa->fld("mat_id")) ){
				setcookie("mat_lido",0);
				setcookie("mat_ant", $rsa->fld("mat_id"));
				$mat_messages = "Material solicitado por ".$rsa->fld("usu_nome")." | Material: ".$rsa->fld("mcad_desc");
				setcookie("mat_mensagem", $mat_messages);
				$mat_page = "mat_sol.php?token=".$_SESSION["token"];
				setcookie("matpag", $mat_page);
			}
		}

	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-lightbulb-o"></i>
			<span class="label label-info"><?=($nlin==0?"":$nlin);?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
			
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; <?=($nlin==0?"não":"");?> tem <?=($nlin==0?"":$nlin);?> pedidos</li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php
				$rsa->FreeSql($sql);
				while($rsa->GeraDados()){
				?>
				<li><!-- start message -->
					<a href="mat_sol.php?token=<?=$_SESSION['token'];?>">
						<div class="pull-left">
							<i class="fa fa-puzzle-piece text-aqua"></i> <?=$rsa->fld("mcad_desc")." (".$rsa->fld("mat_qtd").")";?>
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
