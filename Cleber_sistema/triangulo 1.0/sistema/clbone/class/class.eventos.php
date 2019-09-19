<?php
require_once("../../model/recordset.php");

class eventos extends recordset{
	var $tabela;

	function eventos(){
		$this->link = conecta();
		return $this->link;
	}
	
	function novo_evento($dados){
		if( !$this->Insere($dados,"eventos") ){
			$this->resul["status"]="OK";
			$this->resul["mensagem"]="Novo evento cadastrado";
		}
		else{
			$this->resul["status"]="NO";
			$this->resul["mensagem"]="Falha na inclus&atilde;o";
		}
		
		return json_encode($this->resul);
	}
}