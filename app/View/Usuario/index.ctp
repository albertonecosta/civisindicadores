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

// Carregamento das variáveis para controle de acesso
$adicionar = $this->ControleDeAcesso->validaAcessoElemento('adicionar', 'Usuario');
$visualizar = $this->ControleDeAcesso->validaAcessoElemento('visualizar', 'Usuario');
$editar = $this->ControleDeAcesso->validaAcessoElemento('editar', 'Usuario');
$excluir = $this->ControleDeAcesso->validaAcessoElemento('excluir', 'Usuario');
?>
<script type="text/javascript">
  $(function() {
    $('.footable').footable();
  });
  $("#index").treetable({ expandable: true});
</script>
<div class="container">
	<br />
	 
	<h4>Usuários</h4>		
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
			<?php if($adicionar){?>			
			<p><button class="btn btn-small btn-primary pull-right" type="button" onclick="location.href= '<?php echo $this->Html->url(array('controller' => 'Usuario', 'action' => 'adicionar'), true);?>' ">Adicionar</button></p>
			<?php }?>
		</div>
	</div>
	</form>
	 
	<table cellpadding="0" cellspacing="0" class="footable table table-bordered table-hover table-condensed" id="index">
		<thead>
			<tr>
				<th data-class="expand"><?php echo $this->Paginator->sort('Pessoa.titulo', 'Título'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Pessoa.email', 'Email'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Cargo.titulo', 'Cargo'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Setor.titulo', 'Setor'); ?></th>
				<th data-hide="phone,tablet"><?php echo $this->Paginator->sort('Departamento.titulo', 'Departamento'); ?></th>
				<?php if($editar || $excluir){?>
				<th><center><?php echo __('Ações'); ?></center></th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
		<?php foreach($usuario as $usuario){?>
			<tr>
				<td><?php
					if($visualizar){
						echo $this->Html->link($usuario['Pessoa']['titulo'], array('action' => 'visualizar', $usuario['Usuario']['id']));
					}else{
						echo $usuario['Pessoa']['titulo'];
					} 
					?>&nbsp;
				</td>
				<td><?php echo h($usuario['Pessoa']['email']); ?>&nbsp;</td>
				<td><?php echo h($usuario['Cargo']['titulo']); ?>&nbsp;</td>
				<td><?php echo h($usuario['Setor']['titulo']); ?>&nbsp;</td>
				<td><?php echo h($usuario['Departamento']['titulo']); ?>&nbsp;</td>
				<?php if($editar || $excluir){?>
				<td width="7%" nowrap="nowrap">
					<center>
					<?php 
						if($editar){
							echo $this->Html->link(
								__(""),
								array('action' => 'editar', $usuario['Usuario']['id']),
								array('class'=>'icon-edit')
							);
							echo "&nbsp;&nbsp;";
						}
						if($excluir){
							echo $this->Form->postLink(
								__(""), 
								array('action' => 'excluir', $usuario['Usuario']['id']), 
								array('class'=>'icon-trash'),
								__(Util::MENSAGEM_DELETAR, $usuario['Usuario']['id'])
							);
						}
					?>
					</center>
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