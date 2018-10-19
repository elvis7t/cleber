<?php
require_once("../model/recordset.php");
class dashboard extends recordset {
	var $link;
	var $niveis = array(
			1=> array(
				1=> array("cor"=>"bg-blue", "ico"=>"fa fa-suitcase", "valor"=>"", "tam"=>4,	"tit"=>"Empresas",	"sub"=>"Empresas Ativas", 		"tabela"=>"tri_clientes"),
				2=> array("cor"=>"bg-yellow", "ico"=>"fa fa-handshake-o", "valor"=>"", "tam"=>4,	"tit"=>"Usuarios",	"sub"=>"Domínio Atendimento", 		"tabela"=>"tri_clientes", "link"=>"../rel/rel_da.php?da=1"),
				3=> array("cor"=>"bg-purple", "ico"=>"fa fa-user", "valor"=>"", "tam"=>4,	"tit"=>"Acessos",	"sub"=>"Acesso Mensal", 		"tabela"=>"logado"),
				4=> array("cor"=>"bg-teal", "ico"=>"fa fa-tasks", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados Abertos", 		"tabela"=>"chamados", "link"=>"atendimento.php"),
				5=> array("cor"=>"bg-red", "ico"=>"fa fa-hourglass", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados Aguardando", 	"tabela"=>"chamados", "link"=>"atendimento.php"),
				6=> array("cor"=>"bg-green", "ico"=>"fa fa-cogs", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"em Atendimento", 		"tabela"=>"chamados", "link"=>"atendimento.php"),
				7=> array("cor"=>"bg-blue", "ico"=>"fa fa-check", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados Finalizados", 	"tabela"=>"chamados", "link"=>"atendimento.php")
			),
			2=> array(
					1=> array("cor"=>"bg-blue", "ico"=>"fa fa-suitcase", "valor"=>"", "tam"=>4,	"tit"=>"Empresas",	"sub"=>"Empresas Ativas", 		"tabela"=>"tri_clientes"),
					2=> array("cor"=>"bg-yellow", "ico"=>"fa fa-handshake-o", "valor"=>"", "tam"=>4,	"tit"=>"Usuarios",	"sub"=>"Domínio Atendimento", 		"tabela"=>"tri_clientes","link"=>"../rel/rel_da.php?da=1"),
					3=> array("cor"=>"bg-purple", "ico"=>"fa fa-user", "valor"=>"", "tam"=>4,	"tit"=>"Acessos",	"sub"=>"Acesso Mensal", 		"tabela"=>"logado"),
					4=> array("cor"=>"bg-teal", "ico"=>"fa fa-tasks", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados Abertos", 		"tabela"=>"chamados"),
					5=> array("cor"=>"bg-red", "ico"=>"fa fa-hourglass", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados Aguardando", 	"tabela"=>"chamados"),
					6=> array("cor"=>"bg-green", "ico"=>"fa fa-cogs", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"em Atendimento", 		"tabela"=>"chamados"),
					7=> array("cor"=>"bg-blue", "ico"=>"fa fa-check", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados Finalizados", 	"tabela"=>"chamados")
			),
			
			3=>	array(
					1=> array("cor"=>"bg-green", "ico"=>"fa fa-suitcase", "valor"=>"", "tam"=>4,	"tit"=>"Empresas",		"sub"=>"Carteira de Clientes", 	"tabela"=>"tri_clientes"),
					2=> array("cor"=>"bg-yellow", "ico"=>"fa fa-handshake-o", "valor"=>"", "tam"=>4,	"tit"=>"Usuarios",	"sub"=>"Domínio Atendimento", 		"tabela"=>"tri_clientes", "link"=>"../rel/rel_da.php?da=1"),
					3=> array("cor"=>"bg-red", "ico"=>"fa fa-battery-half", "valor"=>"", "tam"=>4,	"tit"=>"Serviços",	"sub"=>"Serviços em Aberto", 		"tabela"=>"servicos", "link"=>"serv_lista_saidas.php"),

					4=> array("cor"=>"bg-purple", "ico"=>"fa fa-refresh", "valor"=>"", "tam"=>3,	"tit"=>"Clientes SN",	"sub"=>"Simples Nac.", 			"tabela"=>"tri_clientes"),
					5=> array("cor"=>"bg-red", "ico"=>"fa fa-money", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LR",	"sub"=>"Lucro Real", 			"tabela"=>"tri_clientes"),
					6=> array("cor"=>"bg-blue", "ico"=>"fa fa-tags", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LP",	"sub"=>"Lucro Pres.", 			"tabela"=>"tri_clientes"),
					7=> array("cor"=>"bg-teal", "ico"=>"fa fa-cogs", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados em aberto.", 			"tabela"=>"chamados")
			),
			4=>	array(
					1=> array("cor"=>"bg-green", "ico"=>"fa fa-suitcase", "valor"=>"", "tam"=>8,	"tit"=>"Empresas",		"sub"=>"Carteira de Clientes", 	"tabela"=>"tri_clientes"),
					2=> array("cor"=>"bg-yellow", "ico"=>"fa fa-handshake-o", "valor"=>"", "tam"=>4,	"tit"=>"Usuarios",	"sub"=>"Domínio Atendimento", 		"tabela"=>"tri_clientes", "link"=>"../rel/rel_da.php?da=1"),
					3=> array("cor"=>"bg-purple", "ico"=>"fa fa-refresh", "valor"=>"", "tam"=>3,	"tit"=>"Clientes SN",	"sub"=>"Simples Nac.", 			"tabela"=>"tri_clientes"),
					4=> array("cor"=>"bg-red", "ico"=>"fa fa-money", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LR",	"sub"=>"Lucro Real", 			"tabela"=>"tri_clientes"),
					5=> array("cor"=>"bg-blue", "ico"=>"fa fa-tags", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LP",	"sub"=>"Lucro Pres.", 			"tabela"=>"tri_clientes"),
					6=> array("cor"=>"bg-teal", "ico"=>"fa fa-cogs", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados em aberto.", 			"tabela"=>"chamados")
			),
			5=>	array(
					1=> array("cor"=>"bg-green", "ico"=>"fa fa-suitcase", "valor"=>"", "tam"=>8,	"tit"=>"Empresas",		"sub"=>"Carteira de Clientes", 	"tabela"=>"tri_clientes",),
					2=> array("cor"=>"bg-yellow", "ico"=>"fa fa-handshake-o", "valor"=>"", "tam"=>4,	"tit"=>"Usuarios",	"sub"=>"Domínio Atendimento", 		"tabela"=>"tri_clientes", "link"=>"../rel/rel_da.php?da=1"),
					3=> array("cor"=>"bg-purple", "ico"=>"fa fa-refresh", "valor"=>"", "tam"=>3,	"tit"=>"Clientes SN",	"sub"=>"Simples Nac.", 			"tabela"=>"tri_clientes"),
					4=> array("cor"=>"bg-red", "ico"=>"fa fa-money", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LR",	"sub"=>"Lucro Real", 			"tabela"=>"tri_clientes"),
					5=> array("cor"=>"bg-blue", "ico"=>"fa fa-tags", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LP",	"sub"=>"Lucro Pres.", 			"tabela"=>"tri_clientes"),
					6=> array("cor"=>"bg-teal", "ico"=>"fa fa-cogs", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados em aberto.", 			"tabela"=>"chamados")
			),
			6=>	array(
					1=> array("cor"=>"bg-green", "ico"=>"fa fa-suitcase", "valor"=>"", "tam"=>8,	"tit"=>"Empresas",		"sub"=>"Carteira de Clientes", 	"tabela"=>"tri_clientes"),
					2=> array("cor"=>"bg-yellow", "ico"=>"fa fa-handshake-o", "valor"=>"", "tam"=>4,	"tit"=>"Usuarios",	"sub"=>"Domínio Atendimento", 		"tabela"=>"tri_clientes", "link"=>"../rel/rel_da.php?da=1"),
					3=> array("cor"=>"bg-purple", "ico"=>"fa fa-refresh", "valor"=>"", "tam"=>3,	"tit"=>"Clientes SN",	"sub"=>"Simples Nac.", 			"tabela"=>"tri_clientes"),
					4=> array("cor"=>"bg-red", "ico"=>"fa fa-money", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LR",	"sub"=>"Lucro Real", 			"tabela"=>"tri_clientes"),
					5=> array("cor"=>"bg-blue", "ico"=>"fa fa-tags", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LP",	"sub"=>"Lucro Pres.", 			"tabela"=>"tri_clientes"),
					6=> array("cor"=>"bg-teal", "ico"=>"fa fa-cogs", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados em aberto.", 			"tabela"=>"chamados")
			),
			7=>	array(
					1=> array("cor"=>"bg-green", "ico"=>"fa fa-suitcase", "valor"=>"", "tam"=>8,	"tit"=>"Empresas",		"sub"=>"Carteira de Clientes", 	"tabela"=>"tri_clientes"),
					2=> array("cor"=>"bg-yellow", "ico"=>"fa fa-handshake-o", "valor"=>"", "tam"=>4,	"tit"=>"Usuarios",	"sub"=>"Domínio Atendimento", 		"tabela"=>"tri_clientes", "link"=>"../rel/rel_da.php?da=1"),
					3=> array("cor"=>"bg-purple", "ico"=>"fa fa-refresh", "valor"=>"", "tam"=>3,	"tit"=>"Clientes SN",	"sub"=>"Simples Nac.", 			"tabela"=>"tri_clientes"),
					4=> array("cor"=>"bg-red", "ico"=>"fa fa-money", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LR",	"sub"=>"Lucro Real", 			"tabela"=>"tri_clientes"),
					5=> array("cor"=>"bg-blue", "ico"=>"fa fa-tags", "valor"=>"", "tam"=>3,	"tit"=>"Clientes LP",	"sub"=>"Lucro Pres.", 			"tabela"=>"tri_clientes"),
					6=> array("cor"=>"bg-teal", "ico"=>"fa fa-cogs", "valor"=>"", "tam"=>3,	"tit"=>"Chamados",	"sub"=>"Chamados em aberto.", 			"tabela"=>"chamados")
			),
			8=>	array(
					1=> array("cor"=>"bg-blue", "ico"=>"fa fa-phone", "valor"=>"", "tam"=>4,	"tit"=>"Solicitações",		"sub"=>"Em aberto", 	"tabela"=>"tri_solic"),
					2=> array("cor"=>"bg-yellow", "ico"=>"fa fa-handshake-o", "valor"=>"", "tam"=>4,	"tit"=>"Usuarios",	"sub"=>"Domínio Atendimento", 		"tabela"=>"tri_clientes", "link"=>"../rel/rel_da.php?da=1"),
					3=> array("cor"=>"bg-purple", "ico"=>"fa fa-lock", "valor"=>"", "tam"=>4,	"tit"=>"Acessso",	"sub"=>"Meus Acessos", 			"tabela"=>"logado"),
					4=> array("cor"=>"bg-teal", "ico"=>"fa fa-gavel", "valor"=>"", "tam"=>2,	"tit"=>"DEP. LEGAL",	"sub"=>"Documentos", 		"tabela"=>"docs_entrada"),
					5=> array("cor"=>"bg-red", "ico"=>"fa fa-key", "valor"=>"", "tam"=>2,	"tit"=>"ESCRITA FISCAL",	"sub"=>"Documentos",		"tabela"=>"docs_entrada"),
					6=> array("cor"=>"bg-green", "ico"=>"fa fa-balance-scale", "valor"=>"", "tam"=>2,	"tit"=>"CONTÁBIL",	"sub"=>"Documentos",			"tabela"=>"docs_entrada"),
					7=> array("cor"=>"bg-blue", "ico"=>"fa fa-heartbeat", "valor"=>"", "tam"=>2,	"tit"=>"DEPTO PESSOAL",	"sub"=>"Documentos",		"tabela"=>"docs_entrada"),
					8=> array("cor"=>"bg-teal", "ico"=>"fa fa-phone", "valor"=>"", "tam"=>4,	"tit"=>"LIGAÇÕES",	"sub"=>"Ligações",		"tabela"=>"tri_solic")
				)
			

		);
	var $contagem = array(
		"empresas" 		=> array("tabela"=>"tri_clientes",	"valor", "condic"=>"ativo=1 AND emp_vinculo = 2"),
		"impostos"		=> array("tabela"=>"irrf",			"valor", "condic"=>"ir_ano='2016'"),
		"usuarios"		=> array("tabela"=>"usuarios",		"valor", "condic"=>"usu_empcod=2"),
		"login"			=> array("tabela"=>"logado",		"valor", "condic"=>"1"),
		"carteira"		=> array("valor")
	);
	//public $pdm = date("Y")."-".date("m")."-"."01";
	//public $udm = date("Y-m-t");
	
	function __construct(){
		$this->link = conecta();
		return $this->link;
	}
	
	function quadro($nivel, $tipo){
		$di = date("Y-m")."-01 00:00:00";
		$df = date("Y-m-t")." 23:59:59";
		$cp = '{"1":{"user":"","data":""},"2":{"user":"","data":""},"4":{"user":"","data":""}}';
		$nv = array(
			1=> array(
					1=> array("condic"=>"ativo=1"),
					2=> array("condic"=>"uda=1 AND ativo=1"),
					3=> array("condic"=>"log_horario BETWEEN '".$di."' AND '".$df."'"),
					4=> array("condic"=>"cham_abert BETWEEN '{$di}' AND '$df'"),
					5=> array("condic"=>"cham_status=0 AND cham_abert BETWEEN '{$di}' AND '$df'"),
					6=> array("condic"=>"cham_status=91 AND cham_abert BETWEEN '{$di}' AND '$df'"),
					7=> array("condic"=>"cham_status=99 AND cham_abert BETWEEN '{$di}' AND '$df'")
			),
			2=> array(
					1=> array("condic"=>"ativo=1"),
					2=> array("condic"=>"uda=1 AND ativo=1"),
					3=> array("condic"=>"log_horario BETWEEN '".$di."' AND '".$df."'"),
					4=> array("condic"=>"cham_abert BETWEEN '{$di}' AND '$df'"),
					5=> array("condic"=>"cham_status=0 AND cham_abert BETWEEN '{$di}' AND '$df'"),
					6=> array("condic"=>"cham_status=91 AND cham_abert BETWEEN '{$di}' AND '$df'"),
					7=> array("condic"=>"cham_status=99 AND cham_abert BETWEEN '{$di}' AND '$df'")
			),
			
			3=>	array(
					1=> array("condic"=>"ativo=1 and carteira <> '".$cp."'"),
					2=> array("condic"=>"uda=1  AND ativo=1"),
					3=> array("condic"=>"ser_usuario = ".$_SESSION['usu_cod']." AND ser_lista <>0 AND ser_status <> 99"),
					4=> array("condic"=>"ativo=1 and tribut = 'SN'"),
					5=> array("condic"=>"ativo=1 and tribut = 'LR'"),
					6=> array("condic"=>"ativo=1 and tribut = 'LP'"),
					7=> array("condic"=>"cham_dept = ".$_SESSION['dep']." AND cham_status IN(0,91)")
			),
			4=>	array(
					1=> array("condic"=>"ativo=1 and carteira <> '".$cp."'"),
					2=> array("condic"=>"uda=1  AND ativo=1"),
					3=> array("condic"=>"ativo=1 and tribut = 'SN'"),
					4=> array("condic"=>"ativo=1 and tribut = 'LR'"),
					5=> array("condic"=>"ativo=1 and tribut = 'LP'"),
					6=> array("condic"=>"cham_dept = ".$_SESSION['dep']." AND cham_status IN(0,91)")
			),
			5=>	array(
					1=> array("condic"=>"ativo=1 AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					2=> array("condic"=>"uda=1  AND ativo=1 AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					3=> array("condic"=>"ativo=1 and tribut = 'SN' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					4=> array("condic"=>"ativo=1 and tribut = 'LR' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					5=> array("condic"=>"ativo=1 and tribut = 'LP' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					6=> array("condic"=>"cham_dept = ".$_SESSION['dep']." AND cham_status IN(0,91)")
			),
			6=>	array(
					1=> array("condic"=>"ativo=1 AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					2=> array("condic"=>"uda=1  AND ativo=1 AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					3=> array("condic"=>"ativo=1 and tribut = 'SN' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					4=> array("condic"=>"ativo=1 and tribut = 'LR' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					5=> array("condic"=>"ativo=1 and tribut = 'LP' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					6=> array("condic"=>"cham_dept = ".$_SESSION['dep']." AND cham_status IN(0,91)")
			),
			7=>	array(
					1=> array("condic"=>"ativo=1 AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					2=> array("condic"=>"uda=1  AND ativo=1 AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					3=> array("condic"=>"ativo=1 and tribut = 'SN' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					4=> array("condic"=>"ativo=1 and tribut = 'LR' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					5=> array("condic"=>"ativo=1 and tribut = 'LP' AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					6=> array("condic"=>"cham_dept = ".$_SESSION['dep']." AND cham_status IN(0,91)")
			),
			8=>	array(
					1=> array("condic"=>"sol_status=0 AND sol_data BETWEEN '".$di."' AND '".$df."'"),
					2=> array("condic"=>"uda=1 AND ativo=1 AND carteira LIKE '%\"".$_SESSION['dep']."\":{\"user\":\"".$_SESSION['usu_cod']."\"%'"),
					3=> array("condic"=>"log_user='".$_SESSION['usuario']."' AND log_horario BETWEEN '".$di."' AND '".$df."'"),
					4=> array("condic"=>"doc_status=0 AND doc_data BETWEEN '".$di."' AND '".$df."' AND doc_dep=5 AND doc_data BETWEEN '".$di."' AND '".$df."'"),
					5=> array("condic"=>"doc_status=0 AND doc_data BETWEEN '".$di."' AND '".$df."' AND doc_dep=2 AND doc_data BETWEEN '".$di."' AND '".$df."'"),
					6=> array("condic"=>"doc_status=0 AND doc_data BETWEEN '".$di."' AND '".$df."' AND doc_dep=4 AND doc_data BETWEEN '".$di."' AND '".$df."'"),
					7=> array("condic"=>"doc_status=0 AND doc_data BETWEEN '".$di."' AND '".$df."' AND doc_dep=1 AND doc_data BETWEEN '".$di."' AND '".$df."'"),
					8=> array("condic"=>"sol_status = 0  AND sol_empcod = ".$_SESSION['usu_empcod']." AND sol_data BETWEEN '".date("Y-m-d")."' AND '".date("Y-m-d")." 23:59:59'")
			)

		);
		$sql = "SELECT count(*) FROM ".$this->niveis[$nivel][$tipo]["tabela"];
		$sql.= " WHERE ". $nv[$nivel][$tipo]["condic"];
		//echo $sql;
		$this->FreeSql($sql);
		$this->GeraDados();
		$this->niveis[$nivel][$tipo]["valor"]=$this->fld("count(*)");
			
		return $this->niveis[$nivel][$tipo]["valor"];
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