<?
session_start();
require_once("../config/main.php");
require_once("../../model/recordset.php");

$rs = new recordset();
$rs->Seleciona("*","sistema","sys_nome = 'triangulo'");
$rs->GeraDados();

$_SESSION['sistema'] 	= $rs->fld("sys_nome");
$_SESSION['logo'] 		= $rs->fld("sys_logo");
$_SESSION['dominio'] 	= $rs->fld("sys_dominio");
$_SESSION['empresa']	= $rs->fld("sys_empresa");

?>