$(document).ready(function(){
	console.log("Matt, funcionou!");
	
	$("input").focus(function(){
		$('.data_br').mask('99/99/9999');
		$('.shortdate').mask('99/9999');
		$('.time').mask('99:99:99');
		$('.cep').mask('99999999');
		$('.tel').mask('(99)9999-9999');
		$('.telsm').mask('9999-9999');
		$('.cel').mask('(99)9 9999-9999');
		$('.cpf').mask('999.999.999-99');
		$('.cnpj').mask('99.999.999/9999-99');
		$('.iest').mask('999.999.999.999');
	});
});