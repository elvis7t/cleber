<?php
require_once("../model/recordset.php");

class usuarios extends recordset{
		var $resul = array();
		var $link;
		function usuarios(){
			$this->link = conecta();
			return $this->link;
		}
		
		function add_user($dados){
			if( !$this->Insere($dados,"usuarios") ){
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