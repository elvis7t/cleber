<?php

class xmlpriore{
	var $link;
	var $nfkey;
	var $dv;
	
	function xmlpriore(){
		/*$this->link = conecta();
		return $this->link;*/
	}
	
	function calcDV($chave43){
		$multiplicadores = array(2,3,4,5,6,7,8,9);
		$i = 42;
		while ($i >= 0) {
			 for ($m=0; $m<count($multiplicadores) && $i>=0; $m++) {
				$soma_ponderada+= $chave43[$i] * $multiplicadores[$m];
				$i--;
			 }
		}
		$resto = $soma_ponderada % 11;
		if($resto == 0 || $resto == 1) {$cDV = 0;} 
		else{$cDV = 11 - $resto;}
		$this->dv = $cDV;
		return $cDV;
	}
	
	function calculaChaveAcesso($cUF, $dEmi, $CNPJ, $mod, $serie, $nNF, $cNF){
		$chave = $cUF;
		$chave.= $dEmi;
		$chave.= $CNPJ;
		$chave.= $mod;
		$chave.= $serie;
		$chave.= $nNF;
		$chave.= $cNF;
		$chave.= $this->calcDV($chave);
		$this->nfkey = $chave;
	}
	
	/*
	function lerxml($arq){
		header('Content-Type: text/html; charset=utf-8');
		$xml = simplexml_load_file($arq);
		foreach($xml->livro as $item){
			echo $item->titulo."<br>";
			echo $item->descricao."<br>";
			echo $item->autor."<br>";
			echo $item->pagina."<br>";
			echo $item->preco."<br>";
		}
	}
	*/
}
?>