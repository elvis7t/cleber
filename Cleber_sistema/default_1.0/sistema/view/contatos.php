
<table class="table table-hover">
<tr>
	<th>Tel / Cel / E-mail</th>
	<th>Contato</th>
	<th>A&ccedil;&otilde;es</th>
</tr>
<?php

require_once("../class/class.empresas.php");
$rs = new recordset();
$sql = "SELECT * FROM empresas
			LEFT JOIN contatos ON emp_cnpj = con_cli_cnpj
		WHERE emp_codigo = '".trim($_GET['clicod'])."'";
$rs->FreeSql($sql);
while($rs->GeraDados()){?>
<tr>
	<td><ul class="timeline"><li><i class="<?=$rs->fld("con_tipo");?> bg-blue"></i></li></ul></td>
	<td><?=$rs->fld("con_contato");?></td>
	<td>
		<button type="button" class="btn btn-danger btn-xs" id="exc_ctt" data-tbl="contatos" data-contato=<?=$rs->fld("con_cod");?>><i class="fa fa-trash"></i></button>
	</td>
	
</tr>
<?php
}
?>
</table>

								