-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.16-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela priore_sys.calendario
CREATE TABLE IF NOT EXISTS `calendario` (
  `cal_id` int(11) NOT NULL AUTO_INCREMENT,
  `cal_eveid` int(11) DEFAULT NULL,
  `cal_eveusu` varchar(200) DEFAULT NULL,
  `cal_dataini` date DEFAULT NULL,
  `cal_horaini` time DEFAULT NULL,
  `cal_datafim` date DEFAULT NULL,
  `cal_horafim` time DEFAULT NULL,
  `cal_url` varchar(200) DEFAULT NULL,
  `cal_criado` int(11) DEFAULT NULL,
  `cal_obs` text,
  PRIMARY KEY (`cal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='calendário de eventos\r\nUtiliza tabela eventos';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.chamados
CREATE TABLE IF NOT EXISTS `chamados` (
  `cham_id` int(11) NOT NULL AUTO_INCREMENT,
  `cham_dept` int(11) NOT NULL DEFAULT '0',
  `cham_task` varchar(30) NOT NULL,
  `cham_solic` int(11) NOT NULL COMMENT 'Quem solicitou',
  `cham_trat` int(11) NOT NULL COMMENT 'Quem tratou',
  `cham_percent` int(11) NOT NULL,
  `cham_status` int(11) NOT NULL,
  `cham_sla` time DEFAULT NULL,
  `cham_aval` double(3,2) NOT NULL COMMENT 'Nota de 0 à 5',
  `cham_abert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cham_tratini` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cham_tratfim` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cham_id`)
) ENGINE=InnoDB AUTO_INCREMENT=311 DEFAULT CHARSET=latin1 COMMENT='Tabela que gerencia os chamados internos';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.cham_obs
CREATE TABLE IF NOT EXISTS `cham_obs` (
  `chobs_id` int(11) NOT NULL AUTO_INCREMENT,
  `chobs_chamid` int(11) NOT NULL,
  `chobs_obs` varchar(4000) NOT NULL,
  `chobs_user` int(11) NOT NULL,
  `chobs_horario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`chobs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=805 DEFAULT CHARSET=latin1 COMMENT='Tabela para observações dos chamados';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_msg` varchar(500) DEFAULT NULL,
  `chat_de` int(11) DEFAULT NULL,
  `chat_para` int(11) DEFAULT NULL,
  `chat_lido` int(11) DEFAULT NULL,
  `chat_hora` timestamp NULL DEFAULT NULL,
  `chat_view` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4060 DEFAULT CHARSET=latin1 COMMENT='Armazena conversas online com o Admin\r\n';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `classe_id` int(11) NOT NULL AUTO_INCREMENT,
  `classe_desc` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`classe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Armazena a Classe dos usuários.\r\nTabela criada caso haja necessidade de o sistema ser utilizado por mais de uma empresa';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.clientes_tel
CREATE TABLE IF NOT EXISTS `clientes_tel` (
  `ctel_id` int(11) NOT NULL AUTO_INCREMENT,
  `ctel_lista` int(11) NOT NULL,
  `ctel_cod` int(11) NOT NULL,
  `ctel_nome` varchar(200) NOT NULL,
  `ctel_doc` varchar(18) NOT NULL,
  PRIMARY KEY (`ctel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1348 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.codstatus
CREATE TABLE IF NOT EXISTS `codstatus` (
  `st_cod` int(11) NOT NULL AUTO_INCREMENT,
  `st_codstatus` int(11) DEFAULT '0',
  `st_desc` varchar(50) DEFAULT '0',
  `st_opcaode` varchar(50) DEFAULT '0',
  `st_icone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`st_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COMMENT='SERVE PARA TODAS AS TABELAS QUE TEM ALGUM STATUS :)';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.comunicacao
CREATE TABLE IF NOT EXISTS `comunicacao` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_cod` int(11) DEFAULT NULL,
  `com_canal` varchar(50) DEFAULT NULL,
  `com_depto` int(11) DEFAULT NULL,
  `com_obs` varchar(1000) DEFAULT NULL,
  `com_usu` int(11) DEFAULT NULL,
  `com_data` datetime DEFAULT NULL,
  `com_ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`com_id`),
  KEY `fkComDepto` (`com_depto`),
  CONSTRAINT `fkComDepto` FOREIGN KEY (`com_depto`) REFERENCES `departamentos` (`dep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.contatos
CREATE TABLE IF NOT EXISTS `contatos` (
  `con_cod` int(11) NOT NULL AUTO_INCREMENT,
  `con_cli_cnpj` varchar(18) DEFAULT '0',
  `con_tipo` varchar(30) DEFAULT '0',
  `con_contato` varchar(255) DEFAULT '0',
  PRIMARY KEY (`con_cod`),
  KEY `FKCli_cod` (`con_cli_cnpj`),
  CONSTRAINT `FKCli_cod` FOREIGN KEY (`con_cli_cnpj`) REFERENCES `empresas` (`emp_cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=728 DEFAULT CHARSET=latin1 COMMENT='tabela de contatos ligadas ao cliente';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.contatos_cli
CREATE TABLE IF NOT EXISTS `contatos_cli` (
  `ctcli_id` int(11) NOT NULL AUTO_INCREMENT,
  `ctcli_lista` int(11) NOT NULL DEFAULT '0',
  `ctcli_tel` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ctcli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2281 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.controle_horas
CREATE TABLE IF NOT EXISTS `controle_horas` (
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_data` date NOT NULL,
  `ch_colab` int(11) NOT NULL,
  `ch_hora_saida` time NOT NULL,
  `ch_usucad` int(11) NOT NULL,
  `ch_horacad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ch_status` int(11) NOT NULL,
  `ch_referido` int(11) NOT NULL,
  `ch_aprovadopor` int(11) NOT NULL,
  `ch_obs` varchar(256) NOT NULL,
  PRIMARY KEY (`ch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1182 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.dados_user
CREATE TABLE IF NOT EXISTS `dados_user` (
  `dados_id` int(11) NOT NULL AUTO_INCREMENT,
  `dados_nome` varchar(100) DEFAULT '0',
  `dados_cpf` varchar(14) DEFAULT '0',
  `dados_rg` varchar(30) DEFAULT '0',
  `dados_sexo` enum('0','1') DEFAULT '0',
  `dados_escol` varchar(50) DEFAULT NULL,
  `dados_cep` varchar(8) DEFAULT NULL,
  `dados_rua` varchar(200) DEFAULT NULL,
  `dados_num` varchar(20) DEFAULT NULL,
  `dados_compl` varchar(50) DEFAULT NULL,
  `dados_bairro` varchar(50) DEFAULT NULL,
  `dados_cidade` varchar(50) DEFAULT NULL,
  `dados_uf` varchar(50) DEFAULT NULL,
  `dados_usu_email` varchar(200) DEFAULT NULL,
  `dados_habil` varchar(200) DEFAULT NULL,
  `dados_notas` varchar(200) DEFAULT NULL,
  `dados_nasc` date DEFAULT NULL,
  PRIMARY KEY (`dados_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1 COMMENT='Tabela para dados do usuario.\r\nPartilha informações com a tabela contato.';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para evento priore_sys.deletar_inativo
DELIMITER //
CREATE DEFINER=`br_admin`@`%` EVENT `deletar_inativo` ON SCHEDULE EVERY 10 MINUTE STARTS '2015-09-21 13:14:05' ON COMPLETION NOT PRESERVE DISABLE DO UPDATE logado SET log_status="0" WHERE NOT(NOW() BETWEEN log_horario AND log_expira)//
DELIMITER ;

-- Copiando estrutura para tabela priore_sys.departamentos
CREATE TABLE IF NOT EXISTS `departamentos` (
  `dep_id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_nome` varchar(50) DEFAULT NULL,
  `dep_tema` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`dep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='Cadastra Departamentos da empresa';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.desconto_horas
CREATE TABLE IF NOT EXISTS `desconto_horas` (
  `desc_id` int(11) NOT NULL AUTO_INCREMENT,
  `desc_colab` int(11) NOT NULL,
  `desc_horas` float(4,2) NOT NULL,
  `desc_data` datetime NOT NULL,
  `desc_usucad` int(11) NOT NULL,
  `desc_obs` text NOT NULL,
  PRIMARY KEY (`desc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 COMMENT='Essa tabela é responsável por descontar as horas calculadas pelo controle de horas e registrar as ações.';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.docs_entrada
CREATE TABLE IF NOT EXISTS `docs_entrada` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_tipo` int(11) DEFAULT NULL,
  `doc_ref` varchar(7) DEFAULT NULL,
  `doc_cli` int(11) DEFAULT NULL,
  `doc_dep` int(11) DEFAULT NULL,
  `doc_resp` int(11) DEFAULT NULL,
  `doc_data` timestamp NULL DEFAULT NULL,
  `doc_datarec` timestamp NULL DEFAULT NULL,
  `doc_obs` varchar(400) NOT NULL DEFAULT '0',
  `doc_status` int(11) DEFAULT NULL,
  `doc_recpor` int(11) DEFAULT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2707 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.documentos
CREATE TABLE IF NOT EXISTS `documentos` (
  `doc_cod` int(11) NOT NULL AUTO_INCREMENT,
  `doc_cli_cnpj` varchar(18) DEFAULT NULL,
  `doc_tipo` varchar(255) DEFAULT NULL,
  `doc_ender` text,
  `doc_dtenv` date DEFAULT NULL,
  `doc_user_env` varchar(200) DEFAULT NULL,
  `doc_desc` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`doc_cod`),
  KEY `FKdoc_cnpj` (`doc_cli_cnpj`),
  CONSTRAINT `FKdoc_cnpj` FOREIGN KEY (`doc_cli_cnpj`) REFERENCES `empresas` (`emp_cnpj`) ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='armazena os documentos dos clientes';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `emp_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `emp_cnpj` varchar(18) NOT NULL,
  `emp_razao` varchar(50) NOT NULL,
  `emp_nome` varchar(50) NOT NULL,
  `emp_ie` varchar(18) NOT NULL DEFAULT '000.000.000.000' COMMENT 'Número de Registro da Empresa dentro do Estado',
  `emp_im` varchar(8) DEFAULT NULL COMMENT 'Número de Registro da Empresa dentro do Município',
  `emp_cnae` varchar(7) DEFAULT NULL,
  `emp_crt` varchar(7) DEFAULT '0000000',
  `emp_cep` varchar(10) NOT NULL,
  `emp_logr` varchar(70) NOT NULL,
  `emp_num` varchar(10) NOT NULL,
  `emp_compl` varchar(30) NOT NULL,
  `emp_bairro` varchar(50) NOT NULL,
  `emp_cidade` varchar(30) NOT NULL,
  `emp_uf` varchar(2) NOT NULL,
  `emp_resp` varchar(50) NOT NULL,
  `emp_evento` enum('1','2') NOT NULL,
  `emp_logo` varchar(100) NOT NULL,
  PRIMARY KEY (`emp_codigo`),
  UNIQUE KEY `emp_cnpj` (`emp_cnpj`),
  KEY `emp_cnpj_2` (`emp_cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=805 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.eventos
CREATE TABLE IF NOT EXISTS `eventos` (
  `eve_id` int(11) NOT NULL AUTO_INCREMENT,
  `eve_desc` varchar(50) NOT NULL DEFAULT '0',
  `eve_tema` varchar(50) NOT NULL DEFAULT '0',
  `eve_cor` varchar(50) NOT NULL DEFAULT '0',
  `eve_dep` tinytext NOT NULL,
  PRIMARY KEY (`eve_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1 COMMENT='Cria eventos no Sistema';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.irpf_cotas
CREATE TABLE IF NOT EXISTS `irpf_cotas` (
  `icot_id` int(11) NOT NULL AUTO_INCREMENT,
  `icot_ir_id` int(11) NOT NULL DEFAULT '0',
  `icot_parc` int(11) NOT NULL,
  `icot_valor` float(11,2) NOT NULL,
  `icot_ref` varchar(7) NOT NULL,
  `icot_print` enum('Y','N') DEFAULT 'N',
  `icot_quem` int(11) DEFAULT NULL,
  `icot_datas` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`icot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=868 DEFAULT CHARSET=latin1 COMMENT='Armazena os valores e vencimentos para pagamento de cotas no caso de IAP';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.irpf_outrosdocs
CREATE TABLE IF NOT EXISTS `irpf_outrosdocs` (
  `irdocs_id` int(11) NOT NULL AUTO_INCREMENT,
  `irdocs_cli_id` int(11) NOT NULL,
  `irdocs_tipo` varchar(50) NOT NULL,
  `irdocs_dado` varchar(50) NOT NULL,
  PRIMARY KEY (`irdocs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1 COMMENT='Outros documentos para imposto de renda';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.irpf_recibo
CREATE TABLE IF NOT EXISTS `irpf_recibo` (
  `irec_id` int(11) NOT NULL AUTO_INCREMENT,
  `irec_emt_por` int(11) DEFAULT NULL,
  `irec_data` timestamp NULL DEFAULT NULL,
  `irec_pago` int(11) DEFAULT NULL,
  `irec_ativo` int(11) DEFAULT NULL,
  `irec_forma` varchar(50) DEFAULT NULL,
  `irec_pagodata` timestamp NULL DEFAULT NULL,
  `irec_valor` float(13,2) DEFAULT '0.00',
  `irec_compl` varchar(50) DEFAULT NULL,
  `irec_obs` varchar(200) DEFAULT NULL,
  `irec_recpor` int(11) DEFAULT NULL,
  PRIMARY KEY (`irec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=621 DEFAULT CHARSET=latin1 COMMENT='Gerencia o status do Recibo';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.irpf_retorno
CREATE TABLE IF NOT EXISTS `irpf_retorno` (
  `iret_id` int(11) NOT NULL AUTO_INCREMENT,
  `iret_ir_id` int(11) NOT NULL DEFAULT '0',
  `iret_tipo` varchar(3) NOT NULL,
  `iret_valor` float(11,2) NOT NULL,
  `iret_cotas` int(11) NOT NULL,
  `iret_datalib` date NOT NULL,
  `iret_pagto` varchar(50) NOT NULL,
  PRIMARY KEY (`iret_id`)
) ENGINE=InnoDB AUTO_INCREMENT=546 DEFAULT CHARSET=latin1 COMMENT='Armazena o retorno do imposto';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.irpf_selic
CREATE TABLE IF NOT EXISTS `irpf_selic` (
  `isel_id` int(11) NOT NULL AUTO_INCREMENT,
  `isel_ref` varchar(7) NOT NULL,
  `isel_taxa` float(3,2) NOT NULL,
  PRIMARY KEY (`isel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COMMENT='Armazena as taxas mensais da SELIC de acordo com o site da Receita\r\n';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.irrf
CREATE TABLE IF NOT EXISTS `irrf` (
  `ir_Id` int(11) NOT NULL AUTO_INCREMENT,
  `ir_cli_id` int(11) DEFAULT NULL,
  `ir_tipo` varchar(50) DEFAULT NULL,
  `ir_compl` varchar(50) DEFAULT NULL,
  `ir_valor` double(11,2) DEFAULT NULL,
  `ir_ano` varchar(4) DEFAULT NULL,
  `ir_status` int(11) DEFAULT NULL,
  `ir_cad_user` int(11) DEFAULT NULL,
  `ir_ult_user` int(11) DEFAULT NULL,
  `ir_dataent` timestamp NULL DEFAULT NULL,
  `ir_dataalt` timestamp NULL DEFAULT NULL,
  `ir_reciboId` int(11) DEFAULT NULL,
  PRIMARY KEY (`ir_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1268 DEFAULT CHARSET=latin1 COMMENT='Tabela que armazena impostos de Renda realizados';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.irrf_historico
CREATE TABLE IF NOT EXISTS `irrf_historico` (
  `irh_id` int(11) NOT NULL AUTO_INCREMENT,
  `irh_ir_id` int(11) DEFAULT NULL,
  `irh_usu_cod` int(11) DEFAULT NULL,
  `irh_obs` varchar(200) DEFAULT NULL,
  `irh_dataalt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`irh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2453 DEFAULT CHARSET=latin1 COMMENT='Armazena as alterações realizadas em cada registro no IRRF';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.logado
CREATE TABLE IF NOT EXISTS `logado` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_user` varchar(100) NOT NULL DEFAULT '0',
  `log_classe` tinyint(4) NOT NULL DEFAULT '0',
  `log_token` varchar(100) NOT NULL DEFAULT '0',
  `log_horario` timestamp NULL DEFAULT NULL,
  `log_expira` timestamp NULL DEFAULT NULL,
  `log_status` enum('1','0') DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11198 DEFAULT CHARSET=latin1 COMMENT='Tabela para Logados';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.logs_altera
CREATE TABLE IF NOT EXISTS `logs_altera` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_cod` int(11) NOT NULL,
  `log_altera` varchar(4000) NOT NULL,
  `log_user` int(11) NOT NULL,
  `log_data` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=709 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.ltempo
CREATE TABLE IF NOT EXISTS `ltempo` (
  `tem_id` int(11) NOT NULL AUTO_INCREMENT,
  `tem_data` date DEFAULT NULL,
  `tem_hora` datetime DEFAULT NULL,
  `tem_usu_id` int(11) DEFAULT NULL,
  `tem_Titulo` varchar(200) DEFAULT '0',
  `tem_icone` varchar(50) DEFAULT '0',
  `tem_cor` varchar(50) DEFAULT '0',
  `tem_desc` varchar(400) DEFAULT '0',
  `tem_local` varchar(50) DEFAULT '0',
  PRIMARY KEY (`tem_id`),
  KEY `FKusu` (`tem_usu_id`),
  CONSTRAINT `FKusu` FOREIGN KEY (`tem_usu_id`) REFERENCES `usuarios` (`usu_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=1092 DEFAULT CHARSET=latin1 COMMENT='guarda eventos para a linnha do tempo';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.maquinas
CREATE TABLE IF NOT EXISTS `maquinas` (
  `maq_id` int(11) NOT NULL AUTO_INCREMENT,
  `maq_ip` varchar(20) NOT NULL,
  `maq_user` int(11) NOT NULL,
  `maq_usuario` varchar(50) NOT NULL,
  `maq_sistema` varchar(50) NOT NULL,
  `maq_memoria` varchar(50) NOT NULL,
  `maq_hd` varchar(50) NOT NULL,
  `maq_ativa` int(11) NOT NULL,
  `maq_tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`maq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.mat_cadastro
CREATE TABLE IF NOT EXISTS `mat_cadastro` (
  `mcad_id` int(11) NOT NULL AUTO_INCREMENT,
  `mcad_catid` int(11) NOT NULL DEFAULT '0',
  `mcad_desc` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mcad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Cadastro de materiais\r\n';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.mat_categorias
CREATE TABLE IF NOT EXISTS `mat_categorias` (
  `mcat_id` int(11) NOT NULL AUTO_INCREMENT,
  `mcat_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`mcat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Categorias de Materiais';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.mat_historico
CREATE TABLE IF NOT EXISTS `mat_historico` (
  `mhist_id` int(11) NOT NULL AUTO_INCREMENT,
  `mhist_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mhist_user` int(11) NOT NULL,
  `mhist_operacao` int(11) NOT NULL,
  `mhist_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`mhist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='historico de movimentação dos materiais';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `mnu_id` int(11) NOT NULL AUTO_INCREMENT,
  `mnu_cod` int(11) DEFAULT NULL,
  `mnu_titulo` varchar(50) DEFAULT NULL,
  `mnu_sess` varchar(50) DEFAULT NULL,
  `mnu_icon` varchar(50) DEFAULT NULL,
  `mnu_link` varchar(50) DEFAULT NULL,
  `mnu_niveis` varchar(50) DEFAULT NULL,
  `mnu_filhos` enum('1','0') DEFAULT NULL,
  `mnu_hier` enum('P','F') DEFAULT NULL,
  PRIMARY KEY (`mnu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='Menus do Sistema para permissionamento';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.menu_triangulo
CREATE TABLE IF NOT EXISTS `menu_triangulo` (
  `mnu_id` int(11) NOT NULL AUTO_INCREMENT,
  `mnu_cod` int(11) DEFAULT NULL,
  `mnu_titulo` varchar(50) DEFAULT NULL,
  `mnu_sess` varchar(50) DEFAULT NULL,
  `mnu_icon` varchar(50) DEFAULT NULL,
  `mnu_link` varchar(50) DEFAULT NULL,
  `mnu_niveis` varchar(50) DEFAULT NULL,
  `mnu_filhos` enum('1','0') DEFAULT NULL,
  `mnu_hier` enum('P','F') DEFAULT NULL,
  PRIMARY KEY (`mnu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 COMMENT='Menus do Sistema para permissionamento';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.obrigacoes
CREATE TABLE IF NOT EXISTS `obrigacoes` (
  `ob_id` int(11) NOT NULL AUTO_INCREMENT,
  `ob_cod` int(11) DEFAULT NULL,
  `ob_titulo` int(11) DEFAULT NULL,
  `ob_depto` int(11) DEFAULT NULL,
  `ob_ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`ob_id`),
  KEY `fkObDepto` (`ob_depto`),
  CONSTRAINT `fkObDepto` FOREIGN KEY (`ob_depto`) REFERENCES `departamentos` (`dep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.ocorr_maquinas
CREATE TABLE IF NOT EXISTS `ocorr_maquinas` (
  `ocor_id` int(11) NOT NULL AUTO_INCREMENT,
  `ocor_maqid` int(11) NOT NULL,
  `ocor_obs` varchar(1000) NOT NULL,
  `ocor_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ocor_user` int(11) NOT NULL,
  PRIMARY KEY (`ocor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.particularidades
CREATE TABLE IF NOT EXISTS `particularidades` (
  `part_id` int(11) NOT NULL AUTO_INCREMENT,
  `part_cod` int(11) NOT NULL,
  `part_titulo` varchar(50) NOT NULL DEFAULT '0',
  `part_usu` int(11) NOT NULL,
  `part_depto` int(11) NOT NULL,
  `part_data` datetime NOT NULL,
  `part_obs` text NOT NULL,
  `part_tipo` int(11) NOT NULL,
  `part_ativo` int(11) NOT NULL,
  PRIMARY KEY (`part_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.perifericos
CREATE TABLE IF NOT EXISTS `perifericos` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `per_maqid` int(11) NOT NULL,
  `per_tipo` varchar(50) NOT NULL,
  `per_modelo` varchar(50) NOT NULL,
  `per_status` varchar(50) NOT NULL,
  `per_ativo` int(11) NOT NULL,
  `per_datacad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `per_usucad` int(11) NOT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.permissoes
CREATE TABLE IF NOT EXISTS `permissoes` (
  `pem_id` int(11) NOT NULL AUTO_INCREMENT,
  `pem_desc` varchar(50) DEFAULT NULL,
  `pem_pag` varchar(50) NOT NULL,
  `pem_permissoes` varchar(500) NOT NULL,
  PRIMARY KEY (`pem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COMMENT='Gerencia o acesso ao conteudo e funcionalidades';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.planos
CREATE TABLE IF NOT EXISTS `planos` (
  `plan_cod` int(11) NOT NULL AUTO_INCREMENT,
  `plan_nome` varchar(100) DEFAULT '0',
  `plan_icone` varchar(50) DEFAULT NULL,
  `plan_cor` varchar(50) DEFAULT '0',
  `plan_desc` varchar(300) DEFAULT '0',
  `plan_valor` float DEFAULT '0',
  `plan_impre` int(11) DEFAULT '0',
  `plan_lanc` int(11) DEFAULT '0',
  `plan_fopag` int(11) DEFAULT '0',
  `plan_usuarios` int(11) DEFAULT '0',
  `plan_usu_avulso` float DEFAULT '0',
  `plan_ser_avulso` float DEFAULT '0',
  PRIMARY KEY (`plan_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Planos da Priore';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.porte_empresa
CREATE TABLE IF NOT EXISTS `porte_empresa` (
  `port_id` int(11) NOT NULL AUTO_INCREMENT,
  `port_tipo` int(11) NOT NULL,
  `port_tam` varchar(10) NOT NULL,
  `port_func` varchar(50) NOT NULL,
  PRIMARY KEY (`port_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.priore_planos
CREATE TABLE IF NOT EXISTS `priore_planos` (
  `priplan_cod` int(11) NOT NULL AUTO_INCREMENT,
  `priplan_emp_cnpj` varchar(18) DEFAULT '0',
  `priplan_plan_cod` int(11) DEFAULT '0',
  PRIMARY KEY (`priplan_cod`),
  KEY `FKemp_cod` (`priplan_emp_cnpj`),
  KEY `FKplan_cod` (`priplan_plan_cod`),
  CONSTRAINT `FKemp_cod` FOREIGN KEY (`priplan_emp_cnpj`) REFERENCES `empresas` (`emp_cnpj`),
  CONSTRAINT `FKplan_cod` FOREIGN KEY (`priplan_plan_cod`) REFERENCES `planos` (`plan_cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela diferente da tabela planos.\r\nEspecifica os planos contratados pelo Cliente';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.senhas
CREATE TABLE IF NOT EXISTS `senhas` (
  `sen_id` int(11) NOT NULL AUTO_INCREMENT,
  `sen_cod` int(11) NOT NULL,
  `sen_desc` varchar(50) NOT NULL,
  `sen_acesso` varchar(200) NOT NULL,
  `sen_user` varchar(40) NOT NULL,
  `sen_senha` varchar(40) NOT NULL,
  `sen_obs` text NOT NULL,
  `sen_usercad` int(11) NOT NULL,
  `sen_dtcad` datetime NOT NULL,
  PRIMARY KEY (`sen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.servicos
CREATE TABLE IF NOT EXISTS `servicos` (
  `ser_id` int(11) NOT NULL AUTO_INCREMENT,
  `ser_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ser_usuario` int(11) NOT NULL,
  `ser_cliente` int(11) NOT NULL,
  `ser_venc` date NOT NULL,
  `ser_obs` varchar(1000) COLLATE utf8_bin NOT NULL,
  `ser_status` int(11) NOT NULL,
  `ser_lista` int(11) NOT NULL,
  PRIMARY KEY (`ser_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2374 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Lista de servicos';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.serv_hist
CREATE TABLE IF NOT EXISTS `serv_hist` (
  `shist_id` int(11) NOT NULL AUTO_INCREMENT,
  `shist_serid` int(11) NOT NULL,
  `shist_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `shist_user` int(11) NOT NULL,
  `shist_obs` varchar(400) NOT NULL,
  PRIMARY KEY (`shist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2417 DEFAULT CHARSET=latin1 COMMENT='histórico dos serviços';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.serv_saidas
CREATE TABLE IF NOT EXISTS `serv_saidas` (
  `said_id` int(11) NOT NULL AUTO_INCREMENT,
  `said_usuario` int(11) NOT NULL,
  `said_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `said_lista` int(11) NOT NULL,
  `said_venc` date NOT NULL,
  `said_status` int(11) NOT NULL,
  `said_ativo` int(11) NOT NULL,
  `said_useralt` int(11) NOT NULL,
  `said_dataalt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`said_id`)
) ENGINE=InnoDB AUTO_INCREMENT=565 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.sistema
CREATE TABLE IF NOT EXISTS `sistema` (
  `sys_nome` varchar(20) COLLATE utf8_bin NOT NULL,
  `sys_versao` varchar(10) COLLATE utf8_bin NOT NULL,
  `sys_retorno` varchar(255) COLLATE utf8_bin NOT NULL,
  `sys_empresa` varchar(50) COLLATE utf8_bin NOT NULL,
  `sys_cnpj` varchar(18) COLLATE utf8_bin NOT NULL,
  `sys_mail` varchar(255) COLLATE utf8_bin NOT NULL,
  `sys_senha` varchar(20) COLLATE utf8_bin NOT NULL,
  `sys_logo` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `sys_dominio` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tab_municipios
CREATE TABLE IF NOT EXISTS `tab_municipios` (
  `id` varchar(50) DEFAULT NULL,
  `iduf` int(11) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='municipios da sefaz';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tbl_estado
CREATE TABLE IF NOT EXISTS `tbl_estado` (
  `est_cod` tinyint(4) DEFAULT NULL,
  `est_sigla` varchar(2) DEFAULT NULL,
  `est_estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='guarda codigos do estado uteis para NFE';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tipos_doc
CREATE TABLE IF NOT EXISTS `tipos_doc` (
  `tdoc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tdoc_tipo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tdoc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='Tabela que contempla os tipos de docs';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tipos_empresas
CREATE TABLE IF NOT EXISTS `tipos_empresas` (
  `tipemp_Id` int(11) NOT NULL AUTO_INCREMENT,
  `tipemp_cod` int(11) DEFAULT NULL,
  `tipemp_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`tipemp_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tipos_impostos
CREATE TABLE IF NOT EXISTS `tipos_impostos` (
  `imp_id` int(11) NOT NULL AUTO_INCREMENT,
  `imp_nome` varchar(50) NOT NULL,
  `imp_desc` varchar(1000) NOT NULL,
  `imp_tipo` varchar(30) NOT NULL,
  `imp_venc` int(11) DEFAULT NULL,
  `imp_depto` int(11) NOT NULL,
  `imp_cadpor` int(11) NOT NULL,
  `imp_dtcad` datetime NOT NULL,
  `imp_ativo` int(11) NOT NULL,
  `imp_regra` varchar(50) DEFAULT NULL,
  `imp_pasta` varchar(50) DEFAULT NULL,
  `imp_arquivo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`imp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tipos_obs
CREATE TABLE IF NOT EXISTS `tipos_obs` (
  `tipobs_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipobs_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`tipobs_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tipo_serv
CREATE TABLE IF NOT EXISTS `tipo_serv` (
  `tip_cod` int(11) NOT NULL AUTO_INCREMENT,
  `tip_ser_id` int(11) NOT NULL DEFAULT '0',
  `tip_serv` varchar(100) NOT NULL DEFAULT '0',
  `tip_desc` varchar(1000) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tip_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COMMENT='Tabela de tipos de serviços.\r\nUtiliza ser_id da tabela services para link de categoria';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tributos
CREATE TABLE IF NOT EXISTS `tributos` (
  `tr_id` int(11) NOT NULL AUTO_INCREMENT,
  `tr_cod` int(11) NOT NULL,
  `tr_titulo` int(11) NOT NULL,
  `tr_depto` int(11) NOT NULL,
  `tr_ativo` int(11) NOT NULL,
  PRIMARY KEY (`tr_id`),
  KEY `FkTrDpeto` (`tr_depto`),
  CONSTRAINT `FkTrDpeto` FOREIGN KEY (`tr_depto`) REFERENCES `departamentos` (`dep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tri_clientes
CREATE TABLE IF NOT EXISTS `tri_clientes` (
  `cod` int(11) DEFAULT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `apelido` varchar(50) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `obs` varchar(300) DEFAULT NULL,
  `regiao` varchar(50) DEFAULT NULL,
  `responsavel` varchar(40) DEFAULT NULL,
  `tipo_emp` int(11) DEFAULT NULL,
  `num_emp` int(11) DEFAULT '0',
  `email` varchar(200) DEFAULT NULL,
  `site` varchar(200) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `tribut` varchar(2) DEFAULT NULL,
  `processos` varchar(100) DEFAULT NULL,
  `carteira` varchar(300) DEFAULT ' {"1":{"user":"","data":""},"2":{"user":"","data":""},"4":{"user":"","data":""}}',
  `ativo` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela de Clientes para o projeto Triangulo';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tri_ligac
CREATE TABLE IF NOT EXISTS `tri_ligac` (
  `sol_cod` int(11) NOT NULL AUTO_INCREMENT,
  `sol_data` timestamp NULL DEFAULT NULL,
  `sol_datareal` timestamp NULL DEFAULT NULL,
  `sol_emp` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `sol_tel` varchar(15) CHARACTER SET latin1 DEFAULT '0',
  `sol_cont` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `sol_fcom` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `sol_obs` varchar(400) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `sol_por` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `sol_status` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `sol_real_por` varchar(50) CHARACTER SET latin1 DEFAULT '0',
  `sol_pres` int(11) DEFAULT NULL,
  PRIMARY KEY (`sol_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=13772 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.tri_solic
CREATE TABLE IF NOT EXISTS `tri_solic` (
  `sol_cod` int(11) NOT NULL AUTO_INCREMENT,
  `sol_data` timestamp NULL DEFAULT NULL,
  `sol_datareal` timestamp NULL DEFAULT NULL,
  `sol_emp` varchar(50) DEFAULT '0',
  `sol_tel` varchar(15) DEFAULT '0',
  `sol_cont` varchar(50) DEFAULT '0',
  `sol_fcom` varchar(50) DEFAULT '0',
  `sol_obs` varchar(400) NOT NULL DEFAULT '0',
  `sol_por` int(11) DEFAULT '0',
  `sol_status` int(11) DEFAULT '0',
  `sol_real_por` int(11) DEFAULT '0',
  PRIMARY KEY (`sol_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=7632 DEFAULT CHARSET=latin1 COMMENT='Solicitações de Contatos Externos';

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela priore_sys.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usu_cod` int(11) NOT NULL AUTO_INCREMENT,
  `usu_nome` varchar(100) DEFAULT '0',
  `usu_senha` varchar(80) DEFAULT '0',
  `usu_emp_cnpj` varchar(18) DEFAULT '0',
  `usu_classe` tinyint(4) DEFAULT '0',
  `usu_email` varchar(200) DEFAULT '0',
  `usu_ativo` enum('0','1') DEFAULT '0',
  `usu_dep` varchar(50) DEFAULT '0',
  `usu_lider` enum('Y','N') DEFAULT 'N',
  `usu_ramal` varchar(5) DEFAULT 'N',
  `usu_pausa` varchar(30) DEFAULT NULL,
  `usu_online` enum('0','1') DEFAULT '0',
  `usu_foto` varchar(150) DEFAULT '0',
  `usu_perm` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`usu_cod`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1 COMMENT='Armazena usuarios do sistema';

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
