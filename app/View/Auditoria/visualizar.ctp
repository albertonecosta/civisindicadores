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
