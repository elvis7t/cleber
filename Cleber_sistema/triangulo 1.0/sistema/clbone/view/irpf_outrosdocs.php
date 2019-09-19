
<table class="table table-hover">
<tr>
	<th>Tipo</th>
	<th>Dado</th>
</tr>
<?php

require_once("../class/class.empresas.php");
$rs = new recordset();
$sql = "SELECT * FROM empresas
			LEFT JOIN irpf_outrosdocs ON emp_codigo = irdocs_cli_id
		WHERE emp_codigo = '".trim($_GET['clicod'])."'";
$rs->FreeSql($sql);
while($rs->GeraDados()){?>
<tr>
	<td><ul class="timeline"><li><i class="<?=$rs->fld("irdocs_tipo");?> bg-blue"></i></li></ul></td>
	<td><?=$rs->fld("irdocs_dado");?></td>
</tr>
<?php
}
?>
</table>