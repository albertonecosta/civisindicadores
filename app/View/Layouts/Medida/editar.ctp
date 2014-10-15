<div class="container">
	<?php echo $this->Form->create('Medida'); ?>	
 		<fieldset>
 			<legend>Edição de Ações</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
  					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
					echo $this->Form->input('ordem', array('class'=>'input-xlarge', 'empty' => 'Selecione a Ordem','type' => 'select','options' => $ordem));
					echo $this->Form->input('prioridade', array('class'=>'input-xlarge', 'type' => 'select', 'values' => $prioridades));
					echo $this->Form->input('dimensao_id', array('class'=>'input-xlarge', 'empty' => 'Selecione a Dimensão','type' => 'select','options' => $dimensoes));
					echo $this->Form->input('ano', array('class'=>'input-xlarge', 'empty' => 'Selecione o ano','type' => 'select','options' => Util::anos()));
					echo $this->Form->input('andamento', array('label' => 'Andamento','class'=>'input-xlarge','type' => 'select','options' => $andamento));
					echo $this->Form->input('status', array('label' => 'Status','class'=>'input-xlarge', 'empty' => 'Selecione o Status','type' => 'select','options' => $status));
					echo $this->Form->input('resultado', array('label' => 'Resultados','class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('providencia', array('label' => 'Providências','class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('restricao', array('label' => 'Restrições','class'=>'input-xlarge jqte-test'));
					echo $this->Form->input('tipo', array('class'=>'input-xlarge', 'empty' => 'Selecione o tipo do medida','type' => 'select','options' => array(Util::TIPO_PADRAO => 'Padrão', Util::TIPO_MEDIDA => 'Medida')));
					echo $this->Form->input('medida_id', array('label' => 'A que ação ou objetivo esta ação está associada?','div' => array('id' => 'medida_id'),'class'=>'input-xlarge', 'empty' => 'Selecione o medida','type' => 'select','options' => $medidas));
							?>
  			</div>
 			</div>
 			<div class="row">
 				<div class="span12">
 					<div class="form-actions">
  						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
 				</div>
 			</div>
 		</fieldset>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
		var valor = $("#MedidaTipo").val();
		if(valor == <?php echo Util::TIPO_MEDIDA ?>){
			$("#medida_id").show();
		}else{
			$("#MedidaMedidaId").val("");
			$("#medida_id").hide();
		}
		$("#MedidaTipo").click(function() {
			var valor = $(this).val();
            if(valor == <?php echo Util::TIPO_MEDIDA ?>){
            	$("#medida_id").show();
            }else{
            	$("#MedidaMedidaId").val("");
            	$("#medida_id").hide();
            }
        })
    });
</script>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->base?>/js/jquery-te-1.4.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $this->base?>/css/jquery-te-1.4.0.css">
<script>
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>

