<?php
	//require_once("../model/recordset.php");
	class historico extends recordset{
		var $tpop = array(
			1 => array("tipo"=>"Consulta", 	"icone"=>"fa fa-search", 			"cor"=>"bg-blue", 	"desc"=>"Realizou consulta pelo CNPJ ou NOME FANTASIA."),
			2 => array("tipo"=>"Cadastro", 	"icone"=>"fa fa-plus-circle", 		"cor"=>"bg-navy", 	"desc"=>"Cadastrou uma nova empresa."),
			3 => array("tipo"=>"Usuario", 	"icone"=>"fa fa-user-plus", 		"cor"=>"bg-purple", "desc"=>"Cadastrou um novo usu&aacute;rio no sistema."),
			4 => array("tipo"=>"Login", 	"icone"=>"fa fa-user", 				"cor"=>"bg-yellow", "desc"=>"Fez Login no Portal."),
			5 => array("tipo"=>"Dados", 	"icone"=>"fa fa-database",			"cor"=>"bg-maroon", "desc"=>"Adicionou dados de contato a uma Empresa."),
			6 => array("tipo"=>"Upload", 	"icone"=>"fa fa-upload", 			"cor"=>"bg-green", 	"desc"=>"Enviou um documento."),
			7 => array("tipo"=>"Download", 	"icone"=>"fa fa-download", 			"cor"=>"bg-green", 	"desc"=>"Fez download de um documento."),
			8 => array("tipo"=>"Usuario", 	"icone"=>"fa fa-user-plus", 		"cor"=>"bg-purple", "desc"=>"Consulta de usu&aacute;rio no sistema."),
			9 => array("tipo"=>"Evento", 	"icone"=>"fa fa-calendar-plus-o", 	"cor"=>"bg-gray", 	"desc"=>"Inclus&atilde;o de evento no sistema."),
			10 => array("tipo"=>"Evento", 	"icone"=>"fa fa-calendar", 			"cor"=>"bg-gray", 	"desc"=>"Pesquisa de evento no sistema."),
			11 => array("tipo"=>"Solicita", "icone"=>"fa fa-tty", 				"cor"=>"bg-blue", 	"desc"=>"Nova solicita&ccedil;&atilde;o."),
			12 => array("tipo"=>"Solicita", "icone"=>"fa fa-check",				"cor"=>"bg-green", 	"desc"=>"Realizou uma solicitação de ligação."),
			13 => array("tipo"=>"Cadastro", "icone"=>"fa fa-user",				"cor"=>"bg-red", 	"desc"=>"Alterou dados de cliente."),
			14 => array("tipo"=>"IRPF", 	"icone"=>"fa fa-tag",				"cor"=>"bg-yellow", "desc"=>"Cadastrou novo IRPF")
		);
		var $link;
		
		function historico(){
			$this->link = conecta();
			return $this->link;
		}
		
		function add_hist($acao){
			$dados = array(
				"tem_data" 		=> date("Y-m-d"),
				"tem_hora" 		=> date("Y-m-d H:i:s"),
				"tem_usu_id" 	=> $_SESSION['usu_cod'],
				"tem_Titulo" 	=> $this->tpop[$acao]["tipo"],
				"tem_icone"		=> $this->tpop[$acao]["icone"],
				"tem_cor"		=> $this->tpop[$acao]["cor"],
				"tem_desc"		=> $this->tpop[$acao]["desc"]
			);
			$this->Insere($dados, "ltempo");
		}
	}
?>