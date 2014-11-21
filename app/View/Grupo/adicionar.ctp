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
<?php echo $this->Form->create('Grupo'); ?>
	<fieldset>
 		<legend>Cadastro Grupo</legend>
 		<div class="row">
 			<div class="span12"> 
				<?php
					echo $this->Form->input('titulo', array('class'=>'input-xlarge', 'div'=>array('class'=>false)));
				?>
			</div>
			<div class="span12" style="padding:0;margin:0">
				<?php 
					$count = 0;
					foreach($restricoes as $sessao => $listaPermissoes){ 
					$count++;
				?>
				<div class="span3">
					<div class="form-group">
						<label for="Modulo<?php echo $count;?>"><?php echo $sessao;?></label>
						<select multiple="multiple" id="Modulo<?php echo $count;?>" name="data[permissoes][<?php echo $sessao;?>][]" style="height: 150px" class="form-control">						
							<?php foreach($listaPermissoes as $nomePermissao => $item){?>
								<option value="<?php echo $nomePermissao;?>"><?php echo $nomePermissao;?></option>					
							<?php } ?>
						</select>
					</div>
				</div>
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
</div>
<script type="text/javascript" src="<?php echo $this->base?>/js/libs/jquery.lwMultiSelect.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->base?>/js/jquery-te-1.4.0.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //initialize the element
    $('#ProjetoTeste').lwMultiSelect();
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    //initialize the element
    $('.multi-select').lwMultiSelect();
  });
</script>