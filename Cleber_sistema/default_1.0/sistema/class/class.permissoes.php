<?php

//session_start();
require_once("../model/recordset.php");

class permissoes extends recordset {
	var $link;
	var $tabela = "permissoes";
	var $tabela2 = "permissoes_indiv";

	function permissoes(){
		$this->link = conecta();
		return $this->link;
	}

	function getPermissao($pag, $user=0){
		$classe = $_SESSION['classe'];
		if($user<>0){
			$s1 = "SELECT * FROM $this->tabela2 WHERE pem_pag = '".$pag."' AND pem_user=".$user;
			$this->FreeSql($s1);
			if($this->linhas==1){
				$sql = $s1;
			}
			else{
				$sql = "SELECT * FROM $this->tabela WHERE pem_pag = '".$pag."'";
			}
		}
		else{
			$sql = "SELECT * FROM $this->tabela WHERE pem_pag = '".$pag."'";
		}
		$this->FreeSql($sql);
		$this->GeraDados();
		$this->con =  json_decode(json_encode(json_decode($this->fld("pem_permissoes"))),true);
		return $this->con[$classe];
	}
}
