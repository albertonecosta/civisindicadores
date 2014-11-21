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
<div class="container">
	<?php echo $this->Form->create('Usuario', array('type' => 'file')); 
	?>
 		<fieldset>
 			<legend>Editar Usuário</legend>
 			<div class="row">
  			<div class="span6">
  				<legend>Dados Pessoais</legend>
  				
  				<!--
  				<div class="control-group required <?php if($this->Form->isFieldError('Pessoa.titulo')){echo 'error';}?>">
  					<label class="control-label" for="inputTitulo">Nome</label>
  					<div class="controls">
  						<input type="text" class="input-xlarge" id="inputTitulo" name="data[Pessoa][titulo]" />
  						<?php echo $this->Form->error("Pessoa.titulo", "Campo nome inválido", array("class" => "help-inline"));?>	
  					</div>
  				</div>
  				-->
  				
  				<?php
  				echo $this->Form->input('Pessoa.id', array('type' => 'hidden'));				
				echo $this->Form->input('Pessoa.titulo', array('class'=>'input-xlarge','div' => array('class' => 'input text required')));
				echo $this->Form->input('Pessoa.email', array('class'=>'input-xlarge','div' => array('class' => 'input text required')));
				//Caso venha a existir alem de pessoa fisica, tirar o atributo hidden e adicionar PJ
				echo $this->Form->input('Pessoa.tipo', array('type' => 'hidden', 'value' => 'PF'));
				echo $this->Form->input('Usuario.id', array('type' => 'hidden'));
				echo $this->Form->input('Usuario.login', array('class' => 'input-xlarge'));
				
				if($usuarioLogado['id'] == $_SESSION['dados_a_salvar']['Usuario']['id']){
					echo $this->Form->input('Usuario.senha_nova', array('type' => 'password', 'class' => 'input-xlarge', 'value' => '', 'label' => 'Senha'));
					echo $this->Form->input('Usuario.confirmacao_senha_nova', array('type' => 'password', 'class' => 'input-xlarge', 'label' => 'Confirmacao Senha'));
					echo $this->Form->input('Usuario.lembrete_senha', array('class' => 'input-xlarge'));
				}else{
					echo $this->Form->input('Usuario.senha_nova', array('type' => 'hidden', 'class' => 'input-xlarge', 'value' => '', 'label' => 'Senha'));
					echo $this->Form->input('Usuario.confirmacao_senha_nova', array('type' => 'hidden', 'class' => 'input-xlarge', 'label' => 'Confirmacao Senha'));
					echo $this->Form->input('Usuario.lembrete_senha', array('type' => 'hidden','class' => 'input-xlarge'));
				}	
				
				
				echo $this->Form->input('Usuario.cpf', array('class' => 'input-xlarge'));
				echo $this->Form->input('Usuario.rg', array('class' => 'input-xlarge'));
				echo $this->Form->input('Pessoa.observacao', array('class' => ' jqte-test'));
				echo $this->Form->input('Usuario.imagem_perfil', array('class'=>'input-xlarge', 'type' => 'file'));
				echo $this->Form->input('Usuario.diretorio_imagem_perfil', array('type' => 'hidden'));
				?>
  			</div>
 			<div class="span6">
 				<legend>Endereço</legend>
 				<?php
 					echo $this->Form->input('Endereco.id',array('type' => 'hidden')); 
 					echo $this->Form->input('Endereco.logradouro',array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.numero', array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.cep', array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.bairro', array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.cidade', array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.uf', array('label' => 'UF','type' => 'select', 'options' => Util::getEstados()));
				?>
				<legend>Dados de acesso</legend>
				<?php
					echo $this->Form->input('Usuario.grupo_id', array("options" => $grupos, 'empty' => "Selecione o grupo"));
					echo $this->Form->input('Usuario.cargo_id', array("options" => $cargos, 'empty' => "Selecione o cargo"));
					echo $this->Form->input('Usuario.vinculo_id', array("options" => $vinculos, 'empty' => "Selecione o vinculo"));
					echo $this->Form->input('Usuario.setor_id', array("options" => $setores, 'empty' => "Selecione o setor"));
					echo $this->Form->input('Usuario.departamento_id', array("options" => $departamentos, 'empty' => "Selecione o departamento"));
					echo $this->Form->input('Usuario.chefe', array("label" => "Chefia?" ,"options" => array(Util::INATIVO => 'Não', Util::ATIVO => "Sim")));
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