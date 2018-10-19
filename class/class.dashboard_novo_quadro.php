<?php
require_once("../../model/recordset.php");
class dashboard extends recordset {
	var $link;
	var $niveis = array(
			1=> array(
				1=> array("cor"=>"bg-red", "ico"=>"fa fa-suitcase", "valor"=>"", "tam"=>4,	"tit"=>"Metas",	"sub"=>"Metas Atribuídas"),
				2=> array("cor"=>"bg-green", "ico"=>"fa fa-tasks", "valor"=>"", "tam"=>4,	"tit"=>"Metas",	"sub"=>"Metas Realizadas")

			)

		);
	
	function dashboard(){
		$this->link = conecta();
		return $this->link;
	}
	
	function quadro($nivel, $num, $tipo){
		$di = date("Y-m")."-01 00:00:00";
		$df = date("Y-m-t")." 23:59:59";
		//$cp = '{"1":{"user":"","data":""},"2":{"user":"","data":""},"4":{"user":"","data":""}}';
		
		if($tipo == "Metas_Atrib"){
			$sql = "SELECT count(b.metas_id) as result
			 FROM tarmetas a 
				JOIN metas b 		ON a.tarmetas_metasId = b.metas_id
				JOIN usuarios c 	ON b.metas_colab = c.usu_cod
				WHERE 1
					AND	b.metas_datafin BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND LAST_DAY(NOW())
					AND 	c.usu_dep = 8
					AND 	b.metas_colab = 1
					";
		}

		if($tipo == "Metas_Real"){
			$sql="SELECT count(b.metas_id) as result
				FROM tarmetas a 
					JOIN metas b 		ON a.tarmetas_metasId = b.metas_id
					JOIN usuarios c 	ON b.metas_colab = c.usu_cod
					LEFT JOIN impostos_enviados d ON a.tarmetas_obri = d.env_codImp 
						AND a.tarmetas_comp = d.env_compet
						AND a.tarmetas_emp = d.env_codEmp
					WHERE 1
						AND	b.metas_datafin BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND LAST_DAY(NOW())
						AND 	c.usu_dep = 8
						AND 	b.metas_colab = 1
						AND 	d.env_movdata 	BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND LAST_DAY(NOW())";
		}

		$this->FreeSql($sql);
		$this->GeraDados();
		
		
		return $this->fld("result");
			
		
	}

	function contagens($tabela){
		$this->FreeSql("SELECT count(*) FROM ".$this->contagem[$tabela]["tabela"]." WHERE ". $this->contagem[$tabela]["condic"]);
		$this->GeraDados();
		$this->contagem[$tabela]["valor"]=$this->fld("count(*)");
			
		return $this->contagem[$tabela]["valor"];
	}
	
	function carteira($usuario, $depart){
		$this->FreeSql("SELECT count(carteira) FROM tri_clientes WHERE carteira LIKE '%\"".$depart."\":{\"user\":\"".$usuario."\"%'");
		$this->GeraDados();
		return $this->fld("count(carteira)");
		
		//return $this->contagem[$tabela]["valor"];
	}
	
	function acessos($usuario){
		
		$this->FreeSql("SELECT count(*) FROM logado WHERE log_user ='".$usuario."'");
		$this->GeraDados();
		return $this->fld("count(*)");
		
		//return $this->contagem[$tabela]["valor"];
	}
	
	function tribut($tri, $usuario, $depart){
		$this->FreeSql("SELECT count(*) FROM tri_clientes WHERE tribut ='".$tri."' AND carteira LIKE '%\"".$depart."\":{\"user\":\"".$usuario."\"%'");
		$this->GeraDados();
		return $this->fld("count(*)");
		
		//return $this->contagem[$tabela]["valor"];
	}
	
	function msg($user){
		$this->FreeSql("SELECT count(*) FROM chat WHERE chat_para =".$user." AND chat_lido=0");
		$this->GeraDados();
		return $this->fld("count(*)");
		
		//return $this->contagem[$tabela]["valor"];
	}
	
	function docs($user, $status, $dep){
		$cnd = ($user==""?"1":"doc_recpor =".$user);
		$this->FreeSql("SELECT count(*) FROM docs_entrada WHERE ".$cnd." AND doc_status= ".$status." AND doc_dep=".$dep);
		$this->GeraDados();
		return $this->fld("count(*)");
		
		//return $this->contagem[$tabela]["valor"];
	}
	// This funtions gets all the tax the company has regardless either it has been sent or not
	function getImpostoCad($depart="", $user="", $empresa="", $tipo=""){
		$sql = "SELECT count(*) FROM obrigacoes a 
				LEFT JOIN tipos_impostos b ON a.ob_titulo=b.imp_id
				LEFT JOIN tri_clientes c ON a.ob_cod=c.cod
				WHERE ob_ativo=1";
	
		if($depart<>""){
			$sql.="	AND imp_depto=".$depart;
		}

		if($user<>""){
			$sql.= " AND carteira LIKE '%\":{\"user\":\"".$user."\"%'";
		}

		if($empresa<>""){
			$sql.=" AND cod = ".$empresa;
		}

		if($tipo<>""){
			$sql.=" AND imp_tipo= '".$tipo."'";
		}

		$this->FreeSql($sql);
		//echo $sql.";<br>";
		$this->GeraDados();
		return $this->fld("count(*)");
	}

	function getImposto($compet, $tipo, $depart="", $user="", $empresa="",  $tipo_im=""){
		$sql = "SELECT count(*) FROM impostos_enviados a
					JOIN tri_clientes b 	ON a.env_codEmp = b.cod
					JOIN tipos_impostos c 	ON a.env_codImp = c.imp_id
					LEFT JOIN obrigacoes d ON a.env_codImp = d.ob_titulo AND b.cod = d.ob_cod
					
				WHERE env_compet = '".$compet."'
				AND env_mov IN(1,0)
				AND d.ob_ativo = 1
				";
		
		if($tipo<>""){
			$sql.="	AND ".$tipo."=1";
		}

		if($depart<>""){
			$sql.="	AND imp_depto=".$depart;
		}

		if($user<>""){
			$sql.= " AND carteira LIKE '%\":{\"user\":\"".$user."\"%'";
			
		}

		if($empresa<>""){
			$sql.=" AND cod = ".$empresa;
		}

		if($tipo_im<>""){
			$sql.=" AND imp_tipo= '".$tipo_im."'";
		}

		$this->FreeSql($sql);
		//echo $sql.";<br>";
		$this->GeraDados();
		return $this->fld("count(*)");
	}

	function getColor($valor){
		$msg = "";
		if($valor>=0 AND $valor<=40){
			$msg = "danger";
		}
			
		if($valor>41 AND $valor<=75){
			$msg = "warning";
		}
			
		if($valor>=76 AND $valor<=95){
			$msg = "primary";
		}
			
		if($valor>=96 AND $valor<=100){
			$msg = "success";
		}
		
		
		return $msg;
	}
}
?>