<?php
//sujeira embaixo do tapete :(
error_reporting(E_ALL & E_NOTICE & E_WARNING);

/*inclusão dos principais itens da página */
session_start("portal");
$sec = "CART";
$pag = "quadros.php";
require_once("../config/main.php");
require_once("../config/valida.php");
require_once("../config/mnutop.php");
require_once("../config/menu.php");
require_once("../config/modals.php");
require_once("../class/class.functions.php");
require_once("../class/class.permissoes.php");

?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Contagens
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li>Solicita&ccedil;&atilde;o</li>
				<li class="active">Contagens</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="row">

				<!-- Content for Popover #1 -->
				<div class="hidden" id="form-pop">
					<div class="popover-body">
						<div class="form-group">
							<label for="cont_imposto">Imposto:</label>
							<select class="select2 form-control sm" name="cont_imposto" id="cont_imposto">
								<option value=""></option>
								<?php
									$dep = "";
									$sql = "SELECT imp_id, imp_nome, imp_depto, dep_nome FROM tipos_impostos a
												JOIN departamentos b ON imp_depto = dep_id
											WHERE imp_id <> 0 ORDER BY imp_depto ASC, imp_nome ASC";
									$rs->FreeSql($sql);
									while($rs->GeraDados()):	
										if($rs->fld("dep_nome")!=$dep){
											$dep = $rs->fld("dep_nome");
											echo "<optgroup label = '".$dep."'>";
										}
										?>
											<option value="<?=$rs->fld("imp_id");?>"><?=$rs->fld("imp_nome");?></option>
										<?php
									endwhile;
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="cont_cor">Cor:</label>
							<div class="btn-group">
								<button class="btn btn-sm bg-aqua" onclick='color("bg-aqua")'></button>
								<button class="btn btn-sm bg-olive" onclick='color("bg-olive")'></button>
								<button class="btn btn-sm bg-yellow" onclick='color("bg-yellow")'></button>
								<button class="btn btn-sm bg-red" onclick='color("bg-red")'></button>
								<button class="btn btn-sm bg-blue" onclick='color("bg-blue")'></button>
								<button class="btn btn-sm bg-orange" onclick='color("bg-orange")'></button>
								<button class="btn btn-sm bg-purple" onclick='color("bg-purple")'></button>
							</div>	
						</div>
						<div class="form-group">
							<label for="cont_tam">Tamanho:</label>
							<div class="btn-group">
								<button class="btn btn-sm btn-primary" onclick='size("col-lg-3")'>3</button>
								<button class="btn btn-sm btn-primary" onclick='size("col-lg-4")'>4</button>
								<button class="btn btn-sm btn-primary" onclick='size("col-lg-5")'>5</button>
								<button class="btn btn-sm btn-primary" onclick='size("col-lg-6")'>6</button>
							</div>	
						</div>				 	
						<div class="form-group">
							<label for="cont_ico">Icone:</label>
							<div id="ico" class="btn-group">
								<a href="javascript:icone('fa fa-heart')" 	class="btn btn-sm btn-primary">		<i class="fa fa-heart"></i></a>
								<a href="javascript:icone('fa fa-globe')" 	class="btn btn-sm btn-primary">		<i class="fa fa-globe"></i></a>
								<a href="javascript:icone('fa fa-cog')" 	class="btn btn-sm btn-primary">		<i class="fa fa-cog"></i></a>
								<a href="javascript:icone('fa fa-user')" 	class="btn btn-sm btn-primary">		<i class="fa fa-user"></i></a>
								<a href="javascript:icone('fa fa-tag')" 	class="btn btn-sm btn-primary">		<i class="fa fa-tag"></i></a>
								<a href="javascript:icone('fa fa-flag-o')" 	class="btn btn-sm btn-primary">		<i class="fa fa-flag-o"></i></a>
								<a href="javascript:icone('fa fa-magnet')" 	class="btn btn-sm btn-primary">		<i class="fa fa-magnet"></i></a>
								<a href="javascript:icone('fa fa-thumbs-o-up')" class="btn btn-sm btn-primary">	<i class="fa fa-thumbs-o-up"></i></a>
								<a href="javascript:icone('fa fa-unlock')" 	class="btn btn-sm btn-primary">		<i class="fa fa-unlock"></i></a>
								<a href="javascript:icone('fa fa-balance-scale')" 	class="btn btn-sm btn-primary">		<i class="fa fa-balance-scale"></i></a>
								<a href="javascript:icone('fa fa-bomb')" 	class="btn btn-sm btn-primary">		<i class="fa fa-bomb"></i></a>
								<a href="javascript:icone('fa fa-bath')" 	class="btn btn-sm btn-primary">		<i class="fa fa-bath"></i></a>
								<a href="javascript:icone('fa fa-binoculars')" 	class="btn btn-sm btn-primary">		<i class="fa fa-binoculars"></i></a>
								<a href="javascript:icone('fa fa-bug')" 	class="btn btn-sm btn-primary">		<i class="fa fa-bug"></i></a>
							</div>	
								
						</div>
					</div>
				</div>

				<div class="col-xs-12">
					<div id="painel" class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Contagens do Painel</h3>
						</div>
						<div class="box-body sortable">
							
							
						</div>
						<div class="box-footer">
							<button class="btn btn-sm btn-success pull-right" id="btn_countsave"><i class="fa fa-save"></i></button>					
						</div>
					</div>
				</div>
				<div class="col-xs-12">
						<div id="painel_disp" class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Contagens Disponíveis</h3>
							</div><!-- /.box-header -->
							<div class="box-body sortable">
								<?php
								for($i=0; $i<12;$i++){ ?> 
									<div id="c<?=$i;?>" data-imposto="" data-icone="" data-cor="" data-tam="" class="col-lg-3 pop" data-toggle="popover" data-title="Configurar Quadro" data-placement="left" data-content="">
										<div class="info-box bg-aqua">
											
											<span class="info-box-icon"><i class="fa fa-tag"></i></span>
											<div class="info-box-content">
												<span class="info-box-text">Imposto</span>
												<span class="info-box-number">10</span>
												<div class="progress">
													
													<div class="progress-bar" style="width:30%"></div>
												</div>
												<span class="progress-description">
													de 100 (10,0%)
												</span>
											</div>
										</div>
									</div>
								<?php
									}
								?>	
							</div>
						</div><!-- ./box -->
				</div><!-- ./col -->		
	</section>
</div>
<?php
	require_once("../config/footer.php");
?>
</div><!-- ./wrapper -->


<script src="<?=$hosted;?>/sistema/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?=$hosted;?>/sistema/assets/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$hosted;?>/sistema/assets/dist/js/app.min.js"></script>
<!-- Slimscroll -->
<script src="<?=$hosted;?>/sistema/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/maskinput.js"></script>
<script src="<?=$hosted;?>/sistema/assets/js/jmask.js"></script>
<script src="<?=$hosted;?>/sistema/js/action_metas.js"></script>
<script src="<?=$hosted;?>/sistema/js/controle.js"></script>
<script src="<?=$hosted;?>/sistema/js/jquery.cookie.js"></script>
<script src="<?=$hosted;?>/sistema/js/functions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/bootstrap/js/star-rating.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$hosted;?>/sistema/assets/plugins/datatables/dataTables.bootstrap.min.js"></script> 

<script src="<?=$hosted;?>/sistema/assets/jquery-ui/jquery-ui.min.js"></script> 


<!-- SELECT2 TO FORMS-->
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script type="text/javascript" src="<?=$hosted;?>/sistema/js/bootstrap-notify.js"></script>
<!-- Validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
	/*------------------------|INICIA TOOLTIPS E POPOVERS|---------------------------------------*/
	var obj = "";
	$(document).ready(function () {

		var options = {
			html:true,
			content: function() {
				return $("#form-pop").children(".popover-body").html();
			},
			placement: function (context, source) {
				var position = $(source).position();

				if (position.left > 515) {
					return "left";
				}

				if (position.left < 515) {
					return "right";
				}

				if (position.top < 110){
					return "bottom";
				}

				return "top";
			}, 
			trigger: "click"
		};
		$(".pop").popover(options);
		//$(".select2").select2();
		$( ".sortable" ).sortable({
			tolerance: 'pointer',
			revert: 'invalid',
			forceHelperSize: true,
			connectWith: '.sortable'
		}).end(function(){
			console.log($("#painel"));
		});
		$( ".sortable" ).disableSelection();
		
		$(".pop").click(function(){
			obj = $(this).attr("id");
			//console.log(obj);
		});

		$(document.body).on("change",".select2",function(){
			$("#"+obj).find(".info-box-text").text($(".select2 option:selected").text());
			$("#"+obj).data("imposto", $(this).val());
			//alert($("#"+obj).data("imposto"));
		});

		$(document.body).on("click","#btn_countsave", function(){
			// Creating variable json to receive the data of the frames
			var json = "";
			// Creating the auxiliary var i, to append an index to the json
			var i = 0;
			// creating an array to store the object id's ehich has been found
			var ob = new Array();
			json = "{";
			//console.log($("#painel").find('.sortable').children().length);
			$("#painel").find('.sortable').children().each(function(){
				i++;
				ob[i-1] = $(this).attr('id');
				im = $(this).data("imposto");
				tm = $(this).data("tam").replace('col-lg-','');
				cl = $(this).data("cor");
				ic = $(this).data("icone");
				json += '"'+i+'":{"id_imp":'+im+',"tamanho":'+tm+',"cor":"'+cl+'","icone":"'+ic+'"},'
			});
			json = json.substring(0, json.length -1)+"}";
			var j=0;
			var erro = new Array()
			$.each(ob, function( index, value){
				j++;
				$.each($("#"+value).data(),function(i,v){
					if(i == "cor" && v==0){erro.push("Veifique o quadro das posição "+j+": Escolha uma "+i+"\n");}
					if(i == "tam" && v==0){erro.push("Veifique o quadro das posição "+j+": Defina o campo "+i+"\n");}
					if(i == "imposto" && v==0){erro.push("Veifique o quadro das posição "+j+": Escolha um "+i+"\n");}
					if(i == "icone" && v==0){erro.push("Veifique o quadro das posição "+j+": Escolha um "+i+"\n");}
				});
			});
			if(erro.length > 0){
				alert(erro);
			}
			else{
				$.post("../controller/TRIEmpresas.php",{
					acao	: "custom_count",
					conts	: json
					},
					function(data){
						if(data.status=="OK"){
							$.notify({
								title: 		"<b>Contagens Alteradas!</b><br>",
								message: 	"Volte ao Dashboard para ver as novas contagens!"
								}, {
									type: 			"success",
									allow_dismiss: 	true
							});
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

		$('body').on('click', function (e) {
		    $('[data-toggle="popover"]').each(function () {
		        if (!$(this).is(e.target) && 
		             $(this).has(e.target).length === 0 && 
		             $('.popover').has(e.target).length === 0) {
		            $(this).popover('hide');
		        }
		    });
		});	
	});
	
	function icone(icon){
		$("#"+obj).find(".info-box-icon i").removeClass().addClass(icon);
		$("#"+obj).data("icone",icon);
		//alert($("#"+obj).data("icone"));
	}
	function color(cor){
		$("#"+obj).find(".info-box").removeClass().addClass("info-box "+cor);	
		$("#"+obj).data("cor",cor);
		//alert($("#"+obj).data("cor"));
	}
	function size(tam){
		$("#"+obj).removeClass().addClass(tam);	
		$("#"+obj).data("tam",tam);
		//alert($("#"+obj).data("tam"));
	}

	

</script>

</body>
</html>	