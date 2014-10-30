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

// Carregamento das variáveis para controle de acesso.
$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar');
$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar');
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir');
$visualizarUsuario = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">

	<h4 class="title title-section">Indicador</h4>

	<?php echo $this->FilterForm->create('',array('class' => 'well form-search'));?>
	<div class="list-actions row-fluid">
		<div class="list-actions-buttons pull-right">
			<?php if($adicionar){?>			
			<button class="btn btn-small btn-primary" type="button" onclick="location.href='<?php echo $this->Html->url(array('controller' => 'Indicador', 'action' => 'adicionar'), true);?>' "><i class="fa fa-plus-circle"></i>Adicionar</button>
			<?php }?>
		</div><!-- /.list-actions -->
		<!-- Filtros -->
		<div class="list-filters pull-left">
			
			<div class="with-select">
				<?php
					echo $this->FilterForm->input('filter1', array('placeholder' => 'O que você procura?'));		
				?>
				<select name="" id="">
					<option value="">Filtrar em:</option>
					<option value="">Título</option>
				</select>
				<button type="submit" class="btn"><i class="icon-search fa fa-search"></i></button>
			</div>

		</div><!-- /.list-filters -->
		<!-- end Filtros -->	
	</div>
	</form>
	
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand"><?php echo $this->Paginator->sort('titulo', 'Título'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Responsavel.Pessoa.titulo','Responsável'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Pai.titulo', 'Pai'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('tipo_calculo', 'Tipo Cálculo'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('desdobramento'); ?></th>
				<?php if($editar || $excluir){?>
				<th class="actions"><center><?php echo __('Ações'); ?></center></th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
		<?php foreach($indicador as $indicador){?>
			<tr>
				<td>
					<?php
					if($visualizar){
						echo $this->Html->link($indicador['Indicador']['titulo'], array('action' => 'visualizar', $indicador['Indicador']['id']));
					}else{
						echo $indicador['Indicador']['titulo'];
					}
					?>&nbsp;
				</td>
				<td>
					<?php
					if($visualizarUsuario){
						echo $this->Html->link($indicador['Responsavel']['Pessoa']['titulo'], array('controller' => 'usuario','action' => 'visualizar', $indicador['Responsavel']['id']));
					}else{
						echo $indicador['Responsavel']['Pessoa']['titulo'];
					}
					?>&nbsp;
				</td>
				<td>
					<?php
					if($visualizar){
						echo $this->Html->link($indicador['Pai']['titulo'], array('action' => 'visualizar', $indicador['Pai']['id']));
					}else{
						echo $indicador['Pai']['titulo'];
					}
					?>&nbsp;
				</td>
				<td><?php echo Util::getTipoCalculo($indicador['Indicador']['tipo_calculo']); ?>&nbsp;</td>
				<td><?php echo $indicador['Indicador']['desdobramento'] == Util::ATIVO ? 'Mensal' : 'Anual'; ?>&nbsp;</td>
				<?php if($editar || $excluir){?>
				<td class="actions" width="7%" nowrap="nowrap">
					<?php 
						if($editar){
						echo $this->Html->link(
							__(""),
							array('action' => 'editar', $indicador['Indicador']['id']),
							array('class'=>'icon-edit fa fa-edit')
						);
						echo "&nbsp;&nbsp;";
						}
						if($excluir){
						echo $this->Form->postLink(
							__(""), 
							array('action' => 'excluir', $indicador['Indicador']['id']), 
							array('class'=>'icon-trash fa fa-trash-o'),
							__(Util::MENSAGEM_DELETAR, $indicador['Indicador']['id'])
						); 
						}
					?>
				</td>
				<?php }?>
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