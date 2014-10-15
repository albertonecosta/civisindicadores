<div class="container">
	<legend>Visualizar Plano Ação</legend>
	<div class="row">
		<div class="span12">
			<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover table-condensed">
				<tbody>
					<tr>
						<td><strong><?php echo __('Titulo'); ?></strong></td>
						<td><?php echo h($planoAcao['PlanoAcao']['titulo']); ?></td>
					</tr>
					<?php if(count($planoAcao['AcaoPlanoAcao']) > 0){?>
					<tr>
						<td><strong><?php echo __('Ações'); ?></strong></td>						
						<td><ul><?php
							foreach($planoAcao['AcaoPlanoAcao'] as $acoes){
								echo "<li>".$acoes['Acao']['titulo']."</li>";
							}											
						?></ul></td>						
					</tr>
					<?php } ?>
				</tbody>				
			</table>			
		</div>
	</div>
</div>