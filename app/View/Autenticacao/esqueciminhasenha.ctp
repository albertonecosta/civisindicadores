<div class="container">
	<div class="row-fluid">
		<div class="span4">			
		</div>
		<div class="span4">
			<div class="box-login">
				<div class="row-fluid">
					<h3 class="titulo cor-destaque titulo-secao" style="width:300px">Esqueci minha senha</h3>
				</div>
				<form method="post" action="" enctype="multipart/form-data">
					<fieldset>
						<?php echo $this->Form->input('Usuario.login', array('label'=>'Email','div' => array('class' => 'input text div-campo-grande required')));?>
					</fieldset>
					<div class="div-botao div-botao-destaque div-botao-salvar">
						<input type="submit" value="Enviar">
					</div>
				</form>
			</div><!-- fim .index -->
		</div><!-- fim .conteudo-principal -->
	</div>
</div>

<br /><br /><br />