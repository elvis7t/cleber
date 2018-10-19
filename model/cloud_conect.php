<?php
/* função que conecta o banco de dados
@author 	Cleber Marrara Prado
@version 	1.0
*/

require_once("cloud_config.php");
//Abre Conexao com mysql
function conecta_cloud(){
	$cloud_link = mysqli_connect(DB_CHOSTNAME, DB_CUSERNAME, DB_CPASSWORD, DB_CDATABASE) or die(mysqli_connect_error());
	mysqli_set_charset($cloud_link, DB_CCHARSET) or die(mysqli_error($cloud_link));
	return $cloud_link;
}

function desconecta_cloud($cloud_link){
	mysqli_close($cloud_link);
}

?>