<?
/*---------------------------------------------------*\
|	SMC CONFIG
|	Guarda as configurações das tarifas e planos
|	Fornecido via e-mail por VIZIR
|	Regras:
|	Atribuir correção 10% caso o tempo da ligação seja maior que o oferecido
|	pelo plano e mostrar o valor com e sem o plano na página
\*---------------------------------------------------*/

$tarifas = array(
	"SP1"	=> array("origem" => "011 - São Paulo", "destino" => "016 - Interior", "valor" => "1.90"),
	"SP2"	=> array("origem" => "011 - São Paulo", "destino" => "017 - Interior", "valor" => "1.70"),
	"SP3"	=> array("origem" => "011 - São Paulo", "destino" => "018 - Interior", "valor" => "0.90"),
	"SP4"	=> array("origem" => "011 - São Paulo", "destino" => "077 - Bahia", "valor" => "2.90"),
	"INT1"	=> array("origem" => "016 - Interior", "destino" => "011 - São Paulo", "valor" => "2.90"),
	"INT2"	=> array("origem" => "017 - Interior", "destino" => "011 - São Paulo", "valor" => "2.70"),
	"INT3"	=> array("origem" => "018 - Interior", "destino" => "011 - São Paulo", "valor" => "1.90"),
	"BAH1"	=> array("origem" => "077 - Bahia", "destino" => "011 - São Paulo", "valor" => "2.60")

);
$planos = array(
	"FaleMais30"	=> 30,
	"FaleMais60"	=> 60,
	"FaleMais120"	=> 120
);

?>