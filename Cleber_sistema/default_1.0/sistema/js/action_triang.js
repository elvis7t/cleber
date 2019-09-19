$(document).on("ready", function(){
	
	/*---------------|CAIXA DE SELEÇÃO DE SERVIÇOS|----------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	\*-------------------------------------------------------------*/
		$(document.body).on("change","#emp_tel", function(){
			$("#emp_altera").val(1);
		});
	/*---------------|SOLICITAR LIGAÇÕES|--------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_solic", function(){
	        var container = $("#formerros1");
			$("#cad_sol").validate({
	            debug: true,
	            errorClass: "error",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                emp_nome: {required: true},
	                emp_res	: {required: true},
	                emp_fcom: {required: true}
	            },
	            messages: {
	                emp_nome: {required: "Digite o Nome da Empresa"},
	                emp_res	: {required: "Informe o respons&aacute;vel pela empresa"},
	                emp_fcom: {required: "Informe o contato (com quem voc&ecirc; deseja falar)"}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
				if($("#cad_sol").valid()==true){
					$("#bt_solic").html("<i class='fa fa-cog fa-spin'></i> Processando...");
					$.post("../controller/TRIEmpresas.php",{
						acao		: "inclusao",
						emp_nome	: $("#emp_nome").val(),
						emp_tel		: $("#emp_tel").val(),
						emp_res		: $("#emp_res").val(),
						emp_fcom	: $("#emp_fcom").val(),
						emp_obs		: $("#emp_obs").val()
						},
						function(data){
							if(data.status=="OK"){
								$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
								$('#spload').fadeOut('slow');
								$("#cad_sol")[0].reset();
								$("#slc").load("vis_solic.php").fadeIn("slow");
								$("#bt_solic").html("<i class='fa fa-fax'></i> Solicitar");
								//location.reload();
								
							} else{
								$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							}
	                        console.log(data.sql);//TO DO mensagem OK
						},
						"json"
					);
				}
				if($("#emp_altera").val()==1){
						$.post("../controller/TRIEmpresas.php",{
						acao		: "altera_cli",
						emp_cod		: $("#sel_empresa").val(),
						emp_nome	: $("#emp_nome").val(),
						emp_tel		: $("#emp_tel").val(),
						emp_res		: $("#emp_res").val()
						},
						function(data){
							if(data.status=="OK"){
								$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
								$('#spload').fadeOut('slow');
								$("#cad_sol")[0].reset();
								$("#slc").load("vis_solic.php").fadeIn("slow");
								$("#bt_solic").html("<i class='fa fa-cog fa-fax'></i> Solicitar");
								//location.reload();
								
							} else{
								$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							}
	                        console.log(data.sql);//TO DO mensagem OK
						},
						"json"
					);
				}
		});
	/*---------------|ENTRADA DE LIGAÇÕES|-------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_ent", function(){
	        var container = $("#formerros1");
			$("#cad_sol").validate({
	            debug: true,
	            errorClass: "error",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                emp_nome: {required: true},
	                //emp_tel	: {required: true},
	                emp_res	: {required: true},
	                emp_fcom: {required: true}
	            },
	            messages: {
	                emp_nome: {required: "Digite o Nome da Empresa"},
					//emp_tel	: {required: "Informe o telefone da empresa"},
	                emp_res	: {required: "Informe o respons&aacute;vel pela empresa"},
	                emp_fcom: {required: "Informe o nome do contato"}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
				if($("#cad_sol").valid()==true){
					$("#bt_ent").html("<i class='fa fa-cog fa-spin'></i> Processando...");
					$.post("../controller/TRIEmpresas.php",{
						acao		: "ligacao",
						emp_nome	: $("#emp_nome").val(),
						emp_tel		: $("#emp_tel").val(),
						emp_res		: $("#emp_res").val(),
						emp_fcom	: $("#emp_fcom").val(),
						emp_pres	: ($("#emp_pres").is(":checked")?1:0),
						emp_obs		: $("#emp_obs").val()
						},
						function(data){
							if(data.status=="OK"){
								$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
								$("#cad_sol")[0].reset();
								$("#bt_ent").html("<i class='fa fa-check'></i> Atendido");
								$("#slc_e").fadeOut();
								$("#slc_e").load("vis_solic_entra.php").fadeIn("slow");
								//location.reload();
								
							} else{
								$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							}
	                        console.log(data.sql);//TO DO mensagem OK
						},
						"json"
					);
				}
		});
	/*---------------|ENVIAR MENSAGEM DO CHAT|---------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	\*-------------------------------------------------------------*/
		$("#message").on("keypress",function(e){
			
			var tecla = (e.keyCode?e.keyCode:e.which);
			if(tecla == 13){
				$("#btChatEnvia").trigger("click");
			}
		});
	/*---------------|SELEÇÃO DE EMPRESAS DO SOLIC.PHP|------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	\*-------------------------------------------------------------*/
		$("#sel_empresa").on("change", function(){
			tipo = "fa fa-spinner fa-spin";
			// limpa as caixas...
			$("#emp_nome").val('...');
			$("#emp_tel").val('...');
			$.post("../controller/TRIEmpresas.php",{
				acao		: "consulta",
				sel_empresa	: $("#sel_empresa").val()
				},
				function(data){
					if(data.st=="OK"){
						$("#emp_nome").val(data.empresa);
						$("#emp_tel").val(data.telefone);
						$("#emp_res").val(data.responsavel);
						$("#emp_det").html('');
						$("#emp_det").html(data.detalhes);

					} 
					
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		});
	/*---------------|AÇÕES AS LIGAÇÕES|---------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	\*-------------------------------------------------------------*/
		// trecho para os botoes de solicitação de ligações
		$(document.body).on("click",".alink",function(e){
			e.preventDefault;
			tipo = "fa fa-spinner fa-spin";
			$.post("../controller/TRIEmpresas.php",{
				acao	: "realizar",
				action	: $(this).data('action'),
				solic	: $(this).data('solic')
				},
				function(data){
					if(data.status=="OK"){
						$("#msg_conf").text("Status alterado para "+data.status);
						$("#slc").fadeOut();
						$("#slc").load("vis_solic.php").fadeIn("slow");
						//location.reload();
					} 
					else{
						$("#msg_conf").text("Status alterado para "+data.status);
						$("#slc").fadeOut();
						$("#slc").load("vis_solic.php").fadeIn("slow");
						//location.reload();
					}
					
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		});
	/*---------------|RECEBER DOCUMENTOS|--------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/03/2016											|
	| ALTERAÇÂO CLEBER MARRARA PRADO 15/03/2016
	| BOTAO PARA ALTERAÇÃO DO STATUS DE RECIBO DE DOCS
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".dlink",function(e){
			e.preventDefault;
			tipo = "fa fa-spinner fa-spin";
			$.post("../controller/TRIEmpresas.php",{
				acao	: "recebe_doc",
				action	: $(this).data('action'),
				solic	: $(this).data('solic')
				},
				function(data){
					if(data.status=="OK"){
						$("#msg_conf").text("Status alterado para "+data.status);
						$("#doc_report").fadeOut();
						$("#doc_report").load("vis_docs.php").fadeIn("slow");
						$("#pes_docs").trigger("click");//location.reload();
					} 
					else{
						$("#msg_conf").text("Status alterado para "+data.status);
						$("#doc_report").fadeOut();
						$("#doc_report").load("vis_docs.php").fadeIn("slow");
						//location.reload();
					}
					
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
		});

	/*---------------|RELATÓRIO DE DOCUMENTOS|---------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/03/2016											|
	| ALTERAÇÃO - RELATORIO DE DOCUMENTOS QUE PERMITE A BAIXA DE  	|
	| DOCS MAIS ANTIGOS												|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#pes_docs",function(e){
			e.preventDefault;
			var token= $("#token").val();
			var di = $("#doc_dtini").val();
			var df = $("#doc_dtfim").val();
			var stat = $("#doc_stat").val();
			var depar = $("#doc_depar").val();
			$("#pes_docs").html("<i class='fa fa-spin fa-spinner'></i> Aguarde...");
			$("#doc_report").load("vis_docs.php?token="+token+"&di="+di+"&df="+df+"&depar="+depar+"&stat="+stat,
				function(){
					$("#pes_docs").html("<i class='fa fa-search'></i>");
				});
		});

	/*---------------|CONF NAO|------------------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	11/11/2016											|
	| Limpa as mensagens armazenadas em msgConf						|
	\*-------------------------------------------------------------*/
		$(document.body).on("click", "#confNao", function(){
			$("#msg_conf").html("");
		});

	/*---------------|IMPOSTO DE RENDA|----------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	02/2016												|
	| trecho para os botoes de IRPF 								|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".irpflink",function(e){
			var container = $("#formerros_ocorr");
			e.preventDefault;
			$("#ir_ocorr").validate({
	            debug: true,
	            errorClass: "error",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                ir_acao	:{required:true},
	                iret_cotas: 	{required: true},
		            iret_valor: 	{required: true}
		            
	            },
	            messages: {
	                ir_acao :{required:"Escolha uma a&ccedil;&atilde;o para o imposto"} ,
	                iret_cotas: {required: "Num de cotas deve ser informado"},
		            iret_valor: {required: "Digite o Valor do retorno."}
		            
	            }
	        });
			
			if($("#ir_ocorr").valid()==true){
				$("#bt_salvar_ocorr").html("<i class='fa fa-cog fa-spin'></i> Processando...");
				$.post("../controller/TRIEmpresas.php",{
					acao	: "registra_ocorrencia",
					irh_id	: $("#ir_cod").val(),
					irh_obs	: $("#ir_obs").val() ,
					irh_pend: ($("#ck_pend").is(":checked")?1:0)
					},
					function(data){
						if(data.status=="OK"){
							//altera o status tal qual url
							$("#irrf_cLi_Oc").fadeOut();
							$("#irrf_cli_Oc .box-body").load("irpf_conOcorr.php?ircod="+$("#ir_cod").val()).fadeIn("slow");
							//$("#ir_ocorr")[0].reset();
							$("#bt_salvar_ocorr").html("<i class='fa fa-save'></i> Salvar");
							$("<span></span>").html("Deseja alterar o status da solicita&ccedil;&atilde;o?").appendTo("#msg_conf");
							$("#confSim").addClass("simIrpf");
							$("#confirma").modal("show");
						} 
						
						else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						}
						
						console.log(data.sql);//TO DO mensagem OK
					},
					"json"
				);
			}
			
		});
	/*---------------|SIM IRPF|------------------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	02/2016												|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".simIrpf",function(e){
			e.preventDefault;
			$.post("../controller/TRIEmpresas.php",{
				acao	: "alteracao_IR",
				codigo	: $("#bt_salvar_ocorr").data('codigo'),
				solic	: $("#bt_salvar_ocorr").data('solic'),
				irid 	: $("#iret_irid").val(),
				tipo 	: $("#iret_tipo").val(),
				valor	: $("#iret_valor").val(),
				cotas 	: $("#iret_cotas").val(),
				pagto 	: $("#iret_pagto").val(),
				dtlib 	: $("#iret_data").val()
				},
				function(data){
					
					if(data.status=="OK"){
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-check"></i> Alterado OK - ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						$("#confirma").modal("hide");
						$("#bt_salvar_ocorr").addClass("hide");
						$("#cancel_IR").addClass("hide");
						$("#voltar_IR").removeClass("hide");

					} 
					else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
					}
					console.log(data.ir_solic);//TO DO mensagem OK
				},
				"json"
			);
		});
	/*---------------|CHAT ENVIA|----------------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	02/2016												|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#btChatEnvia",function(){
			if($("#para").val()==0 || $("#message").val()==""){
				alert("Selecione um destinatário / escreva uma mensagem");
			}
			else{
				$("#btChaEnvia").attr("disabled",true).html("Enviando... <i class='fa fa-spinner fa-spin'></i>");
				$.post("../controller/TRIEmpresas.php",{
				acao		: "ChatEnvia",
				usu_cod		: $("#usu_cod").val(),
				para		: $("#para").val(),
				mensagem	: $("#message").val()
				},
				function(data){
					if(data.status=="OK"){
						$("#message").val("");
						$("#btChatEnvia").attr("disabled",false).html("Enviar");
						$("#chatContent").load(location.href+" #msgs");
						//location.reload();
					} 
					else{
						alert("NOK");
						//location.reload();
					}
				},
				"json"
			);
			}
			$("#chatContent").scrollTop($("#msgs").height());
		});
	/*---------------|AÇÃO DO RELATÓRIO DE LIGAÇÕES|---------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	\*-------------------------------------------------------------*/
		$("#rel_tbl").on("change", function(){
			if($(this).val()=="tri_solic"){
				$("#selec").removeClass("hide");
				$("#selec1").addClass("hide");
			}
			else{
				$("#selec").addClass("hide");
				$("#selec1").removeClass("hide");
			}
		});
	/*---------------|RELATORIO DE LIGAÇÕES|-----------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_ver", function(){
			var tabela 	= $("#rel_tbl").val();
			if(tabela == ""){
				alert("Preencha o campo Tabela!");
			}
			else{
				$(this).html("<i class='fa fa-spin fa-spinner'></i> Gerando...");
				var di 		= $("#rel_di").val();
				var df 		= $("#rel_df").val();
				var atend 	= $("#rel_nome").val();
				var solic	= "";
				if($("#rel_tbl").val() == "tri_solic"){ solic = $("#rel_solic").val();}
				else{ solic = $("#rel_solic1").val();}
				var pres	= $("#rel_pres").val();
				$("#rls").load('corpo_rel.php?tabela='+tabela+'&di='+di+'&df='+df+'&atend='+atend+'&solic='+solic+'&pres='+pres);
				$("#bt_print").attr({
					'href':'rel_print.php?tabela='+tabela+'&di='+di+'&df='+df+'&atend='+atend+'&solic='+solic+'&pres='+pres
				});
				$("#bt_excel").attr({
					'href':'rel_excel.php?tabela='+tabela+'&di='+di+'&df='+df+'&atend='+atend+'&solic='+solic+'&pres='+pres
				});
				console.log('corpo_rel.php?tabela='+tabela+'&di='+di+'&df='+df+'&atend='+atend+'&solic='+solic+'&pres='+pres);			
			}
			$(this).html("<i class='fa fa-pie-chart'></i> Gerar Relatorio");
		});
	/*---------------|RELATORIOS DE DOCUMENTOS|--------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	19/10/2016											|
	\*-------------------------------------------------------------*/	
		$("#bt_ver_docs").on("click", function(){
			
			var emp 	= $("#drel_emp").val();
			var ref		= $("#drel_ref").val();
			var por		= $("#drel_por").val();
			var dep 	= $("#drel_dep").val();
			var din		= $("#drel_di").val();
			var dif 	= $("#drel_df").val();
			
			$("#rls").load('docs_rel.php?emp='+emp+'&ref='+ref+'&por='+por+'&dep='+dep+'&di='+din+'&df='+dif);
			$("#bt_print").attr({
				'href':'rel_docs_print.php?emp='+emp+'&ref='+ref+'&por='+por+'&dep='+dep+'&di='+din+'&df='+dif
			});
			$("#bt_docs_excel").attr({
				'href':'rel_docs_excel.php?emp='+emp+'&ref='+ref+'&por='+por+'&dep='+dep+'&di='+din+'&df='+dif
			});				
		});

	/*---------------|RELATORIOS DE SAÍDAS|------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	19/10/2016											|
	\*-------------------------------------------------------------*/
		$("#bt_ver_saidas").on("click", function(){
			
			var emp 	= $("#sai_emp").val();
			var din		= $("#dsai_di").val();
			var dif 	= $("#dsai_df").val();
			var sts 	= $("#sai_status").val();
			$("#rls").load('saidas_rel.php?emp='+emp+'&di='+din+'&df='+dif+'&stat='+sts);
			$("#bt_printsaidas").attr({
				'href':'rel_saidas_print.php?emp='+emp+'&di='+din+'&df='+dif+'&stat='+sts
			});
			$("#bt_saidas_excel").attr({
				'href':'rel_saidas_excel.php?emp='+emp+'&di='+din+'&df='+dif+'&stat='+sts
			});				
		});
	/*---------------|IMPOSTO DE RENDA|----------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - Cleber Marrara Prado - 29/02/2016
	| Codigo do status do evento atribuido para 
	| $("#bt_salvar_ocorr").data('solic')
	\*-------------------------------------------------------------*/
		$("#ir_acao").on("change", function(){
			$("#bt_salvar_ocorr").data('solic', $(this).val());
			console.log($("#bt_salvar_ocorr").data('solic'));
		});
	/*---------------|ALTERAÇÃO DO IR|-----------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - Cleber Marrara Prado - 29/02/2016
	| Botao para alterar o valor e o complemento dos campos do 
	| IR no codigo correspondente
	\*-------------------------------------------------------------*/
		$("#bt_altera_ir").on("click", function(){
			$(this).html("<i class='fa fa-spinner fa-spin'></i> Alterando...");
			$.post("../controller/TRIEmpresas.php",{
				acao	: "altera_IR",
				ir_cod		: $("#ir_cod").val(),
				ir_valor	: $("#ir_valor").val(),
				ir_compl	: $("#ir_compl").val(),
				ir_tipo		: $("#ir_tipo").val()
				},
				function(data){
					if(data.status=="OK"){
						$("#bt_altera_ir").html("<i class='fa fa-pencil'></i> Alterar");
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-check"></i> Alterado OK - ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						
					} 
					else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
					}
					
					console.log(data.ir_solic);//TO DO mensagem OK
				},
				"json"
			);
		});
	/*---------------|ALTERAÇÃO DO IR|-----------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - Cleber Marrara Prado - 07/03/2016
	| Botao para alterar ou caastrar os dados do usuário
	\*-------------------------------------------------------------*/
		$("#bt_altera_func").on("click", function(){
			$(this).html("<i class='fa fa-spinner fa-spin'></i> Alterando...");
			$.post("../controller/TRIEmpresas.php",{
				acao		: "altera_perfil",
				escol 		: $("#escol").val(),
				cep 		: $("#cep").val(),
				log 		: $("#log").val(),
				num 		: $("#num").val(),
				compl 		: $("#compl").val(),
				bai 		: $("#bai").val(),
				cid 		: $("#cid").val(),
				uf 			: $("#uf").val(),
				data 		: $("#data").val(),
				notas 		: $("#notas").val(),
				usu_email	: $("#usu_email").val(),
				usu_cor		: $("#usu_cor").val()

				},
				function(data){
					if(data.status=="OK"){
						$("#bt_altera_func").html("<i class='fa fa-pencil'></i> Alterar");
						$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-check"></i> Alterado OK - ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						location.reload();
					} 
					else{
						$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
					}
					
					console.log(data.mensagem);//TO DO mensagem OK
				},
				"json"
			);
		});
	/*---------------|ALTERAÇÃO DE SENHAS DOS USUÁRIOS DO PORTAL|--*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - Cleber Marrara Prado - 07/03/2016
	| Botao para alterar senhas de usuário
	\*-------------------------------------------------------------*/
		$("#bt_alt_senha").on("click", function(){
			var container = $("#formerros_senha");
			$("#alt_senha").validate({
	            debug: true,
	            errorClass: "error",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                sen_atual	: {required: true},
	                sen_nova	: {required:true},
	                rsen_nova	: {equalTo:"#sen_nova"}

	            },
	            messages: {
	                sen_atual: {required: "A senha atual deve ser digitada"},
	                sen_nova : {required: "Digite uma nova senha"},
	                rsen_nova: {equalTo: "As senhas devem coincidir!"}
	            }
	        });
			
			if($("#alt_senha").valid()==true){
				$(this).html("<i class='fa fa-cog fa-spin'></i> Processando...");
				$.post("../controller/TRIEmpresas.php",{
					acao	: "Altera_Senha",
					senha	: $("#senhaatual").val(),
					nsenha	: $("#sen_nova").val() 
					},
					function(data){
						if(data.status=="OK"){
							//altera o status tal qual url
							$("#bt_alt_senha").html("<i class='fa fa-pencil'></i> Alterar");
							$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-check"></i> Alterado OK - ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta2");
							location.reload();
							
						} 
						
						else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta2");	
							$("#bt_alt_senha").html("<i class='fa fa-pencil'></i> Alterar");
						}
						
						console.log(data.sql);//TO DO mensagem OK
					},
					"json"
				);
			}

		});
	/*---------------|DOCUMENTOS|----------------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - 09/03/2016 - Cleber Marrara Prado
	| Inserir docs no banco de dados
	\*-------------------------------------------------------------*/
		$("#bt_doc_ent").on("click", function(){
			var container = $("#formerros_docs");
			//e.preventDefault;
			$("#doc_entrada").validate({
	            debug: true,
	            errorClass: "error",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                sel_docs : {required: true},
	                sel_dep : {required: true},
	                doc_ref : {required: true}
	            },
	            messages: {
	                sel_docs : {required: "Selecione um Documento "},
	                sel_dep : {required: "Selecione um Departamento"},
	                doc_ref : {required: "Informe a data de refer&ecirc;ncia"} 
	            }
	        });
			
			if($("#doc_entrada").valid()==true){
				$("#bt_doc_ent").html("<i class='fa fa-cog fa-spin'></i> Processando...");
				$.post("../controller/TRIEmpresas.php",{
					acao	: "entra_docs",
					doc 	: $("#sel_docs").val(),
					emp 	: $("#sel_emp").val(),
					dep 	: $("#sel_dep").val(),
					res 	: $("#sel_resp").val(),
					obs 	: $("#doc_obs").val(),
					ref 	: $("#doc_ref").val()
					},
					function(data){
						if(data.status=="OK"){
							//altera o status tal qual url
							$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							$("#doc_entrada")[0].reset();
							$("#slc").load("vis_docs.php").fadeIn("slow");
							$("#bt_doc_ent").html("<i class='fa fa-folder-open'></i> Receber (em outro Departamento)");

						} 
						
						else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						}
						
						console.log(data.sql);//TO DO mensagem OK
					},
					"json"
				);
			}
		});
	/*---------------|DOCUMENTOS|----------------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - 09/03/2016 - Cleber Marrara Prado
	| Combo box de funcionários de acordo com o departamento 
	| escolhido
	\*-------------------------------------------------------------*/
		$("#sel_dep").on("change", function(){
			$('#sel_resp option[value!=0]').remove();
			$('#sel_resp').val(0);

			$.post("../controller/TRIEmpresas.php",
				{
					acao : "combo_dep",
					id_dep: $(this).val()
				},
				function(data){
					$("#sel_resp").append(data);
					console.log(data);
				},
				"html"
			);
		});
	/*---------------|CALENDÁRIO|----------------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 														|
	| Alteração - 27/04/2016 - Cleber Marrara Prado
	| Inserir docs no banco de dados
	\*-------------------------------------------------------------*/
		$("#bt_cal_alt").on("click", function(){
			var container = $("#formerros3");
			//e.preventDefault;
			$("#cal_alt").validate({
	            debug: true,
	            errorClass: "error",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                vcal_datai : {required: true},
	                vcal_dataf : {required: true}
	            },
	            messages: {
	                vcal_datai : {required: "Data inicial Obrigat&oacute;ria "},
	                vcal_dataf : {required: "Data final Obrigat&oacute;ria"}
	            }
	        });
			
			if($("#cal_alt").valid()==true){
				$("#bt_cal_alt").html("<i class='fa fa-cog fa-spin'></i> Processando...");
				$.post("../controller/TRIEmpresas.php",{
					acao	: "alt_calendario",
					dataini : $("#vcal_datai").val(),
					datafim	: $("#vcal_dataf").val(),
					horaini	: $("#vcal_horai").val(),
					horafim	: $("#vcal_horaf").val(),
					eveusu 	: $("#vcal_eveusu").val(),
					obs 	: CKEDITOR.instances.vcal_obs.getData(),
					calid 	: $("#vcal_id").val()
					},
					function(data){
						if(data.status=="OK"){
							//altera o status tal qual url
							$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							$("#bt_cal_alt").html("<i class='fa fa-pencil'></i> Alterar");

						} 
						
						else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						}
						
						console.log(data.sql);//TO DO mensagem OK
					},
					"json"
				);
			}
		});
	/*------------------------|CONTROLE DE HORAS|------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	02/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_horas", function(){
			var container = $("#formerros1");
			//e.preventDefault;
			$("#cad_hora").validate({
	            debug: true,
				errorClass: "has-error",
	            validClass: "has-success",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                ch_colab : {required: true},
	                ch_data : {required: true},
	                ch_hora_saida : {required: true}
	            },
	            messages: {
	                ch_colab 		: {required: "Escolha um colaborador!"},
	                ch_data 		: {required: "Data da sa&iacute;da obrigat&oacute;ria!"},
	                ch_hora_saida 	: {required: "Hora da sa&iacute;da obrigat&oacute;ria!"}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
	        if($("#cad_hora").valid()==true){
				$("#bt_horas").html("<i class='fa fa-cog fa-spin'></i> Processando...");
				$.post("../controller/TRIEmpresas.php",{
					acao 			: "controle_horas",
					ch_colab		: $("#ch_colab").val(),
					ch_data			: $("#ch_data").val(),
					ch_hora_saida	: $("#ch_hora_saida").val(),
					},
					function(data){
						if(data.status=="OK"){
							//altera o status tal qual url
							$("#slc").load("vis_controlehora.php").fadeIn("slow");
							$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");

						} 
						
						else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						}
						console.log(data.sql);//TO DO mensagem OK
					},
					"json"
				);
			}
			$("#bt_horas").html("<i class='fa fa-save'></i> Salvar");

		}); // Utilizando document.body para referencias dinâmicas
	/*---------------|EXCLUIR APONTAMENTO DE HORA|-----------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	02/06/2016											|
	\*-------------------------------------------------------------*/
		
		/*|COM A CLASSE excHoras, FAZER A EXCLUSÃO DO BD|*/
		$(document.body).on("click",".excHoras",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_horas",
				ch_id: cod
			},
			function(data){
				if(data.status=="OK"){
					alert(data.mensagem);
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|VALIDAR APONTAMENTO DE HORA|-----------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	02/06/2016											|
	\*-------------------------------------------------------------*/
		/*$(document.body).on("click","#bt_altch",function(){
			cod = $("#bt_altch").data("reg");
			$("<span></span>").html("Deseja validar o apontamento "+cod+"?").appendTo("#msg_conf");
			$("#confSim").addClass("altHoras");
			$("#confirma").modal("show");
		});

		/*|COM A CLASSE althoras, FAZER A EXCLUSÃO DO BD|*/
		$(document.body).on("click",".althoras",function(){
			console.log("CLICK OK");
			$.post("../controller/TRIEmpresas.php",{
				acao: "valida_horas",
				ch_id: $(this).data("reg")
			},
			function(data){
				if(data.status=="OK"){
					alert(data.mensagem);
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|CADASTRAR SERVIÇO MOTORISTA|-----------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	08/06/2016											|
	\*-------------------------------------------------------------*/

		$(document.body).on("click","#bt_addserv", function(){
			var container = $("#formerros1");
			//e.preventDefault;
			$("#cad_servicos").validate({
	            debug: true,
				errorClass: "has-error",
	            validClass: "has-success",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                serv_cli : {required: true},
	                editor1: {required: true}
	            },
	            messages: {
	                serv_cli : {required: "Escolha uma empresa!"},
	                editor1: {required: "Escreva algo sobre esse item..."}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
	        if($("#cad_servicos").valid()==true){
				$("#bt_addserv").html("<i class='fa fa-cog fa-spin'></i> Processando...");
				$.post("../controller/TRIEmpresas.php",{
					acao 		: "inclui_servico",
					serv_cli	: $("#serv_cli").val(),
					serv_obs	: CKEDITOR.instances.editor1.getData()
					},
					function(data){
						if(data.status=="OK"){
							//altera o status tal qual url
							$("#slc").load("vis_servs.php").fadeIn("slow");
							$("#cad_servicos")[0].reset();
							$("#serv_cli").select2('val', "");
							CKEDITOR.instances.editor1.setData('');
							$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");

						} 
						
						else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						}
						console.log(data.sql);//TO DO mensagem OK
						$("#bt_addserv").html("<i class='fa fa-plus'></i> Incluir");
					},
					"json"
				);
			}
			
		});
	/*---------------|GERAR SAÍDAS DE SERVIÇOS|--------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	09/06/2016											|
	\*-------------------------------------------------------------*/
		$("#ger_venc").on("keyup",function(){
			//$("#gerar_saida").html($("#ger_venc").val().length);
			if($(this).inputmask("isComplete") ){
				$("#gerar_saida").attr("disabled",false);
			}
			else{
				$("#gerar_saida").attr("disabled",true);
				
			}
		});

		$("#gerar_saida").on("click", function () {
			$(this).html("<i class='fa fa-spinner fa-spin'></i> Gerando...");
			// solução para pegar todos os check de IR marcados para a geraçao do boleto
			var checkeditems = $('input:checkbox[name="serv_cods[]"]:checked')
	                       .map(function() { return $(this).val() })
	                       .get()
	                       .join(",");
	        if(checkeditems==""){
	        	alert("Escolha o serviço que deseja listar!");
	        	
	        }
	        else{
				$.post("../controller/TRIEmpresas.php",
					{
						acao : "gerar_saida",
						servs : checkeditems,
						servn : $("#ger_venc").val()
					},
					function(data){
						if(data.status=="OK"){
								$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
								location.reload();
								
							} else{
								$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							}
			                console.log(data.sql);//TO DO mensagem OK
			                $("#gerar_saida").html("<i class='fa fa-print'></i> Gerar Sa&iacute;da");
					},
					"json"
				);
	        }
		$("#gerar_saida").html("<i class='fa fa-print'></i> Gerar Sa&iacute;da");
		});
	/*---------------|EXCLUIR SAÍDAS DE SERVIÇOS|------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".exc_Saida",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_saidas",
				said_id: cod
			},
			function(data){
				if(data.status=="OK"){
					alert(data.mensagem);
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|REALIZAR SAÍDAS DE SERVIÇOS|-----------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".Realizar_Saida",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIEmpresas.php",{
				acao: "real_saidas",
				said_id: cod
			},
			function(data){
				if(data.status=="OK"){
					alert(data.mensagem);
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|EXCLUIR ITENS DE SERVIÇOS|-------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".excItem",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_itens",
				ser_id: cod
			},
			function(data){
				if(data.status=="OK"){
					alert(data.mensagem);
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|EXCLUIR SAÍDAS DE SERVIÇOS|------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".exc_Item",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_item",
				ser_id: cod
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|BAIXAR ITENS DE SERVIÇOS|--------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".baixa_Serv",function(){
			console.log("CLICK OK");
			cod = $(".baixa_Serv").data('reg');
			$.post("../controller/TRIEmpresas.php",{
				acao: "save_item",
				ser_id: cod,
				ser_obs: "OK, entregue com sucesso!"
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|RELISTAR ITENS DE SERVIÇOS|-------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#btn_relistItem",function(){
			console.log("CLICK OK");
			var token = $("#token").val();
			var lista = $("#lista").val();
			cod = $("#ser_id").val();
			$.post("../controller/TRIEmpresas.php",{
				acao: "relist_item",
				ser_id: cod,
				ser_obs: $("#ser_obs").val()
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					$(location).attr('href','servicos.php?token='+token);
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|COMPLETAR SERVIÇOS|--------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	14/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#completa_Serv",function(){
			console.log("CLICK OK");
			var token = $("#token").val();
			var lista = $("#lista").val();
			
			$.post("../controller/TRIEmpresas.php",{
				acao: "comp_saida",
				said_id: lista
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					$(location).attr('href','serv_lista_saidas.php?token='+token);
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|CANCELAR SERVIÇOS|---------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	14/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#canc_Serv",function(){
			console.log("CLICK OK");
			var token = $("#token").val();
			var lista = $("#lista").val();
			
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_saidas",
				said_id: lista
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					$(location).attr('href','serv_lista_saidas.php?token='+token);
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|PESQUISA DE HORAS|---------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	14/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click", "#pes_chora", function(){
			$(this).html("<i class='fa fa-spin fa-refresh'></i>");
			var chr_dep 	= $("#chr_dep").val();
			var chr_nome 	= $("#chr_nome").val();
			var chr_data 	= $("#chr_data").val();
			var chr_dataf 	= $("#chr_dataf").val();
			var token 		= $("#token").val();
			var link = "controle_horas.php?token="+token;
			if(chr_dep != ""){link=link+"&chr_dep="+chr_dep;}
			if(chr_nome != ""){link=link+"&chr_nome="+chr_nome;}
			if(chr_data != ""){link=link+"&chr_data="+chr_data;}
			if(chr_dataf != ""){link=link+"&chr_dataf="+chr_dataf;}
			
			$(location).attr("href",link);
		});
	/*---------------|EXCEL PARA CONTROLE DE HORAS|----------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	27/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#btn_RelHora",function(){
			var dep = $("#dep").val();
			var col = $("#cola").val();
			var data = $("#data").val();
			var dataf = $("#dataf").val();
			console.log("../rel/rel_horas.php?chr_dep="+dep+"&chr_nome="+col+"&chr_data="+data+"&chr_dataf="+dataf);
			location.href = "../rel/rel_horas.php?chr_dep="+dep+"&chr_nome="+col+"&chr_data="+data+"&chr_dataf="+dataf;
		});
    /*---------------|CADASTRAR USUARIOS|----------------------*\
	| Author: 	Elvis Leite 				                 	|
	| Version: 	1.0 			            					|
	| Email: 	elvis7t@gmail.com 						        |
	| Date: 	15/10/2016									    |	
	\*---------------------------------------------------------*/
		$(document.body).on("click","#btn_cadUsu", function(){
			var container = $("#formerrosUsu");
			//e.preventDefault;
			$("#cadUsu").validate({
	            debug: true,
				errorClass: "has-error",
	            validClass: "has-success",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                usu_nome 	: {required: true},
	                usu_cpf 	: {required: true},
	                usu_email 	: {required: true, email:true},
	                usu_senha 	: {required: true},
	                usu_csenha 	: {required: true, equalTo:"#usu_senha"},
	                sel_class 	: {required: true},
	                sel_depto 	: {required: true},
	                sel_lider 	: {required: true},
	                usu_ramal 	: {required: true, maxlength:3},
	                usu_pausa 	: {required: true}
	            },
	            messages: {
	                usu_nome 	: {required: "Digite o nome do usuário"},
	                usu_cpf 	: {required: "Digite o cpf do usuário"},
	                usu_email 	: {required: "Digite um E-mail valido", email:"Email Invalido"},
	                usu_senha 	: {required: "Digite uma senha"},
	                usu_csenha 	: {required: "Confrme a senha", equalTo:"As senhas não coincidem"},
	                sel_class 	: {required: "Selecione uma Classe"},
	                sel_depto 	: {required: "Selecione um departamento"},
	                sel_lider 	: {required: "Selecione um o"},
	                usu_ramal 	: {required: "Digite o ramal de usuário", maxlength:"Numero invalido"},
	                usu_pausa 	: {required: "Escolha uma das pausas"}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
	        if($("#cadUsu").valid()==true){
				$("#btn_cadUsu").html("<i class='fa fa-cog fa-spin'></i> Processando...");
				$.post("../controller/TRIEmpresas.php",{
					acao 		: "inclui_usuario",
					usu_nome 	: $("#usu_nome").val(),
					usu_cpf 	: $("#usu_cpf").val(),
					usu_email 	: $("#usu_email").val(),
					usu_senha 	: $("#usu_senha").val(),
					sel_class 	: $("#sel_class").val(),
					sel_depto 	: $("#sel_depto").val(),
					sel_lider 	: $("#sel_lider").val(),
					usu_ramal	: $("#usu_ramal").val(),
					usu_pausa	: $("#usu_pausa").val()
					},
					function(data){
						if(data.status=="OK"){
							//altera o status tal qual url
							location.reload();
							$("#cadUsu")[0].reset();
							$("#sel_class").select2('val', "");
							$("#sel_depto").select2('val', "");
							$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");

						} 
						
						else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						}
						console.log(data.sql);//TO DO mensagem OK
						$("#btn_cadUsu").html("<i class='fa fa-save'></i> Salvar");
					},
					"json"
				);
			}
			
		});
	/*----------|CONSULTAR HORAS DO CONTROLE|------------------*\
	| Author: 	Cleber MARRARA 									|
	| Version: 	1.0 			            					|
	| Email: 	cleber.marrara.prado@gmail.com 					|
	| Date: 	31/10/2016									    |	
	\*---------------------------------------------------------*/
		$(document.body).on("click","#pes_dhoras", function(){
			$("#pes_dhoras").html("<i class='fa fa-cog fa-spin'></i> Processando...");
				if( $("#dhor_colab").val()==""){
					alert("Escolha um funcionário para a consulta!");
					$("#pes_dhoras").html("<i class='fa fa-search'></i>");
				}
				else{
					$.post("../controller/TRIEmpresas.php",{
						acao 		: "cons_horas",
						usu_cod 	: $("#dhor_colab").val()
						},
						function(data){
							//alert(data.sql);//TO DO mensagem OK
							$("#pes_dhoras").html("<i class='fa fa-search'></i>");
							if(data.status=="OK"){
								//altera o status tal qual url
								$("#dhor_disp").val(data.disp).replace(",",".");
								$("#dhor_desc").val("");
								$("#dhor_saldo").val("");
								$("#dhor_colab").attr("disabled",true);
							} 
							
							else{
								$("#dhor_disp").val(data.disp).replace(".",",");
								$("#dhor_desc").val("");
								$("#dhor_saldo").val("");
								$("#dhor_colab").attr("disabled",true);
								$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							}
						},
						"json"
					);
					var nusu = $("#dhor_colab").val();
					$("#slc").load("vis_deschoras.php?us="+nusu);
				}
		});
	/*|DESCONTO DE HORAS|*/
		$(document.body).on("keyup","#dhor_desc",function(){
			var n1, n2, disp;
			n1 = parseFloat($(this).val().replace(",","."));
			n2 = parseFloat($("#dhor_disp").val().replace(",","."));
			disp = n2 - n1;
			
			if(n1 > n2){
				alert("Não é possível descontar mais horas que o disponível");
				$("#dhor_disp").val(n2.toFixed(2).replace(".",","));
				$("#dhor_desc").val("");
				$("#dhor_saldo").val("");
			}
			else{
				$("#dhor_saldo").val(disp.toFixed(2).replace(".",","));
			}
		});
	/*|INCLUINDO DESCONTO|*/
		$(document.body).on("click","#desc_salvar", function(){
			var container = $("#formerrosDesc");
			//e.preventDefault;
			$("#desc_horas").validate({
	            debug: true,
				errorClass: "has-error",
	            validClass: "has-success",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                dhor_colab 	: {required: true},
	                dhor_desc	: {required: true},
	                dhor_obs 	: {required: true, minlength:10}
	            },
	            messages: {
	                dhor_colab 	: {required: "Escolha um usu&aacute;rio"},
	                dhor_desc	: {required: "Digite as horas a serem descontadas"},
	                dhor_obs 	: {required: "Justifique o desconto das horas", minlength:"M&iacute;nimo de 10 caracteres"}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
	        if($("#desc_horas").valid()==true){
				$("#desc_salvar").html("<i class='fa fa-cog fa-spin'></i> Processando...");
				$.post("../controller/TRIEmpresas.php",{
					acao 		: "desc_horas",
					dhor_colab 	: $("#dhor_colab").val(),
					dhor_desc 	: $("#dhor_desc").val(),
					dhor_obs 	: $("#dhor_obs").val()
					},
					function(data){
						if(data.status=="OK"){
							//altera o status tal qual url
							$("#slc").load("vis_deschoras.php").fadeIn("slow");
							$("#desc_horas")[0].reset();
							$("#dhor_colab").select2('val', "");
							$("#dhor_colab").attr("disabled",false);
							
							$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");

						} 
						
						else{
							$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");	
						}
						console.log(data.sql);//TO DO mensagem OK
						$("#desc_salvar").html("<i class='fa fa-save'></i> Salvar");
					},
					"json"
				);
			}
			
		});
	/*---------------|GERAR LISTA DE MATERIAIS|--------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	25/11/2016											|
	\*-------------------------------------------------------------*/
		$("#lismat_venc").on("keyup",function(){
			//$("#gerar_saida").html($("#ger_venc").val().length);
			if($(this).inputmask("isComplete") ){
				$("#gerar_lista").attr("disabled",false);
			}
			else{
				$("#gerar_lista").attr("disabled",true);
				
			}
		});

		$("#gerar_lista").on("click", function () {
			$(this).html("<i class='fa fa-spinner fa-spin'></i> Gerando...");
			// solução para pegar todos os check de IR marcados para a geraçao do boleto
			var checkeditems = $('input:checkbox[name="serv_cods[]"]:checked')
	                       .map(function() { return $(this).val() })
	                       .get()
	                       .join(",");
	        if(checkeditems==""){
	        	alert("Escolha o produto que deseja listar!");
	        	
	        }
	        else{
				$.post("../controller/TRIEmpresas.php",
					{
						acao : "gerar_lista",
						servs : checkeditems,
						servn : $("#lismat_venc").val()
					},
					function(data){
						if(data.status=="OK"){
								$("<div></div>").addClass("alert alert-success alert-dismissable").html('<i class="fa fa-flag-checkered"></i> '+data.mensagem+' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
								location.reload();
								
							} else{
								$("<div></div>").addClass("alert alert-danger alert-dismissable").html('<i class="fa fa-times"></i> Ocorreu um erro! ('+data.mensagem+')<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>').appendTo("#consulta");
							}
			                console.log(data.sql);//TO DO mensagem OK
			        },
					"json"
				);
	        }
		$("#gerar_lista").html("<i class='fa fa-print'></i> Gerar Lista");
		});
	/*---------------|REALIZAR COMPRAS MATERIAIS|------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	25/11/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".Saida_mat",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIEmpresas.php",{
				acao: "real_compmat",
				mlist_id: cod
			},
			function(data){
				if(data.status=="OK"){
					alert(data.mensagem);
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|EXCLUIR ITENS DE LISTA MAT|------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	25/11/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".exc_listaMat",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_Lista",
				mlist_id: cod
			},
			function(data){
				if(data.status=="OK"){
					alert(data.mensagem);
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|EXCLUIR ITENS DA LISTA|----------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	25/11/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click",".exc_ItensLista",function(){
			console.log("CLICK OK");
			cod = $(this).data("reg");
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_itensLista",
				mat_id: cod
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					location.reload();
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	
	/*---------------|RELISTAR ITENS DE SERVIÇOS|-------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	13/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#btn_relistItem",function(){
			console.log("CLICK OK");
			var token = $("#token").val();
			var lista = $("#lista").val();
			cod = $("#ser_id").val();
			$.post("../controller/TRIEmpresas.php",{
				acao: "relist_item",
				ser_id: cod,
				ser_obs: $("#ser_obs").val()
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					$(location).attr('href','servicos.php?token='+token);
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|COMPLETAR COMPRA|----------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	25/11/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#completa_lista",function(){
			console.log("CLICK OK");
			var token = $("#token").val();
			var lista = $("#lista").val();
			
			$.post("../controller/TRIEmpresas.php",{
				acao: "comp_lista",
				mlist_id: lista
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					$(location).attr('href','mat_listacmp.php?token='+token);
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|CANCELAR SERVIÇOS|---------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	14/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#canc_lista",function(){
			console.log("CLICK OK");
			var token = $("#token").val();
			var lista = $("#lista").val();
			
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_listas",
				mlist_id: lista
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					$(location).attr('href','mat_listacmp.php?token='+token);
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*-----------------|DELETAR EVENTO CALENDARIO|-----------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	02/12/2016											|
	\*-------------------------------------------------------------*/
		/*|APÓS CONFIRMACAO|*/
		$(document.body).on("click",".exc_evecal",function(){
			console.log("CLICK OK");
			var token = $("#token").val();
			var evento = $(this).data("reg");
			
			$.post("../controller/TRIEmpresas.php",{
				acao: "exclui_evecal",
				evecal: evento
			},
			function(data){
				if(data.status=="OK"){
					$("#confirma").modal("hide");
					$("#aguarde").modal("show");
					$(location).attr('href','calendar.php?token='+token);
				} 
				else{
					alert(data.mensagem);	
				}
			},
			"json");
		});
	/*---------------|RELATÓRIO DE IMPOSTOS ENVIADOS|--------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	30/03/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_ver_impenvios",function(e){
			var container = $("#formerrosimps");
			//e.preventDefault;
			$("#rels_imp").validate({
	            debug: true,
				errorClass: "has-error",
	            validClass: "has-success",
	            errorContainer: container,
	            errorLabelContainer: $("ol", container),
	            wrapper: 'li',
	            rules: {
	                imp_comp 	: {required: true, minlength:6}
	                
	            },
	            messages: {
	                imp_comp 	: {required: "Digite uma competência para o relatório", minlength:"Digite a competencia mm/aaaa"}
	            },
	            highlight: function(element) {
	        		$(element).closest('.form-group').addClass('has-error');
	    		},
	    		unhighlight: function(element) {
	        		$(element).closest('.form-group').removeClass('has-error');
	    		}
	        });
	        if($("#rels_imp").valid()==true){

				e.preventDefault;
				var token	= $("#token").val();
				var cod 	= $("#imp_empresa").val();
				var comp 	= $("#imp_comp").val();
				var dep 	= $("#imp_dep").val();
				var colab 	= $("#imp_colab").val();
				var mov 	= $("#imp_mov").val();
				var ger 	= $("#imp_ger").val();
				var conf 	= $("#imp_conf").val();
				var env  	= $("#imp_env").val();
				var tipo 	= $("#imp_tipo").val();
				var trib 	= $("#imp_trib").val();
				$("#bt_ver_impenvios").html("<i class='fa fa-spin fa-spinner'></i> Aguarde...");
				$("#bt_impenvios_excel").attr({
					"href":"imp_envios_excel.php?token="+token+"&emp="+cod+"&comp="+comp+"&dep="+dep+"&colab="+colab+"&mov="+mov+"&ger="+ger+"&conf="+conf+"&env="+env+"&tipo="+tipo+"&trib="+trib});
				$("#rls").load("imp_envios.php?token="+token+"&emp="+cod+"&comp="+comp+"&dep="+dep+"&colab="+colab+"&mov="+mov+"&ger="+ger+"&conf="+conf+"&env="+env+"&tipo="+tipo+"&trib="+trib,
					function(){
						$("#bt_ver_impenvios").html("<i class='fa fa-pie-chart'></i> Gerar Relatorio");
					});
			}
		});

});