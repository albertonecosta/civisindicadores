<?php 
/**
*
* Copyright [2014] -  Civis Gestão Inteligente
* Este arquivo é parte do programa Civis Estratégia
* O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
* Este programa é distribuído na esperança que possa ser útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
* Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
*
*/
?>
<div class="container">
	<?php echo $this->Form->create('Medida'); ?>	
 		<fieldset>
 			<legend>Edição de Ações Estratégicas</legend>
 			<div class="row">
  			<div class="span12">  				
  				<?php
  					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('titulo', array('class'=>'input-xlarge', 'readonly'=>'readonly'));
					echo $this->Form->input('prioridade', array('class'=>'input-xlarge', 'readonly'=>'readonly'));
					//echo $this->Form->input('ordem', array('class'=>'input-xlarge', 'empty' => 'Selecione a Ordem','type' => 'select','options' => $ordem));
					//echo $this->Form->input('prioridade', array('class'=>'input-xlarge', 'type' => 'select', 'values' => $prioridades));
					//echo $this->Form->input('dimensao_id', array('class'=>'input-xlarge', 'empty' => 'Selecione a Dimensão','type' => 'select','options' => $dimensoes));
					//echo $this->Form->input('ano', array('class'=>'input-xlarge', 'empty' => 'Selecione o ano','type' => 'select','options' => Util::anos()));
					echo $this->Form->input('andamento', array('label' => 'Andamento','class'=>'input-xlarge','type' => 'select','options' => $andamento));
					echo $this->Form->input('status_medida', array('label' => 'Status','class'=>'input-xlarge', 'empty' => 'Selecione o Status','type' => 'select','options' => $status_medida));
					echo $this->Form->input('situacao', array('label' => 'Situação','class'=>'input-xlarge', 'empty' => 'Selecione a Situação','type' => 'select','options' => $situacao));
					echo $this->Form->input('situacao_desc', array('label' => 'Descrição da Situação','class'=>'input-xxlarge textarea'));
					echo $this->Form->input('resultado', array('label' => 'Resultados','class'=>'input-xxlarge textarea'));
					echo $this->Form->input('providencia', array('label' => 'Providências','class'=>'input-xxlarge textarea'));
					echo $this->Form->input('restricao', array('label' => 'Restrições','class'=>'input-xxlarge textarea'));
					echo $this->Form->input('riscos', array('label' => 'Riscos','class'=>'input-xxlarge textarea'));
					echo $this->Form->input('observacoes', array('label' => 'Observações','class'=>'input-xxlarge textarea'));
					echo $this->Form->input('data_ultima_atualizacao', array('label' => 'Última Atualização','type' => 'text','class'=>'input-xlarge data datepicker'));
					echo $this->Form->input('tipo', array('class'=>'input-xlarge', 'empty' => 'Selecione o tipo do medida','type' => 'select','options' => array(Util::TIPO_PADRAO => 'Padrão', Util::TIPO_MEDIDA => 'Medida')));
					echo $this->Form->input('objetivo_id', array('label' => 'A que ação ou objetivo esta ação está associada?','div' => array('id' => 'medida_id'),'class'=>'input-xlarge', 'empty' => 'Selecione a ação','type' => 'select','options' => $medidas, 'readonly'=>'readonly'));
							?>
					
				
  			</div>
 			</div>
			<div class="row">
				<div class="span12">
				<p>
				<?php
					echo 'Editado pela última vez em '.$editado_em[0]['created'].' por <a href="mailto:'.$editado_em[0]['email'].'">'.$editado_em[0]['titulo'].'</a>.';
				?>	
				</p>
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

