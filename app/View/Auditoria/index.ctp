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
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">
	<br />
	<h4>Auditorias</h4>
	<?php
		echo $this->FilterForm->create('',array('class' => 'well form-search'));
	?>
	<div class="row">
		<div class="span7">
			<?php
				echo $this->FilterForm->input('filter1');	
			?>
			<button type="submit" class="btn"><i class="icon-search"></i>&nbsp;</button>		
		</div>
		<div class="span4">				
			<p><button class="btn btn-small btn-primary pull-right" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'Auditoria', 'action' => 'adicionar'), true);?>' ">Adicionar</button></p>
		</div>
	</div>
	</form>
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand"><?php echo $this->Paginator->sort('alias_controller', 'Módulo'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('alias_acao', 'Ação'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('elemento_id', 'Id do elemento'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('usuario_id', 'Quem modificou'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('created', 'Data'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($auditoria as $auditoria){?>
			<tr>
				<td><?php echo $this->Html->link($auditoria['Auditoria']['alias_controller'], array('action' => 'visualizar', $auditoria['Auditoria']['id'])); ?>&nbsp;</td>
				<td><?php echo $auditoria['Auditoria']['alias_acao']; ?>&nbsp;</td>
				<td><?php echo $auditoria['Auditoria']['elemento_id']; ?>&nbsp;</td>
				<td><?php echo $this->Html->link($auditoria['Usuario']['Pessoa']['titulo'], array('controller' => 'Usuario','action' => 'visualizar', $auditoria['Usuario']['id']));; ?>&nbsp;</td>
				<td><?php echo $auditoria['Auditoria']['created']; ?>&nbsp;</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<div class="row">
		<div class="span6">
			<small>
				<?php
				echo $this->Paginator->counter(array(
				'format' => __(Util::MENSAGEM_PADRAO_PAGINACAO)
				));
				?>
			</small>	
		</div>	
		<div class="span6">
				<div class="pagination pagination-mini pull-right" style="margin:0;">
				<ul>
				<?php
					echo $this->Paginator->prev(__(Util::ANTERIOR_PAGINACAO), array(
						'escape'=>false,
						'tag'=>'li'
					), '<a onclick="return false;">' . Util::ANTERIOR_PAGINACAO . '</a>', 
					array('class'=>'disabled prev','escape'=>false,'tag'=>'li'));
					
					echo $this->Paginator->numbers(
						array(
							'separator' => '',
							'currentClass' => 'active',
							'currentTag' => 'a',
							'tag'=>'li'
						)
					);
					
					echo $this->Paginator->next(__(Util::PROXIMO_PAGINACAO), array(
						'escape'=>false,
						'tag'=>'li'
					), '<a onclick="return false;">' . Util::PROXIMO_PAGINACAO . '</a>', 
					array('class'=>'disabled next','escape'=>false,'tag'=>'li'));
			
				?>
				</ul>
				</div>
			</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#filterFilter1").mask("99/99/9999");
		$("#filterFilter1-between").mask("99/99/9999");
		$("#filterFilter1").datepicker({
			dateFormat: 'dd/mm/yy',
		    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		    nextText: 'Próximo',
		    prevText: 'Anterior'
		});
		$("#filterFilter1-between").datepicker({
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
</script>