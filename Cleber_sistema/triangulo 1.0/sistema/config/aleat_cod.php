<?php

// Gerador de código

function aleat(){
	$prefixo = "TCW";
	$tamanho = 10;
	$qtd = 1;
	$c = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	for($i = 0; $i<$qtd; $i++){
		$cod = $prefixo;
			for( $j = 0; $j< ( $tamanho - strlen($prefixo) ); $j++){
				$cod .= $c{mt_rand(0,35)};
			}
	}
	return $cod;
}

?>