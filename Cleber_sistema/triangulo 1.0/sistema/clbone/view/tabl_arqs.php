<?php
session_start();
/*
require_once("../config/main.php");
Array com os tipos de documentos que são inseridos no banco
Escolhe pelo indice, o icone e a cor da caixa para apresentação dos docs.
*/
require_once("../class/class.empresas.php");
require_once("../../sistema/class/class.functions.php");
$fn = new functions();
$rs = new recordset();

$_tipoArq = array(
	"application/pdf" 	=> array("icone" => "fa fa-file-pdf-o", "cor" => "bg-blue"),
	"image/png" 		=> array("icone" => "fa fa-file-picture-o", "cor" => "bg-aqua"),
	"image/jpeg" 		=> array("icone" => "fa fa-file-picture-o", "cor" => "bg-info"),
	"application/vnd.openxmlformats-officedocument.wordprocessingml.document" => array("icone" => "fa fa-file-word-o", "cor" => "bg-teal"),
	
	"application/vnd.ms-excel" => array("icone" => "fa fa-file-excel-o", "cor" => "bg-green"),
	"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" => array("icone" => "fa fa-file-excel-o", "cor" => "bg-green")
);


if(isset($_POST['doc_pes'])):
	$doc = $_POST['doc_pes'];
else:
	if(isset($_GET['cnpj'])):
		$doc = $_GET['cnpj'];
	else:
		$doc = $_SESSION["usu_empresa"];
	endif;
endif;
//echo $doc;

?>
	<table class="table table-striped">
				<tr>
					<th>Tipo</th>
					<th>Nome do Arquivo</th>
					<th>Data do Envio</th>
					<th>Enviado Por</th>										
				</tr>
				<?php
				$whr = "doc_cli_cnpj = '".$doc."'";
				$rs->Seleciona("*","documentos",$whr,"doc_cod ASC");
				while($rs->GeraDados()){
					$user = explode("@",$rs->fld("doc_user_env"));?>
					<tr>
						<td><ul class="timeline"><li><i class="<?=$_tipoArq[$rs->fld("doc_tipo")]["icone"];?> bg-blue"></i></li></ul></td>
						<td><?=$rs->fld("doc_desc");?></td>
						<td><?=$fn->data_br($rs->fld("doc_dtenv"));?></td>
						<td><?=$user[0];?></td>
					</tr>
				<?php
				}
				?>
				
			</table>
		
				<a href="empresas_docs.php?token=<?=$_SESSION['token'];?>&clicod=<?=$_GET['clicod']; ?>&doc_pes=<?=$doc;?>"
					class='btn btn-sm btn-success' 
					data-toggle='tooltip' 
					data-placement='bottom' 
					title='Novo IRPF'><i class='fa fa-pie-chart'></i> Enviar Documento
				</a>
				
			
												