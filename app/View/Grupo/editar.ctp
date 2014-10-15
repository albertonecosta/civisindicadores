<div class="container">
<form method="post">
	<fieldset>
 		<legend>Editar Grupo</legend>
 		<div class="row">
 			<div class="span12"> 
				<?php
				echo $this->Form->input('Grupo.id');
					echo $this->Form->input('Grupo.titulo', array('class'=>'input-xlarge', 'div'=>array('class'=>false)));
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
								<option value="<?php echo $nomePermissao;?>" <?php if(in_array($sessao.'.'.$nomePermissao, $permissoes)) echo 'selected="selected"'; ?>><?php echo $nomePermissao;?></option>					
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
</form>
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