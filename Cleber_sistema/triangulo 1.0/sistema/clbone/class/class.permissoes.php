<?php

session_start();
require_once("../../model/recordset.php");

class permissoes extends recordset {
	var $link;
	var $tabela = "permissoes";

	function permissoes(){
		$this->link = conecta();
		return $this->link;
	}

	function getPermissao($pag){
		$classe = $_SESSION['classe'];
		$sql = "SELECT * FROM $this->tabela WHERE pem_pag = '".$pag."'";
		$this->FreeSql($sql);
		$this->GeraDados();
		$this->con =  json_decode(json_encode(json_decode($this->fld("pem_permissoes"))),true);
		return $this->con[$classe];
	}
}
