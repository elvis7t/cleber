<?php

require_once("../config/main.php");
require_once("../model/recordset.php");

$rs = new recordset();
$rs->Seleciona("*","sistema","sys_nome = 'triangulo'");
$rs->GeraDados();
$_SESSION['sistema'] 	= $rs->fld("sys_nome");
$_SESSION['logo'] 		= $rs->fld("sys_logo");
$_SESSION['dominio'] 	= $rs->fld("sys_dominio");
$_SESSION['empresa']	= $rs->fld("sys_empresa");
$_SESSION['cnpj_emp']	= $rs->fld("sys_cnpj");
$_SESSION['sys_id']	= $rs->fld("sys_id");
/*	SESSOES DE UTILIZAÇÃO - ADEQUAÇÃO PARA USO EXTERNO
	TODAS AS FUNCIONALIDADES DEVEM ESTAR:
		LISTADAS NA TABELA SISTEMA;
		LISTADA NAS SESSÕES;
		PERMISSIONADAS EM CADA MENU.
*/

$_SESSION['usaPadrao']			= 1; // Para o Dashboard e relatórios
$_SESSION['usaLigacoes']		= $rs->fld("sys_usaLigacoes");
$_SESSION['usaClientes']		= $rs->fld("sys_usaClientes");
$_SESSION['usaServicos']		= $rs->fld("sys_usaServicos");
$_SESSION['usaAtendLig']		= $rs->fld("sys_usaAtendLig");
$_SESSION['usaGerenciador']		= $rs->fld("sys_usaGerenciador");
$_SESSION['usaDocumentos']		= $rs->fld("sys_usaDocumentos");
$_SESSION['usaRelLig']			= $rs->fld("sys_usaRelLig");
$_SESSION['usaRelLig']			= $rs->fld("sys_usaRelLig");
$_SESSION['usaRelDocs']			= $rs->fld("sys_usaRelDocs");
$_SESSION['usaIrpf']			= $rs->fld("sys_usaIrpf");
$_SESSION['usaChamados']		= $rs->fld("sys_usaChamados");
$_SESSION['usaCalendario']		= $rs->fld("sys_usaCalendario");
$_SESSION['usaControleHoras']	= $rs->fld("sys_usaControleHoras");
$_SESSION['usaComputadores']	= $rs->fld("sys_usaComputadores");
$_SESSION['usaColaboradores']	= $rs->fld("sys_usaColaboradores");
$_SESSION['usaAssinaturas']		= $rs->fld("sys_usaAssinaturas");
$_SESSION['usaMateriais']		= $rs->fld("sys_usaMateriais");
$_SESSION['usaRecalculo']		= $rs->fld("sys_usaRecalculo");
$_SESSION['usaRelEnvios']		= $rs->fld("sys_usaRelEnvios");

?>