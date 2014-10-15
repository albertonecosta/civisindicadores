<?php 
if(isset($auditoria['AuditoriaCampos'])){
	foreach($auditoria['AuditoriaCampos'] as $value){
		if($value['valor_novo'] != null){
			$valor_novo[$value['alias_model']] = unserialize($value['valor_novo']);
		}
		if($value['valor_antigo'] != null){
			$valor_antigo[$value['alias_model']] = unserialize($value['valor_antigo']);
		}
	}
}
?>
<div class="container">
<legend>Visualizar Log</legend>
<div class="row-fluid">
	<div class="span6">
		<legend>Valores Antes</legend>
		<table class="table table-condensed table-bordered table-striped">
			<?php if(isset($valor_antigo)){ ?>
				<?php foreach($valor_antigo as $key =>$value){?>
					<tr>
						<td colspan="2"><b><?php echo $key; ?></b></td>
					</tr>
					<?php foreach($value as $chave => $valor){?>
						<?php if($chave != "id" && $chave != "created" && $chave != "modified" && $chave != "foto" && $chave != "enviado"){ ?>
							<tr>
								<td><?php echo $chave; ?></td>
								<td><?php echo is_array($valor) ? "" : $valor; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</table>
	</div>
	<div class="span6">
		<legend>Valores Depois</legend>
		<table class="table table-condensed table-bordered table-striped">
			<?php if(isset($valor_novo)){ ?>
				<?php foreach($valor_novo as $key => $value){?>
					<tr>
						<td colspan="2"><b><?php echo $key; ?></b></td>
					</tr>
					<?php foreach($value as $chave => $valor){?>
						<?php if($chave != "id" && $chave != "created" && $chave != "modified" && $chave != "foto" && $chave != "enviado"){ ?>
							<tr>
								<td><?php echo $chave; ?></td>
								<td><?php echo is_array($valor) ? "" : $valor; ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</table>
	</div>
</div>
</div>
