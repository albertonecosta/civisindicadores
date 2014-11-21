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