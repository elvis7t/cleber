<?
session_start();
require_once("../model/recordset.php");
class dashboard extends recordset {
	var $link;
	var $contagem = array(
		"empresas" 		=> array("tabela"=>"empresas",		"valor"),
		"documentos"	=> array("tabela"=>"documentos",	"valor"),
		"usuarios"		=> array("tabela"=>"usuarios",		"valor"),
		"login"			=> array("tabela"=>"logado",		"valor")
	);
	
	function dashboard(){
		$this->link = conecta();
		return $this->link;
	}
	function contagens($tabela){
		$this->FreeSql("SELECT count(*) FROM ".$this->contagem[$tabela]["tabela"]);
		$this->GeraDados();
		$this->contagem[$tabela]["valor"]=$this->fld("count(*)");
			
		return $this->contagem[$tabela]["valor"];
	}
	
}
?>