<li class="dropdown notifications-menu">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
		$nova = 0;
		$mcorr = date("m")-1;
		$mcorr = str_pad($mcorr, 2,"0",STR_PAD_LEFT);
		$ycorr = date("Y");
		$compcorr = $mcorr."/".$ycorr;
		$con = $perm->getPermissao("ver_all_docs", $_SESSION['usu_cod']);
		$sql = "SELECT * FROM impostos_enviados a
				LEFT JOIN tipos_impostos c ON a.env_codImp = c.imp_id
				LEFT JOIN departamentos f ON c.imp_depto = f.dep_id
				LEFT JOIN tri_clientes e ON e.cod = a.env_codEmp
			WHERE 1";
				
		if($con['C']==0){
			$sql.= " AND e.carteira LIKE '%".$_SESSION['usu_cod']."%'";
			$sql.= " AND c.imp_depto = ".$_SESSION['dep'];
		}
				
		$sql.=" -- AND imp_tipo <> 'A'
				AND env_mov=1 
				AND env_gerado=1 
				AND env_conferido=1
				AND (env_enviado IS NULL OR env_enviado=0)
				AND env_compet='".$compcorr."'";

		$sql.=" ORDER BY env_id DESC, e.cod ASC, imp_tipo ASC, cast(imp_venc as unsigned integer) DESC";
		//echo $sql;
		$rsa->FreeSql($sql);

		$nlin = $rsa->linhas;
		$rsa->GeraDados();
		if($rsa->linhas >0){
			if( !(isset($_COOKIE['envant'])) OR ($_COOKIE['envant'] <> $rsa->fld("env_id")) ){
				setcookie("envlido",0);
				setcookie("envant", $rsa->fld("env_id"));
				$envmessages = "Envio Pendente \n\rEmpresa: ".str_pad($rsa->fld("cod"),3,"0",STR_PAD_LEFT)." - ".$rsa->fld("apelido")." \n\rI/O: ".$rsa->fld("imp_nome");
				setcookie("envmensagem", $envmessages);
				$env_page = "#";
				setcookie("envpag", $env_page);
				
			}
		}		
		/*
		if($_SESSION["classe"]==1){
			echo "<pre>";
			print_r($_COOKIE);
			echo "</pre>";
		}
		*/
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-briefcase"></i>
			<span class="label label-danger"><?=($nlin==0?"":$nlin);?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
			
	</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; <?=($nlin==0?" não tem ": " tem ".$nlin);?> envio(s) pendente(s)</li>
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
							<i class="fa fa-plane text-green"></i> <?=" ".str_pad($rsa->fld("cod"),3,"0",STR_PAD_LEFT)." - ".$rsa->fld("imp_nome");?>
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
