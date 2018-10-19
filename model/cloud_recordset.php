<?php
/*
Recordset - Guarda funções básicas do banco de dados
Inserir, Alterar, Excluir*/

require_once("cloud_conect.php");

class recordset_cloud {
	
	var $cloud_link;

	var $cloud_linhas;
	var $cloud_result;
	var $cloud_sql;
	var $cloud_regs;
	
	function recordset_cloud(){
		$this->cloud_link = conecta_cloud();
		return $this->cloud_link;
	}
	
	function c_Executa_Sql($cloud_sql){
		mysqli_query($this->cloud_link, $cloud_sql) or die(mysqli_error($this->cloud_link));
	}
	function c_GeraDados(){
		return $this->cloud_regs = mysqli_fetch_assoc($this->cloud_result);
		desconecta_cloud($this->cloud_link);
	}
	/*---------------------------------------------------------------------------------------*/
	function c_Insere($campos, $tabela){
		/*
		uso: INSERT INTO $tabela($campos array) VALUES ($dados array)*/
		$cloud_sql = "INSERT INTO ".$tabela."(";
		//foreach nos campos da tabela, enviado via array
		foreach($campos as $campo => $dado){
			$cloud_sql.= $campo.", ";
		}
		$cloud_sql = substr($cloud_sql,0,-2);
		$cloud_sql.=") VALUES(";
		//foreach nos dados, enviados via array
		foreach($campos as $campo => $dado){
			if(is_string($dado)) // verifica se é string; otimiza o tipo de dados.
				$cloud_sql.= "'".$dado."', ";
			else
				$cloud_sql.= $dado.", ";
		}
		$cloud_sql = substr($cloud_sql,0,-2);
		
		//finaliza sql e manda executar
		$cloud_sql.= ")";
		
		$this->sql = $cloud_sql;
		
		return $this->c_Executa_Sql($this->sql);
		desconecta_cloud($this->cloud_link);
	}
	/*-------------------------------------------------------------------------------------------*/
	function c_Altera($campos, $tabela, $whr){
		/*uso: UPDATE $tabela SET $dados = alteração WHERE $whr*/
		$cloud_sql = "UPDATE ".$tabela." SET ";
		foreach($campos as $campo => $dado){
			if(is_string($dado)) // verifica se é string; otimiza o tipo de dados.
			$cloud_sql.= $campo.' = "'.$dado.'", ';
			else
			$cloud_sql.= $campo." = ".$dado.", ";
		}
		$cloud_sql = substr($cloud_sql,0,-2);
		$cloud_sql.=" WHERE ".$whr;
		$this->sql = $cloud_sql;
		$this->c_Executa_Sql($this->sql);
		desconecta_cloud($this->cloud_link);
	}
	/*---------------------------------------------------------------------------------------------*/
	function c_Exclui($tabela, $whr){
		/*uso: DELETE FROM $tabela WHERE $whr*/
		$cloud_sql = "DELETE FROM ".$tabela;
		$cloud_sql.=" WHERE ".$whr;
		$this->sql = $cloud_sql;
		
		$this->c_Executa_Sql($this->sql);
		desconecta_cloud($this->cloud_link);
	}
	/*---------------------------------------------------------------------------------------------*/
	function c_Seleciona($campos="*", $tabela, $where=1, $group="", $order="", $limit="" ){
		if($where <> 1){$whr = $where;}
			
		$cloud_sql = "SELECT ";
		$cloud_sql.= $campos;	
		$cloud_sql.=" FROM ".$tabela;
		$cloud_sql.=" WHERE ". $whr;
		
		if($group)
			$cloud_sql.= " GROUP BY ".$group;
		if($order)
			$cloud_sql.= " ORDER BY ".$order;
		if($limit)
			$cloud_sql.= " LIMIT ".$limit;
		
		$this->sql = $cloud_sql;
		$this->cloud_result = mysqli_query($this->cloud_link, $this->sql) or die(mysqli_error($this->cloud_link));
		$this->cloud_linhas = mysqli_num_rows($this->cloud_result);
	/*------------------------------------------------------------------------------------------------*/		
	}
	Function c_FreeSQL($cloud_sql){
		$this->sql = $cloud_sql;
		$this->cloud_result = mysqli_query($this->cloud_link, $this->sql) or die(mysqli_error($this->cloud_link));
		if(is_bool($this->cloud_result)){$this->cloud_linhas = 0;}
		else {$this->cloud_linhas = mysqli_num_rows($this->cloud_result);}
	}
	/*------------------------------------------------------------------------------------------------*/
	function c_pegar($campo="*", $tabela, $where=1, $group="", $order="", $limit=""){
		$this->c_Seleciona($campo, $tabela, $where, $group, $order, $limit);
		$this->c_GeraDados();
		return $this->fld($campo);
	}
	/*------------------------------------------------------------------------------------------------*/

	function c_fld($campo){
		return $this->cloud_regs[$campo];
	}
	/*-------------------------------------------------------------------------------------------------*/
	function c_autocod($campo, $tabela){
		$this->c_FreeSql("SELECT ".$campo." FROM ".$tabela." ORDER BY ".$campo." DESC");
		$this->c_GeraDados();
		$cod = $this->c_fld($campo)+1;
		return $cod;
	}
}
?>