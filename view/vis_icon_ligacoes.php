<!--|INICIO DAS LIGACOES|-->

<li class="dropdown notifications-menu">
	<?php

		$sql = "SELECT a.sol_cod, a.sol_emp, c.dep_nome FROM tri_solic a 
				JOIN usuarios b ON b.usu_cod = a.sol_por
				JOIN departamentos c ON c.dep_id = b.usu_dep 
				WHERE a.sol_status = 0 
				AND sol_data BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59'";
		$sql.=" ORDER BY sol_cod ASC";	
		$rsa->FreeSql($sql);

		$nlin = $rsa->linhas;
			
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-phone"></i>
        <span class="label label-danger"><?=($nlin==0?"":$nlin);?></span>
	</a>
    <ul class="dropdown-menu">
		<li class="header">Voc&ecirc; tem <?=($nlin==1? $nlin." Ligação Pendente": $nlin." Ligações Pendentes");?></li>
		<li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu">
			<?php
			if($nlin == 0):
			?>
				<li>
					<a href="#">
						<i class="fa fa-times text-danger"></i> Nenhuma liga&ccedil;&atilde;o solicitada
					</a>
				</li>
			<?php else:
				$rsa->GeraDados();
				if( !(isset($_COOKIE['liga_ant'])) OR ($_COOKIE['liga_ant'] <> $rsa->fld("sol_cod")) ){
					setcookie("liga_lido",0);
					setcookie("liga_ant", $rsa->fld("sol_cod"));
					$liga_msg = "Solicitação de Ligação: ".$rsa->fld("sol_emp");
					setcookie("liga_msg", $liga_msg);
					setcookie("liga_dep", $rsa->fld("dep_nome"));
					$liga_page = "solic.php?token=".$_SESSION["token"];
					setcookie("liga_page", $liga_page);
				}

				$rsa->FreeSql($sql); 
				while($rsa->GeraDados()):
					?>
						<li>
							<a href="solic.php?token=<?=$_SESSION['token'];?>">
								<i class="fa fa-phone text-success"></i> <?=$rsa->fld("sol_emp");?>
							</a>
						</li>
					<?php 
				endwhile;
			endif;?>
			</ul>

		</li>
		<li class="footer"><a href="solic.php?token=<?=$_SESSION['token'];?>">Ver Todos</a></li>
	</ul>
</li>

<!--|FIM DAS LIGAÇÕES|-->
