$(document).on("ready", function(){
	
	var nome="";
	var tipo = "";
	/*AjaxStart e AjaxStop*/
	$(document).ajaxStart(function(){
		$('#'+nome).html("<i class='fa fa-spinner fa-spin'></i> Processando");
	});
	$(document).ajaxStop(function(){
		$('#'+nome).html(tipo);
	});

	/*---------------|NOVA MAQUINA NO PARQUE|----------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	17/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_newMaq",function(e){
			$(this).html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIMaquinas.php",{
				acao		: "nova_maquina",
				maq_ip		: $("#maq_ip").val(),
				maq_usuario	: $("#maq_login").val(),
				maq_user	: $("#maq_user").val(),
				maq_sistema	: $("#maq_sys").val(),
				maq_memoria	: $("#maq_mem").val(),
				maq_hd		: $("#maq_hd").val(),
				maq_tipo	: $("#maq_tipo").val()
				},
				function(data){
					if(data.status=="OK"){
						$("#slc").load("vis_maquinas.php").fadeIn("slow");
						$("#cad_maq")[0].reset();
						location.reload();
					} 
					else{
						$("#slc").load("vis_maquinas.php").fadeIn("slow");
					}
					
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
			//$(this).html("<i class='fa fa-cog fa-terminal'></i> Nova");
		});
	/*---------------|ALTERA MAQUINA NO PARQUE|--------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	23/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_altMaq",function(e){
			$(this).html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIMaquinas.php",{
				acao		: "altera_maquina",
				maq_ip		: $("#maq_ip").val(),
				maq_usuario	: $("#maq_login").val(),
				maq_user	: $("#maq_user").val(),
				maq_sistema	: $("#maq_sys").val(),
				maq_memoria	: $("#maq_mem").val(),
				maq_hd		: $("#maq_hd").val(),
				maq_tipo	: $("#maq_tipo").val()
				
				},
				function(data){
					if(data.status=="OK"){
						$("#slc").load("vis_maquinas.php").fadeIn("slow");
						$("#cad_maq")[0].reset();
						location.reload();
					} 
					else{
						$("#slc").load("vis_maquinas.php").fadeIn("slow");
					}
					
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
			//$(this).html("<i class='fa fa-cog fa-terminal'></i> Nova");
		});
	/*---------------|NOVO PERIFERICO|-----------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	22/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_newPer",function(){
			$(this).html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIMaquinas.php",{
				acao		: "novo_perif",
				per_maqid	: $("#per_assoc").val(),
				per_tipo	: $("#per_tipo").val(),
				per_modelo	: $("#per_modelo").val(),
				per_status	: $("#per_status").val(),
				per_ativo	: ($("#per_ativo").is(":checked") ? 1 :0)
				},
				function(data){
					if(data.status=="OK"){
						//$("#slc").load("vis_maquinas.php").fadeIn("slow");
						//$("#cad_maq")[0].reset();
						location.reload();
					} 
					else{
						$("#slc").load("vis_perifs.php").fadeIn("slow");
					}
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
			//$(this).html("<i class='fa fa-cog fa-terminal'></i> Novo");
		});
	/*---------------|ALTERA PERIFERICO|---------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	24/06/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_altPer",function(){
			$(this).html("<i class='fa fa-cog fa-spin'></i> Processando...");
			$.post("../controller/TRIMaquinas.php",{
				acao		: "altera_perif",
				per_maqid	: $("#per_assoc").val(),
				per_id		: $("#perid").val(),
				per_tipo	: $("#per_tipo").val(),
				per_modelo	: $("#per_modelo").val(),
				per_status	: $("#per_status").val(),
				per_ativo	: ($("#per_ativo").is(":checked") ? 1 :0)
				},
				function(data){
					if(data.status=="OK"){
						//$("#slc").load("vis_maquinas.php").fadeIn("slow");
						//$("#cad_maq")[0].reset();
						location.reload();
					} 
					else{
						$("#slc").load("vis_perifs.php").fadeIn("slow");
					}
					console.log(data.sql);//TO DO mensagem OK
				},
				"json"
			);
			//$(this).html("<i class='fa fa-cog fa-terminal'></i> Novo");
		});
	/*---------------|PESQUISA MAQUINA|----------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	16/09/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_search",function(){
			nome = "bt_search";
			tipo = "<i class='fa fa-search'></i>"
			var ip = $("#maq_ips").val();
			var user = $("#maq_users").val();
			var usua = $("#maq_usuario").val();
			var token = $("#token").val();
			console.log("vis_maquinas.php?ip="+ip+"&user="+user+"&usuario="+usua+"&token="+token);
			$("#sl").load("vis_maquinas.php?ip="+ip+"&user="+user+"&usuario="+usua+"&token="+token);
			
		});
	/*---------------|PESQUISA PERIFERICO|-------------------------*\
	| Author: 	Cleber Marrara Prado 								|
	| Version: 	1.0 												|
	| Email: 	cleber.marrara.prado@gmail.com 						|
	| Date: 	18/10/2016											|
	\*-------------------------------------------------------------*/
		$(document.body).on("click","#bt_searchp",function(){
			nome = "bt_searchp";
			tipo = "<i class='fa fa-search'></i>"
			var ip = $("#per_ips").val();
			var per = $("#txps").val();
			var token = $("#token").val();
			console.log("vis_perifericos.php?ip="+ip+"&tipo="+per+"&token="+token);
			$("#slc").load("vis_perifericos.php?ip="+ip+"&tipo="+per+"&token="+token);
			
		});
});