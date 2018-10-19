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
							 <?=(strlen($rsa->fld("doc_desc"))>20?substr($rsa->fld("doc_desc"), 0,25)."...":$rsa->fld("doc_desc"));?>
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
