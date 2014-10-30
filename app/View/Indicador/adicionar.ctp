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
	<h4 class="title title-section">Indicador</h4>
	<?php echo $this->Form->create('Indicador'); ?>	
 		<fieldset>
 			<legend>Novo Indicador</legend>
 			<div class="row">
  			<div class="span6">  
  				<legend>Dados Básicos</legend>				
  				<?php
					echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
					echo $this->Form->input('unidade', array('class'=>'input-xlarge'));
					echo $this->Form->input('indicador_id', array('class'=>'input-xlarge', 'empty' => 'Selecione o item','type' => 'select','options' => $indicadores, 'label' => 'Sub-item de'));
					echo $this->Form->input('faixa_id', array('class'=>'input-xlarge', 'empty' => 'Selecione a faixa','type' => 'select','options' => $faixas, 'label' => 'Faixa'));
					echo $this->Form->input('objetivo_id', array('class'=>'input-xlarge', 'empty' => 'Selecione o objetivo','type' => 'select','options' => $objetivos, 'label' => 'Objetivo'));
					echo $this->Form->input('usuario_id', array('class'=>'input-xlarge', 'empty' => 'Selecione o responsável','type' => 'select','options' => $usuarios, 'label' => 'Responsável'));
					echo $this->Form->input('projeto_id', array('class'=>'input-xlarge', 'empty' => 'Selecione o projeto','type' => 'select','options' => $projetos, 'label' => 'Projetos'));
					echo $this->Form->input('tipo_calculo', array('class'=>'input-xlarge', 'empty' => 'Selecione o tipo de cálculo','type' => 'select','options' => $tiposCalculo, 'label' => 'Tipo do cálculo'));
					echo $this->Form->input('desdobramento', array('class'=>'input-xlarge', 'empty' => 'Selecione o desdobramento','type' => 'select','options' => array('1' => 'Mensal', '0' => 'Anual')));
				?>
				<label>Tipo</label>
				<?php
					echo $this->Form->input('tipo', array('value' => '0','legend' => false,'type' => 'radio', 'options' => array(Util::ATIVO => 'Inteiro', Util::INATIVO => 'Decimal')));
				?>
				<label>Projeção</label>
				<?php
					echo $this->Form->input('projecao', array('value' => '0','legend' => false,'type' => 'radio', 'options' => array(Util::ATIVO => 'Sim', Util::INATIVO => 'Não')));
				?>
				<label>Cálculo</label>
				<?php
					echo $this->Form->input('calculo', array('value' => '0','legend' => false,'type' => 'radio', 'options' => array(Util::CALCULO_MEDIA => 'Média', Util::CALCULO_SOMA => 'Soma')));
				?>
				<?php 
					echo $this->Form->input('ordem', array('class'=>'input-xlarge','type' => 'select','options' => $ordem));
				?>
  			</div>
  			<div class="span6"> 
  				<legend>Atribuições</legend>
  				<?php
  			
					echo $this->Form->input('anos', 
					array('class'=>'input-xlarge', 
					'multiple' => 'multiple',
					'type' => 'select',
					'options' => Util::anos(), 
					'label' => 'Anos','div' => array('class' => 'input label-block')));
					
					echo $this->Form->input('autorizado_visualizar', array('class'=>'input-xlarge', 'multiple' => 'multiple','type' => 'select','options' => $usuarios, 'label' => 'Quem irá visualizar?' 
					,'div' => array('class' => 'input label-block')));
					echo $this->Form->input('responsavel_meta', array('class'=>'input-xlarge', 'multiple' => 'multiple','type' => 'select','options' => $usuarios, 'label' => 'Quem irá colocar a meta?', 
					'div' => array('class' => 'input label-block')));
					echo $this->Form->input('responsavel_realizado', array('class'=>'input-xlarge', 'multiple' => 'multiple','type' => 'select','options' => $usuarios, 'label' => 'Quem irá colocar o realizado?', 
					'div' => array('class' => 'input label-block')));
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
<script type="text/javascript" src="<?php echo $this->base?>/js/libs/jquery.lwMultiSelect.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //initialize the element
      $('#IndicadorAnos').lwMultiSelect();
    $('#IndicadorAutorizadoVisualizar').lwMultiSelect();
    $('#IndicadorResponsavelMeta').lwMultiSelect();
    $('#IndicadorResponsavelRealizado').lwMultiSelect();
  });
</script>