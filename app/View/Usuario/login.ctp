<div class="container">
	<div class="row-fluid">
		<div class="span4">			
		</div>
		<div class="span4">
			<div class="box-login">
				<div class="row-fluid">
					<h2 class="title"><span>Entrar no</span> Civis Indicadores</h2>
				</div>
			    <div class="users form">
					<form method="post">
					    <fieldset>
					        <?php 
					        echo $this->Form->input('Usuario.login');
					        echo $this->Form->input('Usuario.senha', array('type'=>'password'));
					    	?>
					    </fieldset>
						<button type="submit" class="btn btn-primary">Logar</button>
						<a href="<?php echo $this->base;?>/autenticacao/esqueciminhasenha" class="forgot-password">Esqueci minha senha</a>
					</form>
				</div>
			</div><!-- /.box-login -->
		</div><!-- /.span4 -->
	</div>
</div>
