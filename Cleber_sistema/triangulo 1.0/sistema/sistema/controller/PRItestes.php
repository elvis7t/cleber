<?php
	//header('Content-type: text/xml; charset="ISO-8859-1"'); 
	require_once("../class/class.xmlpriore.php");
	require_once("../nfe/libs/NFe/MakeNFePHP.class.php");
	$prixml = new xmlpriore();
	//Criar Chave
		
	$uf		= 35; // Código da UF - 2 dígitos
	$aamm	= 1510; // Ano e Mes da emissão - 4 dígitos
	$cnpj	= 23072748000103; // CNPJ com 14 dígitos - só números
	$modelo	= 55; // Modelo - 2 digitos
	$serie	= str_pad("1",3,"0",STR_PAD_LEFT); // Série - 3 dígitos
	$nNf	= str_pad("2",9,"0",STR_PAD_LEFT); // Número da NF - 9 digitos
	$codNf	= str_pad("1",9,"0",STR_PAD_LEFT); // Código - 9 dígitos
	$prixml->calculaChaveAcesso($uf, $aamm, $cnpj, $modelo, $serie, $nNf, $codNf);
	$ch = $prixml->nfkey;
	$dados_nfe = array();
	
	$nfe = new MakeNFe();
	$dados_nfe['version'] 	= "3.10";		//Versão da NFe
	$resp = $nfe->taginfNFe($ch, $dados_nfe['version']);
	
	

	/* dados da tag <ide> */
	
	$cUF		= $uf;			//Código da UF
	$cNf 		= $codNf;		//Código da NF
	$natOp 		= 'VENDA';		//Natureza da Operação
	$indPag 	= '0';			//0=Pag à vista |1=À Prazo |2=Outros
	$mod 		= $modelo;		//Modelo: 55=NFe | 65=NFCe (Verificar XML)
	//$serie	= $serie;
	$nNF		= $nNf;			//Número da NF - Pode ser sequencial
	$dhEmi		= '2015-10-30'	//Data no Formato AAAA-MM-DD
	$dhSaiEnt	= '';
	$tpNF		= '0'			//0=Entrada |1=Saída
	$idDest		= '1'			//1=Op Interna |2=Op Interestadual |3=Op com Exterior
	$cMunFG		= '3518800'		//Completo na na tabela tab_municipios
	$tpImp		= '1'			//0=Sem Danfe | 1=Danfe Retrato | 2=Danfe Paisagem
	$tpEmiss	= '1'			//1=Normal
	$cDV		= $prixml->dv;
	$tbAmb		= '2';
	$finNFe		= '1';
	$indFinal	= '0';
	$indPres	= '9';
	$procEmi	= '0';
	$verProc	= '1.0';
	//$AAMM		= $aamm;
	//$CNPJ		= $cnpj;
	$resp = $nfe->tagide($cUf, $cNF, $natOp, $indPag, $mod, $serie, $nNF, $dhEmi, $dhSaiEnt, $tpNF, $idDest, $cMunFG, $tpImp, $tpEmiss, $cDV, $tpAmb, $finNFe, $indFinal, $indPres, $procEmi, $verProc, '', '');
	
	$resp = $nfe->montaNFe();
	$arquivo_xml = '';
	if($resp){
		$arquivo_xml = $nfe->getXML();
		echo "<!--XML OK! - Erros ".$nfe->erros."-->";
		echo $arquivo_xml;
	}
	
?>