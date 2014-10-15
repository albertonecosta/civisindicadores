<div class="container">
<?php
$modulos = Util::procurarFilhos(1, $acos);
?>
<?php echo $this->Form->create('Grupo'); ?>
	<fieldset>
 		<legend>Cadastro Grupo</legend>
 		<div class="row">
 			<div class="span12">
	<?php
		echo $this->Form->input('id', array('type' => 'hidden'));
		echo $this->Form->input('titulo', array('class'=>'input-xlarge'));
	?>
	<?php 
	$count = 0;
	foreach($modulos as $modulo){
	$acoes = Util::procurarFilhos($modulo[0]['id'], $acos);
	$count++;?>	
	<?php 
		/**
		 * Adicionamos no 'if' logo abaixo, os modulos que queremos que não apareça
		 * para que o usuário.
		 */
	?>
	<?php if ($modulo[0]['alias'] != "Pages" && $modulo[0]['alias'] != "AclExtras" && $modulo[0]['alias'] != "FilterResults"){?>
	<label for="Modulo<?php echo $count;?>"><?php echo $modulo[0]['alias'];?></label>
	<input type="hidden" name="data[ModuloAcao][AcaoModuloPerfil<?php echo $count;?>][modulo_alias][]" value="<?php echo $modulo[0]['alias'];?>">
	<select multiple="multiple" id="Modulo<?php echo $count;?>" name="data[ModuloAcao][AcaoModuloPerfil<?php echo $count;?>][acao_alias][]" class="input-xlarge multi-select">						
		<?php foreach($acoes as $acao){ ?>
			<?php 
				/**
				 * Por motivo logico, as ações login e logout abaixo, serão por padrão habilitadas para todos
				 * os usuarios. (Habilitamos essa ação no controller)
				 */
			?>
			<?php if($acao[0]['alias'] != "login" && $acao[0]['alias'] != "logout"){?>
				<option value="<?php echo $acao[0]['alias']?>" <?php echo in_array($acao[0]['id'], $idAcos) ? "selected" : "" ;?>><?php echo $acao[0]['alias'] == "index" ? "listar" : $acao[0]['alias']; ?></option>
			<?php }?>
		<?php }?>
	</select>
	<?php }?>
<?php }?>
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
<script type="text/javascript">
  $(document).ready(function() {
    //initialize the element
    $('.multi-select').lwMultiSelect();
  });
</script>