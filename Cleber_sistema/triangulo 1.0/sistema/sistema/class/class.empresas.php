<?php
require_once("../../model/recordset.php");


class empresas extends recordset{
	var $resul = array();
	var $dados;
	var $link;
	
	function empresas(){
		$this->link = conecta();
		return $this->link;
	}
	
	function add_novo($dados){
		//mescla arrays com os valores do formulário
		
		if( !$this->Insere($dados,"empresas") ){
			$this->resul["status"]="OK";
			$this->resul["mensagem"]="Nova empresa cadastrada";
		}
		else{
			$this->resul["status"]="NO";
			$this->resul["mensagem"]="Falha na inclus&atilde;o";
		}
		
		return json_encode($this->resul);
	}
}
?>