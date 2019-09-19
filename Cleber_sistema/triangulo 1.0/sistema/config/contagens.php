<?
$contagens = array();

$sql = "
	SELECT * FROM Testes_Pers WHERE tes_ativo=1; 
";
$rs_msg->FreeSQL($sql);
$contagens['testes'] 		= $rs_msg->linhas;
$contagens['clientes'] 		= 2;
$contagens['sites'] 		= 2;
$contagens['comentarios'] 	= 0;
$contagens['tickets'] 		= 0;
?>
