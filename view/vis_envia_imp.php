<?php

require_once('../../model/recordset.php');
require_once('../class/class.functions.php');
$rs = new recordset();
$sql = "SELECT ob_titulo FROM obrigacoes WHERE ob_cod = {$_GET['emp']} AND ob_depto = 1 GROUP BY ob_titulo";
$rs->FreeSql($sql);
if($rs->linhas == 0){
	echo "Nenhum resultado";
}
else{
	echo "<table>";
	while($rs->GeraDados()){
		echo "<tr><td>".$rs->fld("ob_titulo")."</td></tr>";
	}
	echo "</table>";
}