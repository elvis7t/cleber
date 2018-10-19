<?php
//session_start();
require_once("../model/recordset.php");
class irpf extends recordset {
	var $link;
	var $tabela = "irrf";
	var $status = array();
	var $historico = array();

	function irpf(){
		$this->link = conecta();
		return $this->link;
	}
	function status_ir(){
		$periodo = (int)date("Y") - 1;
		$sql = "SELECT ir_status, st_desc, count(ir_status) FROM irrf a
					JOIN codstatus b ON a.ir_status = b.st_codstatus
				WHERE ir_ano = '".(string)$periodo."' GROUP BY ir_status";
		$this->FreeSql($sql);
		$i = 0;
		while($this->GeraDados()){
			$this->status[$i]["codigo"]	= $this->fld("ir_status");
			$this->status[$i]["desc"] 	= $this->fld("st_desc");
			$this->status[$i]["valor"]	= $this->fld("count(ir_status)");
			$i++;
		}
		return $this->status;
	}
	function history_ir(){
		$sql = "SELECT ir_ano, count(ir_ano) FROM irrf 
				GROUP BY ir_ano";
		$this->FreeSql($sql);
		$i = 0;
		while($this->GeraDados()){
			$this->historico[$i]["ano"]	= $this->fld("ir_ano");
			$this->historico[$i]["valor"]	= $this->fld("count(ir_ano)");
			$i++;
		}
		return $this->historico;
	}

	function pagos_ir(){
		$periodo = (int)date("Y")-1;
		$sql_pagos = "SELECT count(a.ir_Id) FROM irrf a
						JOIN irpf_recibo b on a.ir_reciboId = b.irec_id
					WHERE b.irec_pago = 1 AND a.ir_ano='".$periodo."'";
		$this->FreeSql($sql_pagos);
		$this->GeraDados();
		return $this->fld("count(a.ir_Id)");
	}
	
	function devem_ir(){
		$periodo = (int)date("Y")-1;
		$sql_devem = "SELECT count(a.ir_Id) FROM irrf a
						JOIN irpf_recibo b on a.ir_reciboId = b.irec_id
					WHERE b.irec_pago = 0 AND a.ir_ano='".$periodo."'";
		$this->FreeSql($sql_devem);
		$this->GeraDados();
		return $this->fld("count(a.ir_Id)");
	}

	function sem_boleto(){
		$periodo = (int)date("Y")-1;
		$sql_devem = "SELECT count(a.ir_Id) FROM irrf a
						WHERE a.ir_reciboid = 0 AND a.ir_ano='".$periodo."'";
		$this->FreeSql($sql_devem);
		$this->GeraDados();
		return $this->fld("count(a.ir_Id)");
	}

}

?>