<?php 
require_once("../class/class.permissoes.php");
$nova = 0;
$fna = new functions();
$rsa = new recordset();
$perm = new permissoes();


//Visualizar icone CPC
$cpc_per = $perm->getPermissao("cpcs",$_SESSION['usu_cod']); 
if($cpc_per['C']==1){
	require_once("vis_icon_cpc.php");
}

//ver icone certidoes
$cert_per = $perm->getPermissao("form_certid.php",$_SESSION['usu_cod']); 
if($cert_per['C']==1){
	require_once("vis_icon_certid.php");
}

//Visualizar icone Materiais
$mat = $perm->getPermissao("sol_mat.php",$_SESSION['usu_cod']);
if($mat['C']==1){
	require_once("vis_icon_materiais.php");
}

//Visualizar icone Homologação
$ver_hom = $perm->getPermissao("homologa",$_SESSION['usu_cod']);
if($ver_hom['C']==1){
	require_once("vis_icon_homologacao.php");
}

//Visualizar icone Recalculo
$ver_rec = $perm->getPermissao("recalc.php",$_SESSION['usu_cod']);
if($ver_rec['C']==1){
	require_once("vis_icon_recalculo.php");
}

//Visualizar icone Compra Material
$ver_rec = $perm->getPermissao("materiais.php",$_SESSION['usu_cod']);
if($ver_rec['C']==1){
	require_once("vis_icon_compras.php");
}

//Visualizar icone Imposto a Enviar
$ver_env = $perm->getPermissao("pend_env",$_SESSION['usu_cod']);
if($ver_env['C']==1){
	require_once("vis_icon_envia_imposto.php");
}

//Visualizar icone Saida Motorista
$ver_sai = $perm->getPermissao("servicos.php",$_SESSION['usu_cod']);
if($ver_sai['C']==1){
	require_once("vis_icon_motorista.php");
}
//Visualizar icone arquivos
$ver_doc = $perm->getPermissao("arquivos.php",$_SESSION['usu_cod']);
if($ver_doc['C']==1){
	require_once("vis_icon_arquivos.php");
}

//Visualizar icone mensagens
$ver_msg = $perm->getPermissao("mensagens",$_SESSION['usu_cod']);
if($ver_msg['C']==1){
	require_once("vis_icon_mensagens.php");
}

//Visualizar icone documentos recepção
$ver_adocs = $perm->getPermissao("entrega_docs.php",$_SESSION['usu_cod']);
if($ver_adocs['C']==1){
	require_once("vis_icon_documentos.php");
}

//Visualizar icone calendario
$ver_cal = $perm->getPermissao("calendar.php",$_SESSION['usu_cod']);
if($ver_cal['C']==1){
	require_once("vis_icon_calendario.php");
}


//Visualizar icone ligações
$ver_lig = $perm->getPermissao("solic_enter.php",$_SESSION['usu_cod']);
if($ver_lig['C']==1){
	require_once("vis_icon_ligacoes.php");
}

$ver_cham = $perm->getPermissao("chamados_TI",$_SESSION['usu_cod']);
if($ver_cham['C']==1){
	require_once("vis_icon_chamados.php");
}

$ver_chamleg = $perm->getPermissao("chamados_legal.php",$_SESSION['usu_cod']);
if($ver_chamleg['C']==1){
	require_once("vis_icon_chamadosleg.php");
}

?>

<!-- User Account: style can be found in dropdown.less -->
	<li class="dropdown user user-menu">
		<?php  if(!isset($_SESSION['nome_usu'])):?>
		<a href="<?=$hosted."/triangulo/view/login.php";?>">
			<?php  else :?>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<img src="<?=$hosted.$_SESSION['usu_foto'];?>" class="user-image" alt="User Image">
			<?php  endif;?>
			<span class="hidden-xs"><?=(isset($_SESSION['nome_usu'])? $_SESSION['nome_usu'] :'Login');?></span>
		</a>
		<?php  if(isset($_SESSION["nome_usu"])):?>
		<ul class="dropdown-menu">
			<!-- User image -->
			<li class="user-header">
				<img src="<?=$hosted.$_SESSION["usu_foto"];?>" class="img-circle" alt="User Image">
				<p>
				<?=$_SESSION['nome_usu'];?>
					<small><?=$_SESSION['usuario'];?></small>
				</p>
			</li>
			<li class="user-footer">
				<div class="pull-left">
					<a href="<?=$hosted;?>/sistema/view/user_perfil.php?token=<?=$_SESSION['token'];?>&usuario=<?=$_SESSION['usu_cod'];?>" class="btn btn-default btn-flat">Perfil</a>
				</div>
				<div class="pull-right">
					<a href="<?=$hosted;?>/sistema/view/logout.php" class="btn btn-default btn-flat">Sair</a>
				</div>
			</li>
		</ul>
			
		<?php  endif;?>
	</li>
<!-- END OF User Account: style can be found in dropdown.less -->
