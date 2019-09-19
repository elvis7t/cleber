<?
session_start();
require_once("../../model/recordset.php");
require_once("../config/gera_token.php");

extract($_POST);
$arr = array();

$rs = new recordset();
$whr = "usu_email = '".ltrim($usuario)."'";
$rs->Seleciona("*","usuarios",$whr);
if($rs->linhas == 1){//se encontrou o e-mail
	$rs->GeraDados();
	if(trim(md5($senha)) == trim($rs->fld("usu_senha"))){
		//se senha encryptada for igual a senha do banco
		$_SESSION['usuario']	= $usuario;
		$_SESSION['nome_usu']	= $rs->fld("usu_nome");
		$_SESSION['usuario_on']	= 1;
		$_SESSION['usu_foto']	= $rs->fld("usu_foto");
		$_SESSION['usu_empresa']= $rs->fld("usu_emp_cnpj");
		$_SESSION['classe']		= $rs->fld("usu_classe");
		$_SESSION['token']		= md5($codigo);
		// Criadas as sessions, vamos incluir numa tabela de Logins Efetuados, para aumentar a segurança
		/*
		$altera = array("usu_online"=>1);
		$whr = "usu_nome='".$usuario."'";
		$rs->Altera($altera,"usuarios",$whr);
		*/
		$dados = array(
			"log_user" 		=> $usuario,
			"log_classe"	=> $_SESSION['classe'],
			"log_token"		=> $_SESSION['token'],
			"log_horario"	=> date("Y-m-d h:m:s", strtotime("now")),
			"log_expira"	=> date("Y-m-d h:m:s", strtotime("+1 hour")) 
		);
		$rs->Insere($dados, "logado");
		$arr['status']			= "OK";
		$arr['mensagem']		= "Login Efetuado...";
		$arr['sql']				= $rs->sql;
	}
	else{
		$arr["status"] 		= "NO";
		$arr["mensagem"]	= "Senha incorreta!";
	}
}	
else{//se não encontrou o email
	$arr["status"] 		= "NO";
	$arr["mensagem"]	= "E-mail n&atilde;o encontrado!";
}
echo json_encode($arr);
?>