<?php 
echo $this->Html->script(array('libs/jquery.maskedinput',
								'libs/jquery.maskMoney',
								'libs/bootstrap.min',
								'libs/geral',
								'libs/jquery.ui.datepicker'));
echo $this->fetch('script');
echo $this->Js->writeBuffer(); // note: write cached scripts 
?>

<script>
$(function() {
	$.datepicker.setDefaults( $.datepicker.regional[""] );
	$(".datepicker").datepicker( $.datepicker.regional["pt-BR"] );
});
</script>