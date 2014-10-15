<div class="container">
	<?php echo $this->Form->create('Empresa'); ?>	
 		<fieldset>
 			<legend>Cadastro Empresa</legend>
 			<div class="row">
  			<div class="span6">
  				<legend>Dados Básicos</legend>
  				
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
				echo $this->Form->input('Pessoa.titulo', array('class'=>'input-xlarge','div' => array('class' => 'input text required')));
				echo $this->Form->input('Pessoa.email', array('class'=>'input-xlarge','div' => array('class' => 'input text required')));
				//Caso venha a existir alem de pessoa fisica, tirar o atributo hidden e adicionar PJ
				echo $this->Form->input('Pessoa.tipo', array('type' => 'hidden', 'value' => 'PJ'));
				?>
				<label>Matriz</label>
				<?php 
				echo $this->Form->input('Empresa.matriz', array('class' => 'matriz','value' => '1','legend' => false,'type' => 'radio', 'options' => array('1' => 'sim', '0' => 'não')));
				echo $this->Form->input('Empresa.empresa_id', array('div' => array('id' => 'empresa_id'),'empty' => 'Selecione a Matriz','type' => 'select','options' => $empresas));
				echo $this->Form->input('Empresa.cnpj', array('class' => 'input-xlarge'));
				echo $this->Form->input('Empresa.inscricao_municipal', array('class' => 'input-xlarge'));
				echo $this->Form->input('Empresa.inscricao_estadual', array('class' => 'input-xlarge'));
				echo $this->Form->input('Pessoa.observacao', array('class' => 'jqte-test'));
				?>
  			</div>
 			<div class="span6">
 				<legend>Endereço</legend>
 				<?php 
 					echo $this->Form->input('Endereco.logradouro',array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.numero', array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.cep', array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.bairro', array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.cidade', array('class' => 'input-xlarge'));
					echo $this->Form->input('Endereco.uf', array('label' => 'UF','type' => 'select', 'options' => Util::getEstados()));
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
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#empresa_id").hide();
    	$('.matriz').click(function() {
            var valor = "";
            //Executa Loop entre todas as Radio buttons com o name de valor
            $('input:radio[class=matriz]').each(function() {
                //Verifica qual está selecionado
                if ($(this).is(':checked'))
                    valor = parseInt($(this).val());
            })
            if(valor == 1){
				$("#EmpresaEmpresaId").val("");
				$("#empresa_id").hide();
            }else{
				$("#empresa_id").show();
            }
        })
    });
</script>