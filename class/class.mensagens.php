<?php
require_once("../model/recordset.php");


class mensagens extends recordset{
	var $resul = array();
	var $dados;
	var $link;
	
	function mensagens(){
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

	function get_mensagens($data){
		$sql1 = "SELECT * FROM mensagens WHERE men_dtini >= str_to_date('".$data."','%Y-%m-%d') OR men_dtfim <= str_to_date('".$data."','%Y-%m-%d')";
		$this->FreeSql($sql1);
		if($this->linhas >0){
			
			$sql = "SELECT * FROM mensagens WHERE cod<>0";
			$this->FreeSql($sql);
			$this->GeraDados();
			$this->resul['status'] = "OK";
			$this->resul['titulo'] = $this->fld("men_titulo");
			$this->resul['mensagem'] = $this->fld("men_corpo");
			$this->resul['id'] = $this->fld("men_id");
			$this->resul['sql']= $sql;
		}
		else{
			$this->resul['status'] = "NOK";
			$this->resul['linhas'] = $this->linhas;
			$this->resul['sql'] = $sql1;

		}

		return json_encode($this->resul);
	}
}
?>