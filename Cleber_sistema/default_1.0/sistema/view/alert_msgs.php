<!--|PRODUTOS PARA COMPRAR|-->
<li class="dropdown notifications-menu <?=(($_SESSION['classe']>=4 )? "hide" : "");?>">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
	require_once("../class/class.permissoes.php");
	$nova = 0;
	$fna = new functions();
	$rsa = new recordset();
	$perm = new permissoes();
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
							<i class="fa fa-puzzle-piece text-aqua"></i> <?=$rsa->fld("mcad_desc");?>
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

<!--|HOMOLOGAÇÕES|-->
<?php 
	$ver_hom = $perm->getPermissao("homologa",$_SESSION['usu_cod']);
	if($ver_hom['C']==1){ ?> 
		<li class="dropdown notifications-menu">
			<!-- Messages: style can be found in dropdown.less-->
			<?php
			$nova = 0;
			
			$sql = "SELECT a.*, c.usu_nome as solic, b.empresa, b.cod
					FROM homologacoes a
						JOIN tri_clientes b ON a.hom_empresa = b.cod
						LEFT JOIN usuarios c ON a.hom_cadpor = c.usu_cod
						LEFT JOIN usuarios d ON a.hom_realpor = d.usu_cod
						JOIN codstatus e ON a.hom_status = e.st_codstatus
						WHERE hom_empvinculo = ".$_SESSION['usu_empcod'];
						
					$sql.=" AND hom_datahom BETWEEN adddate(now(),-10) and adddate(now(),30) AND hom_status NOT IN(90,99) ";
					$sql .=" Order BY hom_status ASC, hom_id DESC";
				
				$rsa->FreeSql($sql);

				$nlin = $rsa->linhas;
				$rsa->GeraDados();
				if($rsa->linhas >0 AND $_SESSION['classe']<=3){
					if( !(isset($_COOKIE['hom_ant'])) OR ($_COOKIE['hom_ant'] <> $rsa->fld("hom_id")) ){
						setcookie("hom_lido",0);
						setcookie("hom_ant", $rsa->fld("hom_id"));
						$hom_messages = "Homologação cadastrada: ".$rsa->fld("solic")." \nEmpresa ".$rsa->fld("empresa");
						setcookie("hom_mensagem", $hom_messages);
						$hom_page = "#";//"recalc_sol.php?token=".$_SESSION["token"];
						setcookie("hompag", $hom_page);
					}
				}

			?>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-hand-scissors-o"></i>
					<span class="label label-warning"><?=($nlin==0?"":$nlin);?></span>
					<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
					
			</a>
			<ul class="dropdown-menu">
				<li class="header">Voc&ecirc; <?=($nlin==0?"não":"");?> tem <?=($nlin==0?"":$nlin);?> homologa&ccedil;&atilde;o (&otilde;es)</li>
				<li>
				<!-- inner menu: contains the actual data -->
					<ul class="menu">
						<?php
						$rsa->FreeSql($sql);
						while($rsa->GeraDados()){
						?>
						<li><!-- start message -->
							<a href="atende_homol.php?token=<?=$_SESSION['token'];?>&homol=<?=$rsa->fld("hom_id");?>">
								<div class="pull-left">
									<i class="fa fa-hand-scissors-o text-orange"></i> <?=$rsa->fld("cod")." - ".$rsa->fld("hom_empregado");?>
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
	<?php }?>
<!--|FIM HOMOLOGAÇÕES|-->






<!--|RECALCULOS|-->
<li class="dropdown notifications-menu">
	<!-- Messages: style can be found in dropdown.less-->
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

<!--|PRODUTOS PARA COMPRAR|-->
<li class="dropdown notifications-menu <?=(($_SESSION['classe']>=4 AND $_SESSION['classe']<8)? "hide" : "");?>">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
	$nova = 0;
	$sql = "SELECT * FROM alerta_compras a 
			LEFT JOIN mat_cadastro b ON a.alerta_matId = b.mcad_id
			WHERE (a.alerta_matcomp - a.alerta_matentr) < a.alerta_matmin
			AND a.alerta_matId NOT IN (SELECT mat_cadId FROM mat_historico WHERE mat_operacao = 'I' AND mat_lista IS NOT NULL )
			 ORDER BY alerta_id DESC";
	$rsa->FreeSql($sql);
	
	/*
	$sql = "SELECT * FROM servicos a
			JOIN codstatus b
				ON b.st_codstatus = a.ser_status
			JOIN tri_clientes c
				ON c.cod = a.ser_cliente
			WHERE ser_status = 0 AND ser_lista=0";
	*/

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
<!--|PRODUTOS PARA COMPRAR|-->

<!--|IMPOSTOS A ENVIAR|-->
<li class="dropdown notifications-menu">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
		$nova = 0;
		$mcorr = date("m")-1;
		$mcorr = str_pad($mcorr, 2,"0",STR_PAD_LEFT);
		$ycorr = date("Y");
		$compcorr = $mcorr."/".$ycorr;
		$con = $perm->getPermissao("ver_impostos", $_SESSION['usu_cod']);
		$sql = "SELECT * FROM impostos_enviados a
				LEFT JOIN tipos_impostos c ON a.env_codImp = c.imp_id
				LEFT JOIN departamentos f ON c.imp_depto = f.dep_id
				LEFT JOIN tri_clientes e ON e.cod = a.env_codEmp
			WHERE 1";
				
		if($con['C']==0){
			$sql.= " AND e.carteira LIKE '%".$_SESSION['usu_cod']."%'";
			$sql.= " AND c.imp_depto = ".$_SESSION['dep'];
		}
				
		$sql.=" AND imp_tipo <> 'A'
				AND env_mov=1 
				AND env_gerado=1 
				AND env_conferido=1
				AND (env_enviado IS NULL OR env_enviado=0)
				AND env_compet='".$compcorr."'";

		$sql.=" ORDER BY env_id DESC, e.cod ASC, imp_tipo ASC, cast(imp_venc as unsigned integer) DESC";

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

<!--|FIM IMPOSTOS A ENVIAR|-->

<!--|INICIO SAIDAS DO MOTORISTA|-->
<li class="dropdown notifications-menu <?=(($_SESSION['classe']>4 AND $_SESSION['classe']<8)? "hide" : "");?>">
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

<!--|FIM SAIDAS DO MOTORISTA|-->

<!--|INICIO ARQUIVOS|-->
<?php
$_tipoArq = array(
    "application/pdf" => array("icone" => "file-pdf-o", "cor" => "bg-purple"),
    "image/png" => array("icone" => "file-picture-o", "cor" => "bg-aqua"),
    "image/jpeg" => array("icone" => "file-picture-o", "cor" => "bg-danger"),
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document" => array("icone" => "file-word-o", "cor" => "bg-blue"),
    "application/vnd.ms-excel" => array("icone" => "file-excel-o", "cor" => "bg-green"),

    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" => array("icone" => "file-excel-o", "cor" => "bg-green")
);
?>
<li class="dropdown notifications-menu">
	<!-- Messages: style can be found in dropdown.less-->
	<?php

	$sql = "SELECT a.*, b.usu_nome as Nome, c.usu_nome as Env FROM documentos a 
            JOIN usuarios b ON a.doc_cli_cnpj = b.usu_cpf
            JOIN usuarios c ON a.doc_user_env = c.usu_email
				WHERE doc_cli_cnpj = '{$_SESSION['usu_cpf']}'";
		$sql_l = $sql." AND doc_visto=0 ORDER BY doc_cod DESC";
		$sql = $sql." ORDER BY doc_cod DESC";
		$rsa->FreeSql($sql_l);
		//echo $rsa->sql;
		$nlin = $rsa->linhas;
		$rsa->GeraDados();
		if($rsa->linhas >0){
			if( !(isset($_COOKIE['arqant'])) OR ($_COOKIE['arqant'] <> $rsa->fld("doc_cod")) ){
				setcookie("arqlido",0);
				setcookie("arqant", $rsa->fld("doc_cod"));
				$arqmessages = "Novo arquivo enviado por ".$rsa->fld("Env")." | Documento: ".$rsa->fld("doc_desc");
				setcookie("arqmensagem", $arqmessages);
				$arq_page = "arquivos.php?token=".$_SESSION["token"];
				setcookie("arqpag", $arq_page);
				$rs = new recordset();
				
			}
		}
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-file-pdf-o"></i>
			<span class="label label-info"><?=($nlin==0?"":$nlin);?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
			
	</a>
	<ul class="dropdown-menu">
		<?php 
			$rsa->FreeSql($sql);
			$nlin = $rsa->linhas;
		?>
		<li class="header">Voc&ecirc; <?=($nlin==0?"não tem":"tem " .$nlin);?> Arquivos</li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php
				while($rsa->GeraDados()){

				?>
				<li><!-- start message -->
					<a href="<?=$rsa->fld("doc_ender");?>" target="_blank" id="marca_visto">
						<div class="pull-left">
							<i class="fa fa-<?=$_tipoArq[$rsa->fld("doc_tipo")]['icone']." fa-2x ".$_tipoArq[$rsa->fld("doc_tipo")]['cor'];?>"></i>
							 <?=$rsa->fld("doc_desc");?>
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
<!--|FIM ARQUIVOS|-->

<!--|INICIO DAS MENSAGENS|-->
<li class="dropdown messages-menu">
	<!-- Messages: style can be found in dropdown.less-->
	<?php
		//ob_start();
		
		$cua = $_SESSION["usu_cod"];

		//marcando mensagens como lidas com o ID do PARA
		$para = (isset($_GET["para"])?$_GET["para"] : 0);
		$msg = (isset($_COOKIE["msgant"])?$_COOKIE["msgant"] : 0);
		//setcookie("msg_lido",1);

		//Verificando novas mensagens não lidas
		$sql = "SELECT * FROM chat a
					LEFT JOIN usuarios b
					ON a.chat_de = b.usu_cod
					WHERE chat_para = ". $cua ." AND chat_lido = 0 ORDER BY chat_id DESC ";
					//echo $sql;
		$rsa->FreeSql($sql);
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-comments-o"></i>
		<?php
		/*|VERIFICAR MENSAGENS PARA EXIBIR NOTIFICAÇÕES|*/
		if($rsa->linhas > 0): 
			$nova = $rsa->linhas;
			$rsa->GeraDados();
			
			if( !(isset($_COOKIE['msgant'])) OR ($_COOKIE['msgant'] <> $rsa->fld("chat_id")) ){
				setcookie("msg_lido",0);
				setcookie("msgant", $rsa->fld("chat_id"));
				$messages = $rsa->fld('chat_msg');
				setcookie("mensagem", $messages);
				//$nm = explode(" ",$rsa->fld("usu_nome"));
				setcookie("user",$rsa->fld("usu_nome"));
				$link_page = "solic.php?token=".$_SESSION["token"]."&para=".$rsa->fld("chat_de");
				setcookie("foto",$rsa->fld("usu_foto"));
				setcookie("pag", $link_page);
				
			}

			?>
			<span class="label label-danger"><?=$rsa->linhas;?></span>
			<!--<input type="hidden" id="nova" value=<?=$nova;?> />-->
		<?php else:
			
			endif;
			//print_r($_COOKIE);
			/*|	NOVA FUNCIONALIDADE - VERIFICAR DOCUMENTOS ENTREGUES PARA EXIBIR NOTIFICAÇÕES
				CLEBER MARRARA PRADO - 07/04/2016
				COLAB. BRUNO RIBEIRO
				AS NOTIFICAÇÕES SÃO FORMADAS NO ARQUIVO js/controle.js
				A CHAMADA DA FUNÇÃO OCORRE NO ARQUIVO config/footer.php
				FUNCIONA SOMENTE EM PÁGINAS COM O jcookie.js REFERENCIADO
			|*/
			$rsdocs = new recordset();  
			
			$docsql = "SELECT * FROM docs_entrada a
						JOIN tipos_doc b ON a.doc_tipo = b.tdoc_id
						JOIN departamentos c ON a.doc_dep = c.dep_id
						JOIN tri_clientes d ON a.doc_cli = d.cod
					WHERE doc_status = 0 AND dep_id=".$_SESSION['dep']." ORDER BY doc_id DESC";
			$rsdocs->FreeSql($docsql);
			if($rsdocs->linhas > 0){
				$rsdocs->GeraDados();
				if( !(isset($_COOKIE['docant'])) OR ($_COOKIE['docant'] <> $rsdocs->fld("doc_id")) ){
					setcookie("docant", $rsdocs->fld("doc_id"));
					setcookie("doclido",0);
					$docmessages = "Novo Documento na portaria Empresa: ".$rsdocs->fld("apelido")." | Documento: ".$rsdocs->fld("tdoc_tipo");
					setcookie("docmensagem", $docmessages);
					setcookie("docdep", $rsdocs->fld("dep_nome"));
					$doc_page = "entrega_docs.php?token=".$_SESSION["token"];
					setcookie("docpag", $doc_page);
				}
			}
			
			if(isset($_SESSION['pausa'])){
				$cafe = array(1=>'09:00',
							2=>'09:10',
							3=>'09:20',
							4=>'15:00',
							5=>'15:10',
							6=>'15:20');


				list($p1, $p2) = explode(",", $_SESSION['pausa']);

				
				if($cafe[$p1] == date('H:i')){
					//echo $cafe[$p1];
					if( !(isset($_COOKIE['pausa'])) OR ($_COOKIE['pausa'] <> $cafe[$p1])){
						setcookie("pausa",$cafe[$p1]);
						setcookie("pausalido",0);
						$pausamsg = "Café...";
						setcookie("pausamsg", $pausamsg);
					}
					//exit;
				}
				//echo date("H:i");
				
				if($cafe[$p2] == date("H:i")){
					if( !(isset($_COOKIE['pausa'])) OR ($_COOKIE['pausa'] <> $cafe[$p2]) ){
						setcookie("pausa",$cafe[$p2]);
						setcookie("pausalido",0);
						$pausamsg = "Café...";
						setcookie("pausamsg", $pausamsg);
					}
					//exit;
				}
				
			
			}
			

		?>
		<input type="hidden" id="nova" value=<?=$_COOKIE['msg_lido'];?> />
		</a>
	<ul class="dropdown-menu">
		<li class="header">Voc&ecirc; tem <?=$rsa->linhas .($rsa->linhas>1?" mensagens":" mensagem");?></li>
		<li>
		<!-- inner menu: contains the actual data -->
			<ul class="menu">
				<?php 
				
					$rsa->FreeSql($sql);
					while($rsa->GeraDados()):
					$link_page = "solic.php?token=".$_SESSION["token"]."&para=".$rsa->fld("chat_de");
				?>
				<li><!-- start message -->

					<a href="<?=$link_page;?>">
						<div class="pull-left">
						<img src="<?=$hosted.$rsa->fld("usu_foto");?>" class="img-circle" alt="User Image">
						</div>
						<h4>
						<?php
							list($nome, $sobre) = explode(" ",$rsa->fld("usu_nome"));
							echo $nome." ".$sobre;
						?>
						<small><i class="fa fa-clock-o"></i> <?=$fna->calc_dh($rsa->fld("chat_hora"));?></small>
						</h4>
						<p><?=$rsa->fld("chat_msg");?></p>
					</a>
				</li><!-- end message -->
				<?php endwhile; 
				// Setando mensagens como lida
				$sq_chat = "UPDATE chat SET chat_lido=1 WHERE chat_de = ".$para." AND chat_para = ".$cua;
				$rsa->FreeSql($sq_chat);
				echo "<!--".$rsa->sql."-->";
		
				?>
				
				<!--<li class="footer"><a href="#">Veja todas as Mensagens</a></li>-->
			</ul>
		</li>
	</ul>	
</li>
<!--|FIM DAS MENSAGENS|-->


<!--|INICIO DOS DOCUMENTOS|-->

<li class="dropdown notifications-menu">
	<?php

		$sql = "SELECT * FROM docs_entrada a
					JOIN codstatus b
						ON b.st_codstatus = a.doc_status
					JOIN tri_clientes c
						ON c.cod = a.doc_cli
					LEFT JOIN usuarios d 
						ON d.usu_cod = a.doc_resp
					JOIN departamentos e 
						ON e.dep_id = a.doc_dep
					JOIN tipos_doc f
						ON f.tdoc_id =  a.doc_tipo
				WHERE doc_dep = ".$_SESSION['dep']." AND doc_status=0 ORDER BY doc_id DESC";
			
			$rsa->FreeSql($sql);

			$nlin = $rsa->linhas;
			$rsa->GeraDados();
			
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-file-text"></i>
        <span class="label label-warning"><?=($nlin==0?"":$nlin);?></span>
	</a>
    <ul class="dropdown-menu">
		<li class="header">Voc&ecirc; tem <?=($nlin==1? $nlin." documento": $nlin." documentos");?></li>
		<li>
			<!-- inner menu: contains the actual data -->
			<ul class="menu">
			<?php
			if($nlin == 0):
			?>
				<li>
					<a href="#">
						<i class="fa fa-times text-danger"></i> Nenhum documento dispon&iacute;vel
					</a>
				</li>
			<?php else:
				$rsa->FreeSql($sql); 
				while($rsa->GeraDados()):
					?>
						<li>
							<a href="entrega_docs.php?token=<?=$_SESSION['token'];?>">
								<i class="fa fa-<?=$rsa->fld("dep_tema");?> text-info"></i> <?=$rsa->fld("tdoc_tipo")." - ".$rsa->fld("apelido")." (id: #".$rsa->fld("doc_id").")";?>
							</a>
						</li>
					<?php 
				endwhile;
			endif;?>
			</ul>

		</li>
		<li class="footer"><a href="#">Ver Todos</a></li>
	</ul>
</li>
<!--|FIM DOS DOCUMENTOS|-->

	
<!--|INICIO DO CALENDARIO|-->
<li class="dropdown tasks-menu">
	<?php
		$sql = "SELECT eve_desc, cal_dataini, cal_url, usu_nome FROM calendario a
					JOIN eventos b ON a.cal_eveid = b.eve_id
					JOIN usuarios c on a.cal_criado = c.usu_cod
				WHERE cal_dataini >= '".date("Y-m-d", strtotime("-1 days"))."' AND cal_datafim <='".date("Y-m-d",strtotime("+7 days"))."' 
				AND (cal_eveusu like '%[".$_SESSION['usu_cod']."]%'
				OR cal_eveusu like '%[9999]%') ORDER BY cal_id DESC";
		$rsa->FreeSql($sql);
		$rsa->GeraDados();
		$linhas = $rsa->linhas;
		//echo $rsa->sql;
		// Cria cookies caso tenha eventos. Validade de 24hs.
		if($linhas > 0 ){
			if(!isset($_COOKIE["ncal"])){
				setcookie("ncal",0,time()+86400);
			}
		}
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-calendar"></i>
		
			<?php
				if($linhas > 0 AND (isset($_COOKIE["vcal"]) AND $_COOKIE["vcal"]==0)){
					setcookie("vcal",0,time()+86400);
					setcookie("calmsg",$rsa->fld("usu_nome")." | ".$rsa->fld("eve_desc"));
	
				}
			if($rsa->linhas>0){
			?>
			<span class="label label-danger">
				<?=$rsa->linhas;?>
			</span>
			<?php }?>
	</a>

	<?php 
	if(($rsa->linhas > 0) /*AND (!isset($_COOKIE["vcal"]) OR $_COOKIE["vcal"]==0)*/):
		?>
		<ul class="dropdown-menu">
			<li class="header">Existem <?=$rsa->linhas;?> tarefas no calend&aacute;rio</li>
			<li>
			<!-- inner menu: contains the actual data -->
				<ul class="menu">
					<?php
						$rsa->FreeSql($sql);
						//$rsa->GeraDados();
						while($rsa->GeraDados()){?>
						<li><!-- Task item -->
							<a href="<?=$hosted;?>/view/<?=$rsa->fld("cal_url");?>&token=<?=$_SESSION['token'];?>">
								<h3>
									<?=$fna->data_br($rsa->fld("cal_dataini"))." - ". $rsa->fld("eve_desc");?>
								</h3>
							</a>
						</li><!-- end task item -->
					<?php
						}
					?>
				</ul>
			</li>
			<li class="footer">
				<a href="<?=$hosted;?>/view/calendar.php?token=<?=$_SESSION['token'];?>">Ver todas as tarefas</a>
			</li>
		</ul>
	<?php else: ?>
		<ul class="dropdown-menu">
			<li class="header">N&aacute;o existem tarefas para hoje</li>
		</ul>
	<?php endif; ?>
</li>
<!--|FIM DO CALENDARIO|-->



<!--|INICIO DOS CHAMADOS|-->
<li class="dropdown tasks-menu">
	<?php
		$sql = "SELECT UCASE(cham_task), cham_percent, cham_id 
					FROM chamados 
					WHERE cham_dept = ".$_SESSION['dep']." AND cham_status IN(0,92) ORDER BY cham_id DESC";
		$rsa->FreeSql($sql);
		//echo $rsa->sql;
		$rsa->GeraDados();
		// Cria cookies caso tenha eventos. Validade de 24hs.
		if($rsa->linhas > 0 ){
			if( !(isset($_COOKIE['chams'])) OR ($_COOKIE['chams'] <> $rsa->fld("cham_id")) ){
				setcookie("chams", $rsa->fld("cham_id"));
				setcookie("chamlido",0);
				$chammessages = "Novo Chamado: ".$rsa->fld("UCASE(cham_task)");
				setcookie("chammensagem", $chammessages);
			}
			/*
			if(!(isset($_COOKIE["chams"])) OR ){
				setcookie("chams",0,time()+86400);
				setcookie("vchams",0,time()+86400);
				setcookie("chammsg","TAREFA | ".$rsa->fld("UCASE(cham_task)"));
			}
			*/
		}
	?>

	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-cogs"></i>
		<?php
			if($rsa->linhas > 0){?>
				<span class="label label-info">
				<?=$rsa->linhas;?>
				</span>
			<?php
			}
		?>
	</a>

	<?php 

	if(($rsa->linhas > 0)):
		
		?>
		<ul class="dropdown-menu">
			<li class="header">Existem <?=$rsa->linhas;?> tarefas para tratar</li>
			<li>
			<!-- inner menu: contains the actual data -->
				<ul class="menu">
					<?php
						$rsa->FreeSql($sql);
						//$rsa->GeraDados();
						while($rsa->GeraDados()){?>
						<li><!-- Task item -->
							<a href="<?=$hosted;?>/view/atendimento.php?token=<?=$_SESSION['token'];?> &acao=1&chamado=<?=$rsa->fld("cham_id");?>">
								<h3>
									<?=$rsa->fld("UCASE(cham_task)");?>                    				
								</h3>
								<div class="progress xs">
									<div class="progress-bar progress-bar-info" style="width: <?=$rsa->fld("cham_percent");?>%" role="progressbar" aria-valuenow="<?=$rsa->fld("cham_percent");?>" aria-valuemin="0" aria-valuemax="100">
										<span class="sr-only"><?=$rsa->fld("cham_percent");?>% Completo</span>
									</div>
								</div>
							</a>
						</li><!-- end task item -->
					<?php
						}
					?>
				</ul>
			</li>
			<li class="footer">
				<a href="<?=$hosted;?>/view/vis_chamados.php?token=<?=$_SESSION['token'];?>">Ver todas as tarefas</a>
			</li>
		</ul>
	<?php else: ?>
		<ul class="dropdown-menu">
			<li class="header">N&aacute;o existem chamados abertos</li>
		</ul>
	<?php endif; ?>
</li>
<!--|FINAL DOS CHAMADOS|-->


<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
	<?php  if(!isset($_SESSION['nome_usu'])):?>
	<a href="<?=$hosted."/view/login.php";?>">
		<?php  else :?>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<img src="<?=$hosted.$_SESSION['usu_foto'];?>" class="user-image" alt="User Image">
		<?php  endif;?>
		<span class="hidden-xs"><?=(isset($_SESSION['nome_usu'])? $_SESSION['nome_usu'] :'Login');?></span>
	</a>
	<?php  if(isset($_SESSION["nome_usu"])):?>
	<ul class="dropdown-menu">
		<!-- User image -->
		<li class="user-header">
			<img src="<?=$hosted.$_SESSION["usu_foto"];?>" class="img-circle" alt="User Image">
			<p>
			<?=$_SESSION['nome_usu'];?>
				<small><?=$_SESSION['usuario'];?></small>
			</p>
		</li>
		<li class="user-footer">
			<div class="pull-left">
				<a href="<?=$hosted;?>/view/user_perfil.php?token=<?=$_SESSION['token'];?>&usuario=<?=$_SESSION['usu_cod'];?>" class="btn btn-default btn-flat">Perfil</a>
			</div>
			<div class="pull-right">
				<a href="<?=$hosted;?>/view/logout.php" class="btn btn-default btn-flat">Sair</a>
			</div>
		</li>
	</ul>
		
	<?php  endif;?>
</li>
<!-- END OF User Account: style can be found in dropdown.less -->

<script type="text/javascript">
	setTimeout(function(){
		$("#alms").load(location.href+" #almsg");
		console.log("Atualizado AlertMSG");
	},7500);

</script>