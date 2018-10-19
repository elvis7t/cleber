<?php
require_once("../model/recordset.php");
class dashboard extends recordset {
	var $link;
	
	function __construct(){
		$this->link = conecta();
		return $this->link;
	}

	function count_imposto($obr, $dep, $user, $perm=0, $compet){
		// Creating an array to store the info
		$vals = array("meta"=>0, "real"=>0, "imposto"=>"");
		// Getting the tax name and setting the tax name onto imposto key
		$vals['imposto'] = $this->pegar("imp_nome","tipos_impostos","imp_id=".$obr);
		$cli_empresas = $this->pegar("usu_empresas","usuarios","usu_cod=".$user);
		
		// First, we get the number of obligations for this current month
		$sql_meta = "SELECT COUNT(*) FROM obrigacoes a
					JOIN tri_clientes b ON b.cod = a.ob_cod
					WHERE 1	
						AND ob_ativo = 1
						AND b.ativo = 1
						AND ob_titulo = ".$obr;
		
		if($cli_empresas<>"" AND $cli_empresas <>0){
			$sql_meta .= " AND ob_cod IN (".$cli_empresas.")";	
		}
		else{
			if($perm == 0){
				$sql_meta.=" AND carteira LIKE '%\"".$dep."\":{\"user\":\"".$user."\"%'";
			}
		}

		$this->FreeSql($sql_meta);
		$this->GeraDados();
		$vals["meta"] = $this->fld("COUNT(*)");
		/*
		*/

		// Then, we search for the same parameters at the sent_taxes
		$sql_real = "SELECT COUNT(*) FROM impostos_enviados a
					JOIN tri_clientes b ON b.cod = a.env_codEmp
					WHERE 1
						AND a.env_codImp = ".$obr."
						AND a.env_compet = '".$compet."'
						AND a.env_conferido = 1";
		if($cli_empresas<>"" AND $cli_empresas <>0){
			$sql_real .= " AND env_codEmp IN (".$cli_empresas.")";	
		}
		else{
			if($perm == 0){
				$sql_real.=" AND carteira LIKE '%\"".$dep."\":{\"user\":\"".$user."\"%'";
			}
		}
		
		
		echo "<script>alert(".$sql_real.")</script>";
		$this->FreeSql($sql_real);
		$this->GeraDados();
		$vals["real"] = $this->fld("COUNT(*)");
		return $vals;
		/*
		*/
	}
}