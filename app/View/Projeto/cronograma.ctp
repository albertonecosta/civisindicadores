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
<!-- Buttons -->

<div class="list-buttons">
	<a href="javascript:abrirPizza(<?php echo $projeto_id; ?>)" class="btn"><i class="fa fa-adjust"></i> Ver Torta</a>
	<a href="javascript:abrirGantt(<?php echo $projeto_id; ?>)" class="btn"><i class="fa fa-align-center"></i> Ver Gantt</a>
</div>
<!-- end Buttons -->

<div class="list row-fluid">
	<?php echo $this->Form->create('Atividade', array('action' => 'cronograma', 'id'=>'formCronograma')); ?>	
		<table class="footable table table-hover table-condensed">
			<thead>
				<tr>
					<td>Ação</td>
					<td>Data Início</td>
					<td>Data Fim</td>
					<td>Responsável</td>
					<td>Status</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($atividades as $atividade){?>
					<tr>
						<td><?php echo $atividade['Atividade']['titulo']; ?></td>
						<td><?php echo $this->Form->input('data_inicio_previsto.', array('type' => 'text','label' => false,'value'=> $atividade['Atividade']['data_inicio_previsto'],'class'=>'input-menor date datepicker'));?></td>
						<td><?php echo $this->Form->input('data_fim_previsto.', array('type' => 'text','label' => false,'value'=> $atividade['Atividade']['data_fim_previsto'],'class'=>'input-menor date datepicker'));?></td>
						<td><?php echo $atividade['Responsavel']['Pessoa']['titulo']; ?></td>
						<td><?php echo Util::getStatus($atividade['Atividade']['status']); ?></td>
						<td><?php echo $this->Form->input('id.', array('label' => 'id','type' => 'hidden','value'=> $atividade['Atividade']['id']));?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php echo $this->Form->input('dias_a_mais.', array('label' => 'Dias a acrescentar','type' => 'text', 'class'=>'input-menor'));?>
		<span class="label label-warning" style="margin-bottom: 5px">Obs: A quantidade inserida irá afetar todas as datas, de todas as ações listadas.<br>(O cálculo será data início + quantidade de dias inserido)</span>	
		<div class="row">
	 		<div class="span12">
	 			<div class="form-actions">
	  				<button type="submit" class="btn btn-primary" id="salvar-datas">Salvar</button>
				</div>
	 		</div>
	 	</div>
</div>

<style>
.input-menor{
width: 70px;
}
</style>
<script type="text/javascript">
$(".datepicker").datepicker({
    dateFormat: 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    nextText: 'Próximo',
    prevText: 'Anterior'
});

calculaData = function(data1l,data2l,result){
	
	    DAY = 1000 * 60 * 60  * 24;	
	 
	    data1 = $('#'+data1l).val();
	
	    data2 = $('#'+data2l).val();
	
	    var nova1 = data1.toString().split('/');
	
	    Nova1 = nova1[1]+"/"+nova1[0]+"/"+nova1[2];
	
	    var nova2 = data2.toString().split('/');
	
	    Nova2 = nova2[1]+"/"+nova2[0]+"/"+nova2[2];
	
	    d1 = new Date(Nova1)
	
	    d2 = new Date(Nova2)
	
	    days_passed = Math.round((d2.getTime() - d1.getTime()) / DAY)
	
	    $('#'+result).val(days_passed);
	
	}

</script>