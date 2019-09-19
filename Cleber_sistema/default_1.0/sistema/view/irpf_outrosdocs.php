
<table class="table table-hover">
<tr>
	<th width="100">Tipo</th>
	<th>N&uacute;mero do Benef&iacute;cio</th>
	<th>A&ccedil;&otilde;es</th>
</tr>
<?php

require_once("../class/class.empresas.php");
$rs = new recordset();
$sql = "SELECT * FROM empresas
			RIGHT JOIN irpf_outrosdocs ON emp_codigo = irdocs_cli_id
		WHERE emp_codigo = '".trim($_GET['clicod'])."'";
$rs->FreeSql($sql);

while($rs->GeraDados()){?>
<tr>
	<td><ul class="timeline"><li><i class="<?=$rs->fld("irdocs_tipo");?> bg-blue"></i></li></ul></td>
	<td><?=$rs->fld("irdocs_dado");?></td>
	<td>
		<a href="javascript:del('<?=$rs->fld("irdocs_id");?>','exc_benef','Excluir o beneficio')" type="button" class="btn btn-danger btn-xs" id="exc_benef"><i class="fa fa-trash"></i></a>
	</td>
</tr>
<?php
}
?>
</table>