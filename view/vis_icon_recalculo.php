<li class="dropdown notifications-menu">
	<?php
	$nova = 0;
	
	$sql = "SELECT m.*, a.calc_desc, b.apelido, c.usu_nome AS solic, d.usu_nome as efet, e.st_desc
			FROM recalculos m
				JOIN tipos_calc a ON m.rec_doc = a.calc_id 
				JOIN tri_clientes b ON m.rec_cli = b.cod
				LEFT JOIN usuarios c ON m.rec_user = c.usu_cod
				LEFT JOIN usuarios d ON m.rec_usuSol = d.usu_cod
				JOIN codstatus e ON m.rec_status = e.st_codstatus
				WHERE rec_emp = ".$_SESSION['usu_empcod'];
				
			$sql.=" AND rec_status=0";
			$sql .=" Order BY rec_status ASC, rec_id DESC";
		
		$rsa->FreeSql($sql);

		$nlin = $rsa->linhas;
		$rsa->GeraDados();
		if($rsa->linhas >0 AND $_SESSION['classe']<=3){
			if( !(isset($_COOKIE['rec_ant'])) OR ($_COOKIE['rec_ant'] <> $rsa->fld("rec_id")) ){
				setcookie("rec_lido",0);
				setcookie("rec_ant", $rsa->fld("rec_id"));
				$rec_messages = "Recalculo solicitado por ".$rsa->fld("solic")." |Recalcular ".$rsa->fld("calc_desc");
				setcookie("rec_mensagem", $rec_messages);
				$rec_page = "recalc_sol.php?token=".$_SESSION["token"];
				setcookie("recpag", $rec_page);
			}
		}

	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-calculator"></i>
			<span class="label label-danger"><?=($nlin==0?"":$nlin);?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
			
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; <?=($nlin==0?"não":"");?> tem <?=($nlin==0?"":$nlin);?> recalculos</li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php
				$rsa->FreeSql($sql);
				while($rsa->GeraDados()){
				?>
				<li><!-- start message -->
					<a href="recalc.php?token=<?=$_SESSION['token'];?>">
						<div class="pull-left">
							<i class="fa fa-calculator text-aqua"></i> <?=$rsa->fld("calc_desc");?>
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

<!--|FIM ALERTA ENTREGAS|-->
