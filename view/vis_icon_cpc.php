<!--|CPC|-->
<li class="dropdown notifications-menu">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
	$sq = "SELECT(SELECT count(distinct(cpc_cli)) FROM cpcviews) -(SELECT count(distinct(cpc_cli)) FROM cpcviews WHERE cpc_usuario = ".$_SESSION['usu_cod'].") as num";
	$rsa->FreeSql($sq);
	$rsa->GeraDados();
	$num = $rsa->fld("num");
	
	if ($num > 0) {
		$sql = "SELECT cpc_id, cpc_cli, apelido FROM cpcviews a
				JOIN tri_clientes b ON a.cpc_cli = b.cod
				WHERE cpc_usuario <> ".$_SESSION['usu_cod']."
				AND cpc_cli NOT IN (SELECT cpc_cli FROM cpcviews WHERE cpc_usuario = ".$_SESSION['usu_cod'].")	
				GROUP BY cpc_cli ORDER BY cpc_cli ASC";
		
		$rsa->FreeSql($sql);

		$nlin = $rsa->linhas;
		$rsa->GeraDados();
		if($rsa->linhas >0 AND $_SESSION['classe']<=4){
			if( !(isset($_COOKIE['cpc_ant'])) OR ($_COOKIE['cpc_ant'] <> $rsa->fld("cpc_id")) ){
				setcookie("cpc_lido",0);
				setcookie("cpc_ant", $rsa->fld("cpc_id"));
				$cpc_messages = "Novo CPC Atualizado: ".$rsa->fld("cpc_cli")." - ".$rsa->fld("apelido");
				setcookie("cpc_mensagem", $cpc_messages);
				$cpc_page = "rel/rel_cpc.php?cod=".$rsa->fld("cpc_cli")."&gera=0";
				setcookie("cpcpag", $cpc_page);
			}
		}
	}
	else{
		$nlin = 0;
	}

	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-print"></i>
			<span class="label label-danger"><?=($nlin==0?"":$nlin);?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
			
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; <?=($nlin==0?"não":"");?> tem <?=($nlin==0?"":$nlin);?> CPC para ver</li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php
				if($nlin<>0){
					$rsa->FreeSql($sql);
					while($rsa->GeraDados()){
					?>
					<li><!-- start message -->
						<a href="../rel/rel_cpc.php?cod=<?=$rsa->fld('cpc_cli')."&gera=1";?>">
							<div class="pull-left">
								<i class="fa fa-building text-info"></i> <?=$rsa->fld("cpc_cli")." - ".$rsa->fld("apelido");?>
							</div>
						</a>
					</li><!-- end message -->
					<?php 
					}
				}
				?>
				<!--<li class="footer"><a href="#">Veja todas as Mensagens</a></li>-->
			</ul>
		</li>
	</ul>	
</li>
<!--|FIM CPC|-->
