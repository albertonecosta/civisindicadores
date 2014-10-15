$(document).ready(function(){
	/* adicionando devidas m�scaras �s classes */
	$(".telefone").mask("(99) 9999-9999");
	$(".cep").mask("99999-999");
	$(".data").mask("99/99/9999");
	$(".datahora").mask("99/99/9999 99:99");
	$(".hora").mask("99:99");
	$(".cpf").mask("999.999.999-99");
	$(".cnpj").mask("99.999.999/9999-99");
	jQuery(".money").maskMoney({symbol:"R$",decimal:",",thousands:"."});
	jQuery(".float").maskMoney({decimal:",",thousands:"."});
	$(".datepicker").datepicker({
		dateFormat: 'dd/mm/yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior'
	});
	
});