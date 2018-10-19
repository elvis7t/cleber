<?php
require_once('../../model/recordset.php');

require_once('../class/class.functions.php');
/*
$cod = "308,544,477";
$dep = 4;
$user = 47;
$dados2 = array();
$dados2[$dep]["user"]=$user;
$dados2[$dep]["data"]=date("Y-m-d");;

$ods = explode(",", $cod);

foreach($ods as $cods){
$rs2= new recordset();
	$rs = new recordset();
	$rs->Seleciona("carteira","tri_clientes","cod=".$cods);
	$rs->GeraDados();
	$re = $rs->fld("carteira");
	unset($rs);
	$cart 	= json_decode($re,true);
	$ncart 	= $dados2 + $cart;
	$json 	= json_encode($ncart);
	$dados['carteira'] = addslashes($json);
	
	$whr = "cod =".$cods;
	$rs2->Altera($dados, "tri_clientes", $whr);
	echo $rs2->sql."<br>";	
}


/*
$cart = array();
$ncart = array();
$cart[1] = array("user"=>"","data"=>"");
$cart[2] = array("user"=>"","data"=>"");
$cart[4] = array("user"=>"","data"=>"");

print_r($cart);
$json = json_encode($cart);
echo $json."<br><br>"; 
$ncart = json_decode($json, true);
$ncart[2] = array("user"=>56,"data"=>"01/10/2016");
ksort($ncart);
print_r($ncart);
echo json_encode($ncart);
*/

/*
$dep = 1;
$cod = 308;
$user = 64;
$dados2 = array();
$dados2[$dep]["user"] = $user;
$dados2[$dep]["data"] = date("d/m/Y");

$arr = $rs->pegar("carteira","tri_clientes","cod=".$cod);

$cart 	= json_decode($arr,true);

$ncart 	= $dados2+$cart;
print_r($cart);
echo "<br>";
print_r($dados2);
echo "<br>";
print_r($ncart);
echo "<br>";
$json 	= json_encode($ncart);

echo $json;

$fn = new functions();



$cod = 487;
$id = 57;
$dados = array();
$dados['sen_user'] = "cleber";

$whr = "sen_id=".$id." and sen_cod=".$cod;
$fn->Audit("senhas",$whr,$dados, $cod,1);

$fn = new functions();

echo $fn->dia_util(20, "dia_banco");

$path = is_dir("file://I:/");
var_dump($path);
*/
$paths[] = "//SRV-STG/Central de informacoes/SQL_SYS.sql";
$paths[] = "file://SRV-STG/Central de informacoes/SQL_SYS.sql";
$paths[] = "file:///I:/Central de Informacoes/SQL_SYS.sql";
$paths[] = "file:///C:\SQL_SYS.sql";
clearstatcache();
foreach ($paths as $path):
 if (file_exists($path)):
  echo "True<br/>"; 
 else: 
  echo  "false<br/>";
 endif;
endforeach;
?>
