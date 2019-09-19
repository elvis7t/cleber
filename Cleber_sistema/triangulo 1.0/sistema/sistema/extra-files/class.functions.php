<?
class functions{
	
	function functions(){
		
	}
	function data_br($data){
		$arraydata = split("-",$data);
		$novadata = $arraydata[2]."/".$arraydata[1]."/".$arraydata[0];
		return $novadata;
	}
	function data_usa($data){
		$arraydata = split("/",$data);
		$novadata = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0];
		return $novadata;
	}
	function is_set($variavel){//Verifica se está setado e se valor != null
		if( (isset($variavel)) AND ((!empty($variavel)) OR (is_null($variavel))) ) {
			return true;
		}
		else{ return false;}
	}
	function calc_dh($valor){
		/* Parte 1 - Calcular mkTime da data passaa via parametro*/
		$dt = date("Y-m-d" , strtotime($valor));
		$hr = date("H:i:s", strtotime($valor));
		list($y, $m, $d) = explode("-",$dt);
		list($h, $i, $s) = explode(":",$hr);
		$dpc = mktime($h,$i,$s,$m,$d,$y);
		/* Parte 2 - Calcular a data de agora */
		$agr = mktime(date("H"),date("m"),date("s"),date("m"),date("d"),date("Y"));
		/* Parte 3 - Calcular a diferença */
		$difer = $agr - $dpc;
		/* Parte 4 - Verificar o tempo em minutos / horas / dias / data*/
		switch($difer){
			case ($difer<=60) :
				$msg = "H&aacute; menos de 1 minuto";
				break;
			case ($difer>60 AND $difer<=3600):
				$msg = "H&aacute; ". number_format(($difer/60),0) . " minutos";
				break;
			case ($difer>3600 AND $difer<=86400):
				$msg = "H&aacute; ". number_format(($difer/3600),0) . " horas";
				break;
			case ($difer >86400):
				$msg = "H&aacute; ". number_format(($difer/86400),0) ." dias";
				break;
		}
		return $msg;
	}
	function mes_extenso($data){
		$meses = array("Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
		list($dia, $mes,$ano) = explode("/",$data);
		return $dia." de ".$meses[$mes-1]." de ".$ano;
	}
	
	function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false ){
 
        //$valor = self::removerFormatacaoNumero( $valor );
 
        $singular = null;
        $plural = null;
 
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
 
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
 
 
        if ( $bolPalavraFeminina )
        {
 
            if ($valor == 1) 
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else 
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
 
 
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
 
 
        }
 
 
        $z = 0;
 
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
 
        for ( $i = 0; $i < count( $inteiro ); $i++ ) 
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }
 
        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
 
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
 
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
 
        $rt = mb_substr( $rt, 1 );
 
        return($rt ? trim( $rt ) : "zero");
 
    }
	
}
?>
