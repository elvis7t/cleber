<?
class functions{
	
	function functions(){
		
	}
	function data_br($data){
		$arraydata = explode("-",$data);
		$novadata = $arraydata[2]."/".$arraydata[1]."/".$arraydata[0];
		return $novadata;
	}
	function data_usa($data){
		$arraydata = explode("/",$data);
		$novadata = $arraydata[2]."/".$arraydata[1]."/".$arraydata[0];
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
	
}
?>
