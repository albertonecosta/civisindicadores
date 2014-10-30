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
?><div class="container">
	<br />
	<h4>Planos de Ação</h4>
	<?php
		echo $this->FilterForm->create('',array('class' => 'well form-search'));
	?>
	<div class="row">
		<div class="span6">
			<div class="input-append">
				<?php
					echo $this->FilterForm->input('filter1');		
				?>
				<button type="submit" class="btn"><i class="icon-search"></i>&nbsp;</button>
			</div>
		</div>
		<div class="span5">				
			<p><button class="btn btn-small btn-primary pull-right" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'PlanoAcao', 'action' => 'adicionar'), true);?>' ">Adicionar</button></p>
		</div>
	</div>
	</form>
	
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('titulo'); ?></th>
				<th><center><?php echo __('Ações'); ?></center></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($planoAcao as $planoAcao){?>
			<tr>
				<td><?php echo $this->Html->link($planoAcao['PlanoAcao']['titulo'], array('action' => 'visualizar', $planoAcao['PlanoAcao']['id'])); ?>&nbsp;</td>
				<td width="7%" nowrap="nowrap">
					<center>
					<?php 
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $planoAcao['PlanoAcao']['id']),
							array('class'=>'icon-edit')
						);
						echo "&nbsp;&nbsp;";
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $planoAcao['PlanoAcao']['id']), 
							array('class'=>'icon-trash'),
							__(Util::MENSAGEM_DELETAR, $planoAcao['PlanoAcao']['id'])
						); 
					?>
					</center>
				</td>
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