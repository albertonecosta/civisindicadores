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
	<?php 
	error_reporting(E_ALL ^ E_NOTICE);
	
	echo $this->Form->create('AcaoEstrategica'); 
	?>	
 		<fieldset>
 			<legend>Edição de Ações</legend>
 			<div class="row">
  			<div class="span12">
				
  				<?php
					function cleanUpTags($str){
						$order   = array("\r\n", "\n", "\r");
						$replace = "<br />";
						return str_replace($order, $replace, strip_tags($str));
					}
					
					function buildBox($name, $lbl, $str){
						$box = "";
						
						
						$box .= "<p style=\"margin-left:170px\"><a href=\"javascript: void(0);\" onclick=\"$('#vpf_".$name."').slideToggle('fast', 'swing');\"><sup>Versão do Ponto Focal (clique para ocultar/exibir)</sup></a></p>";
						$box .= "<div id=\"vpf_".$name."\" style=\"display: none; border: 1px solid #CCC;background-color: lightyellow;width: 520px;margin-left:170px;padding: 15px 10px 10px 10px;\">";
						$box .= "".cleanUpTags($str)."";
						$box .= "</div><br />";
						return $box;
					}
					
					$versao_ponto_focal = unserialize($editado_em[0]['valor_novo']);				
					
					
  					echo $this->Form->input('id', array('type' => 'hidden'));
					echo $this->Form->input('titulo', array('class'=>'input-xlarge', 'readonly'=>'readonly'));
					/*echo $this->Form->input('ordem', array('class'=>'input-xlarge', 'empty' => 'Selecione a Ordem','type' => 'select','options' => $ordem));
					echo $this->Form->input('prioridade', array('class'=>'input-xlarge', 'type' => 'select', 'values' => $prioridades));
					echo $this->Form->input('dimensao_id', array('class'=>'input-xlarge', 'empty' => 'Selecione a Dimensão','type' => 'select','options' => $dimensoes));
					echo $this->Form->input('ano', array('class'=>'input-xlarge', 'empty' => 'Selecione o ano','type' => 'select','options' => Util::anos()));
					*/
					
					echo $this->Form->input('usuario_id', array('label' => 'Responsável','class'=>'input-xlarge', 'empty' => 'Selecione o Responsável','type' => 'select','options' => $usuarios));
					
					if (isset($versao_ponto_focal['usuario_id']) && isset($usuarios[$versao_ponto_focal['usuario_id']])) {
						echo buildBox("usuario_id" ,"Responsável", $usuarios[$versao_ponto_focal['usuario_id']]);
					}
					echo $this->Form->input('andamento', array('label' => 'Andamento','class'=>'input-xlarge','type' => 'select','options' => $andamento));
					
					if (isset($versao_ponto_focal['andamento'])){
						echo buildBox("andamento" ,"Andamento", $versao_ponto_focal['andamento']);
					}
					
					echo $this->Form->input('status_acaoestrategica', array('label' => 'Status','class'=>'input-xlarge', 'empty' => 'Selecione o Status','type' => 'select','options' => $status_acaoestrategica));
					
					if (isset($versao_ponto_focal['status_acaoestrategica']) && isset($status_acaoestrategica[$versao_ponto_focal['status_acaoestrategica']])){
						echo buildBox("status_acaoestrategica", "Status", $status_acaoestrategica[$versao_ponto_focal['status_acaoestrategica']]);
					}
					
					
					echo $this->Form->input('situacao', array('label' => 'Situação','class'=>'input-xlarge', 'empty' => 'Selecione a Situação','type' => 'select','options' => $situacao));
					
					if (isset($versao_ponto_focal['situacao']) && isset($situacao[$versao_ponto_focal['situacao']])){
						echo buildBox("situacao", "Situação", $situacao[$versao_ponto_focal['situacao']]);
					}
					
					
					echo $this->Form->input('situacao_desc', array('label' => 'Descrição da Situação','class'=>'input-xxlarge textarea'));
					
					if (isset($versao_ponto_focal['situacao_desc'])){
						echo buildBox("situacao_desc", "Descrição da Situação", $versao_ponto_focal['situacao_desc']);
					}
					
					
					echo $this->Form->input('resultado', array('label' => 'Resultados','class'=>'input-xxlarge textarea'));
					
					if (isset($versao_ponto_focal['resultado'])){
						echo buildBox("resultado", "Resultados",$versao_ponto_focal['resultado']);
					}
										
					echo $this->Form->input('providencia', array('label' => 'Providências','class'=>'input-xxlarge textarea'));
					
					if (isset($versao_ponto_focal['providencia'])){
						echo buildBox("providencia", "Providências",$versao_ponto_focal['providencia']);
					}
										
					echo $this->Form->input('restricao', array('label' => 'Restrições','class'=>'input-xxlarge textarea'));
					
					if (isset($versao_ponto_focal['restricao'])){
						echo buildBox("restricao", "Restrições",$versao_ponto_focal['restricao']);
					}					
					
					echo $this->Form->input('riscos', array('label' => 'Riscos','class'=>'input-xxlarge textarea'));
					
					if (isset($versao_ponto_focal['riscos'])){
						echo buildBox("riscos", "Riscos",$versao_ponto_focal['riscos']);
					}

					echo $this->Form->input('observacoes', array('label' => 'Observações','class'=>'input-xxlarge textarea'));
					
					if (isset($versao_ponto_focal['observacoes'])){
					echo buildBox("observacoes", "Observações",$versao_ponto_focal['observacoes']);
					}
					
					
					echo $this->Form->input('data_ultima_atualizacao', array('label' => 'Última Atualização','type' => 'text'));					
					echo $this->Form->input('data_ultima_revisao', array('type' => 'hidden', 'value' => date('d/m/Y')));
					
					//echo $this->Form->input('data_ultima_revisao', array('label' => 'Última Revisão','type' => 'text'));
			//		echo $this->Form->input('tipo', array('class'=>'input-xlarge', 'empty' => 'Selecione o tipo do medida','type' => 'select','options' => array(Util::TIPO_PADRAO => 'Padrão', Util::TIPO_MEDIDA => 'Medida')));
			//		echo $this->Form->input('objetivo_id', array('label' => 'A que ação ou objetivo esta ação está associada?','div' => array('id' => 'medida_id'),'class'=>'input-xlarge', 'empty' => 'Selecione a ação','type' => 'select','options' => $medidas));
							?>
  			</div>
 			</div>
			<div class="row">
				<div class="span12">
				<p>
				<?php
					if (count($editado_em)> 0){
						echo 'Atualizado pela última vez em '.$editado_em[0]['created'].' por <a href="mailto:'.$editado_em[0]['email'].'">'.$editado_em[0]['titulo'].'</a>.';
					}
				?>	
				</p>
				<p>
				<?php
					if (count($revisado_em)> 0){
						echo 'Revisado pela última vez em '.$revisado_em[0]['created'].' por <a href="mailto:'.$revisado_em[0]['email'].'">'.$revisado_em[0]['titulo'].'</a>.';
					}
				?>	
				</p>
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
<script type="text/javascript">
    jQuery(document).ready(function($){
		var valor = $("#MedidaTipo").val();
		if(valor == <?php echo Util::TIPO_MEDIDA ?>){
			$("#medida_id").show();
		}else{
			$("#MedidaMedidaId").val("");
			$("#medida_id").hide();
		}
		$("#MedidaTipo").click(function() {
			var valor = $(this).val();
            if(valor == <?php echo Util::TIPO_MEDIDA ?>){
            	$("#medida_id").show();
            }else{
            	$("#MedidaMedidaId").val("");
            	$("#medida_id").hide();
            }
        })
    });
</script>
<script type="text/javascript" src="<?php echo $this->base?>/js/jquery-te-1.4.0.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $this->base?>/css/jquery-te-1.4.0.css">
<script>
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>

