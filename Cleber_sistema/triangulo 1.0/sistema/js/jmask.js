$(document).ready(function(){
	$('.date').mask('11/11/1111');
	$('.time').mask('00:00:00');
	$('.cep').mask('99999999');
	$('.tel').keyup(function(){
		if($(this).val().length < 13){
			$('.tel').mask('(99)9999-9999');
		}
		else{
			$('.tel').mask('(99)9 9999-9999');
		}
	});
	
	$('.cel').mask('(99)9 9999-9999');
	$('.cnpj').mask('00.000.000/0000-00');
});