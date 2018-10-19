<table class="table table-hover">
	<tr>
		<th>Usuario</th>
		<th>Nome</th>
		<th>Classe</th>
		<th>Status</th>
	</tr>
	<?php

	require_once("../class/class.empresas.php");
	$rs = new recordset();
	$sql = "SELECT * FROM empresas
				LEFT JOIN usuarios ON emp_cnpj = usu_emp_cnpj
			WHERE emp_cnpj = '".trim($_GET['cnpj'])."'";
	$rs->FreeSql($sql);
	while($rs->GeraDados()){?>
	<tr>
		<td><?=$rs->fld("usu_email");?></td>
		<td><?=$rs->fld("usu_nome");?></td>
		<td><?=$rs->fld("usu_classe");?></td>
		<td><?=($rs->fld("usu_ativo")==1?"Ativo":"Cancelado");?></td>
	</tr>
	<?php
	}
	?>
</table>