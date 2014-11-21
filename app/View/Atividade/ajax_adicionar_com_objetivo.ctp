<?php 
/**
 *
 * Copyright [2014] -  Civis Gestão Inteligente
 * Este arquivo é parte do programa Civis Estratégia
 * O civis estratégia é um software livre, você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF) na versão 2 da Licença.
 * Este programa é distribuído na esperança que possa ser  útil, mas SEM NENHUMA GARANTIA, sem uma garantia implícita de ADEQUAÇÃO a qualquer  MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "licença GPL.odt", junto com este programa. Se não encontrar,
 * Acesse o Portal do Software Público Brasileiro no endereço www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA 
 *
 */
?>
<div class="row-fluid">
		<?php echo $this->Form->create('Atividade'); ?>	
	 		<fieldset>
	 			<legend>Cadastro Atividade</legend>		
	  				<?php
	  					echo $this->Form->input('objetivo_id', array('type' => 'hidden', 'value' => $objetivo_id));
						echo $this->Form->input('titulo', array('label' => 'Título','class'=>'input-xlarge'));
						echo $this->Form->input('marco', array('label' => 'Marco','type' => 'select','class'=>'input-xlarge', 'options' => array(Util::COMPLETO => 'Sim', Util::INCOMPLETO => 'Não'), 'empty' => 'Selecione'));
						echo $this->Form->input('prioridade', array('class'=>'input-xlarge', 'type' => 'select', 'values' => $prioridades));
						echo $this->Form->input('data_inicio_previsto', array('label' => 'Data Inicial','type' => 'text','class'=>'input-xlarge data datepicker'));
						echo $this->Form->input('data_fim_previsto', array('label' => 'Data Final','type' => 'text','class'=>'input-xlarge data datepicker'));
						echo $this->Form->input('lembrete', array('label' => 'Lembrete','type' => 'text','class'=>'input-xlarge data datepicker'));
						echo $this->Form->input('responsavel_id', array('label' => 'Responsável','class'=>'input-xlarge', 'empty' => 'Selecione o Responsável','type' => 'select','options' => $usuarios));
						echo $this->Form->input('supervisor_id', array('label' => 'Supervisor','class'=>'input-xlarge', 'empty' => 'Selecione o Supervisor','type' => 'select','options' => $usuarios));
						echo $this->Form->input('status', array('label' => 'Status','class'=>'input-xlarge', 'empty' => 'Selecione o Status','type' => 'select','options' => $status));
						echo $this->Form->input('andamento', array('label' => 'Andamento','class'=>'input-xlarge','type' => 'select','options' => $andamento));
						echo $this->Form->input('observacao', array('label' => 'Comentário','class'=>'input-xlarge'));
						echo $this->Form->input('data_conclusao', array('label' => 'Data de Conclusão','type' => 'text','class'=>'input-xlarge data datepicker'));
					//	echo $this->Form->input('acao_id', array('label' => 'Subitem de?','class'=>'input-xlarge', 'empty' => 'Selecione','type' => 'select','options' => $acoes));
					?>
	 			<div class="row">
	 				<div class="span12">
	 					<div class="form-actions">
	  						<button type="button" class="btn btn-primary" id="salvar">Salvar</button>
						</div>
	 				</div>
	 			</div>
	 		</fieldset>
	 	<?php echo $this->Form->end(); ?>	
</div>
<?php
echo $this->Html->script('libs/geral');
?>