<?php
date_default_timezone_set('America/Sao_Paulo');
require_once("../model/recordset.php");
class functions extends recordset{
	var $link;
	var $historicos = array(1=>array("icon"=>"fa fa-pencil", 			"color"=>"bg-blue",		"act"=>"Alterou"),
							2=>array("icon"=>"fa fa-plus-square", 		"color"=>"bg-blue",	"act"=>"Incluiu"),
							3=>array("icon"=>"fa fa-minus-square", 		"color"=>"bg-red",	"act"=>"Excluiu"),
							4=>array("icon"=>"fa fa-paper-plane", 		"color"=>"bg-green",	"act"=>"Enviou"),
							5=>array("icon"=>"fa fa-thumbs-o-up", 		"color"=>"bg-yellow",	"act"=>"Conferiu"),
							6=>array("icon"=>"fa fa-flag", 				"color"=>"bg-teal",		"act"=>"Gerou I/O/A"),
							7=>array("icon"=>"fa fa-check",		 		"color"=>"bg-gray",		"act"=>"Movimentou I/O/A"),
							8=>array("icon"=>"fa fa-check-square-o",	"color"=>"bg-purple",	"act"=>"Conferiu Envio I/O/A")
							);

	function __construct(){
		$this->link = conecta();
		return $this->link;
	}

	/*-----------------------|FUNCTIONS::getColor|---------------------*\
	|	Author: 	Cleber Marrara Prado								|
	|	Version: 	1.0													|
	| 	Email: 		cleber.marrara.prado@gmail.com 						|
	|	Descrição: 	Pega cor para barras de progresso					|
	\*-------------------------------|FIM|-----------------------------*/

	function getColor($valor, $obj="pb"){
		$msg = "";
		if($valor>=0 AND $valor<=40){
			$msg = ($obj=="pb"?"danger":"red");
		}
			
		if($valor>41 AND $valor<=75){
			$msg = ($obj=="pb"?"warning":"yellow");
		}
			
		if($valor>=76 AND $valor<=95){
			$msg = ($obj=="pb"?"primary":"blue");
		}
			
		if($valor>=96 AND $valor<=100){
			$msg = ($obj=="pb"?"success":"green");
		}
		
		
		return $msg;
	}
	
	/*-----------------------|FUNCTIONS::DATA_BR|----------------------*\
	|	Author: 	Cleber Marrara Prado								|
	|	Version: 	1.0													|
	| 	Email: 		cleber.marrara.prado@gmail.com 						|
	|	Descrição: 	Formatar data americana no formato brasileiro		|
	\*-------------------------------|FIM|-----------------------------*/

	function data_br($data){
		$arraydata = explode("-",$data);
		$novadata = $arraydata[2]."/".$arraydata[1]."/".$arraydata[0];
		return $novadata;
	}

	/*-----------------------|FUNCTIONS::DATA_USA|---------------------*\
	|	Author: 	Cleber Marrara Prado								|
	|	Version: 	1.0													|
	| 	Email: 		cleber.marrara.prado@gmail.com 						|
	|	Descrição: 	Formatar data Brasilira no formato americano		|
	\*-------------------------------|FIM|-----------------------------*/

	function data_usa($data){
		$arraydata = explode("/",$data);
		$novadata = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0];
		return $novadata;
	}

	/*-----------------------|FUNCTIONS::DATA_BR|----------------------*\
	|	Author: 	Cleber Marrara Prado								|
	|	Version: 	1.0													|
	| 	Email: 		cleber.marrara.prado@gmail.com 						|
	|	Descrição: 	Formatar data americana no formato brasileiro		|
	\*-------------------------------|FIM|-----------------------------*/

	function data_hbr($data){
		$arraydata = explode(" ",$data);
		$dta = explode("-",$arraydata[0]);
		$novadata = $dta[2]."/".$dta[1]."/".$dta[0] ." &agrave;s ".$arraydata[1] ;
		return $novadata;
	}
	
	function data_mbr($data){
		$arraydata = explode(" ",$data);
		$dta = explode("-",$arraydata[0]);
		$novahora = explode(":",$arraydata[1]);
		$novadata = $dta[2]."/".$dta[1] ." &agrave;s ".$novahora[0].":".$novahora[1];
		return $novadata;
	}

	function is_set($variavel){//Verifica se está setado e se valor != null
		if( (isset($variavel)) AND ((!empty($variavel)) OR (is_null($variavel))) ) {
			return true;
		}
		else{ return false;}
	}
	
	function calc_dh($valor, $valor2 = 0){
		/* Parte 1 - Calcular mkTime da data passaa via parametro*/
		date_default_timezone_set('America/Sao_Paulo');

		$dt = date("Y-m-d" , strtotime($valor));
		$hr = date("H:i:s", strtotime($valor));
		list($y, $m, $d) = explode("-",$dt);
		list($h, $i, $s) = explode(":",$hr);
		$dpc = mktime($h,$i,$s,$m,$d,$y);
		/* Parte 2 - Calcular a data de agora */
		if($valor2<>0){
			$dt2 = date("Y-m-d" , strtotime($valor2));
			$hr2 = date("H:i:s", strtotime($valor2));
			list($y2, $m2, $d2) = explode("-",$dt2);
			list($h2, $i2, $s2) = explode(":",$hr2);
			$dpc2 = mktime($h2,$i2,$s2,$m2,$d2,$y2);
			$agr = $dpc2;
		}
		else{	
			$agr = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		}
		/* Parte 3 - Calcular a diferença */
		$difer = $agr - $dpc;
		/* Parte 4 - Verificar o tempo em minutos / horas / dias / data*/
		switch($difer){
			case ($difer<=120) :
				$msg = $difer." segundos";
				break;
			case ($difer>120 AND $difer<=3600):
				$msg = number_format(($difer/60),0) . " minutos";
				break;
			case ($difer>3600 AND $difer<=86400):
				$msg = number_format(($difer/3600),0) . " horas";
				break;
			case ($difer >86400):
				$msg = number_format(($difer/86400),0) ." dias";
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
	function sanitize($dado){
		$dado = preg_replace("/[^0-9]/","",$dado);
		return $dado;
	}
	
	function ultimo_dia_mes($ref){
		list($mes,$ano) = explode("/",$ref);
		$ultimo = date("Y-m-t", mktime(0, 0, 0, $mes, 1, $ano));
		$semana = date("w", strtotime($ultimo));
		list($a, $m, $d) = explode("-",$ultimo);
		if($semana==0){$semana =7;}
		while($semana > 5){
			$d--;
			$semana--;
		}
		// Consulta os feriados
		$dtparcial =  date("Y-m-t", mktime(0, 0, 0, $mes, $d, $ano));
		$sql = "SELECT count(*) FROM feriados WHERE fer_data ='".$dtparcial."'";
		$this->FreeSql($sql);
		$this->GeraDados();
		$d -= $this->fld("count(*)");
			
		return $d."/".$ref;		
	}

	function dia_util($dia, $tipo, $mm=0){
		$mes = ($mm==0?date("m"):$mm);
		$ano = date("Y");
		$ultimo = date("Y-m-d", mktime(0, 0, 0, $mes, $dia, $ano));
		$semana = date("w", strtotime($ultimo));
		list($a, $m, $d) = explode("-",$ultimo);

		if($tipo == "dia_util"){
			if($semana==0){$semana = 7;}
			while($semana==6 OR $semana==7){
				$d--;
				$semana--;
			}

		}
		if($tipo == "postpone"){
			$d=$dia;
			while($semana > 5 OR $semana < 1){
				$d++;
				$ultimo = date("Y-m-d", mktime(0, 0, 0, $mes, $d, $ano));
				$semana = date("w", strtotime($ultimo));
			}
		}
		
		if($tipo=="dia_banco"){
			$d = 1; //Dia = 1
			$dm = 0;
			$pdm = $ano."-".$mes."-01";
			$udm = $ano."-".$mes."-".date("t");
			for($i=1; $i<=$dia; $i++){
				$ultimo = date("Y-m-d", mktime(0, 0, 0, $mes, $i, $ano));
				$semana = date("w", strtotime($ultimo));
				if($semana ==6 || $semana ==0){
					$dm++;
				}
			}
			//echo $pdm."<br>";
			$d = $dia + $dm;
			// Consulta os feriados
			$sql = "SELECT count(*) FROM feriados WHERE fer_data BETWEEN '".$pdm."' AND '".$udm."'";
			$this->FreeSql($sql);
			$this->GeraDados();
			$d += $this->fld("count(*)");
			// Agora, passamos a regra do dia post_pone
			$ultimo = date("Y-m-d", mktime(0, 0, 0, $mes, $d, $ano));
			$semana = date("w", strtotime($ultimo));
			while($semana > 5 OR $semana < 1){
				$d++;
				$ultimo = date("Y-m-d", mktime(0, 0, 0, $mes, $d, $ano));
				$semana = date("w", strtotime($ultimo));
			}

		}
		
		if($tipo=="dia_spec"){
			$d=0;
			$f=0;
			for($x=1;$x<=$dia; $x++){
				$d++;
				// transforma $ddm em data
				$dia_p = $ano."-".$mes."-".str_pad($d,2,"0",STR_PAD_LEFT);
				$semana = date("w", strtotime($dia_p));
				//echo $dia_p." | ".$semana."<br>";
				if(($semana==6) || ($semana==0)){
					$dia++;
					$f++;
				}
				
				$sql = "SELECT fer_data FROM feriados WHERE fer_data ='".$dia_p."'";
				//echo $sql."<br>";
				$this->FreeSql($sql);
				if($this->linhas<>0){
					$dia++;
					$f++;
				}
			}
		}

		$ultimo = date("Y-m-d", mktime(0, 0, 0, $mes, $d, $ano));
		return $ultimo;		
	}

	function hora_decimal($hora){
		list($h, $m, $s) = explode(":",$hora);
		$dec = ($h*60)+($m)+($s/60);
		return $dec;
	}


	function DiaDaSemana($date){
	    return date('w', strtotime($date));
	}

	function getFeed($feed_url) {
     
	    $content = file_get_contents($feed_url);
	    $x = new SimpleXmlElement($content);
	     
	    /*echo "<ul>";
	     
	    foreach($x->channel->item as $entry) {
	        echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
	    }
	    echo "</ul>";
	    */
	    echo htmlentities($x->channel->item->description);
	}
	function Audit($tabela, $param, $dados, $emp, $user, $acao = 1){

		$this->Seleciona("*",$tabela,$param);
		$this->GeraDados();
		$logact = $this->historicos[$acao]["act"]." dados - tabela: $tabela";
		$log = "";

		foreach($dados as $i=>$v){
			if($v <> $this->fld($i)){
				$log.="<b>".$i." de </b>".($this->fld($i)==""?"vazio":$this->fld($i))."<b> para </b>".$v."<br>";
			}
		}
		$dlog = array();
		$dlog['log_cod'] 	= $emp;
		$dlog['log_acao'] 	= $logact;
		$dlog['log_altera'] = $log;
		$dlog['log_user'] 	= $user;
		$dlog['log_data'] 	= date("Y-m-d");
		$dlog['log_datahora'] = date("Y-m-d H:i:s");
		$dlog['log_icon'] 	= $this->historicos[$acao]["icon"];
		$dlog['log_cor'] 	= $this->historicos[$acao]["color"];
		$this->Insere($dlog,"logs_altera");
	}
	
	function countWeekendDays($start, $end){
    
	    $iter = 24*60*60; // whole day in seconds
	    $count = 0; // keep a count of Sats & Suns

	    for($i = $start; $i <= $end; $i=$i+$iter){
	        if(Date('D',$i) == 'Sat' || Date('D',$i) == 'Sun'){
	            $count++;
	        }
	    }
		return $count;
	}

	function simple_horas_uteis($abert, $fecham){

		/*TO-DO
		Finais de semana, hora abertura e fechament no bd*/
		$entrada 	= strtotime("07:30:00");
		$saida 		= strtotime("17:00:00");

		$util = ($saida-$entrada)/3600; 

		
		// Dias inteiros
		$diaab = date("Y-m-d", strtotime($abert));
		$diafc = date("Y-m-d", strtotime($fecham));

		//pesquisa feriados na tabela e retorna numero de dias enontrados
		$sql = "SELECT fer_data FROM feriados WHERE fer_data BETWEEN '".$diaab."' AND '".$diafc."'";
		$this->FreeSql($sql);
		$fers = $this->linhas;

		// funcção que retorna fins de semana

		$wknd = $this->countWeekendDays(strtotime($diaab),strtotime($diafc));

		// retorna dias de diferença entre abertura e fechamento do chamado
		$dias_inteiros = (((strtotime($diafc) - strtotime($diaab))/86400)-1);
		$dias_uteis = $dias_inteiros-$fers - $wknd;

		// se houverem mais de dois dias de diferença, multiplica pelas hotas uteis
		$horas_dint =  ($dias_inteiros > 0?$dias_uteis*$util:0);
		
		// Aqui, fazemos a conta de hora final - hora da abertura
		$fech_diaab = date("Y-m-d H:i:s", strtotime($diaab." 17:00:00"));
		$aber_diaab =  date("Y-m-d H:i:s", strtotime($abert));
		$tempo_ab = strtotime($fech_diaab) - strtotime($aber_diaab);

		// Aqui, hora do fechamento do chamado - hora inicio do dia do fechamento.
		$fech_diafc = date("Y-m-d H:i:s", strtotime($diafc. "07:30:00"));
		$aber_diafc =  date("Y-m-d H:i:s", strtotime($fecham));
		$tempo_fc = strtotime($aber_diafc) - strtotime($fech_diafc);


		// Soma tudo, converte em hora e aquele abraço mlk
		$htotal = (($dias_inteiros<=0?(strtotime($aber_diafc)-strtotime($aber_diaab)):($tempo_ab+$tempo_fc))/3600)+$horas_dint;
		$horas = intval($htotal);
		$minutos = 60*($htotal - $horas);

		
		return sprintf("%02d",$horas)."h".sprintf("%02d",$minutos)."mins";
	}

	function formata_din($num){
		return "R$".number_format($num, 2,",",".");
	} 

    /**
     * Calcula a diferença em horas comerciais entre a primeira e a segunda data passadas como parâmetro
     * @param DateTime $data1 Data inicial
     * @param DateTime $data2 Data final
     * @param DateTime $inicio Hora de inicio do horário comercial, padrão = 8
     * @param DateTime $fim Hora de término do horário comercial, padrão = 18
     * @return Array Array com horas e minutos
     */
    public static function horasUteis(DateTime $start, DateTime $end, $feriados = Array(), $inicio = '07:30', $fim = '17:00') {
        $step = $start;
        $seguinte = $start;
        $horas = 0;
 
        $hora_inicio = strtotime($step->format('Y-m-d') . ' ' . $inicio);
        while ($step <= $end) {
            // Hora inicial e final no dia atual
            $hora_inicio = strtotime($step->format('Y-m-d') . ' ' . $inicio);
            $hora_fim = strtotime($step->format('Y-m-d') . ' ' . $fim);
 
            // Se a hora atual estiver dentro do horario comercial
            // E o dia não for domingo
            if (($step->format('U') < $hora_fim)&&($step->format("w")!=0)) {
                if ($step->format('U') >= $hora_inicio) {
                    $inicial = $step->format('U');
                    $step = new DateTime($step->format('Y-m-d'));
                }else{
                    $inicial = $hora_inicio;
                }
                // Se a hora estiver abaixo do horário comercial
                if ($step->format('U') < $hora_fim) {
                    if (strtotime($end->format('y-m-d')) == strtotime($step->format('Y-m-d'))) {
                        if($end->format('U') > $hora_inicio){
                        $final = $end->format('U');
                        }else{
                            $final = $hora_inicio;
                        }
                    } else {
                        $final = $hora_fim;
                    }
                }
                if ($final > $hora_fim) {
                    $horas += ( $hora_fim - $inicial);
                } else {
                    $horas += ( $final - $inicial);
                }
            }else{
                    $step = new DateTime($step->format('Y-m-d'));
            }
            $step->modify('+1 day');
        }
        $horas = $horas / 3600;
        $min = ($horas - (int) $horas) * 60;
        $horas = (int) $horas;
        $retorno = array('h' => $horas, 'm' => $min);
        return $retorno;
    }		
}
?>
