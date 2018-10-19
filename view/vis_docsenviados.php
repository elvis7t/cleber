<?php 
require_once("../model/recordset.php");
//$hosted = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER["HTTP_HOST"]."/sistema";
$hosted = "http://www.triangulocontabil.com.br/sistema";
date_default_timezone_set('America/Sao_Paulo');
//echo $hosted;
$rs = new recordset();
extract($_GET);

$link = $rs->pegar("envcli_arquivo","doc_envclientes","envcli_id=".$id);

$sql = "UPDATE doc_envclientes SET envcli_visual = 1, envcli_vispor='".$via."', envcli_visem = '".date("Y-m-d H:i:s")."'
		WHERE envcli_visual=0 AND envcli_id = ".$id;
$rs->FreeSql($sql);

//echo $link;
header("location:".$link);

 ?>
