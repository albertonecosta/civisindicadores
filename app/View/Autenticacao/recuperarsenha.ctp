<div class="container">
	<div class="row-fluid">
		<div class="span4">			
		</div>
		<div class="span4">
			<?php echo $this->Session->flash(); ?>
			<div class="box-login">
				<div class="row-fluid">
					<h3 class="titulo cor-destaque titulo-secao">Recuperar Senha</h3>
				</div>
				<form method="post" action="<?php echo $this->base;?>/autenticacao/recuperarsenha/<?php echo $hash;?>" enctype="multipart/form-data">
					<fieldset>
						<?php echo $this->Form->input('Usuario.nova_senha',array('label'=> 'Nova Senha', 'type' => 'password', 'default' => '', 'div'=>array('class'=>'required')));?>
						<br>
						<?php echo $this->Form->input('Usuario.confirmacao_nova_senha',array('label'=> 'Repetir Nova Senha', 'type' => 'password', 'default'=>'' ,'div'=>array('class'=>'required')));?>
		 			</fieldset>
					<div class="div-botao div-botao-destaque div-botao-salvar">
						<input type="submit" value="Enviar">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<br /><br /><br />